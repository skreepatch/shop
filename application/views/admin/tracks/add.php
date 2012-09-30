<div class="cont_heading">
    <h2><?= $title ?></h2>
</div>

<?php

echo form_open('/admin/tracks/save');

echo form_fieldset();
echo form_label('שם המסלול', 'name', array('class' => 'inline_label'));
echo form_input('name');
echo form_fieldset_close();
echo form_fieldset();
echo form_label('ערך מסלול', 'value', array('class' => 'inline_label'));
echo form_input('value');
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('weight'), 'weight', array('class' => 'inline_label'));
echo form_input('weight');
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('track_type'), 'tracktype_id', array('class' => 'inline_label'));
echo '<select name="tracktype_id">';
foreach ($types as $type) {
    echo form_label($type->type, array('class' => 'inline_label'));
    echo '<option value="'.$type->id.'" >'.$type->type.'</option>';
}
echo '</select>';
echo form_fieldset_close();
echo form_fieldset();
echo '<div class="status_picker">';
echo form_label(lang('status'), 'tracktype_id', array('class' => 'inline_label'));
foreach ($statuses as $status) {
    echo form_label($status->name, array('class' => 'inline_label'));
    echo form_radio('status_id', $status->id);
}
echo '</div>';
echo form_fieldset_close();


echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
echo '<select name="product">';
    echo '<option>'.lang('choose_product').'</option>';
foreach ($products as $product) {
    echo '<option value="'.$product->id.'">'.$product->name.'</option>';
}
echo '</select>';
echo form_fieldset_close();

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>