<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav role="navigation" class="navbar navbar-default nav_menu">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="<?php echo site_url('admin');?>">Գլխավոր</a></li>
			<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#">Թեստեր <b class="caret"></b></a>
			<ul role="menu" class="dropdown-menu">
				<li><a href="<?php echo site_url('admin/create_test');?>">Ավելացնել նոր թեստ</a></li>
				<li><a href="<?php echo site_url('admin/tests');?>">Դիտել թեստերը</a></li>
			</ul>
			</li>
		</ul>
	</div>
</nav>