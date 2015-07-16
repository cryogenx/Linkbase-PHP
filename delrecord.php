<?php
include("inc/dbfunctions.inc.php");

//vars
$linker = $_GET['lid'];
$user_token = $_GET['ut'];
$link_id = $_GET['link'];

if (!isset($linker)) {
	echo "No Linkbase Specfied, please go back and try again";
	die;
} else {
	if(!isset($user_token)) {
		echo "No User Token provided, please try again from your linkbase";
		die;
	} else {
		check_access_key($linker, $user_token);
	}

}

// linker and ut accepted

$return = del_link($linker, $link_id);

include('inc/header.inc.php');
?>
	<div class='container'>
		<?php		

echo $return;

include('inc/footer.inc.php');
?>		
	</div>
			
			<!-- SCRIPT BLOCK -->
		<script src="bootstrap/js/jquery.js"></script>
		<!--<script src="bootstrap/js/jquery.flot.js"></script> -->
		<!--<script src="bootstrap/js/jquery.flot.pie.js"></script> -->
		<!-- <script src="bootstrap/js/jquery.hotkeys.js"></script> -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="bootstrap/js/bootstrap-modalmanager.js"></script>
		<script src="bootstrap/js/bootstrap-modal.js"></script>
		<!--<script src="bootstrap/js/bootstrap-tab.js"></script> -->
		<!-- <script src="bootstrap/js/bootstrap-wysiwyg.js"></script> -->
	
	</body>
</html>
