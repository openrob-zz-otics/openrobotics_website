    </div><!-- main_container -->
	
	<!-- include jQuery -->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<!-- include bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php 
		if (PAGE_TITLE == "manage_project") {
			echo '<link rel="stylesheet" href="assets/css/datepicker3.css">
			<link rel="stylesheet" href="/assets/css/jquery.fileupload.css">
			<script src="assets/js/bootstrap-datepicker.js"></script>
			<script src="/assets/js/jquery.ui.widget.js"></script>
			<script src="/assets/js/jquery.iframe-transport.js"></script>
			<script src="/assets/js/jquery.fileupload.js"></script>';
		} else if (PAGE_TITLE == "display") {
			echo '<link rel="stylesheet" href="/assets/css/jquery.fileupload.css">
			<script src="/assets/js/jquery.ui.widget.js"></script>
			<script src="/assets/js/jquery.iframe-transport.js"></script>
			<script src="/assets/js/jquery.fileupload.js"></script>';
		} else if (PAGE_TITLE == "manage_badge") {
			echo '<link rel="stylesheet" href="/assets/css/jquery.fileupload.css">
			<script src="/assets/js/jquery.ui.widget.js"></script>
			<script src="/assets/js/jquery.iframe-transport.js"></script>
			<script src="/assets/js/jquery.fileupload.js"></script>';
		}
	?>		
	<!-- include general js -->
	<script src="/assets/js/global.js"></script>
	<!-- include unique page js -->
	<script src="assets/js/<?php echo PAGE_TITLE;?>.js"></script>
	<?php
	if (!@seen_popup) {
		echo '<script>$(function() {$("#nav_container").popover("show");});</script>';
	}
	?>
  </body>
</html>
