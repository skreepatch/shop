<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>
<?php echo form_open(site_url('admin/settings', 'POST'));?>
<table class="results" id="configuration">
    <thead>
	<th><?php echo 'Short description';?></th>
	<th><?php echo 'Value';?></th>
    </thead>
    <tr class="odd">
	<td><?php echo 'Sitename'?></td>
	<td><?php echo form_input('sitename', config_item('sitename'));?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'Coupon discount in %'?></td>
	<td><?php echo form_input('coupon_discount',setting_item('coupon_discount'));?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'UK Free Toll'?></td>
	<td><?php echo form_input('us_toll_free',setting_item('us_toll_free'));?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'Regular US'?></td>
	<td><?php echo form_input('regular_us',setting_item('regular_us'));?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'Regular UK'?></td>
	<td><?php echo form_input('regular_uk',setting_item('regular_uk'));?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'Packing method description'?></td>
	<td><?php echo form_textarea('packing_method',setting_item('packing_method'), 'class="ckeditor"');?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'About Us Text'?></td>
	<td><?php echo form_textarea('about_us',setting_item('about_us'), 'class="ckeditor"');?></td>
    </tr>
    <tr class="odd">
	<td><?php echo 'Privacy Policy'?></td>
	<td><?php echo form_textarea('privacy',setting_item('privacy'), 'class="ckeditor"');?></td>
    </tr>
    <tr class="even">
	<td><?php echo 'Google analytics code'?></td>
	<td><?php echo form_input('ga_code', setting_item('ga_code'));?></td>
    </tr>
    
</table>
<div class="grey_bg clearfix vspace"><?php echo form_submit('submit', lang('save_configuration'), 'class="blue_btn left"'); ?></div>

<?php echo form_close();?>