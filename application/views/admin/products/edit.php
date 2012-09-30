<div class="cont_heading">
    <h2><?php echo $title?></h2>
</div>

<h3>Packages and discounts</h3>
<div class="packages_table">
    <div class="row">
	<span class="amount">Amount</span><span class="discount">Discount</span>
    </div>
    <?php foreach($product->package->get() as $pck):?>
    <div class="row">
	<span class="amount"><?php echo $pck->amount?></span><span class="discount"><?php echo $pck->discount?></span><a href="<?php echo site_url('/admin/products/removePackage/'.$pck->id);?>" class="remove_row">- remove</a>
    </div>
    <?php endforeach;?>
</div>
<a href="#" id="addPackage">+ add package</a>

<br/>
<hr/>
<br/>


<?php
	echo $product->render_form($form_fields, $url, array(), 'dmz_htmlform/multipart');

	?>

<script type="text/javascript">
    
$('#addPackage').click(function(e){
    e.preventDefault();
    var row = '<form class="package_row row"><input type="text" name="amount" class="amount"/><input type="text" name="discount" class="discount"/><input type="submit" value="save"/></form>';
    $('.packages_table').append(row);
    $(row).submit(function(e){
	console.log('form submitted');
	e.preventDefault();
    })
});

//$('.remove_row').click(function(){
//    var row_id = $(this).attr('rel');
//    $.ajax({
//	url: '/admin/products/removePackage/'+row_id,
//	type: 'GET',
//	success: function(){
//	    $(this).hide('slow');
//	}
//	
//    })
//});

</script>
	
	
	