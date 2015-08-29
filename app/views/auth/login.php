<?php 

use Core\Error;
use Helpers\Form;


?>
<div class="modal fade" id="login-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Login to Your Account</h1><br>
<?php echo Error::display($error); ?>

<?php echo Form::open(array('method' => 'post'));?>

<?php echo Form::input(array('name' => 'username' , 'placeholder' => 'Username'));?></p>
<?php echo Form::input(array('type' => 'password' , 'placeholder' => 'Password' , 'name' => 'password'));?>
<?php echo Form::input(array('type' => 'submit', 'class' => 'login loginmodal-submit', 'name' => 'submit', 'value' => 'Login'));?>
<?php echo Form::close();?>
<div class="login-help">
					<a href="#">Register</a> - <a href="#">Forgot Password</a>
				  </div>
				</div>
			</div>
		  </div>