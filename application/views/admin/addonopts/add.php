<div class="cont_heading">
    <h2><?= $title ?></h2>
</div>
<?php

echo form_open_multipart('/admin/addons/save', array('id'=>'folding'));

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
    echo form_fieldset();
    echo form_label(lang('tosize'), 'size', array('class' => 'inline_label'));
    echo '<select name="size" id="sizes">';
        echo '<option>'.lang('choose_printtype').'</option>';
    foreach ($sizes as $size) {
        echo '<option value="'.$size->id.'">'.$size->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
    echo form_fieldset();
    echo form_label(lang('topapertype'), 'papertype', array('class' => 'inline_label'));
    echo '<select name="papertype" id="papertypes">';
        echo '<option>'.lang('choose_papertype').'</option>';
    foreach ($papertypes as $papertype) {
        echo '<option value="'.$papertype->id.'">'.$papertype->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
    echo form_fieldset();
    echo form_label(lang('tofoldpage'), 'foldpage', array('class' => 'inline_label'));
    echo '<select name="foldpage" id="foldpages">';
        echo '<option>'.lang('choose_papertype').'</option>';
    foreach ($foldpages as $foldpage) {
        echo '<option value="'.$foldpage->id.'">'.$foldpage->name.'</option>';
    }
    echo '</select>';
    echo form_fieldset_close();
echo form_fieldset_close();

echo form_fieldset();
echo '<div class="status_picker">';
echo form_label(lang('status').':', 'status_id', array('class' => 'inline_label'));
foreach ($statuses as $status) {
    echo form_label($status->name, array('class' => 'inline_label'));
    echo form_radio('status_id', $status->id);
}
echo '</div>';
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('weight').':', 'weight', array('class' => 'inline_label'));
echo form_input('weight');
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('addon_label').':', 'addon_label', array('class' => 'inline_label'));
echo form_input('addon_label');
echo form_fieldset_close();

echo form_fieldset();
echo form_label(lang('addon_desc'), 'addon_desc', array('class'=>'clear_label'));
echo $this->ckeditor->editor('addon_desc');
echo form_fieldset_close();


echo form_fieldset(lang('manage_addon_opts'), array('class'=>'grey_border', 'id' => 'sides_manager'));
   
echo form_fieldset();
echo '<div class="left"><a href="/" title="' . lang('add') . '" class="add_row">' . lang('add') . '</a></div>';
echo '<div class="right" id="rows">';
echo form_label(lang('rows_number'));
//echo form_dropdown('rows', array('1'=>'1', '2', '3', '4', '5', '6', '7', '8', '9', '10'));
echo form_input('rows', '1');
echo '</div>';
echo form_fieldset_close();

echo '<table class="addonrows">';

echo '<thead>
        <th>'.lang('id').'</th>
        <th>'.lang('name').'</th>
        <th>'.lang('default').'</th>
        <th>'.lang('additional_weight').'</th>
        <th>'.lang('show').'</th>
    </thead>
    <tbody>
    </tbody>';

echo '</table>';
echo form_fieldset_close();

$this->load->view('admin/common/add_edit_submit');
echo form_close();
?>