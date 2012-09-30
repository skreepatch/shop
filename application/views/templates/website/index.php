<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $site_name . ' - ' . $site_title ?></title>
	<?php if (isset($keywords)): ?>
    	<meta name="keywords" content="<?php echo $keywords; ?>"/>
	<?php endif; ?>
	<?php if (isset($description)): ?>
    	<meta name="description" content="<?php echo $description; ?>"/>
	<?php endif; ?>
	<?php echo $css ?>
	<?php echo $head ?>
	<?php echo $js ?>
    </head>

    <body class="<?php echo isset($body_class) ? $body_class : '' ?>">
        <div id="message" class="drop_shadow"><?php echo $this->session->flashdata('message'); ?></div>

        <div class="wrap clearfix">
            <div class="header">
		<?php $this->load->view('ws/header'); ?>
            </div>
            <div class="container clearfix">
                <div class="clerfix">
		    <div class="cart_summary">
			<span class="bold"><a href="<?php echo site_url('shopping_cart') ?>" title="">Cart</a></span>
			<?php
			$cart_total = $this->currency->convert('USD', config_item('curr'), $this->cart->total());
			?>
			<span class="cart_total"><?php echo $this->currency->fetch_symbol(config_item('curr'), $cart_total['to_amount']); ?></span>
			<span class="items_total">(<?php echo $this->cart->total_items() ?> items)</span>
		    </div>
		    <?php $this->load->view('ws/mainnav'); ?>
                </div>

		<?php echo $this->load->view('ws/filterbar'); ?>


		<?php if (isset($slides)): ?>
    		<div id="slideshow_wrapper">
    		    <div class="slideshow clearfix">
			    <?php echo $this->load->view('ws/slideshow'); ?>
    		    </div>
    		    <!--    		    <div id="controls">
			<?php foreach ($slides as $k => $slide): ?>
								<a class="control" rel="<?php echo $k ?>"></a>
			<?php endforeach; ?>    
                    		    </div>-->
    		</div>
		<?php endif ?>

		<?php if (!isset($nosidebars)): ?>
    		<div class="sidebar-first">
			<?php $this->load->view('ws/sidebar-first'); ?>
    		</div>

    		<div class="sidebar-last">
			<?php $this->load->view('ws/sidebar-last'); ?>
    		</div>
		<?php endif; ?>
		<?php if (isset($products_page) && $products_page): ?>
    		<div class="main clearfix">
    		    <div class="content clearfix">
    			<div class="product_panel">
				<?php if ($highlights != ''): ?>
				    <div class="visual">
					<?php echo $highlights ?>
				    </div>
				<?php endif; ?>
				<?php
				if ($content != '') {
				    echo $content;
				}
				?>
    			</div>
			    <?php if ($content_bottom != ''): ?>

				<div class="product_panel faq">
				    <?php echo $content_bottom ?>
				</div>
			    <?php endif; ?>
    		    </div>
    		</div>

		<?php else : ?>
		    <?php if ($highlights != ''): ?>
			<div class="highlights">
			    <?php echo $highlights ?>
			</div>
		    <?php endif; ?>
    		<div class="main <?php echo (isset($nosidebars)) ? 'nosidebars' : ''; ?>">
    		    <div class="content">
			    <?php echo $content ?>
    		    </div>
    		</div>
		<?php endif; ?>

            </div>
            <div class="content_bottom container clearfix">

            </div>
        </div>
        <div class="footer clearfix">
	    <?php $this->load->view('ws/footer'); ?>
        </div>

    </body>
</html>






