
<div class="clearfix">
    <h2 class="title"><?php echo $ordering->product->name?></h2>
    <hr/>
    <div class="preview_images">
	<?php foreach($images as $i):?>
	<div class="preview_image">
	    <h3><?php echo $i->pageside->dbtranslate($this->language)->name?></h3>
	    <img src="<?php echo $i->preview?>" alt="" title=""/>
	</div>
	<?php endforeach;?>
    </div>
    <hr/>
    <div class="preview_thumbs">
	<?php foreach($images as $i):?>
	<div class="preview_thumb">
	    <h5><?php echo $i->pageside->dbtranslate($this->language)->name?></h5>
	    <a href="#"><img src="<?php echo $i->url?>" alt="" title="" height="70"/></a>
	</div>
	<?php endforeach;?>
    </div>
</div>
<script>
    $('.preview_thumb').each(function(index){
	if(index == 0){
	    $(this).addClass('active');
	}
	$('a', $(this)).click(function(e){
	   e.preventDefault();
	   var images = $('.preview_image');
	   $('.preview_images').css({'width': $(images[index]).width(), 'height': $(images[index]).height()})
	   $(images).fadeOut('fast');
	   $(this).parent().siblings().removeClass('active');
	   $(this).parent().addClass('active');
	   setTimeout(function(){$(images[index]).fadeIn('fast')}, '300');
	});
    });
</script>