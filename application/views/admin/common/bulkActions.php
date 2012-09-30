<div id="bulk_actions">
    <div class="bulk_trigger"><?php echo lang('actions'); ?>
	<ul>
	    <a href="<?php echo site_url('admin/cloner') ?>" id="clone_btn"><?php echo lang('clone'); ?></a><br/>
	    <a href="<?php echo site_url('admin/deleter') ?>" id="clone_btn"><?php echo lang('delete'); ?></a>
	</ul>
    </div>
    <script>
	$('.bulk_trigger').live('mouseenter', function(){
	    $('#bulk_actions ul').fadeIn('fast');
	});
	$('.bulk_trigger').live('mouseleave', function(){
	    $('#bulk_actions ul').fadeOut('fast');
	});
    </script>
</div>
