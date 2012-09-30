<div class="change_bonus">
    <h3>Choose Your Bonus</h3>
    <div class="inner">
    <?php foreach ($bonuses as $bonus):
	$active = ($current_bonus == $bonus->id) ? 'active' : 'disabled';
    ?>
	<div class="<?php echo $active;?> bonuspack">
	    <div class="bonus_title"><span class="bonus_name"><?php echo $bonus->name?></span><span><?php echo $bonus->description;?></span></div>
	    <?php foreach ($bonus_products as $bp): 
		$active_class = ($bp->id == $bonus_item && $active == 'active') ? 'active' : '';
	    ?>
		<div class="<?php echo $active_class;?> bonus_product">
		    <a href="<?php echo site_url('shopping_cart/index/'.$bp->id);?>">
			<div class="checkbox"></div>
			<div class="product_name"><?php echo $bp->trimmed_name;?></div>
			<div class="italic"><?php echo $bp->dozage . 'mg - ' . $bonus->amount . ' pills'?></div>
		    </a></div>
	    <?php endforeach; ?>
        </div>
	<?php endforeach; ?>
    </div>
</div>