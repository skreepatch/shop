<h1><?php echo $title;?></h1>
<div class="inner">
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
  <th>Quantity</th>
  <th>Item Description</th>
  <th style="text-align:right">Item Price</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>
	<tr>
	  <td>    <?php echo $items['qty']?></td>
	  <td>
		<h3><?php echo $items['name']; ?></h3>

			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

				<p>
					<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

						<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

					<?php endforeach; ?>
				</p>

			<?php endif; ?>

	  </td>
	  <td style="text-align:right">$<?php echo $this->cart->format_number($items['price']); ?></td>
	</tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
  <td colspan="2"> </td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>
</div>
<div class="shipping inner">
    
    <?php
	echo $order->render_form($form_fields, $url, array(), 'dmz_htmlform/multipart');
    ?>
</div>

<?php echo form_close();?>