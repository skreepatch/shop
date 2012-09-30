<?php foreach($slides as $slide):?>
    <div class="slide clearfix">
	    <img src="<?php echo site_url('files/uploads/images/'.$slide->image);?>" alt="<?php echo $slide->text?>" title="<?php echo $slide->text?>"/>
    </div>
<?php endforeach;?>
