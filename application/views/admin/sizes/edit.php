<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>
<?php

echo '<ul class="lang_tabs">';
foreach ($this->config->item('languages') as $language) {
    $active = $language == 'hebrew' ? 'active' : '';
    echo '<li class="tab ' . $active . '"><a href="#" title="' . $language . '" rel="' . $language . '">' . $language . '</a></li>';
}
echo '</ul>';
echo form_open($url);
echo form_hidden('id', $size->id);
foreach ($this->config->item('languages') as $l) {
    echo '<div class="lang_wrapper languages language '.$l.'">';
    echo form_fieldset();
    echo form_label(lang('size_name') . ':', 'name', array('class' => 'inline_label'));
    echo form_input('name_'.$l, $size->{'name_'.$l});
    echo form_fieldset_close();
    echo '</div>';
}

echo form_fieldset();
echo form_label(lang('size_width') . ':', 'width', array('class' => 'inline_label'));
echo form_input('width', $size->width);
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('size_height') . ':', 'height', array('class' => 'inline_label'));
echo form_input('height', $size->height);
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('weight') . ':', 'weight', array('class' => 'inline_label'));
echo form_input('weight', $size->weight);
echo form_fieldset_close();

echo '<div class="status_picker">';
echo form_label(lang('status'), 'status_id', array('class' => 'inline_label'));
foreach ($statuses as $status) {
    echo form_label($status->name, array('class' => 'inline_label'));
    if ($status->id == $size->status_id) {
        echo form_radio('status_id', $status->id, $checked = TRUE);
    } else {
        echo form_radio('status_id', $status->id, $checked = FALSE);
    }
}
echo '</div>';
echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
echo form_fieldset();
echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
echo '<select name="product" id="products">';
echo '<option>' . lang('choose_product') . '</option>';
foreach ($products as $product) {
    $product->dbtranslate($this->language);
    $size->product->get();
    if ($product->id == $size->product->id) {
        echo '<option value="' . $product->id . '" selected="selected">' . $product->name . '</option>';
    } else {
        echo '<option value="' . $product->id . '">' . $product->name . '</option>';
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
    $size->track->get();
    if ($track->id == $size->track->id) {
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
    $size->printtype->get();
    if ($printtype->id == $size->printtype->id) {
        echo '<option value="' . $printtype->id . '" selected="selected">' . $printtype->name . '</option>';
    } else {
        echo '<option value="' . $printtype->id . '">' . $printtype->name . '</option>';
    }
}
echo '</select>';
echo form_fieldset_close();
echo form_fieldset_close();

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>