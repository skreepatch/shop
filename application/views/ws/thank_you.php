<?php ?>

<div class="inner">
    <div id="thankyou">

        <div class="clearfix">
            <?php echo $thank_you_note; ?>
        </div>
        
        <div id="thankyou_btns">
            <a href="<?php echo site_url('shopping_cart/print/');?><?php echo $cart ?>" title="" class="blue_btn"><?php echo lang('print_order_details') ?></a>
            <a href="<?php echo site_url('my_account') ?>" title="" class="blue_btn"><?php echo lang('go_myaccount') ?></a>
            <a href="<?php echo site_url();?>" title="" class="blue_btn"><?php echo lang('back_home') ?></a>
        </div>
    </div>



</div>