<?php
echo form_open(site_url('shopping_cart/checkout'), 'method="POST" class="clearfix" id="checkout" name="checkout"');

echo form_hidden('id', $user->id);
?>
<table class="white_gradient white_layout" cellspacing="0">
    <thead>
    <th class="heading"><?php echo lang('customer_details'); ?></th>
</thead>
<tr><td>
	<?php
	echo form_fieldset('', array('class' => 'right'));
	echo form_fieldset();
	echo form_label(lang('name') . ':', 'name', array('class' => 'inline_label'));
	echo form_input('name', $user->name);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('last_name') . ':', 'last_name', array('class' => 'inline_label'));
	echo form_input('last_name', $user->last_name);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('email') . ':', 'email', array('class' => 'inline_label'));
	echo form_input('email', $user->email);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('password') . ':', 'password', array('class' => 'inline_label'));
	echo form_password('password');
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('c_password') . ':', 'confirm_password', array('class' => 'inline_label'));
	echo form_password('confirm_password');
	echo form_fieldset_close();
	echo form_fieldset_close();



	echo form_fieldset('', array('class' => 'right'));
	echo form_fieldset();
	echo form_label(lang('company') . ':', 'company', array('class' => 'inline_label'));
	echo form_input('company', $user->company);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('company_type') . ':', 'company_type', array('class' => 'inline_label'));
	echo form_input('company_type', $user->company_type);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('main_tel') . ':', 'tel1', array('class' => 'inline_label'));
	echo form_input('tel1', $user->tel1);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('sec_tel') . ':', 'tel2', array('class' => 'inline_label'));
	echo form_input('tel2', $user->tel2);
	echo form_fieldset_close();

	echo form_fieldset();
	echo form_label(lang('fax') . ':', 'fax', array('class' => 'inline_label'));
	echo form_input('fax', $user->fax);
	echo form_fieldset_close();
	echo form_fieldset_close();

	echo '</td></tr></table>';
	?>
	<?php if ($cart->selfcollect_id == 0): ?>
    	<table class="white_gradient white_layout" cellspacing="0">
    	    <thead>
    	    <th class="heading"><?php echo lang('delievery_details'); ?></th>
    	    </thead>
    	    <tr><td>
    <?php
    echo form_fieldset('', array('class' => 'right'));
    echo form_fieldset();
    echo form_label(lang('fullname') . ':', 'fullname', array('class' => 'inline_label'));
    echo form_input('ddetail[fullname]', $user->ddetail->fullname);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('phone') . ':', 'tel', array('class' => 'inline_label'));
    echo form_input('ddetail[tel]', $user->ddetail->tel);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('city') . ':', 'city', array('class' => 'inline_label'));
    echo form_input('ddetail[city]', $user->ddetail->city);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('street') . ':', 'street', array('class' => 'inline_label'));
    echo form_input('ddetail[street]', $user->ddetail->street);
    echo form_fieldset_close();

    echo form_fieldset_close();

    echo form_fieldset('', array('class' => 'right'));
    echo form_fieldset();
    echo form_label(lang('building_number') . ':', 'number', array('class' => 'inline_label'));
    echo form_input('ddetail[number]', $user->ddetail->number);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('entrance') . ':', 'entrance', array('class' => 'inline_label'));
    echo form_input('ddetail[entrance]', $user->ddetail->entrance);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('apartment'), 'apt', array('class' => 'inline_label'));
    echo form_input('ddetail[apt]', $user->ddetail->apt);
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('notes') . ':', 'notes', array('class' => 'inline_label'));
    echo form_input('ddetail[notes]', $user->ddetail->notes);
    echo form_fieldset_close();

    echo form_fieldset_close();

    echo '</td></tr></table>';
    ?>
<?php endif ?>
		    <table class="white_gradient white_layout" cellspacing="0">
			<thead>
			<th class="heading"><?php echo lang('reciept_details'); ?></th>
			</thead>
			<tr><td>
<?php
echo form_fieldset('', array('class' => 'right'));
echo form_fieldset();
echo form_label(lang('issued_to') . ':', 'rdetail[issued_to]', array('class' => 'inline_label'));
echo form_input('rdetail[issued_to]', $user->rdetail->issued_to);
echo form_fieldset_close();
echo form_fieldset_close();


echo form_fieldset('', array('class' => 'right'));
echo form_fieldset();
echo form_label(lang('address') . ':', 'address', array('class' => 'inline_label'));
echo form_input('rdetail[address]', $user->rdetail->address);
echo form_fieldset_close();
echo form_fieldset_close();

echo '</td></tr></table>';
?>
				<table class="white_gradient white_layout" cellspacing="0">
				    <thead>
				    <th class="heading"><?php echo lang('reciept_details'); ?></th>
				    </thead>
				    <tr><td>
				<?php
				echo form_fieldset();

				echo form_fieldset();
				echo form_radio('rdetail[reciept_address]', '0', $cart->ordering->reciept_address == '' ? $checked = TRUE : $checked = FALSE);
				echo form_label(lang('bundled') . ':', 'rdetail[reciept_address]');
				echo form_fieldset_close();

				echo form_fieldset();
				echo form_radio('rdetail[reciept_address]', '1', $cart->reciept_address == '' ? $checked = FALSE : $checked = TRUE);
				echo form_label(lang('diff_reciept_address') . ':', '[rdetail][reciept_address]');
				echo form_input('rdetail[reciept_address]', $cart->address);
				echo form_fieldset_close();

				echo form_fieldset_close();

				echo '</td></tr></table>';
				?>
					    <table class="white_gradient white_layout" cellspacing="0">
						<thead>
						<th class="heading"><?php echo lang('payment_methods'); ?></th>
						</thead>
						<tr><td>
					    <?php
					    echo form_fieldset();

					    foreach ($paymethods as $pm) {
						$pm->dbtranslate($this->language);
						echo form_fieldset();
						echo form_radio('paymethod_id', $pm->id, $user->paymethod_id == $pm->id ? $checked = TRUE : $checked = FALSE);
						echo form_label($pm->name, 'paymethod_id') . ':';
						echo form_fieldset_close();
					    }
					    echo form_fieldset_close();

					    echo '</td></tr></table>';
					    ?>
							<table class="white_gradient white_layout" cellspacing="0">
							    <thead>
							    <th class="heading"><?php echo lang('payment_details'); ?></th>
							    </thead>
							    <tr><td id="paymethod_box">
							<?php
							foreach ($paymethods as $paymethod) {
							    $paymethod->dbtranslate($this->language);
							    echo '<div id="pm_' . $paymethod->id . '" class="paymethod_note">';
							    echo $paymethod->note;
							    echo '</div>';
							}

							echo '</td></tr></table>';

							echo '<div class="btns_set">';
							echo form_submit('save', lang('save_and_continue'), 'class="right blue_btn"');
							echo form_button('destroy', lang('destroy_cart'), 'class="left grey_btn"');
							echo '</div>';
							echo form_close();
							?>



