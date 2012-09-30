<h2><?php echo $title; ?></h2>
<div id="cpanel">
    <div class="orders_stats">
	<div>
	    <?php 
		$o = $orders->group_by('country')->get();
		$countries = config_item('country_list');
		foreach ($o as $country){
		    echo $countries[$country->country] . ' ' . $orders->count();
		}
	    ?> 
	</div>
    </div>

    <div id="totals">
	<div><span class="bold">Total Orders: </span><?php echo $orders->count(); ?></div>
    </div>

</div>