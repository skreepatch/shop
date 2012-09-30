<?php

?>
<tr>
    <?php echo form_hidden('bonus[id]', $bonus_item['id']); ?>
    <?php echo form_hidden(array('name' => 'bonus[qty]', 'value' => $bonus_item['qty'])); ?></td>
<td class="product_info">
    <div>
	<img src="<?php echo site_url('files/uploads/images/' . $p->image) ?>" class="left" width="60"/>
	<h3><?php echo $p->trimmed_name; //$items['name'];   ?></h3>
    </div>
</td>
<td>
    <div>
	<?php foreach ($bonus_item['options'] as $option_name => $option_value): ?>
    	<span><?php echo $p->dozage . 'mg'; ?></span> X <span><?php echo $option_value; ?></span>
	<?php endforeach; ?>
	<a href="<?php echo site_url('shopping_cart/changeBonus/' . $bonus_item['id']) ?>" class="change_bonus grey_btn">change bonus</a>
    </div>
</td>
<td class="price_cell"><div>FREE</div></td>
</tr>
