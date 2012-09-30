<?php
$pricetable = array(
    '30' => '1',
    '60' => '2',
    '90' => '6',
    '120' => '8',
    '160' => '11',
);
?>
<a class="category_link" href="<?php echo site_url('online-pharmacy/' . urlencode($prodgroup->category->name)); ?>" title="<?php echo $prodgroup->category->name; ?>"><?php echo $prodgroup->category->name; ?></a>
<div class="inner clearfix">
    <img class="thumb left" src="<?php echo site_url('files/uploads/images/' . $prodgroup->image); ?>"/>
    <div class="left product_data">
	<h1><?php echo $title; ?></h1>
	<div class="active_ingredient"><?php echo $prodgroup->active_ingredient; ?></div>
	<div class="short_desc"><?php echo $prodgroup->short_desc; ?></div>
    </div>
    <?php foreach ($products as $product): 
	$converted_price = $this->currency->convert('USD', config_item('curr'), $product->price);
	$product_price = $converted_price['to_amount'];
	?>
        <div class="clearfix dozage">
    	<div class="clearfix">
    	    <table class="product_table">
    		<thead>
    		<th>Package</th>
    		<th>Price</th>
    		<th>Price per pill</th>
    		<th>Savings</th>
    		<th>Order</th>
    		</thead>
		    <?php
		    foreach ($product->package->get() as $pck):
			$_total_price = floatval($product_price * $pck->amount);
			$_saving = number_format(floatval($_total_price / 100 * $pck->discount), 2);
			$_total = number_format($_total_price - $_saving, 2);
			$_per_pill = number_format($_total / $pck->amount, 2);
			?>
			<tr>
			    <td><?php echo $product->dozage . 'mg * ' . $pck->amount.' pills' ?></td>
			    <td class="price"><?php echo $this->currency->fetch_symbol(config_item('curr'), $_total); ?></td>
			    <td><?php echo $this->currency->fetch_symbol(config_item('curr'), $_per_pill); ?></td>
			    <td class="savings"><?php echo $this->currency->fetch_symbol(config_item('curr'), $_saving); ?></td>
			    <td class="buttons"><a href="<?php echo site_url('shopping_cart/add/' . $product->id . '/' . $pck->amount . '/' . $_total); ?>" class="grey_btn add_tocart_button">Add to cart</a></td>
			</tr>
		    <?php endforeach; ?>
    	    </table>
    	</div>
        </div>
    <?php endforeach; ?>


    <div class="vspace">
	<h2><?php echo $prodgroup->trimmed_name . ' pill' ?></h2>
	<div id="faqs" class="vspace">
	    <?php foreach ($prodgroup->faq->get() as $faq): ?>
    	    <a class="faq" href="" title=""><?php echo $faq->question; ?><em>&nbsp;</em>
    		<div class="answer"><?php echo $faq->answer; ?></div>
    	    </a>
	    <?php endforeach; ?>
	</div>

	<div class="description"><?php echo $prodgroup->description; ?></div>
    </div>
</div>
