
<h1><?php echo $title;?></h1>
<div class="product_grid">
    <?php foreach ($products as $product): 
	$converted_price = $this->currency->convert('USD', config_item('curr'), $product->lowestPrice());
	?>
        <div class="grid_item">
    	<div class="side">
    	    <img class="thumb" src="<?php echo site_url('files/uploads/images/' . $product->image) ?>"/>
    	    <div class="price"><?php echo $this->currency->fetch_symbol(config_item('curr'), $converted_price['to_amount']); ?></div>
    	</div>
    	<div class="description">
	    <h3><a href="<?php echo site_url('online-pharmacy/'.urlencode(strtolower($product->category->name)).'/'.urlencode(strtolower($product->trimmed_name)));?>" title="<?php echo $product->trimmed_name;?>"><?php echo $product->trimmed_name;?></a></h3>
    	    <div class="active_ing"><?php echo $product->active_ingredient; ?></div>
	    <div class="available_dosage">
		<?php getDosages($product);?>
	    </div>
    	    <div class="trimmed_desc"><?php
	    $desired_width = 80;
	    $string = html_escape($product->short_desc);
	if (strlen($string) > $desired_width) {
	    $string = wordwrap($string, $desired_width);
	    $string = substr($string, 0, strpos($string, "\n"));
	    echo $string . '... <a href="' . site_url('online-pharmacy/'.urlencode(strtolower($product->category->name)).'/'.urlencode(strtolower($product->trimmed_name))) . '" title="' . $product->name . '" class="readmore">' . lang('read_more') . '</a>';
	} else {
	    echo $string;
	}
	
	?></div>
	    <a class="grey_btn" href="<?php echo site_url('online-pharmacy/'.urlencode(strtolower($product->category->name)).'/'.urlencode(strtolower($product->trimmed_name)));?>" title="<?php echo 'buy '.$product->trimmed_name.' online';?>"><?php echo lang('buy_now')?></a>
    	</div>
        </div>
<?php endforeach; ?>
</div>