<?php
namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\Session;
use Helpers\Password;
use Helpers\Url;
use Helpers\Hooks;


class Auth extends Controller{
	private $_model;
	public function __construct(){
		$this->_model = new \Models\auth();
	}
	public function css(){
		echo '<link href="'.DIR.'app/templates/default/css/auth/login.css" rel="stylesheet" type="text/css">';
	}
	public function js(){
		echo '<script src="'.DIR.'app/templates/default/js/auth/login.js" type="text/javascript"></script>';
	}
	public function login(){	
		Hooks::addHook('js', 'Controllers\auth@js');
		Hooks::addHook('css', 'Controllers\auth@css');
		$error = 'hi';
		$success = 'hi';
		if(Session::get('loggedin')){
            Url::redirect();
        }	
		if(isset($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			//validation
			if(Password::verify($password, $this->_model->getHash($username)) == false){
				$error[] = 'Wrong username or password';
			}
			//if validation has passed carry on
			if(!$error){
				Session::set('loggedin',true);
				Session::set('username',$username);
				Session::set('memberID',$this->_model->getID($username));

				$data = array('lastLogin' => date('Y-m-d G:i:s'));
				$where = array('memberID' => $this->_model->getID($username));
				$this->_model->update($data,$where);
				$error = 'hi';
				Url::redirect();
			}
		}
		$data['title'] = 'Login';
		View::rendertemplate('header',$data);
		View::render('auth/login',$data,$error,$success);
		View::rendertemplate('footer',$data);
	}
	public function logout(){
		Session::destroy();
		Url::redirect();
	}
}

?>