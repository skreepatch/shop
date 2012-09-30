var requestStorage=function(){
    var a={},b=[];
    return{
	length:0,
	key:function(a){
	    return typeof a=="number"&&b.length>=a&&a>=0?b[a]:null
	},
	getItem:function(b){
	    return a.hasOwnProperty(b)?a[b]:null
	},
	setItem:function(c,d){
	    a.hasOwnProperty(c)||(this.length++,b.push(c)),a[c]=d
	},
	removeItem:function(c){
	    if(a.hasOwnProperty(c)){
		this.length--;
		for(var d=0;d<b.length;d++)b[d]==c&&b.splice(d,1)
	    }
	    delete a[c]
	},
	clear:function(){
	    a={},b=[],this.length=0
	}
    }
}();
(function(a){
    var b={
	timeStamp:"__timeStamp__",
	responseText:"__responseText__",
	hasResponseXML:"__hasResponseXML__",
	responseHeaders:"__responseHeaders__"
    };
    
    a.ajaxCacheResponse={
	storage:window.requestStorage
    };
        
    var c=function(b){
	var d="";
	for(var e in b){
	    var f=typeof b[e];
	    f==="string"||f==="number"||f==="boolean"?d+=e+"="+b[e]+",":f==="object"?d+=e+"="+a.param(b[e])+",":f==="array"&&a.each(b[e],function(a,b){
		d+=c(b)
	    })
	}
	return d
    },d=function(c,d){
	if(a.ajaxCacheResponse.storage.getItem(c+b.timeStamp)===null)return!1;
	var e=!0;
	if(typeof d.cacheResponseTimer=="number"){
	    var f=parseInt(a.ajaxCacheResponse.storage.getItem(c+b.timeStamp));
	    if(typeof f=="number"){
		var g=(new Date).getTime();
		e=f+d.cacheResponseTimer>g,e===!0&&(d.cacheTimeRemaining=d.cacheResponseTimer-(g-f))
	    }
	}
	a.isFunction(d.cacheResponseValid)&&(e=d.cacheResponseValid.call(this,d));
	return e
    };
    
    a.ajaxPrefilter(function(e,f,g){
	if(e.cacheResponse===!0){
	    if(a.ajaxCacheResponse.storage===undefined)throw"No valid storage defined for the Ajax Cache Response plugin";
	    var h=c(f);
	    e.cacheResponseId=h;
	    if(d(h,e)===!0){
		var i=a.extend({},b);
		for(var j in i)i[j]=a.ajaxCacheResponse.storage.getItem(h+i[j]);e.xhr=function(){
		    return{
			open:a.noop,
			setRequestHeader:a.noop,
			send:a.noop,
			abort:a.noop,
			onreadystatechange:a.noop,
			getResponseHeader:a.noop,
			getAllResponseHeaders:function(){
			    return i.responseHeaders
			},
			readyState:4,
			status:200,
			statusText:"success",
			responseText:i.responseText,
			responseXML:i.hasResponseXML===!0?a.parseXML(i.responseText):undefined
		    }
		},g.responseFromCache=!0,g.cacheTimeRemaining=e.cacheTimeRemaining
	    }else g.responseFromCache=!1
	}
    }),a(document).ajaxSuccess(function(c,e,f,g){
	if(f.cacheResponse===!0){
	    var h=f.cacheResponseId;
	    if(d(h,f)===!1){
		var i=a.ajaxCacheResponse.storage;
		i.setItem(h+b.responseText,e.responseText),i.setItem(h+b.responseHeaders,e.getAllResponseHeaders()),i.setItem(h+b.timeStamp,(new Date).getTime()),i.setItem(h+b.hasResponseXML,e.responseXML!==undefined)
	    }
	}
    })
})(jQuery)



var orderby;
var order = 'acs';
var page;
var pagesize;
var geturl;

var _post = {
    'related': {}
};
var _bulk = {
    'related': {}
};

var filters = {
    'orderby': 'id',
    'order':'acs',
    'page': '1',
    'pagesize': $('.pagesize option:selected').val(),
    'where': {},
    'like': {},
    'dates': {},
    'related': {}
}

