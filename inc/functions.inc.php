<?php

function bodyBuilder($type) {

	if ($type==1){
		echo '<!DOCTYPE html>
<html>
	<head>';
	
	} elseif ($type==2) {
		echo ' <!-- BB2 -->	
		</body>
</html>';
	
	}

}

function is_locked() {
    $lockkey = $_GET['lk'];
    global $lock_status, $lockkey;
    if ($lockkey != '1') {
        $lock_status = '0';
        return $lock_status;
    } else {
        $lock_status = '1';
        return $lock_status;
    }
}

function hide_locked_element() {
    if (is_locked() == '1') {
        return ' hidden';
    } else {
        return '';
    }
}

