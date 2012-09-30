<div class='block login'>
    <div class="inner">
        <?php if(!$user):?>
        <h5>משתמש רשום? התחבר:</h5>
    <?php
        echo form_open(site_url('login'), array('id'=>'ws_login'));
        echo form_fieldset();
            echo form_label(lang('email'), 'email', array('class'=>'right'));
            echo form_input('email');
        echo form_fieldset_close();
        echo form_fieldset();
            echo form_label(lang('password'), 'password', array('class'=>'right'));
            echo form_password('password');
        echo form_fieldset_close();
        echo form_close();
        echo anchor(site_url(), lang('login'), array('id'=>'login_button'));
	echo '<div class="register">'.lang("new_user").'? <a href="'.  site_url("login").'" title="'.lang('register_now').'">'.lang("register_now").'</a></div>';
    ?>
        <?php else: ?>

            <p><?php echo lang('hello')?>,<br/><?php echo $user->name?></p>

            <?php echo anchor(site_url('logout'), lang('logout'));?>
        <?php endif;?>
    </div>
</div>