<h1><?php echo $title; ?></h1>
<div class="inner wrapper" id="shopping_cart">
    <h4>After you click checkout you will be redirected to the secure server.</h4>
    <?php echo form_open(site_url('shopping_cart/checkout'), array('id' => 'cart')); ?>
    <table cellspacing="1" style="width:100%">

	<tr>
	    <th><div>Product</div></th>
	<th><div>Package</div></th>
	<th><div>Price</div></th>
	</tr>

	<?php $i = 1; ?>

	<?php foreach ($this->cart->contents() as $items): ?>
	    <?php
	    $p = new Product($items['id']);
	    $converted = $this->currency->convert('USD', config_item('curr'), $items['price']);
	    ?>

    	<tr>
		<?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
		<?php echo form_hidden(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
    	    <td class="product_info">
    		<div>
    		    <img src="<?php echo site_url('files/uploads/images/' . $p->image) ?>" class="left" width="60"/>
    		    <h3><?php echo $p->trimmed_name; //$items['name'];      ?></h3>
    		    <a href="<?php echo site_url('shopping_cart/update/' . $items['rowid']) ?>" class="remove">remove</a>
    		</div>
    	    </td>
    	    <td>
    		<div>
			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>		
			    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
	    		    <span><?php echo $p->dozage . 'mg'; ?></span> X <span><?php echo $option_value; ?></span>
			    <?php endforeach; ?>
			<?php endif; ?>
    		</div>
    	    </td>
    	    <td class="price_cell"><div><?php echo $this->currency->fetch_symbol(config_item('curr'), $converted['to_amount']); ?></div></td>
    	</tr>

	    <?php $i++; ?>

	<?php endforeach; ?>
	<?php
	if (isset($bonus_item)) {
	    $this->load->view('ws/bonus_product');
	}
	?>
    </table>
    <div class="wrapper">
	<?php
	$converted_total = $this->currency->convert('USD', config_item('curr'), $this->cart->format_number($this->cart->total()));
	$converted_shipp = 0;
	?>
	<div class="subtotal">Subtotal before Delivery Charges<span class="right"><?php echo $this->currency->fetch_symbol(config_item('curr'), $converted_total['to_amount']); ?></span></div>
    </div>
    <div class="wrapper shipping">
	<select name="shipping" id="shipping_id">
	    <option value="0">Choose Shipping Method</option>
	    <?php
	    foreach ($shipping as $sh):
		if (isset($selected_shipping) && $selected_shipping->id == $sh->id) {
		    $sel = 'selected="selected"';
		    if ($selected_shipping->price_floor >= $this->cart->total()) {
			$converted_shipp = $this->currency->convert('USD', config_item('curr'), $this->cart->format_number($selected_shipping->price));
		    } else {
			$converted_shipp = $this->currency->convert('USD', config_item('curr'), $this->cart->format_number(0));
		    }
		} else {
		    $sel = '';
		}
		?>
    	    <option value="<?php echo $sh->id; ?>" <?php echo $sel ?>><?php echo $sh->name; ?></option>
	    <?php endforeach; ?>
	</select>
	<div class="right" id="shipping_price"><?php
	    $ship_price = isset($selected_shipping) ? $this->currency->fetch_symbol(config_item('curr'), $converted_shipp['to_amount']) : '0';
	    if ($converted_shipp['to_amount'] == 1) {
		$converted_shipp['to_amount'] = 0;
		echo $converted_shipp['to_amount'];
	    } else {
		echo $ship_price;
	    }
	    ?></div>
    </div>
    <div id="total_to_pay">
	<?php
	if (isset($converted_shipp)) {
	    $total = $converted_total['to_amount'] + $converted_shipp['to_amount'];
	} else {
	    $total = $converted_total['to_amount'];
	}
	?>
	<h2>Total Cost<span class="right"><?php echo $this->currency->fetch_symbol(config_item('curr'), $total); ?></span></h2>
    </div>

    <div class="wrapper" id="cart_actions">
	<a class="grey_btn left" href="<?php echo site_url(); ?>" title="Continue shopping"><?php echo 'Continue Shopping'; ?></a>
	<button class="grey_btn right" type="submit" title="Continue to checkout" <?php echo !isset($selected_shipping) ? 'disabled="disabled"' : '';?> ><?php echo 'Continue to checkout'; ?></button>
    </div> 
</form>
</div>