$(document).ajaxStart(function(){
    loader = $('<img>', {
	src: '/assets/img/ajax-loader-common.gif' 
    });
    modalWindow.open_el(loader);
    modalWindow.overlay.css('background', 'transparent');
});
$(document).ajaxStop(function(){
    modalWindow.close();
    modalWindow.overlay.css('background', '#000000');
});



function postFilters(url){
    grabFilters();
    var _url;
    if(url){
	_url = url
    } else {
	_url = window.location.href
    }
    
    $.ajax({
	type: "POST",
	url: _url,
	data: filters,
	global: true,
	success: function(data){
	    $('.main > .inner').html($('.content', $(data)));
	    $.each($('.toggler'), function(){
		$(this).togglerHandler();
	    });
	}
    });
}



function grabFilters(){
    $('.filter input[type=text]').each(function(){
	_name = $(this).attr('name');
	_val = $(this).val();
	if(_val != ''){
	    filters.like[_name] = _val;
	} else {
	    delete filters.like[_name];
	}
    });
}

function grabSelectors(){
    $('.clone_selector').each(function(){
	_name = $(this).attr('name');
	_val = $(this).val()
	if(_val != ''){
	    _bulk.related[_name] = _val;
	} else {
	    delete _bulk.related[_name];
	}
    });
    if($('#clone_tree').is(':checked')){
	_bulk.clone_tree = $('#clone_tree').val();
    }
}

$.fn.ajaxSubmit = function(){
    $(this).submit(function(e){
	e.preventDefault();
	var url = $(this).attr('action');
	var postdata = {};
	$.each($('input', $(this)), function(){
	    postdata[$(this).attr('name')] = $(this).val();
	});
	$.post(url, postdata, function(data) {
            
	    var content = $(data).find('.content');
	    $(".content").html(content.html());
	}
	);
    });
}

