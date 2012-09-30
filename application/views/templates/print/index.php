<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo lang('price_offer'); ?></title>
        <?php //echo $css ?>
	<link rel="stylesheet"  media="print, screen" href="/assets/css/print.css"/>
        <?php echo $head ?>
        <?php echo $js ?>
    </head>

    <body class="<?php echo isset($body_class) ? $body_class : '' ?>">       
        <div class="wrap clearfix">
            <div class="main">
                <div class="left"><img src="/assets/img/logo/printver_sol.jpg"/></div>
                <div class="right">
                    <div class="inner">
                        <div class="date"><?php echo lang('date'); ?>: <?php echo date('d/m/Y'); ?></div>
                        <br/>
                        <div><?php echo lang('offered_to'); ?>: <?php echo $cart->user->company; ?></div>
                        <div><?php echo lang('deliever_to'); ?>: <?php echo $cart->user->name . ' ' . $cart->user->last_name; ?></div>
                        <div class="blue"><?php echo $title; ?></div>
                    </div>
                </div>
                <div class="content clearfix">
                    <?php
                    if ($content != '') {
                        echo $content;
                    }
                    ?>
                </div>
            </div> 
        </div>
        <div class="footer">
            <img src="/assets/img/logo/printver_footer.jpg"/>
        </div>
</body>
</html>






