<?php
$m = new Menu();
$m->where('region', 'topnav');
$m->get();
?>





<div class="clearfix">
    <div class="logo">
        <a href="<?php echo base_url() ?>admin">
            <img src="<?php echo base_url() ?>assets/img/logo/logo_solutions.jpg" alt="<?php echo $site_name ?>"/>
        </a>
    </div>
    <?php if ($this->login_manager->logged_in_user): ?>
        <div class="greeting"><?php echo lang('hello'); ?>,&nbsp;<?= $this->login_manager->logged_in_user->name; ?></div>
    <?php endif; ?>
</div>
<div class="clearfix">   
    <ul class="topnav">
        <?php foreach ($m as $menu): ?>
            <ul class="topnav clearfix">
                <?php
                $mi = new Menuitem();
                $mi->order_by('weight', 'acs');
                $mi->get_by_related('menu', $menu);
                ?>
                <?php
                foreach ($mi as $menuitem):
                    $active_parent = 'passive';
                    
                    ?>        
                    <?php if ($menuitem->submenuitem->get()->count() > 0): ?>
                        <?php foreach ($menuitem->submenuitem as $subm): ?>
                            <?php
                            if ($this->uri->uri_string() == $subm->url) {
                                $active_parent = 'active';
                            }
                            ?>
                        <?php endforeach; ?>
            <?
            if ($this->uri->uri_string() == $menuitem->url):
                $active_parent = 'active';
                ?>
                                <?php endif; ?>
                        <li class="<?= $active_parent; ?>">
                            <a href="<?php echo '/' . $menuitem->url ?>" title="<?php echo $menuitem->name ?>"><?php echo $menuitem->name ?></a>
                                    <?php $menuitem->submenuitem->order_by('weight', 'acs')->get(); ?>
                            <ul>
                                    <?php foreach ($menuitem->submenuitem as $submi): ?>
                <?php if ($this->uri->uri_string() == $submi->url) : ?>
                                        <li class="active">
                                    <?php else: ?>
                                        <li class="passive">
                            <?php endif; ?>
                                        <a href="<?php echo site_url() . $submi->url ?>" title="<?php echo $submi->name ?>"><?php echo $submi->name ?></a>
                                    </li>
                            <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php elseif ($menuitem->menuitems->get()->count() == 0): ?>
            <?php if ($this->uri->uri_string() == $menuitem->url) : ?>
                            <li class="active">
                        <?php else: ?>
                            <li class="passive">
            <?php endif; ?>
                            <a href="<?php echo '/' . $menuitem->url ?>" title="<?php echo $menuitem->name ?>"><?php echo $menuitem->name ?></a>
                        </li>
        <?php endif; ?>
    <?php endforeach; ?>
            </ul>

<?php endforeach; ?>
    </ul>
</div>






