<?php



function getDosages($product){
    
    $p = new Product();
    $p->where('trimmed_name', $product->trimmed_name)->order_by('dozage', 'asc');
    $p->get();
    
    $i = 1;
    $count = $p->where('trimmed_name', $product->trimmed_name)->count();
    foreach ($p as $_p){
	echo strval($_p->dozage);
	if($count > $i){
	    echo '/';
	}
	$i++;
    }
    //echo $count;
    echo 'mg';
}


?>
