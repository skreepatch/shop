<div class="cont_heading">
    <h2><?php echo $title?></h2>
</div>

<?php

	echo $shipping->render_form($form_fields, $url, array(), 'dmz_htmlform/multipart');

?>