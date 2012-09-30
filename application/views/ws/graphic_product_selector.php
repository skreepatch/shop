    <?php
    
    echo form_hidden('pid', $designproduct->id);
    echo '<div class="design_props clearfix">';
    
    echo '<div class="design_prop_selector">';
    echo form_label($designproduct->size_label, 'sizes', array('class' => 'inline_label'));
    echo '<select name="designsize_id" id="designsize">';
    $designproduct->designsize->get();
    foreach ($designproduct->designsize as $dsz) {
	$sel = $dsz->id == $preset['designsize'] ? 'selected="selected"' : '';
	echo '<option value="' . $dsz->id . '" '.$sel.'>' . $dsz->{'name_'.$this->language} . '</option>';
    }
    echo '</select>';
    echo '</div>';
    
    echo '<div class="design_prop_selector">';
    echo form_label($designproduct->sides_label, 'sides', array('class' => 'inline_label'));
    echo '<select name="designside_id" id="designside">';
    $designproduct->designside->get();
    foreach ($designproduct->designside as $dsd) {
	$sel = $dsd->id == $preset['designside'] ? 'selected="selected"' : '';
	echo '<option value="' . $dsd->id . '" '.$sel.'>' . $dsd->{'name_'.$this->language} . '</option>';
    }
    echo '</select>';
    echo '</div>';  
    echo '</div>';
    ?>
<div class="designtypes clearfix">
	    <?php
	    foreach ($designtypes as $dt):
		$dt->dbtranslate($this->language);
		$typeswitch;
		$url;
		switch ($dt->id) {
		    case '1':
			$typeswitch = 'self';
			$url = site_url('/products/designer/'.$designproduct->product->id.'/'.$preset['designside']);
			break;
		    case '2':
			$typeswitch = 'tpl';
			$url = site_url('products/graphicdesign_approval/'. $ordering->id.'/'.$dt->id.'/'.$preset['designsize'].'/'.$preset['designside']);
			break;
		    case '3':
			$typeswitch = 'gfx';
			$url = site_url('products/graphicdesign_approval/'. $ordering->id.'/'.$dt->id.'/'.$preset['designsize'].'/'.$preset['designside']);
			break;
		}
		?>
    	    <div class="<?php echo 'designtype_' . $dt->id ?> p_index" id="<?php echo 'designtype_' . $dt->id ?>">
    		<div class="inner">
		    <div class="designtype_box_content">
    		    <h3><?php echo $dt->name ?></h3>	
    		    <h4><?php echo $designproduct->{$typeswitch . '_label'}; ?></h4>
    		    <div><?php echo $designproduct->{$typeswitch . '_desc'}; ?></div>
		    </div>
		    <div class="designprice">
			<?php $_price = $dt->designprice->where_in_related('designside', 'id', $preset['designside'])->get()->price;
			$prs = $_price != 0 ? $_price : lang('free');
			echo lang('cost') . ': ' . $prs?>
		    </div>
		    <div class="designtype">
			<a href="<?php echo $url; ?>" title="<?php echo $dt->{'name_'.$this->language}?>"><?php echo $dt->{'name_'.$this->language}?></a>
		    </div>
    		</div>
    	    </div>
<?php endforeach; ?>
	</div>