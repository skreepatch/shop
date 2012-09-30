<div class="cont_heading">
    <h2><?php echo $title.' '.$ao->{'addon_label_'.$this->language}.' '.lang('for').' '. $ao->product->{'name_'.$this->language};?></h2>
    <a href="<?php echo site_url('admin/addons/editoptions/'.$addon) ?>" class="add_new"><?php echo lang('add_new') ?></a>
</div>
<div class="top_filters">
        <?php getFilters(array('Track', 'Printtype', 'Size', 'Papertype', 'Foldpage'), TRUE,  $dataset['related'], TRUE, $this->language);?>
</div>
<table class="results">
<thead>
    <th class="clone" id="clone"><input type="checkbox"  name="cloneall" id="cloneall"/></th>
    <th class="cell" id="id"><?php echo lang('id') ?></th>
    <th class="cell" id="<?php echo 'name_'.$this->language;?>"><?php echo lang('name') ?></th>
    <th class="cell" id="price_settings"><?php echo lang('price_settings') ?></th>
    <th class="cell" id="actions"><?php echo lang('actions') ?></th>
</thead>
<?php
if($addonopts->count() != 0):
$odd = FALSE;
foreach ($addonopts as $am):
    $am->dbtranslate($this->language);
    $odd = !$odd;
?>
<tbody>
    <tr class="<?php echo $odd ? 'odd' : 'even' ?>">
        <td class="name"><input type="checkbox" value="<?php echo $am->model?>" name="toclone[<?php echo $am->id?>]" class="clone_check"/></td>
        <td class="cell"><?php echo $am->id ?></td>
        <td class="cell"><?php echo $am->name ;?></td>
        <td class="cell">
            <a href="<?php echo  site_url('admin/addons/editprices/'.$addon.'/'.$am->amountprice_id)?>" title=""><?php echo lang('edit_price')?></a>
        </td>
        <td class="buttons">
            <a href="<?php echo site_url('admin/addons/editoptions/' . $am->addon_id.'/'.$am->amountprice_id) ?>" title="<?php echo lang('edit') ?>"><?php echo lang('edit') ?></a><span>&nbsp;|&nbsp;</span>
            <a href="<?php echo site_url('admin/addons/deleteOption/' . $am->id) ?>" title="<?php echo lang('delete') ?>" class="delete"><?php echo lang('delete') ?></a>
        </td>
</tr>
<?php endforeach; ?>
<?php endif;?>
<tr>
            <td class="cell filter">
                <input type="hidden" name="product" value="<?php echo isset($am) ? $am->addon->product_id : '';?>"/>
                <?php $this->load->view('admin/common/bulkActions');?>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
        </tr>
        </tbody>
</table>

<?php $this->load->view('admin/pagination'); ?>