$(document).ready(function(){ 
        
    $.each($('.toggler'), function(){
	$(this).togglerHandler();
    });

    $('#attachment_file').live('change', function(){
	_file = $(this).val();
	_id = $(this).attr('name');
	_filename = $(this).parent().siblings('span.filename')
	_filename.text(_file);
	_loader = $(this).parent().siblings('span.loader')
	_delete = $(this).parent().siblings('span.delete_image')
	_loader.show('fast');
	$('form#file_upload').submit();
	$('iframe#upload_target').load(function(){
	    _file = $(this).contents().find('body').text();
	    
	    if(_file != 'failure'){
		_loader.html('100%');
		_loader.show('fast');
		_delete.show('fast');       
		if($('input[name="filename"]')){
		    $('input[name="filename"]').val(_file);
		    upimg = '/files/uploads/sheets/'+_file;
		    $('.upload_thumb').attr('src', upimg);
		}
		else {
		    alert('error uploading file, try again');
		}
	
	    }
	}, function(){
	    $(this).blur();
	});   
    });


    $("form.ajax").ajaxSubmit();
    
    $('.show_orders').live('click', function(e){
	e.preventDefault();
	filters.like = {
	    'user_id': $(this).attr('data')
	};
	$.postGo('/admin/carts', filters);
    });
    
    $('select#product_filter').change(function(){
	$.postGo('', $(this).val());
    });
    
    
    $('.filters_reset a').live('click', function(e){
	e.preventDefault();
	filters.related = {
	    'not': 'empty'
	};
	filters.pagesize = '10';
	postFilters();
    });
    
    $('select[name=typography]').live('change', function(){
	filters.related['package'] = $(this).val();
	postFilters();
    });
    
    $(".lang_tabs li a").live('click', function(e){
	e.preventDefault();
	var _id = $(this).attr('rel');
	$(this).parent().addClass('active').siblings('li').removeClass('active');
	$('.languages').hide();
	$('.'+_id).show();
    });
    
    if($('#message').html() != ''){
	$('#message').fadeIn('slow', function(){
	    $(this).css({
		'top': ($(window).height() / 2) - ($(this).height() / 2), 
		'left': ($(window).width() / 2) - ($(this).width() / 2) 
	    });
	    $(this).animate({
		top: '0'
	    }, 600, function() {
		setTimeout(function(){
		    $('#message').fadeOut('slow');
		}, '5000');
	    });
	});
    }   
    
    $('.calendar .day').live({  
	'mouseover': function(){
	    if($(this).text() > 0){
		$(this).css('background', '#cccccc');
	    }
	}, 
	'mouseout': function(){
	    if($(this).text() > 0){
		$(this).css('background', '#fff'); 
	    }
	}
    });
        
    
    
    $('.edit_paymethod').live('click', function(e){
	e.preventDefault();
	loadHolder($(this).attr('href'));
    });
    
    //    $('.discard').live('click', function(){
    //	history.go(-1); 
    //    });
    
    $('input#cloneall').live('change', function(){
	if($(this).is(':checked')){
	    $('.clone_check').attr('checked', true);
	} else {
	    $('.clone_check').attr('checked', false);
	}
    });
    
    $('input#chooseall').live('change', function(){
	if($(this).is(':checked')){
	    $('.choosenproducts').attr('checked', true);
	} else {
	    $('.choosenproducts').attr('checked', false);
	}
    });
    
    

    $('#clone_btn').live('click', function(e){
	e.preventDefault();
	checked = $('.clone_check:checked').length;
	if(checked != 0){
	    _href = $(this).attr('href');
	    $('.clone_check:checked').each(function(){
		_name = $(this).attr('name');
		_val = $(this).val();
		_bulk[_name] = _val;
		_bulk.model = _val;
	    });
	    if($('input[name=product]')){
		_bulk['product'] = $('input[name=product]').val();
	    }
            
	    modalWindow.open(_href, _bulk, 'post');
	}
    });

    $('#submit_clone').live('click', function(e){
	e.preventDefault();
	var _url = $('#clone_selectors').attr('action');
	grabSelectors();
	$.ajax({
	    type: 'post',
	    url: _url,
	    data: _bulk,
	    success: function(){
		modalWindow.close();
		console.log(_bulk);
		_bulk = {
		    'related': {}
		};
		postFilters();
	    }

	});
    });
    
    $('li.passive').hover(function(){
	$(this).children('ul').slideDown('fast');
    }, function(){
	$(this).children('ul').slideUp('fast');
    });

    $('.results th.cell').live('click', function(){
	if(filters.order == 'desc' && filters.orderby == $(this).attr('id')){
	    filters.order = 'acs';
	} else if (filters.order == 'acs' && filters.orderby == $(this).attr('id')){
	    filters.order = 'desc';
	}
	filters.orderby = $(this).attr('id')
	postFilters();
    });

    $('.edit, .delete, .add_menuitem, .preview_cell a, .history').live('click', function(e){
	e.preventDefault();
	var _url = $(this).attr('href');
	modalWindow.open(_url);
	$('.close').click(function(event){
	    event.stopPropagation();
	    modalWindow.close();
	});
    });

    $('.pagesize').live('change', function(){
	if(filters.pagesize != 0){
	    filters.pagesize = $(this).val();
	} else {
	    filters.pagesize = 1000;
	}
	grabFilters();
	postFilters();
    });
    
    $('#byactual').live('change', function(){
	if($(this).is(':checked')){
	    filters.byactual = 1;
	    grabFilters();
	    postFilters();
	} else {
	    delete filters.byactual;
	    postFilters();
	}
        
    });
    
    $('#reset_filters').live('click', function(e){
	e.preventDefault();
	location.reload();
    });

    $('.next_page, .prev_page, .page_number').live('click', function(e){
	console.log('asd');
	e.preventDefault();
	filters.page = $(this).attr('href');
	postFilters();
    });

    $('.filter input').bind({
	'blur': function(){
	    $(document).unbind('keydown');
	},
	'focus': function(){
	    $(document).bind('keydown', function(e){
		if(e.keyCode == 13){
		    e.preventDefault();
		    postFilters();
		}
	    });
	}
    });



    filters.where['orderstatus_id'] = $('.status_selector').val();
    if(filters.where['orderstatus_id'] == '00' || filters.where['orderstatus_id'] == undefined){
	delete filters.where['orderstatus_id'];
    }
    $('.status_selector').live('change', function(){
	orderstatus = $(this).val();
	if(orderstatus == '00'){
	    delete filters.where['orderstatus_id'];
	} else {
	    filters.where['orderstatus_id'] = orderstatus;
	}
	postFilters();
    });
    
    filters.where['user_id'] = $('.employees_selector option:selected:').val();
    if(filters.where['user_id'] == '00' || filters.where['user_id'] == undefined){
	delete filters.where['user_id'];
    }
    $('.employees_selector').live('change', function(){
	selecteduser = $(this).val();
	if(selecteduser != '00'){
	    filters.where['user_id'] = selecteduser;
	} else {
	    delete filters.where['user_id'];
	}
	postFilters();
    });

    

    initTopFilters();
    
    

    $('#products').live('change', function(){
	if(_post){
	    _post.related.product = $(this).val()
	}
	getTracks($(this).val());
    });
    $('#tracks').live('change', function(){
	if(_post){
	    _post.related.track = $(this).val()
	}
	getPrinttypes($(this).val());
    });
    $('#printtypes').live('change', function(){
	if(_post){
	    _post.related.printtype = $(this).val()
	}
	getSizes($(this).val());
    });

    $('#sizes').live('change', function(){
	if(_post){
	    _post.related.size = $(this).val()
	}
	getPapertypes($(this).val());
    });
    $('#papertypes').live('change', function(){
	if(_post){
	    _post.related.papertype = $(this).val()
	}
	getFoldpages($(this).val());
    });
    $('#foldpages').live('change', function(){
	if(_post){
	    _post.related.foldpage = $(this).val()
	}
	getAmountprices($(this).val());
    });


    $('#designproducts').live('change', function(){
	if(_post){
	    _post.related.designproduct = $(this).val()
	}
	getDesignProducts($(this).val());
    });
    $('#designsizes').live('change', function(){
	if(_post){
	    _post.related.designsize = $(this).val()
	}
	getDesignSizes($(this).val());
    });
    $('#designsides').live('change', function(){
	if(_post){
	    _post.related.designside = $(this).val()
	}
	getDesignSides($(this).val());
    });

});

