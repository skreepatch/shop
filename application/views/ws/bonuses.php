<?php 
$icons = array('orange','indigo', 'salad');
$i = 0;
?>
<h1>Bonuses</h1>

<div class="inner">
    <div>
    <p class="bold">We have a special discount programm for our customers!</p>
    <p>Please check our bonus options:</p>
</div>
<?php foreach($bonuses as $bonus): ?>
    <div class="bonus_level clearfix <?php echo $icons[$i]?>">
	
	<div class="bonus_icon">
	    <span class="bonus_amount"><?php echo $bonus->amount?></span>
	    <span class="pills">pills</span>
	    <span class="free">free</span>
	</div>
	<div class="description">
	    <p><?php echo $bonus->description?></p>
	</div>
	
    </div>

<?php $i++; endforeach; ?>
</div>

