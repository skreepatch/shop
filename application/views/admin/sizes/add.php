<div class="cont_heading">
    <h2><?= $title ?></h2>
</div>
<?php

echo form_open('/admin/sizes/save');
echo form_fieldset();
echo form_label(lang('size_name').':', 'name', array('class' => 'inline_label'));
echo form_input('name');
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('size_width').':', 'width', array('class' => 'inline_label'));
echo form_input('width');
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('size_height').':', 'height', array('class' => 'inline_label'));
echo form_input('height');
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('weight').':', 'weight', array('class' => 'inline_label'));
echo form_input('weight');
echo form_fieldset_close();


echo '<div class="status_picker">';
echo form_label(lang('status').':', 'status_id', array('class' => 'inline_label'));
foreach ($statuses as $status) {
    echo form_label($status->name, array('class' => 'inline_label'));
    echo form_radio('status_id', $status->id);
}
echo '</div>';

echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
    echo form_fieldset();
    echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
    echo '<select name="product" id="products">';
        echo '<option>'.lang('choose_product').'</option>';
    foreach ($products as $product) {
        echo '<option value="'.$product->id.'">'.$product->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
    echo form_fieldset();
    echo form_label(lang('totrack'), 'track', array('class' => 'inline_label'));
    echo '<select name="track" id="tracks">';
        echo '<option>'.lang('choose_track').'</option>';
    foreach ($tracks as $track) {
        echo '<option value="'.$track->id.'">'.$track->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
    echo form_fieldset();
    echo form_label(lang('toprinttype'), 'printtype', array('class' => 'inline_label'));
    echo '<select name="printtype" id="printtypes">';
        echo '<option>'.lang('choose_printtype').'</option>';
    foreach ($printtypes as $printtype) {
        echo '<option value="'.$printtype->id.'">'.$printtype->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
echo form_fieldset_close();

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>