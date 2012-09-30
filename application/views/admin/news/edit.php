<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>

<?php
echo $newsitem->render_form($form_fields, $url, array(), 'dmz_htmlform/multipart');
?>

<script type="text/javascript">
    // Datepicker
    $(document).ready(function(){
	$('#date').datepicker({
	    inline: true,
	    dateFormat: 'yy-mm-dd'
	});
    });
</script>