<div class="product_panel">
    <div class="inner">
	<h1><?php echo $page->{'title_' . $this->config->item('language')}; ?></h1>
	<?php
	$page->dbtranslate($this->language);
	echo $page->content;
	?>
    </div>
</div>

<?php if ($page->additional_content != ''): ?>
    <div class="product_panel">
        <div class="inner">
	    <?php echo $page->additional_content; ?>
        </div>
    </div>
<?php endif; ?>