function initTopFilters(){
    
    var top_filters = $('.top_filters select');
    
    $(top_filters).each(function(){
	var tf_id = $(this).attr('id');
	filters.related[tf_id] = $(this).val(); 
    });
    
    $(top_filters).live('change', function(){   
	var c_id = $(this).attr('id');
	filters.related[c_id] = $(this).val();
        
	var pin;
	for(i=0; i < $(top_filters).length; i++){
	    var _id = $(top_filters[i]).attr('id');
	    if(_id == c_id){
		pin = i;
	    } 
	    if(i > pin){
		delete(filters.related[_id]);
	    } else if(i > pin && $(top_filters[i]).val() == 0){
		delete(filters.related[_id]);
	    //filters.related[_id] = $(top_filters[i]).val();
	    }
            
	}
        
	postFilters();
    });
}

function getObj(url, container, id, callbk){
    $.ajax({
	type: 'post',
	url: url+id, 
	global: false, 
	success: function(res){
	    $(container).html(res);
	    if(callbk()){
	//                console.log('probejal')
	};
	}
    });
}

function getTracks(pid){
    getObj('/admin/chain/gettracks/', '#tracks', pid, function(){
	tid = $('#tracks option:first').attr('value');
	getPrinttypes(tid)
    });
}

function getPrinttypes(tid){
    getObj('/admin/chain/getprinttypes/', '#printtypes', tid, function(){
	ptid =  $('#printtypes option:first').attr('value');
	getSizes(ptid);
    });
}

function getSizes(ptid){
    getObj('/admin/chain/getsizes/', '#sizes', ptid, function(){
	szid = $('#sizes option:first').attr('value');
	getPapertypes(szid);
    });
}

