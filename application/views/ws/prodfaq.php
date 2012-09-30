<h2 class="blue"><?php echo lang('faqs')?></h2>
<ul>
    <?php foreach ($prodfaq as $faq): 
        $faq->dbtranslate($this->language); ?>
    
        <li <?php echo $faq->expand == 1 ? 'class="expanded"' : ''; ?>>
            <h4><?php echo $faq->question; ?></h4>
            <p><?php echo $faq->answer; ?></p>
        </li>
    <?php endforeach; ?>
</ul>    