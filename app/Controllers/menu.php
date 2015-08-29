<?php
namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\Session;
use Helpers\Password;
use Helpers\Url;
use Helpers\Hooks;

class Menu extends Controller{
    private $_model;
	public function __construct()
    {        
        $this->_model = new \Models\index();        
    }
    public function indexJS(){
       echo '<script src="'.DIR.'app/templates/default/js/fileupload/fileinput.min.js" type="text/javascript"></script>'; 
    }
    public function indexCss(){
        echo '<link href="'.DIR.'app/templates/default/css/menu/index.css" rel="stylesheet" type="text/css">';      
    	echo '<link href="'.DIR.'app/templates/default/css/fileupload/fileinput.min.css" rel="stylesheet" type="text/css">';    	
    }
	public function index(){        
        if(!Session::get('loggedin')){
            Url::redirect('login');
        }
        
        if(isset($_POST['submit']) && $_FILES['fileToUpload']['size'] > 0){
            $name = ((!isset($_POST['productName']) || trim($_POST['productName']) == '')? '': $_POST['productName']);
            $price = ((!isset($_POST['productPrice']) || trim($_POST['productPrice']) == '')? 0: floatval($_POST['productPrice']));
            $description = ((!isset($_POST['productDescription']) || trim($_POST['productDescription']) == '')? '': $_POST['productDescription']);
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    //echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $error = "Sorry, file already exists.".$error;
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $error = "Sorry, your file is too large.".$error;
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.".$error;
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error = "Sorry, your file was not uploaded.".$error;
            // if everything is ok, try to upload file
            } else {
                //if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], str_replace(' ','-',strtolower($target_file)))) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $product['product'] = array('name' => $name,
                                                'price' => $price,
                                                'description' => $description,
                                                'lastUpdate' => date('Y-m-d G:i:s'));
                   $product['image'] = array('image' => file_get_contents($_FILES  ['fileToUpload']['tmp_name']),
                                             'size' => $_FILES["fileToUpload"]["size"] ,
                                             'type' => $imageFileType,);
                   $this->_model->insertProduct($product);
                   //unlink(str_replace(' ','-',strtolower($target_file)));
                             

            }
        }    
		Hooks::addHook('js', 'Controllers\menu@indexJS');
		Hooks::addHook('css', 'Controllers\menu@indexCss');
		$data['title'] = 'index';
        $data['username'] = Session::get('username');
		View::rendertemplate('header',$data);
		View::render('menu/index',$data,$error);
		View::rendertemplate('footer',$data);
	}
}