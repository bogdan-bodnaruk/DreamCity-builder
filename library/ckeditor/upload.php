<?php
$url = 'http://interedinfo.work/interedinfo/upload/ckeditor/'.md5($_FILES['upload']['name']).'.jpg';
$message = '';
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) ) {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0) {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") && ($_FILES['upload']["type"] != "image/jpeg") && ($_FILES['upload']["type"] != "image/png")) {
       $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    else {
		include_once('../../DRM/Upload_image.php');
		$photo = new upload_image();
		$photo->width=640;
		$photo->height=480;
		$photo->imageName=$_FILES['upload']['name'];
		$photo->upload('../../interedinfo/upload/ckeditor', $_FILES['upload']['tmp_name']);
		unset($photo);
    };
echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].', '.$url.', '.$message.');</script>';