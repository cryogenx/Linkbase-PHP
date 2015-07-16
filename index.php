<?php
//linker project 0.1a
include("inc/functions.inc.php");
include("inc/dbfunctions.inc.php");

bodyBuilder(1);
include('inc/header.inc.php');

$linker = $_GET['lid'];
$user_token = $_GET['ut'];
$lockkey = $_GET['lk'];


$gk = check_access_key($linker, $user_token);

if ($gk==1){

?>
<div class='container'>
	<div class="row-fluid">	
		<?php linker_info($linker); ?>
	</div>
	<div class="row-fluid">	
		<?php linker_link_by_cat($linker); ?>
	</div>
	<?php include('inc/footer.inc.php'); ?>
</div>
	
<?php 
} else {
	include('inc/homepage.inc.php');
}

include('inc/modals.inc.php'); 
include('inc/scriptblock.inc.php');
bodyBuilder(2);

?>	





