<?php

$default_frame = false;

if (isset($_POST['user']) && isset($_POST['pass'])) {
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$user_o = $model->users->checkPass($user, $pass);

	//only global admins can login into panel
	if ($user_o === false || (int) $user_o['global_perms'] < 5) {
		$errors[] = 'Zła nazwa użytkownika lub hasło.';
	} else {
		//remove password for safety
		unset($user_o['pass']);
		
		if ($user_o['avatar'] == '') {
			$user_o['avatar'] = file_get_contents('images/user.png');
		}
		
		$_SESSION['auth'] = $user_o;
		header('Location: index');
	}
}
