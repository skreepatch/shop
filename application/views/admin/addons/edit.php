<div class="cont_heading">
    <h2><?php echo $title .': '. $addon->{'addon_label_'.$this->language}. ' ' .lang('for'). ' ' .$related['product']->name ?></h2>
</div>
<?php

echo form_open($url, array('id'=>'folding'));
echo form_hidden('id', $addon->id);
echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
echo form_fieldset();
echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
echo '<select name="product" id="products">';
echo '<option>'.lang('choose_product').'</option>';
foreach ($products as $product) {
    $product->dbtranslate($this->language);
    $addon->product->get();
    if($product->id == $addon->product->id){
        echo '<option value="'.$product->id.'" selected="selected">'.$product->name.'</option>';
    } else {
        echo '<option value="'.$product->id.'">'.$product->name.'</option>';
    }

}
echo '</select>';
echo form_fieldset_close();

echo form_fieldset_close();

echo form_fieldset();
echo '<div class="status_picker">';
echo form_label(lang('status'), 'status_id', array('class' => 'inline_label'));
    foreach ($statuses as $status) {
        echo form_label($status->name, array('class' => 'inline_label'));
        if($status->id == $addon->status_id){
            echo form_radio('status_id', $status->id, $checked = TRUE);
        } else {
            echo form_radio('status_id', $status->id, $checked = FALSE);
        }
    }
echo '</div>';
echo form_fieldset_close();
echo form_fieldset();
echo form_label(lang('weight').':', 'weight', array('class' => 'inline_label'));
echo form_input('weight', $addon->weight);
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('optional'), 'optional', array('class' => 'inline_label'));
if ($addon->optional) {
    echo form_checkbox('optional', TRUE, $checked = TRUE);
} else {
    echo form_checkbox('optional', TRUE);
}
echo form_fieldset_close();

echo '<ul class="lang_tabs">';
foreach ($this->config->item('languages') as $language) {
    $active = $language == 'hebrew' ? 'active' : '';
    echo '<li class="tab ' . $active . '"><a href="#" title="' . $language . '" rel="' . $language . '">' . $language . '</a></li>';
}
echo '</ul>';

foreach ($this->config->item('languages') as $l) {
    echo '<div class="languages '.$l.'">';
echo form_fieldset();
echo form_label(lang('addon_label').':', 'addon_label_'.$l, array('class' => 'inline_label'));
echo form_input('addon_label_'.$l, $addon->{'addon_label_'.$l});
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('addon_desc'), 'addon_desc_'.$l, array('class'=>'clear_label'));
echo $this->ckeditor->editor('addon_desc_'.$l, $addon->{'addon_desc_'.$l});
echo form_fieldset_close();
echo '</div>';
}

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>