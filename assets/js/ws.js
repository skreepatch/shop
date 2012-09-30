$(document).ready(function(){
   search_default = $('#search').val();
   $('#search').focus(function(){
          $('#search').val('');
   }).blur(function(){
       if($('#search').val() == ''){
	   $('#search').val(search_default);
       }
   });
   
   $('.faq').click(function(e){
      e.preventDefault();
      $(this).toggleClass('expanded');
   });
   
   $('#shipping_id').change(function(){
      location.href = '?shipping='+$(this).val();
   });
   
   $('.currencies').change(function(){
     location.href = '/home/switch_currency/'+$(this).val();
   });
   
   $('.change_bonus').click(function(e){
       e.preventDefault();
       modalWindow.open($(this).attr('href'));
   });
   
   
});

var modalWindow = {
    box: $('<div>', {
	css: {
	    'position': 'fixed',
	    'display': 'none',
	    'z-index': 9999,
	    'padding': '0',
	    'background': '#fff',
	    'border': '1px solid #666',
	    'maxHeight': '90%',
	    'maxWidth': '90%',
	    'overflow': 'auto',
	    'borderRadius': '8px',
	    'boxShadow': '0 0 140px #000000'
            
	},
	'class': 'modalBox'
    }),
    x_close: $('<div>', {
	css: {
	    'position': 'absolute',
	    'top': '8px',
	    'right': '10px',
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
	    'opacity': 0.3

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