<?php
?>
<ul id="language_switch">
    <?php foreach ($this->config->item('languages') as $l):?>
        <li>
            <a class="right buttons" href="<?php echo site_url('langswitch/index/'.$l.'?l='.uri_string());?>" title="Switch to <?php echo $l;?>"><?php echo lang($l);?></a>
        </li>
    <?php endforeach; ?>
</ul>
