<div id="product_widget">
    <h3><?php echo lang('toadd') . ' ' . $product->name . ' ' . lang('to_cart') ?>:</h3>
    <?php
    echo form_hidden('pid', $product->id);
    echo '<div class="props clearfix">';
    
    echo '<div class="prop_selector">';
    echo form_label($product->track_label, 'track_id', array('class' => 'inline_label'));
    echo '<select name="track_id" id="tracks">';
    if (isset($this->user)) {
	$product->track->where_in_related('product', $product)->get();
    } else {
	$product->track->where_in_related('tracktype', 'id', 1)->get();
    }
    foreach ($product->track as $track) {
	$track->dbtranslate($this->language);
	$sel = $track->id == $preset['track'] ? 'selected="selected"' : '';
	echo '<option value="' . $track->id . '" '.$sel.'>' . $track->name . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->track_desc . '</div>&nbsp;</span>';
    echo '</div>';
    
    echo '<div class="prop_selector">';
    echo form_label($product->printtype_label, 'printtype_id', array('class' => 'inline_label'));
    echo '<select name="printtype_id" id="printtypes">';
    foreach ($printtypes as $pt) {
	$pt->dbtranslate($this->language);
	$sel = $pt->id == $preset['printtype'] ? 'selected="selected"' : '';
	echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->printtype_desc . '</div>&nbsp;</span>';
    echo '</div>';
    
    echo '<div class="prop_selector">';
    echo form_label($product->sizes_label, 'size_id', array('class' => 'inline_label'));
    echo '<select name="size_id" id="sizes">';
    foreach ($sizes as $pt) {
	$pt->dbtranslate($this->language);
	$sel = $pt->id == $preset['size'] ? 'selected="selected"' : '';
	echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->sizes_desc . '</div>&nbsp;</span>';
    echo '</div>';


    echo '<div class="prop_selector">';
    echo form_label($product->papertype_label, 'papertype_id', array('class' => 'inline_label'));
    echo '<select name="papertype_id" id="papertypes">';
    foreach ($papertypes as $pt) {
	$pt->dbtranslate($this->language);
	$sel = $pt->id == $preset['papertype'] ? 'selected="selected"' : '';
	echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->papertype_desc . '</div>&nbsp;</span>';
    echo '</div>';

    echo '<div class="prop_selector">';
    echo form_label($product->pagetype_label, 'foldpage_id', array('class' => 'inline_label'));
    echo '<select name="foldpage_id" id="foldpages">';
    foreach ($foldpages as $pt) {
	$pt->dbtranslate($this->language);
	$sel = $pt->id == $preset['foldpage'] ? 'selected="selected"' : '';
	echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->pagetype_desc . '</div>&nbsp;</span>';
    echo '</div>';
    echo '<div class="prop_selector">';
    echo form_label($product->amountcost_label, 'amountprice_id', array('class' => 'inline_label'));
    echo '<select name="amountprice_id" id="amountprices">';
    foreach ($pricerows as $pt){
	$sel = $pt->id == $preset['pricerow'] ? 'selected="selected"' : '';
	echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->quantity . '</option>';
    }
    echo '</select>';
    echo '<span class="description"><div>' . $product->amountcost_desc . '</div>&nbsp;</span>';
    echo '</div>';
    
    echo '</div>';
    foreach ($addons as $addon) {
	$addon->dbtranslate($this->language);
	$optional = $addon->optional ? 'optional' : '';

	echo '<div class="prop_selector ' . $optional . '">';
	echo form_label($addon->addon_label, 'addon_id', array('class' => 'inline_label'));
	echo '<select name="addon[' . $addon->id . ']" class="addons" id="' . $addon->id . '">';
	$_addons = $addon->addonopt->where('amountprice_id', $amountprice->id)->get();
	foreach ($_addons as $k => $pt){
	    $pt->dbtranslate($this->language);
	    $sel = $pt->id == $preset['addons'][$addon->id] ? 'selected="selected"' : '';
	    echo '<option value="' . $pt->id . '" ' . $sel . '>' . $pt->name . '</option>';
    }
	echo '</select>';
	echo '<span class="description"><div>' . $addon->addon_desc . '</div>&nbsp;</span>';
	echo '</div>';
    }
    
    ?>
    
    <a href="#" class="ext_opt_tr"><span class="open_ext_options">+ <?php echo lang('click_extended_option'); ?></span><span class="close_ext_options">- <?php echo lang('close_extended_option'); ?></span></a>
    <div class="ext_options"></div>


    <div class="price_padd">
	<?php if(!empty($total)):?>
	<div class="clearfix">
	    
	    <span class="right"><?php echo lang('total_price') ?>: </span>
	    <span class="left">
		<span id="price"><?php echo $total;?></span>
		<span><?php echo lang('currency') ?></span>
	    </span>
	</div>
	<div class="clearfix">
	    <span class="right"><?php echo lang('total_price_vat') ?>: </span>
	    <span class="left">
		<span id="price_vat"><?php echo $total_vat;?></span>
		<span><?php echo lang('currency'); ?></span>
	    </span>
	</div>
	<?php endif;?>
    </div>
    <div class="center price_caption"><?php echo lang('choose_design_option_continue'); ?></div>
</div>

<script type="text/javascript">
approval = 0;
</script>