<h1>Login</h1>
<div class="inner">
    <div id="login">
            <?php
            echo '<h5>' . lang("login_to_system") . '</h5>';
            if (isset($error->all['login'])) {
                echo '<div class="red">' . $error->all['login'] . '</div>';
            }
            echo form_open('login', 'post');
            echo form_label(lang('email') . ':', 'email');
            echo form_input('email');

            echo form_label(lang('password') . ':', 'password');
            echo form_password('password');

            echo '<div><span class="blue">Forgot password? </span>' . lang('fill_email_field') . ' ' . lang('and') . '<a href="/login/forgot_password/">' . lang('click_here') . '</a>' . '</span></div>';

            echo '<div class="spacer"><input type="checkbox" class="inline" name="remember_me" checked=checked/>' . lang('remember_me') . '</div>';

            echo form_submit('login', 'Login', 'class="login_btn"');
            echo form_fieldset_close();
            echo form_close();
            ?>
    </div>
</div>