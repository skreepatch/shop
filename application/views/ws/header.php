<?php
if (isset($this->userdata['currency'])) {
    $current_curr = $this->currency->fetch_symbol($this->userdata['currency']);
} else {
    $current_curr = $this->currency->fetch_symbol(config_item('curr'));
}
$all_curr = config_item('available_currencies');
?>

<div class="localization">

    <div class="switch">
	<div class="current_local">
<!--	    <span class="flag <?php echo strtolower(config_item('curr') . '_flag'); ?>"></span>-->
	    <span class="currency" id="<?php echo strtolower(config_item('curr')) . '_currency' ?>">&nbsp;<?php echo $current_curr['symbol'] . ' ' . config_item('curr') ?></span>
	    <em></em>
	</div>
    </div>
    <div class="local_panel">
	<span>Change currency</span>
	<select class="currencies">
	    <?php
	    $_c = config_item('available_currencies');
	    foreach ($_c as $_curr => $_name):
		$selected = $_curr == config_item('curr') ? 'selected="selected"' : '';
		?>
    	    <option value="<?php echo $_curr ?>" <?php echo $selected ?>><?php echo $_name ?></option>
	    <?php endforeach; ?>
	</select>
    </div>
</div>
<div class="logo"><a href="<?php echo site_url(); ?>"><img src="<?php echo site_url('/assets/img/logo/logo.png') ?>" alt="Lines Pharmacy" title="Lines Pharmacy"/></a></div>
<div class="contact_info">
    <div><span class="">US Toll Free:</span><?php echo setting_item('us_toll_free'); ?></div>
    <div><span class="">Regular US:</span><?php echo setting_item('regular_us'); ?></div>
    <div><span class="">UK:</span><?php echo setting_item('regular_uk'); ?></div>
</div>
