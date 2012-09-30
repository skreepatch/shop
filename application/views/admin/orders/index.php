<div class="cont_heading">
    <h2><?php echo $title?></h2>
</div>
<div id="filters" class="top_filters">
    <form action="<?php echo current_url();?>" method="POST">
    <div class="from_date">
	<label for="fromdate">From date:</label>
	<input name="fromdate" type="text" class="datepicker" value="<?php echo isset($fromdate) ? $fromdate : '';?>"/>
    </div>
    <div class="to_date">
	<label for="fromdate">From date:</label>
	<input name="todate" type="text" class="datepicker" value="<?php echo isset($todate) ? $todate : '';?>"/>
    </div>
    <button type="submit" >Filter</button>
    <a href="<?php echo current_url();?>">Reset</a>
    </form>
</div>
<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="fullname">Full Name</th>
		<th class="cell" id="email">Email</th>
		<th class="cell" id="country">Country</th>
		<th class="cell" id="status_id">Status</th>
		<th class="cell" id="total">Total Items</th>
		<th class="cell" id="price">Total Price</th>
		<th class="cell" id="shipping_id">Shipping</th>
		<th class="cell" id="created">Created at</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($orders as $p):
			$odd = !$odd;
		
		$countries = config_item('country_list');
		$country = $countries[$p->country];
		
		$total += $p->total(); 
		
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="fullname"><a href="<?php echo site_url('admin/orders/open/' . $p->id); ?>" title="Edit this order"><?php echo htmlspecialchars($p->fullname); ?></a></td>
		<td class="email"><?php echo $p->email?></td>
		<td class="country"><?php echo $country;?></td>
		<td class="status"><?php echo $p->status->name;?></td>
		<td class="total"><?php echo $p->orderitem->count()?></td>
		<td class="ptice"><?php
		    $converted = $this->currency->convert('USD', config_item('curr'), $p->total());
		    //print_r($converted);
		    echo $this->currency->fetch_symbol(config_item('curr'), $converted['to_amount']);
		?></td>
		<td class="shipping_id"><?php echo $p->shipping->name?></td>
		<td class="created"><?php echo $p->created?></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/orders/open/' . $p->id); ?>" title="Edit this order"><?php echo icon('edit', 'Edit this order'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['id']) ? $searches['id'] : ''?>"/></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['name']) ? $searches['name'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"><?php 
	    $converted = $this->currency->convert('USD', config_item('curr'), $total);
	    //print_r($converted);
	    echo $this->currency->fetch_symbol(config_item('curr'), $converted['to_amount']);?></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
<script type="text/javascript">
    // Datepicker
    $(document).ready(function(){
	$('.datepicker').datepicker({
	    inline: true,
	    dateFormat: 'yy-mm-dd'
	});
    });
</script>