
<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>
<?php

echo form_open('/admin/tracks/save/' . $track->id);
echo form_hidden('id', $track->id);
echo '<ul class="lang_tabs">';
foreach ($this->config->item('languages') as $language) {
    $active = $language == 'hebrew' ? 'active' : '';
    echo '<li class="tab ' . $active . '"><a href="#" title="' . $language . '" rel="' . $language . '">' . $language . '</a></li>';
}
echo '</ul>';


foreach ($this->config->item('languages') as $l) {
    echo '<div class="lang_wrapper languages language '.$l.'">';
    echo form_fieldset();
    echo form_label(lang('track_name'), 'name', array('class' => 'inline_label'));
    echo form_input('name', $track->{'name_'.$l});
    echo form_fieldset_close();
    echo '</div>';
}
    echo form_fieldset();
    echo form_label(lang('track_value'), 'value', array('class' => 'inline_label'));
    echo form_input('value', $track->value);
    echo form_fieldset_close();
    
    echo form_fieldset();
    echo form_label(lang('weight'), 'weight', array('class' => 'inline_label'));
    echo form_input('weight', $track->weight);
    echo form_fieldset_close();
    
    echo form_fieldset();
    echo form_label(lang('track_type'), 'tracktype_id', array('class' => 'inline_label'));
    echo '<select name="tracktype_id">';
    foreach ($types as $type) {
        echo form_label($type->type, array('class' => 'inline_label'));
        if ($type->id == $track->tracktype_id) {
            echo '<option value="' . $type->id . '" selected="selected">' . $type->type . '</option>';
        } else {
            echo '<option value="' . $type->id . '" >' . $type->type . '</option>';
        }
    }
    echo '</select>';
    echo form_fieldset_close();
    
    echo form_fieldset();
    echo '<div class="status_picker">';
    echo form_label(lang('status'), 'tracktype_id', array('class' => 'inline_label'));
    foreach ($statuses as $status) {
        echo form_label($status->name, array('class' => 'inline_label'));
        if ($status->id == $track->status_id) {
            echo form_radio('status_id', $status->id, $checked = TRUE);
        } else {
            echo form_radio('status_id', $status->id, $checked = FALSE);
        }
    }
    echo '</div>';
    echo form_fieldset_close();
    
    
    echo form_fieldset(lang('settings'), array('class' => 'grey_border'));
    echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
    echo '<select name="product" id="products">';
    echo '<option>' . lang('choose_product') . '</option>';
    foreach ($products as $product) {
        $product->dbtranslate($this->language);
        $track->product->get();
        if ($product->id == $track->product->id) {
            echo '<option value="' . $product->id . '" selected="selected">' . $product->name . '</option>';
        } else {
            echo '<option value="' . $product->id . '">' . $product->name . '</option>';
        }
    }
    echo '</select>';
    echo form_fieldset_close();


    $this->load->view('admin/common/add_edit_submit');
    echo form_close();
