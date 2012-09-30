<?php
?>
<ul id="language_switch" class="right">
    <?php foreach ($this->config->item('languages') as $l):?>
        <li>
            <a href="<?php echo site_url('langswitch/index/'.$l.'?l='.uri_string());?>" title="Switch to <?php echo $l;?>"><?php echo lang($l);?></a>
        </li>
    <?php endforeach; ?>
</ul>
