<?php
class Controller_upload extends Controller {
    function __construct() {
        parent::__construct();
        User::permissions()<50 ? Go::main() : '';
    }
    
    function index() {
        
    }
    
    function ckeditor() {
        $dir = $this->registry()->config['app_path'].'/upload/ckeditor/';
        $url = $this->registry()->config['base_href'].$dir.md5($_FILES['upload']['name']).'.jpg';
        
        $message = '';
        if ($_FILES['upload'] == "none" || empty($_FILES['upload']['name']) ) {
           $message = "No file uploaded.";
        } else if($_FILES['upload']["size"] == 0) {
           $message = "The file is of zero length.";
        } else if ($_FILES['upload']["type"] != "image/pjpeg" && $_FILES['upload']["type"] != "image/jpeg") {
           $message = "The image must be in either JPG format. Please upload a JPG instead.";
        } else {
            ini_set('memory_limit', '128M');
            $photo = new Upload_image();
            $photo->width=640;
            $photo->height=480;
            $photo->imageName=$_FILES['upload']['name'];
            $photo->upload(PATH.$dir, $_FILES['upload']['tmp_name']);
            unset($photo);
        };
        echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$_GET['CKEditorFuncNum'].'", "'.$url.'", "'.$message.'");
              </script>';
    }
}