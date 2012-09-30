
    <?php
    echo form_fieldset('', array('class' => 'add_edit_bl'));

    if(isset($can_agent) && $can_agent){	
        echo form_submit('agentme', lang('save_and_make_order'), 'class="white_btn blue"');
    }
    
    echo form_submit('submit', lang('save'), 'class="white_btn blue"');

    echo form_reset('', lang('reset'), 'class="white_btn blue"');

    echo '<a href="'. $_SERVER['HTTP_REFERER'].'" class="white_btn blue discard">'.lang('discard').'</a>';
    echo form_fieldset_close();
    ?>
