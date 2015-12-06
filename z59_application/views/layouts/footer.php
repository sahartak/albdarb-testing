<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<footer>
		<div class="container">
			<div class="col-xs-6"><a href="http://albdarb.com" target="_blank">&copy; Albdarb.com</a></div>
			<div class="col-xs-6">Powered By <a href="https://www.facebook.com/artak.sahakyan.31" target="_blank">Artak Sahakyan</a></div>
		</div>
	</footer>
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<?php if ($this->router->fetch_method() == 'get_test'):?>
	<script src="/assets/js/flipclock.min.js"></script>
<?php endif;?>
	<script src="/assets/js/scripts.js"></script>
</body>
</html>