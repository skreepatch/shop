<?php
$letters = range('a', 'z');
if(isset($search)){
    if(strlen($search) == 1){
	$searchterm =  'Type you search term';
    } else {
	$searchterm = $search;
    }
} else {
    $searchterm =  'Type you search term';
}


?>
<div class="filterbar clearfix">
    <form action="<?php echo site_url('search')?>" method="post" id="product_search" class="left">
	<label class="inline" for="search"><?php echo lang('search')?></label>
	<input type="text" id="search" name="search" value="<?php echo $searchterm;?>"/>
	<input type="submit" value=""/>
    </form>
    <div class="letter_filter">
	<span><?php echo lang('letter_filter')?></span>
    <?php foreach($letters as $l):
	if(isset($search)){
	    $active = $search == $l ? 'class="active"' : ''; 
	} else {
	    $active = '';
	}
    ?>    
	    <a <?php echo $active?> href="<?php echo site_url('search/'.$l)?>" title="<?php echo 'Search online pharmacy by letter: '.$l?>"><?php echo $l?></a>
    <?php endforeach;?>
    </div>
    <div class="right">
	<a href="<?php echo site_url('bonus');?>" title="" id="check_bonus">&nbsp;</a>
    </div>
</div>