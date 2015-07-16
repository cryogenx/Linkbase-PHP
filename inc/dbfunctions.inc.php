<?php
// mysqli

require('inc/config.inc.php');


function check_access_key($lid, $ut){
	
	global $dbname, $dbuser, $dbpass, $dbhost;
			
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);
	
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$result = $mysqli->query("SELECT `linker`.`linker_id`, `users`.`user_name`,`users`.`user_key`, `linker`.`user_id` FROM linker JOIN users ON `linker`.`user_id` = `users`.`user_id` WHERE `linker`.`linker_id` = '" . $lid . "'");
			while ($row = mysqli_fetch_array($result)){
				if ($row['user_key'] == $ut) {
					return '1';
				} else {
					return '0';
					die;					
				}
			}
		
		$mysqli->close();
}

function get_links($lid, $cat_id){	
	global $dbname, $dbuser, $dbpass, $dbhost, $user_token, $lockkey;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$result = $mysqli->query("SELECT link_id, link_title, link_url, link_target FROM links WHERE linker_id = '" . $lid . "' AND cat_id = '" . $cat_id . "' ORDER BY link_title");
	$num = ($result->num_rows)-1;
	$i=0;
	$n=0;
        $hide = hide_locked_element();
		while ($row = mysqli_fetch_array($result)){
						if ($i==0){
						echo '<div class="row-fluid">';
						}
						?>
						<div id="<?php echo $i . "-" . $n . "-" . $num;?>" class="well well-small span3">
							<a href="<?php echo $row['link_url']; ?>" target="<?php echo get_link_target($row['link_target']);?>"><?php echo $row['link_title']; ?> </a> 
							<a href="delrecord.php?lid=<?php echo $lid; ?>&ut=<?php echo $user_token; ?>&link=<?php echo $row['link_id']; ?>">
								<i class="icon-remove-sign pull-right<?php echo $hide;?>"></i>
							</a>
						</div>					
					<?php

					if ($n==$num){
						if ($i==3){

						} else {
							echo '</div>';
							$i=0;	
						}
					}

					if ($i==3){
						echo '</div>';
						$i=0;
					} else {
						$i++;
					}
					$n++;
		} 
	$mysqli->close();
}

function linker_info($lid){
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
    $hide = hide_locked_element();
	
	$result = $mysqli->query("SELECT linker_title FROM linker WHERE linker_id = '" . $lid . "'");
		while ($row = mysqli_fetch_array($result)){
			echo "<h2 class='span4'>".$row['linker_title'].' <i class="icon-large icon-bookmark"></i></h2> <a href="#linkModal" class="span3 btn btn-info btn-large pull-right'. $hide .'" data-toggle="modal">New Link</a><a href="#catModal" class="span3 btn btn-info btn-large pull-right'. $hide .'" data-toggle="modal">New Category</a>';
		}
	
	$mysqli->close();
}

function linker_link_by_cat($lid){
	
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$c=0;
	$result = $mysqli->query("SELECT cat_id, cat_desc FROM category WHERE linker_id = '" . $lid . "' ORDER BY cat_desc ASC");
	$num=$result->num_rows;
	echo '<div class="accordion" id="accordion2">';
		while ($row = mysqli_fetch_array($result)){
			
			?>	

	<div id="<?php echo $c; ?>" class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $c; ?>">
				<?php echo '<h4>'.$row['cat_desc'].'</h4>'; ?>
			</a>
		</div>
		<div id="collapse<?php echo $c; ?>" class="accordion-body collapse">
			<div class="accordion-inner">
				<?php echo get_links ($lid, $row['cat_id']); ?> 
			</div>
		</div>
	</div>

			<?php
			$c++;

		}
	//echo '</div>';
	$mysqli->close();
}

function linker_get_cats($lid){
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	
	$result = $mysqli->query("SELECT cat_id, cat_desc FROM category WHERE linker_id = '" . $lid . "'");
		while ($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['cat_id'].'">'.$row['cat_desc'].'</option>';
		}
	
	$mysqli->close();
}

function linker_get_targets(){
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	
	$result = $mysqli->query("SELECT target_id, target_desc FROM sys_targets");
		while ($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['target_id'].'">'.$row['target_desc'].'</option>';
		}
	
	$mysqli->close();
}

