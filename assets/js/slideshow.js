$(document).ready(function(){
    $('.slideshow').slideshow('3');
});

var slideshow;

// Slideshow plugin begin
$.fn.slideshow = function(speed){
    var timer;
    slideshow = new Slideshow(this, speed);
    timer = setInterval(function(){
	slideshow.nextslide();
    }, speed + "000")
    $(this).hover(function(){
	clearInterval(timer);
    }, function(){
	timer = setInterval(function(){
	    slideshow.nextslide();
	}, speed + "000")
    });
    slideshow.controls();
}
//Slideshow object
function Slideshow(obj) {
    this.settings = {
	clock: 1,
	slides: [],
	timer: '',
	kids: []
    }

    this.settings.kids = $(obj).children();

    var kids_w = $(this.settings.kids[0]).find('img').width();
    var kids_h = $(this.settings.kids[0]).find('img').height();
    $(this.settings.kids).css({
	'display': 'none'
    });

    //Creating Slide instatnces
    $(this.settings.kids[0]).css('display' ,'block');
    for (i=0; i < this.settings.kids.length; i++){
	var _slide = new Slide(this.settings.kids[i]);
	this.settings.slides.push(_slide);
    }

    this.nextslide = function() {
	if(this.settings.clock == this.settings.kids.length){
	    $(this.settings.kids).fadeOut('slow');
	    this.settings.slides[0].show();
	    this.settings.clock = 0;
	    this.set_active();
	    this.settings.clock = 1;
	} else {
	    $(this.settings.kids).fadeOut('slow');
	    this.settings.slides[this.settings.clock].show();
	    this.set_active();
	    this.settings.clock = this.settings.clock+1;
	}
	
    }
    
    this.set_active = function(){
	controls = $('.control');
	$('.control').removeClass('active');
	$(controls[this.settings.clock]).addClass('active');
    }
    
    this.goto_slide = function(clock){
	this.settings.clock = clock;
	$(this.settings.kids).fadeOut('slow');
	this.settings.slides[clock].show();
	this.set_active();
	
    }
    
    this.controls = function(){
	_html = $('<div>',{
	    'id': 'controls'
	});
	$('.slideshow').append(_html);
	
	if(this.settings.slides.length > 1){
	    $.each(this.settings.slides, function(index){
		_control = new Control(index);
		console.log($(_control));
		$('#controls').append(_control._html);
	    });
	}
    }

    function Control(index){
	this._html = $('<span>', {
	    css: {
		'display': 'block',
		'width': '11px',
		'height': '11px',
		'float': 'left'
	    },
	    'class': 'control',
	    'rel': index,
	    'click': function(){
		slideshow.goto_slide(index);
	    }
	});
    }


    //Slide object
    function Slide(obj){
	this.show = function(){
	    $(obj).fadeIn("slow")
	}
	this.hide = function(){
	    $(obj).fadeOut("slow")
	}
    }
}