<h1><?php echo $title; ?></h1>
<div id="faqs" class="inner">
    <?php foreach($faqs as $faq):?>
    <a class="faq" href="" title=""><?php echo $faq->question;?><em>&nbsp;</em>
	    <div class="answer"><?php echo $faq->answer;?></div>
	</a>
    <?php endforeach;?>
</div>
