<div class="product_panel">
    <div class="inner">
        <div class="left product_selector clearfix">
	    <div id="product_widget">
		<?php $this->load->view('ws/product_approval_selector', array('ordering', $ordering)); ?>
	    </div>
        </div>

        <div class="product_desc clearfix">
            <h1><?php echo lang('order_graphic_approval'); ?></h1>
            <div class="preview_wrapper">
		<?php
		$oi_count = $images->count();
		$preview_mode = $oi_count > 1 ? '2' : '1';
		$i = 1;
		$cut_width = $sizes->width - ($product->cutline->right + $product->cutline->left) / 10;
		$cut_height = $sizes->height - ($product->cutline->top + $product->cutline->bottom) / 10;
		$blead_width = $sizes->width - ($product->bleadline->right + $product->bleadline->left) / 10;
		$blead_height = $sizes->height - ($product->bleadline->top + $product->bleadline->bottom) / 10;
		?>
		<?php foreach ($images as $oi): ?>
		    <?php
		    if ($i % 2 == 1) {
			echo '<div class="preview_page_wrapper">';
		    }
		    ?>
    		<div class="preview_<?php echo $preview_mode;
		echo $i == 1 ? ' right' : ' left'; ?>">
    		    <span class="drop_shadow" name="<?php echo $oi->id . '_' . $sizes->width . '_' . $sizes->height;?>" vertical="<?php echo $oi->vertical?>">

    			<div class="image_preview">&nbsp;</div>

    			<div class="cutlines" 
    			     style="margin: <?php echo $product->cutline->top . 'mm ' . $product->cutline->right . 'mm ' . $product->cutline->bottom . 'mm ' . $product->cutline->left . 'mm' ?>;
    			     width: <?php echo $cut_width . 'cm' ?>; height: <?php echo $cut_height . 'cm' ?>" 
    			     name="<?php echo $product->cutline->top . '_' . $product->cutline->right . '_' . $product->cutline->bottom . '_' . $product->cutline->left ?>">
    			</div>
    			<div class="bleadlines" 
    			     style="margin: <?php echo $product->bleadline->top . 'mm ' . $product->bleadline->right . 'mm ' . $product->bleadline->bottom . 'mm ' . $product->bleadline->left . 'mm' ?>;
    			     width: <?php echo $blead_width . 'cm' ?>; height: <?php echo $blead_height . 'cm' ?>"
    			     name="<?php echo $product->bleadline->top . '_' . $product->bleadline->right . '_' . $product->bleadline->bottom . '_' . $product->bleadline->left ?>">
    			</div>
    			<div class="preview_mask"></div>
    			<div class="preview_click">
				<?php echo lang('click_to_check_graphics') ?>
    			</div>
    		    </span>
    		    <p class="center preview_caption"><?php echo $oi->pageside->name; ?></p>
    		</div>
		    <?php
		    if ($i % 2 == 0 || $images->count() == 1) {
			echo '</div>';
		    } else {
			$i++;
		    }
		    ?>
		<?php endforeach; ?>
                <p class="approval_ins"><?php echo lang('graphic_approval_instructions'); ?></p>

                <textarea class="ordering_notes" rows="5"><?php echo lang('add_ordering_notes') . ':'; ?></textarea>
                <a href="/products/files_upload/<?php echo $product->id ?>" title="" class="left css_btn_white" style="margin-top: 40px;"><?php echo lang('go_back_to_upload') ?></a>
                <p class="preview_caption"><?php echo lang('ordering_name') . ': ' . $ordering->name; ?></br>
		    <?php echo lang('product_type') . ': ' . $product->name ?></br>
		    <?php echo lang('size') . ': ' . $sizes->name ?></br>
		    <?php echo $foldpages->name ?></p>
            </div>
        </div>
    </div>
</div>
<?php if (isset($warning)): ?>
    <div class="product_panel"><?php echo $warning; ?></div>
<?php endif; ?>

<div class="product_panel ">
    <?php $this->load->view('ws/i_agree'); ?>
</div>
<script>
    getProductOptions(approval);
</script>