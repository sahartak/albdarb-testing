<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>Login To Admin Panel</title>

	<!-- Bootstrap -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	</head>
	<body>
	<div class="container">
		<?php echo form_open();?>
            <div class="col-md-10 col-md-offset-2">
        		<div class="row">&nbsp;</div>
        		<div class="row">
        		<?php if($this->session->flashdata('wrong_login')):?>
        			<h4>Լոգինը կամ գաղտնաբառը սխալ է</h4>
        		<?php endif;?>
        			<?php echo validation_errors(); ?>
        		</div>
        		<div class="row">&nbsp;</div>
        		<div class="row">
        			<div class="col-sm-4">
        				<input type="text" class="form-control" required="true" name="login" placeholder="Login" />
        			</div>
        			<div class="col-sm-4">
        				<input type="password" class="form-control" name="password" placeholder="Password" />
        			</div>     
        			<div class="col-sm-4">
        				<input type="submit" class="btn btn-primary" name="login_submit" value="Մուտք" />
        			</div>
        		</div>
        			
        		</div>
            </div>
		</form>
	</div>

	</body>
</html>