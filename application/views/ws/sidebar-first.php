
<div class="block">
    <h3>Categories</h3>
    <?php
    $c = new Category();
    $c->where('active', TRUE)->get();
    echo '<ul class="categories">';
	    foreach($c as $cat){
		$css_class = $cat->favorite ? 'favorite' : '';
		echo '<li class="' . $css_class . '"><a href="'.site_url('online-pharmacy/'.urlencode(strtolower($cat->name))).'" title="'.$cat->name.'">'.$cat->name.'</a></li>';
	    }
    echo '</ul>';
    ?>
</div>