function getPapertypes(szid){
    getObj('/admin/chain/getPapertypes/', '#papertypes', szid, function(){
	ptid = $('#papertypes option:first').attr('value');
	getFoldpages(ptid);
    });
    
}

function getFoldpages(ptid){
    getObj('/admin/chain/getFoldings/', '#foldpages', ptid, function(){
	//fid = $('#foldpages option:first').attr('value');
	//getAmountprices(fid)
	});
}
function getAmountprices(fid){
    getObj('/admin/chain/getAmountprices/', '#amountprices', fid, function(){    
	});
}

// Design tree
function getDesignProducts(tid){
    getObj('/admin/chain/getdesignsizes/', '#designsizes', tid, function(){
	ptid =  $('#designsizes option:first').attr('value');
	getDesignSizes(ptid);
    });
}
function getDesignSizes(ptid){
    console.log(ptid);
//    getObj('/admin/chain/getsizes/', '#sizes', ptid, function(){
//	szid = $('#sizes option:first').attr('value');
//	getPapertypes(szid);
//    });
}
//function getDesignSides(ptid){
//    getObj('/admin/chain/getsizes/', '#sizes', ptid, function(){
//	szid = $('#sizes option:first').attr('value');
//	getPapertypes(szid);
//    });
//}
// end
var modalWindow = {
    box: $('<div>', {
	css: {
	    'position': 'fixed',
	    'display': 'none',
	    'z-index': 9999,
	    'padding': '35px',
	    'background': '#fff',
	    'border': '1px solid #666',
	    'maxHeight': '90%',
	    'maxWidth': '90%',
	    'overflow': 'auto'
            
	},
	'class': 'modalBox'
    }),
    x_close: $('<div>', {
	css: {
	    'position': 'absolute',
	    'top': '4px',
	    'right': '4px',
	    'width': '25px',
	    'height': '12px',
	    'background': '#f2f2f2'
	},
	html: '<span class="x_close"></span>'            
    }),
        
    overlay: $('<div>', {
	css: {
	    'position': 'fixed',
	    'display': 'none',
	    'top': 0,
	    'right': 0,
	    'width': '100%',
	    'height': '100%',
	    'z-index': 8888,
	    'background': '#000',
	    'opacity': 0.6

	},
	'class': 'modalOverlay',
	'click': function(){
	    modalWindow.close();
	}
    }),
    open: function(url, context, type){
	$('body').append(this.overlay, this.box);
	$.ajax({
	    type: type,
	    url: url,
	    data: context,
	    global: false,
	    success: function(result){
		$(modalWindow.box).html(result);
		$(modalWindow.box).append(modalWindow.x_close)
		//console.log(result);
		modalWindow.position();
		$('.x_close').live('click', function(){
		    modalWindow.close();
		});
	    },
	    error: function(result){
		console.log(result);
	    }
	});
    },
    open_el: function(obj, callback_fn){
	$('body').append(this.overlay, this.box);
	$(modalWindow.box).html(obj);
	modalWindow.position(callback_fn);
    },
    position: function(callback_fn){
	if(callback_fn){
	    modalWindow.overlay.fadeIn('slow', callback_fn());
	} else {
	    modalWindow.overlay.fadeIn('slow');
	}
	var wh = $(window).height() / 2;
	var ww = $(window).width() / 2;
	var mh = $(modalWindow.box).height()/ 2;
	var mw = $(modalWindow.box).width()/ 2;
	$(this.box).css({
	    'top': wh - mh ,
	    'left': ww - mw,
	    'display': 'block'
	});
    },
    close: function(){
	modalWindow.box.fadeOut('fast');
	modalWindow.box.remove();
	modalWindow.overlay.fadeOut('fast');
	modalWindow.box.remove();
    }
}


function loadHolder(url){
    $.ajax({
	type: 'GET',
	url: url,
	success: function(data){
	    $('.holder').html(data);
	}
    });
}

