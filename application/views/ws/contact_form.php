<h1><?php echo $title; ?></h1>
<div class="inner">
    <?php
    echo form_open(current_url(), array('id' => 'contact_form'));


    $css_class = isset($error['name']) ? 'error' : '';
    echo form_fieldset('', array('class' => $css_class));
    echo form_label(lang('name') . '*', 'name');
    echo form_input('name', '');
    echo '<em class="icon">&nbsp;</em>';
    echo form_fieldset_close();

    $css_class = isset($error['email']) ? 'error' : '';
    echo form_fieldset('', array('class' => $css_class));
    echo form_label(lang('email') . '*', 'email');
    echo form_input('email', '');
    echo '<em class="icon">&nbsp;</em>';
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('subject'), 'subject');
    echo form_input('subject', '');
    echo form_fieldset_close();

    echo form_fieldset();
    echo form_label(lang('message'), 'message');
    echo form_textarea('message', '');
    echo form_fieldset_close();

    $css_class = isset($captcha_err) ? 'error' : '';
    echo '<fieldset class="captcha '. $css_class .'">';
    $vals = array(
	'time' => time(),
	'word' => $captcha_words,
	'img_path' => './files/captcha/',
	'img_url' => './files/captcha/',
	'font_path' => './assets/fonts/dinamikamedium-webfont.ttf',
	'img_width' => '254',
	'img_height' => '40',
	'expiration' => '7200',
    );



    $cap = create_captcha($vals);

    $data = array(
	'captcha_time' => $cap['time'],
	'ip_address' => $this->input->ip_address(),
	'word' => $cap['word']
    );

    $query = $this->db->insert_string('captcha', $data);
    $this->db->query($query);

    echo '<label class="inline_label">Type the letters</label>';
    echo '<input type="text" name="captcha" value="" />';
    echo '<em class="icon">&nbsp;</em>';
    echo $cap['image'];
    echo '</fieldset>';


    echo form_fieldset();
    echo form_submit('submit', lang('submit'));
    echo form_fieldset_close();




    echo form_close();
    ?>
</div>