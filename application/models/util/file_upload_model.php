<?php

class File_upload_model extends CI_Model {

    function process_img($img_id, $product) {
	$post = $_POST;
	$img_path = './images/orders/';
	$this->load->library('image_lib');
	$base_path = 'g:/xampp_vc9/htdocs/virgo/';

	$_conf = array(
	    'upload_path' => './files/uploads/',
	    'allowed_types' => 'bmp|gif|jpg|png',
	    'max_size' => '128000',
	    'max_width' => '20000',
	    'max_height' => '20000'
	);

	$dynamic_formats = array('.pdf', '.eps', '.ai');

	$img = new Orderimage();
	$img->where('id', $img_id)->get();
	$this->upload->initialize($_conf);
	if ($this->upload->do_upload($img_id)) {

	    $image_data = $this->upload->data();
	    $imagename = $_POST['cart'] . '_' . $_POST['ordering'] . '_' . $product . '_' . $_POST['page_number'] . '_' . $_POST['side_number'] . '_' . $image_data['file_name']; // 
	    if (copy($image_data['full_path'], './images/orders/' . $imagename)) {
		$file = $base_path . 'images/orders/' . $imagename;
		$a = GETIMAGESIZE($file);
		$bpc = ISSET($a['bits']) ? $a['bits'] : 8;
		$f = FOPEN($file, 'rb');
		$data = '';
		WHILE (!FEOF($f)) {
		    $data .= FREAD($f, 4096);
		}
		FCLOSE($f);
		$dpi = UNPACK('x14/ndpi', $data);
	    }

	    $img->url = '/images/orders/' . $imagename;
	    $img->extension = $image_data['file_ext'];
	    $img->width = $image_data['image_width'];
	    $img->height = $image_data['image_height'];
	    $img->image_name = $image_data['file_name'];
//            $img->cart_id = $_POST['cart'];
//            $img->ordering_id = $_POST['ordering'];
//            $img->pageside_id = $img_id;
	    $img->dpi = $dpi['dpi'];

	    $source = $base_path . 'images/orders/' . $imagename;
	    $preview = '';
	    if (in_array($image_data['file_ext'], $dynamic_formats)) {
		$source = $source . '[0]';
		$dest = $base_path . 'images/orders/previews/' . $image_data['file_name'] . '.jpg';
		exec("g:/xampp/imagemagic/convert.exe $source $dest");
		$preview = '/images/orders/previews/' . $image_data['file_name'] . '.jpg';
	    } else {
		$image = realpath('/images/orders/') . $imagename;
		$dpi = $img->dpi;

		$pr_width = $_POST['width'];
		$pr_height = $_POST['height'];

		//$result = $this->px2cm($image, $dpi);
		$_confb = Array();
		$_confb['source_image'] = $source;
		$_confb['new_image'] = $base_path . 'images/orders/previews/' . $image_data['file_name'];
		$_confb['height'] = $pr_height;
		$_confb['width'] = $pr_width;
		$_confb['maintain_ratio'] = TRUE;

		if ($this->image_lib->initialize($_confb)) {
		    if ($this->image_lib->resize()) {
			$preview = '/images/orders/previews/' . $image_data['file_name'];
		    } else {
			echo 'resize_error';
		    }
		} else {
		    echo 'init failed';
		}

		$this->image_lib->clear();
	    }
	    $img->preview = $preview;
	    $img->save();
	    echo 'success';
	} else {
	    echo 'failure';
	}
    }

    function process_attachment($uid) {
	$post = $_POST;
	$img_path = './files/uploads/attachments/';
	$base_path = BASEPATH;

	$_conf = array(
	    'upload_path' => './files/uploads/attachments',
	    'allowed_types' => 'bmp|gif|jpg|png|pdf|doc|docx|txt',
	    'max_size' => '4096',
	    'max_width' => '0',
	    'max_height' => '0'
	);
	$att = new Attachment();
	$this->upload->initialize($_conf);
	if (!$this->upload->do_upload('attachment_file')) {
	    $error = array('error' => $this->upload->display_errors());
	    print_r($error);
	} else {
	    $att_data = $this->upload->data();
	    $filename = $att_data['file_name'];
	    echo 'success';
	}
    }
    function process_sheetAttachment() {
	$post = $_POST;
	$img_path = './files/uploads/sheets/';
	$base_path = BASEPATH;

	$_conf = array(
	    'upload_path' => './files/uploads/sheets',
	    'allowed_types' => 'jpg|png',
	    'max_size' => '4096',
	    'max_width' => '0',
	    'max_height' => '0'
	);
	$this->upload->initialize($_conf);
	if (!$this->upload->do_upload('sheetimage')) {
	    $error = array('error' => $this->upload->display_errors());
	    print_r($error);
	} else {
	    $att_data = $this->upload->data();
	    $filename = $att_data['file_name'];
	    echo 'success';
	}
    }
    
    function process_template() {
	$post = $_POST;
	$img_path = './files/uploads/templates/';
	$base_path = BASEPATH;

	$_conf = array(
	    'upload_path' => './files/uploads/templates',
	    'allowed_types' => 'svg',
	    'max_size' => '10000',
	    'max_width' => '0',
	    'max_height' => '0'
	);
	$this->upload->initialize($_conf);
	if (!$this->upload->do_upload('template_file')) {
	    $error = array('error' => $this->upload->display_errors());
	    echo 'failure';
	} else {
	    $att_data = $this->upload->data();
	    $filename = $att_data['file_name'];
	    echo $filename;
	}
    }
    function process_images($file_upload) {
	$post = $_POST;
	$img_path = './files/uploads/images/';
	$base_path = BASEPATH;

	$_conf = array(
	    'upload_path' => './files/uploads/images',
	    'allowed_types' => 'jpg|png|gif|bmp',
	    'max_size' => '2048',
	    'max_width' => '0',
	    'max_height' => '0'
	);
	$this->upload->initialize($_conf);
	if (!$this->upload->do_upload($file_upload)) {
	    $error = array('error' => $this->upload->display_errors());
	    $res = array(
		'success' => FALSE,
		'error' => $error,
	    );
	    return $res;
	} else {
	    $att_data = $this->upload->data();
	    $filename = $att_data['file_name'];
	    $res = array(
		'success' => TRUE,
		'filename' => $filename,
	    );
	    return $res;
	}
    }

}