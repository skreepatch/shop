<div class="block">
    <div class="center">
	<img src="<?php echo site_url('assets/img/symbols/qc-certificate.png'); ?>" alt="" title=""/>
    </div>
    <a id="free_shipping" href="<?php echo site_url('free-shipping'); ?>">&nbsp;</a>
    <a id="bonuses" href="<?php echo site_url('bonus'); ?>">&nbsp;</a>
</div>

<?php if (isset($is_homepage)): ?>
    <div class="block wrapper">
        <h3>Testimonials</h3>
	<?php foreach ($testimonials as $t): ?>
	    <div class="blockItem">
		<?php 
		    $desired_width = 240;
		    $string = html_escape($t->content);
		if (strlen($string) > $desired_width) {
		    $string = wordwrap($string, $desired_width);
		    $string = substr($string, 0, strpos($string, "\n"));
		}
		echo '<p>' . $string . ' </p>';
		?>
		<p class="italic"><?php echo $t->name . ', ' . ($t->date); ?></p>
	    </div>
	<?php endforeach; ?>
    </div>
    <div class="block wrapper">
        <h3>News</h3>
	<?php foreach ($news as $n): ?>
	    <div class="blockItem">

		<?php 
		    $desired_width = 220;
		    $string = html_escape($n->content);
		if (strlen($string) > $desired_width) {
		    $string = wordwrap($string, $desired_width);
		    $string = substr($string, 0, strpos($string, "\n"));
		}
		echo '<p>' . $string . ' </p>';
		?>
		<p class="italic"><?php echo $n->date; ?></p>
	    </div>
	<?php endforeach; ?>
    </div>
<?php endif ?>


