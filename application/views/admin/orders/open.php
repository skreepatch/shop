<div class="cont_heading">
    <h2><?php echo $title?></h2>
</div>
<div class="orderitems">
<?php foreach($order->orderitem->get() as $item):?>
    <div class="orderitem">
	<div class="name"><h3><?php echo $item->product->name;?></h3></div>
	<div class="qty"><span class="bold">Quantity: </span><?php echo $item->quantity;?></div>
	<div class="price"><span class="bold">Price: </span><?php echo $item->price;?></div>
    </div>
<?php endforeach; ?>
</div>
<div class="order_info">
    <div class="orderstatus">
	<span class="bold">Status: </span><?php echo $order->status->name;?>
    </div>
    <div class="created">
	<span class="bold">Order date: </span><?php echo $order->created;?>
    </div>
</div>