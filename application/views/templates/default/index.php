<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $site_title ?> - <?= $title ?></title>
	<?php echo $head ?>
	<?php echo $css ?>

    </head>

    <body>
        <div id="message" class="drop_shadow"><?php echo $this->session->flashdata('message'); ?></div>
        <div id="shell">
	    
	    <div class="wrap">
		<div class="header">
		    <h1><?php echo $site_title?></h1>
		</div>
		<div class="breadcrumbs">
		    
		</div>

		<div class="sidebar-first">
		    <div class="inner">
			<?php $this->load->view('admin/sidenav');?>
		    </div>
		</div>

		<div class="main">
		    <div class="inner">
			<?php if ($message != ''): ?>
    			<div class="message">
    			    <div class="inner">
				    <?= $messages ?>
    			    </div>
    			</div>
			<?php endif ?>
			<div class="content clearfix">
			    <?= $content ?>
			</div>
		    </div>
		</div>
	    </div>
        </div>
        <div class="footer clearfix">
	</div>
	<?php echo $js ?>
    </body>
</html>