$.fn.togglerHandler = function(){
    if(!$(this).hasClass('no-icon')) {
	$(this).append('<span class="toggle_icon">');
    }
     
    var box = $(this).parent().next('.collapsible');
    if(box.is(':visible')){
	$('span', $(this)).css('backgroundPosition', 'bottom left');   
    } else {
	$('span', $(this)).css('backgroundPosition', 'top left');
    }
    $(this).click(function(){
	console.log(box);
	if(box.is(':visible')){
	    $(box).slideUp('fast');
	    $('span', $(this)).css('backgroundPosition', 'top left');
	} else {
	    $(box).slideDown('fast'); 
	    $('span', $(this)).css('backgroundPosition', 'bottom left'); 
	}
    });
}

$.fn.hover = function( fn1, fn2, fn3 ) {
    if ( fn3 ) this.bind('hoverstart', fn1 ); // 3 args
    if ( fn2 ) this.bind('hoverend', fn3 ? fn3 : fn2 ); // 2+ args
    return !fn1 ? this.trigger('hover') // 0 args
    : this.bind('hover', fn3 ? fn2 : fn1 ); // 1+ args
};

// special event configuration
var hover = $.event.special.hover = {
    delay: 300, // milliseconds
    speed: 10, // pixels per second
    setup: function( data ){
	data = $.extend({
	    speed: hover.speed,
	    delay: hover.delay,
	    hovered:0
	}, data||{} );
	$.event.add( this, "mouseenter mouseleave", hoverHandler, data );
    },
    teardown: function(){
	$.event.remove( this, "mouseenter mouseleave", hoverHandler );
    }
};

// shared event handler
function hoverHandler( event ){
    var data = event.data || event;
    switch ( event.type ){
	case 'mouseenter': // mouseover
	    data.dist2 = 0; // init mouse distance²
	    data.event = event; // store the event
	    event.type = "hoverstart"; // hijack event
	    if ( $.event.handle.call( this, event ) !== false ){ // handle "hoverstart"
		data.elem = this; // ref to the current element
		$.event.add( this, "mousemove", hoverHandler, data ); // track the mouse
		data.timer = setTimeout( compare, data.delay ); // start async compare
	    }
	    break;
	case 'mousemove': // track the event, mouse distance² = x² + y²
	    data.dist2 += Math.pow( event.pageX-data.event.pageX, 2 )
	    + Math.pow( event.pageY-data.event.pageY, 2 );
	    data.event = event; // store current event
	    break;
	case 'mouseleave': // mouseout
	    clearTimeout( data.timer ); // uncompare
	    if ( data.hovered ){
		event.type = "hoverend"; // hijack event
		$.event.handle.call( this, event ); // handle "hoverend"
		data.hovered--; // reset flag
	    }
	    else $.event.remove( data.elem, "mousemove", hoverHandler ); // untrack
	    break;
	default: // timeout compare // distance² = x² + y²  = ( speed * time )²
	    if ( data.dist2 <= Math.pow( data.speed*( data.delay/1e3 ), 2 ) ){ // speed acceptable
		$.event.remove( data.elem, "mousemove", hoverHandler ); // untrack
		data.event.type = "hover"; // hijack event
		if ( $.event.handle.call( data.elem, data.event ) !== false ) // handle "hover"
		    data.hovered++; // flag for "hoverend"
	    }
	    else data.timer = setTimeout( compare, data.delay ); // async recurse
	    data.dist2 = 0; // reset distance² for next compare
	    break;
    }
    function compare(){
	hoverHandler( data );
    }; // timeout/recursive function
};


(function($) {
    $.extend({
	postGo: function(url, params) {
	    var $form = $("<form>")
	    .attr("method", "post")
	    .attr("action", url);
	    $.each(params, function(name, value) {
		if($(value).length > 0 && $(value)){
		    $.each(value, function(sub_name, sub_value) {
			$("<input type='hidden'>")
			.attr("name", name+'['+ sub_name +']')
			.attr("value", sub_value)
			.appendTo($form);
		    });
		} else {
		    $("<input type='hidden'>")
		    .attr("name", name)
		    .attr("value", value)
		    .appendTo($form);
		}
	    });
	    $form.appendTo("body");
	    $form.submit();
	}
    });
})(jQuery);
