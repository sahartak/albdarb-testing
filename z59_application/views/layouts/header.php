<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?=base_url()?>favicon.ico" type="image/x-icon" />
		<title><?=$title?></title>

		<!-- Bootstrap -->
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/assets/css/fonts.css" rel="stylesheet" />
		<?php if ($this->router->fetch_method() == 'get_test'):?>
		<link href="/assets/css/flipclock.css" rel="stylesheet" />
		<?php endif;?>
		<link href="/assets/css/style.css" rel="stylesheet" />
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

	<header class="container-fluid header">
		<div class="header_top_block">
			<div class="container">
				<?php //$this->load->view('layouts/admin_nav')?>
			</div>
		</div>
	</header>     
