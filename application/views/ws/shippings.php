<h1><?php echo $title ?></h1>

<div class="inner">
    <br/>
    <?php foreach ($shippings as $shipping): ?>
        <div class="shipping_method clearfix">

    	<div class="bonus_icon center">
    	    <img src="<?php echo '/files/uploads/images/'.$shipping->image ?>" alt="<?php echo $shipping->name; ?>" title="<?php echo $shipping->name; ?>" />
    	</div>
    	<div class="description">
	    <h3><?php echo $shipping->name;?></h3>
    	    <p><?php echo $shipping->description ?></p>
    	</div>

        </div>
    <?php endforeach; ?>
</div>
<div class="inner" id="package_mathod">
    <span class="pack_icon">&nbsp;</span><h2>Packing Method</h2>
    <?php echo setting_item('packing_method');?>
</div>

