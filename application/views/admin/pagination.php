<div class="pagination">
    <?php 
    
    
    $paginator = $pagination; 
    
    ?>
    <div class="left">
        <select name="pagesize" class="pagesize">
            <?php foreach ($pagesizes as $key => $val): ?>
                <?php if ($paginator->page_size == $key): ?>

                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                <?php else: ?>
                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="right">
        <?php
	$resto = $paginator->current_page * $paginator->page_size < $paginator->total_rows ? $paginator->current_page * $paginator->page_size : $paginator->total_rows;
	$showing = intval($paginator->current_page - 1) * $paginator->page_size + 1;
	echo lang('showing_results') .' '. 
	$showing
		.' '. 
	lang('results_to') . ' ' . $resto . ' ' . 
	lang('results_fromtotal') . ' ' . 
	$paginator->total_rows . ' ' . 
	lang('results') . ', ' . 
	lang('page') . ' ' . 
	$paginator->current_page . ' ' . 
	lang('results_of') . ' ' . 
	$paginator->total_pages . ' ' . 
	lang('pages'); ?>
    </div>
</div>

<div class="pgn_controls">
    <?php if ($paginator->has_previous): ?>
        <a href="<?php echo $paginator->previous_page ?>" class="prev_page"></a>
    <?php endif; ?>
    <?php if (intval($paginator->total_pages) > 1 && intval($paginator->total_pages) < 10): ?>
        <?php for ($i = 1; $i < $paginator->total_pages + 1; $i++): ?>
            <?php if ($paginator->current_page == $i): ?>
                <a href="<?php echo $i ?>" class="page_number active"><?php echo $i ?></a>
            <?php else: ?>
                <a href="<?php echo $i ?>" class="page_number"><?php echo $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

    <?php elseif (intval($paginator->total_pages) > 10): ?>
        <?php if (($paginator->current_page - 5) > 0): ?>
            <a href="1" class="page_number">1... </a>
            <?php for ($i = $paginator->current_page - 4; $i < $paginator->current_page; $i++): ?>
                <a href="<?php echo $i ?>" class="page_number"><?php echo $i ?></a>
            <?php endfor; ?>
        <?php endif; ?>
        <a href="<?php echo $paginator->current_page ?>" class="page_number active"><?php echo $paginator->current_page ?></a>
        <?php if (($paginator->current_page + 5) < $paginator->total_pages): ?>
            <?php for ($i = $paginator->current_page + 1; $i < $paginator->current_page + 5; $i++): ?>
                <a href="<?php echo $i ?>" class="page_number"><?php echo $i ?></a>
            <?php endfor; ?>
            <a href="<?php echo $paginator->total_pages ?>" class="page_number"> ...<?php echo $paginator->total_pages ?></a>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($paginator->has_next): ?>
        <a href="<?php echo $paginator->next_page ?>" class="next_page"></a>
    <?php endif; ?>
</div>