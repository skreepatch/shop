

	<h3><?php echo lang('ordering_product_details') ?>:</h3>
	<?php
	$product->dbtranslate($this->language);
	$track->dbtranslate($this->language);
	$printtypes->dbtranslate($this->language);
	$sizes->dbtranslate($this->language);
	$papertypes->dbtranslate($this->language);
	$foldpages->dbtranslate($this->language);

	echo form_hidden('pid', $product->id);

	echo '<div class="prop_selector">';
	echo form_label($product->track_label, 'track_id', array('class' => 'inline_label'));
	echo '<select name="track_id" id="tracks">';
	echo '<option value="' . $track->id . '">' . $track->name . '</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="prop_selector">';
	echo form_label($product->printtype_label, 'printtype_id', array('class' => 'inline_label'));
	echo '<select name="printtype_id" id="printtypes">';
	echo '<option value="' . $printtypes->id . '">' . $printtypes->name . '</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="prop_selector">';
	echo form_label($product->sizes_label, 'size_id', array('class' => 'inline_label'));
	echo '<select name="size_id" id="sizes">';
	echo '<option value="' . $sizes->id . '">' . $sizes->name . '</option>';
	echo '</select>';
	echo '</div>';


	echo '<div class="prop_selector">';
	echo form_label($product->papertype_label, 'papertype_id', array('class' => 'inline_label'));
	echo '<select name="papertype_id" id="papertypes">';
	echo '<option value="' . $papertypes->id . '">' . $papertypes->name . '</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="prop_selector">';
	echo form_label($product->pagetype_label, 'foldpage_id', array('class' => 'inline_label'));
	echo '<select name="foldpage_id" id="foldpages">';
	echo '<option value="' . $foldpages->id . '">' . $foldpages->name . '</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="prop_selector">';
	echo form_label($product->amountcost_label, 'amountprice_id', array('class' => 'inline_label'));
	echo '<select name="amountprice_id" id="amountprices">';
	foreach ($pricerows as $pt) {
	    $sel = $pt->id == $preset['pricerow'] ? 'selected="selected"' : '';
	    echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->quantity . '</option>';
	}
	echo '</select>';
	echo '</div>';

	
	foreach ($addons as $addon) {
	    $addon->dbtranslate($this->language);
	    $optional = $addon->optional ? 'optional' : '';

	    echo '<div class="prop_selector ' . $optional . '">';
	    echo form_label($addon->addon_label, 'addon_id', array('class' => 'inline_label'));
	    echo '<select name="addon[' . $addon->id . ']" class="addons" id="' . $addon->id . '">';
	    $_addons = $addon->addonopt->where('amountprice_id', $amountprice->id)->get();
	    foreach ($_addons as $pt) {
		$pt->dbtranslate($this->language);
		$sel = $pt->id == $preset['addons'][$addon->id] ? 'selected="selected"' : '';
		echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
	    }
	    echo '</select>';
	    echo '</div>';
	}
	?>

	<a href="#" class="ext_opt_tr">+ <?php echo lang('click_extended_option'); ?></a>
	<div class="ext_options"></div>


	<div class="price_padd">
	    <?php if (!empty($total)): ?>
    	    <div class="clearfix">

    		<span class="right"><?php echo lang('total_price') ?>: </span>
    		<span class="left">
    		    <span id="price"><?php echo $total; ?></span>
    		    <span><?php echo lang('currency') ?></span>
    		</span>
    	    </div>
    	    <div class="clearfix">
    		<span class="right"><?php echo lang('total_price_vat') ?>: </span>
    		<span class="left">
    		    <span id="price_vat"><?php echo $total_vat; ?></span>
    		    <span><?php echo lang('currency'); ?></span>
    		</span>
    	    </div>
	    <?php endif; ?>
	</div>


<script>
    approval = '<?php echo $ordering->id; ?>';
</script>