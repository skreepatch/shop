<h1><?php echo $title; ?></h1>
<div class="wrapper" id="t_wrap">
    <?php foreach ($testimonials as $t): ?>
        <div class="t_item">
	    <div class="t_date"><?php echo $t->date; ?></div>
	    <div class="t_content"><?php echo $t->content; ?></div>
	    <div class="t_username"><?php echo $t->name; ?></div>
        </div>
    <?php endforeach; ?>
</div>