function add_link($linker, $cat, $title, $desc, $url, $target){
	global $dbname, $dbuser, $dbpass, $dbhost, $linker, $user_token;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	if(!isset($desc)) {
		$desc = 'No Desc Provided';
	}
	
	$stmt = $mysqli->prepare("INSERT INTO links(cat_id, link_title, link_desc, link_url, link_target, linker_id) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('isssii', $cat, 
	$title,
	$desc,
	$url,
	$target,
	$linker);
	$stmt->execute();
	$newId = $stmt->insert_id;
	$stmt->close();
	
	return "<div class='row-fluid'><div class='well span12'><p class='span12'>New Link added <br/>ID: $newId<br/>Name: $title</p></div></div><div class='row-fluid'><div class='well span12'><a class='btn btn-large btn-block btn-info' href='index.php?lid=$linker&ut=$user_token'>Back to Linkbase</a></div></div>";
}

function add_cat($linker, $title){
	global $dbname, $dbuser, $dbpass, $dbhost, $linker, $user_token;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	if(!isset($desc)) {
		$desc = 'No Desc Provided';
	}
	
	$stmt = $mysqli->prepare("INSERT INTO category(cat_desc, linker_id) VALUES (?, ?)");
	$stmt->bind_param('si',	$title,	$linker);
	$stmt->execute();
	$newId = $stmt->insert_id;
	$stmt->close();
	
	return "<div class='row-fluid'><div class='well span12'><p class='span12'>New Category added <br/>ID: $newId<br/>Name: $title</p></div></div><div class='row-fluid'><div class='well span12'><a class='btn btn-large btn-block btn-info' href='index.php?lid=$linker&ut=$user_token'>Back to Linkbase</a></div></div>";
}

function add_linker($username, $password, $email, $key, $title){
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	if(!isset($desc)) {
		$desc = 'No Desc Provided';
	}
	
	$stmt = $mysqli->prepare("INSERT INTO users(user_name, user_email, user_password, user_key) VALUES (?, ?, ?, ?)");
	$stmt->bind_param('ssss', $username, $email, $password, $key);
	$stmt->execute();
	$newId = $stmt->insert_id;
	$stmt->close();
	
	$stmt2 = $mysqli->prepare("INSERT INTO linker(linker_title, user_id) VALUES (?, ?)");
	$stmt2->bind_param('ss', $title, $newId);
	$stmt2->execute();
	$newId2 = $stmt2->insert_id;
	
	$stmt2->close();
	
	$to = $email;
	$subject = "Welcome to Linkbase";
	$message = "<html><body><p class='span12'>New User added <br/>ID: $newId<br/>Name: $username <br/> Email: $email <br/>Linker ID: $newId2 Linkbase Key: $key<br/><br/><a href='http://linkbase.me/index.php?lid=$newId2&ut=$key'>Goto your Linkbase</a></p></body></html>";
	$from = "noreply@linkbase.me";
	$headers = "From:" . $from . "\r\n";
	$headers .= "Reply-To: support@linkbase.me \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($to,$subject,$message,$headers);
		
	return "<div class='row-fluid'><div class='well span12'><p class='span12'>New User added <br/>ID: $newId<br/>Name: $username <br/> Email: $email <br/>Linker ID: $newId2 Linkbase Key: $key</p></div></div><div class='row-fluid'><div class='well span12'><a class='btn btn-large btn-block btn-info' href='index.php?lid=$newId2&ut=$key'>Goto your Linkbase</a></div></div>";
}

function del_link($linker, $link_id){
	global $dbname, $dbuser, $dbpass, $dbhost, $linker, $user_token;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$stmt = $mysqli->prepare("DELETE FROM links WHERE linker_id = ? AND link_id = ?");
	$stmt->bind_param('ii', $linker, $link_id);
	$stmt->execute();
	$stmt->close();
	
	return "<div class='row-fluid'><div class='well span12'><p class='span12'>Link Removed</p></div></div><div class='row-fluid'><div class='well span12'><a class='btn btn-large btn-block btn-info' href='index.php?lid=$linker&ut=$user_token'>Back to Linkbase</a></div></div>";
}

function get_link_target($target_id){
	
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	
	$result = $mysqli->query("SELECT target_id, target_text FROM sys_targets WHERE target_id = '" . $target_id . "'");
		while ($row = mysqli_fetch_array($result)){
			echo $row['target_text'];
		}
	
	$mysqli->close();
}

function blank_db_call(){
	
	global $dbname, $dbuser, $dbpass, $dbhost;
		
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	
	$result = $mysqli->query();
		while ($row = mysqli_fetch_array($result)){
			
		}
	
	$mysqli->close();
}

function generatePassword($length=20, $strength=7) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
	
	
?>


