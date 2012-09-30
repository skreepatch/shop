<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>
<?php
echo form_open(site_url('admin/addons/editoptions/' . $addon->id), array('id' => 'folding'));

echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
echo form_fieldset();
echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
echo '<select name="product" id="products">';
if (isset($products)) {
    echo '<option value="00" selected="selected">' . lang('choose_product') . '</option>';
    foreach ($products as $product) {
	$product->dbtranslate($this->language);
	echo '<option value="' . $product->id . '" selected="selected">' . $product->name . '</option>';
    }
} else {
    if ($related['product']->id == $addon->product->id) {
	$related['product']->dbtranslate($this->language);
	echo '<option value="' . $related['product']->id . '" selected="selected">' . $related['product']->name . '</option>';
    } else {
	return FALSE;
    }
}

echo '</select>';
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('totrack'), 'track', array('class' => 'inline_label'));
echo '<select name="track" id="tracks">';
echo '<option>' . lang('choose_track') . '</option>';
foreach ($tracks as $track) {
    $track->dbtranslate($this->language);
    echo $amprice->track->id . ' and track is ' . $related['track']->id;
    if ($related['track']->id == $track->id) {
	echo '<option value="' . $track->id . '" selected="selected">' . $track->name . '</option>';
    } else {
	echo '<option value="' . $track->id . '">' . $track->name . '</option>';
    }
}
echo '</select>';
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('toprinttype'), 'printtype', array('class' => 'inline_label'));
echo '<select name="printtype" id="printtypes">';
echo '<option>' . lang('choose_printtype') . '</option>';
foreach ($printtypes as $printtype) {
    $printtype->dbtranslate($this->language);
    if ($related['printtype']->id == $printtype->id) {
	echo '<option value="' . $printtype->id . '" selected="selected">' . $printtype->name . '</option>';
    } else {
	echo '<option value="' . $printtype->id . '">' . $printtype->name . '</option>';
    }
}

echo '</select>';
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('tosize'), 'size', array('class' => 'inline_label'));
echo '<select name="size" id="sizes">';
echo '<option>' . lang('choose_size') . '</option>';
foreach ($sizes as $size) {
    $size->dbtranslate($this->language);
    if ($related['size']->id == $size->id) {
	echo '<option value="' . $size->id . '" selected="selected">' . $size->name . '</option>';
    } else {
	echo '<option value="' . $size->id . '">' . $size->name . '</option>';
    }
}

echo '</select>';
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('topapertype'), 'papertype', array('class' => 'inline_label'));
echo '<select name="papertype" id="papertypes">';

echo '<option>' . lang('choose_papertype') . '</option>';
foreach ($papertypes as $papertype) {
    $papertype->dbtranslate($this->language);
    if ($related['papertype']->id == $papertype->id) {
	echo '<option value="' . $papertype->id . '" selected="selected">' . $papertype->name . '</option>';
    } else {
	echo '<option value="' . $papertype->id . '">' . $papertype->name . '</option>';
    }
}
echo '</select>';
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('tofoldpage'), 'foldpage', array('class' => 'inline_label'));
echo '<select name="foldpage" id="foldpages">';
echo '<option>' . lang('choose_foldpage') . '</option>';
foreach ($foldpages as $foldpage) {
    $foldpage->dbtranslate($this->language);
    if ($related['foldpage']->id == $foldpage->id) {
	echo '<option value="' . $foldpage->id . '" selected="selected">' . $foldpage->name . '</option>';
    } else {
	echo '<option value="' . $foldpage->id . '">' . $foldpage->name . '</option>';
    }
}

echo '</select>';
echo form_fieldset_close();
echo form_fieldset_close();


echo form_fieldset(lang('edit_addon_options'), array('class' => 'grey_border', 'id' => 'sides_manager'));

echo form_fieldset();
echo '<div class="left"><a href="/" title="' . lang('add') . '" class="add_row">' . lang('add') . '</a></div>';
echo '<div class="right" id="rows">';
echo form_label(lang('rows_number'));
//echo form_dropdown('rows', array('1' => '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'));
echo form_input('rows', '1');
echo '</div>';
echo form_fieldset_close();

echo '<ul class="lang_tabs">';
foreach ($this->config->item('languages') as $language) {
    $active = $language == 'hebrew' ? 'active' : '';
    echo '<li class="tab ' . $active . '"><a href="#" title="' . $language . '" rel="' . $language . '">' . $language . '</a></li>';
}
echo '</ul>';




echo '<table class="addonrows">';

echo '<thead>
        <th>' . lang('id') . '</th>
        <th>' . lang('name') . '</th>
        <th>' . lang('weight') . '</th>
        <th>' . lang('additional_weight') . '</th>
        <th>' . lang('show') . '</th>
    </thead>
    <tbody>';
$odd = FALSE;
if (isset($addonopts) && $addonopts != FALSE) {
    foreach ($addonopts as $k => $v) {
	$odd = !$odd;
	$show = ($v->show == 1) ? "checked" : "";

	echo '<tr class="' . ($odd ? "odd" : "even") . '">
                    <td id="row_num">' . ($k + 1) . '<input type="hidden" name="id[' . ($k + 1) . ']" value="' . $v->id . '"/></td>';
	foreach ($this->config->item('languages') as $l) {
	    echo '<td class="languages ' . $l . '"><input type="text" name="name_' . $l . '[' . ($k + 1) . ']" value="' . $v->{'name_' . $l} . '"/></td>';
	}

	echo '<td><input type="text" name="weight[' . ($k + 1) . ']" value="' . $v->weight . '"/></td>
                    <td><input type="text" name="addweight[' . ($k + 1) . ']" value="' . $v->addweight . '"/></td>
                    <td><input type="checkbox" name="show[' . ($k + 1) . ']" ' . $show . '/></td>
                </tr>';
    }
}
echo '</tbody>';
echo '</table>';

echo form_fieldset_close();

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>