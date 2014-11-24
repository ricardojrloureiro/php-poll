<?php namespace Controllers;

include 'models/User.php';

class UsersController
{
	public function register($postData)
	{
		$user = new \Models\User;
		$result = $user->save([
			'username' => $postData['username'],
			'password' => $postData['password'],
			'password_confirmation' => $postData['password_confirmation']
		]);

		session_start();
		session_set_cookie_params(0, '/~ei12038/proj', 'gnomo.fe.up.pt');

		if(is_array($result))
		{
			$_SESSION['errors'] = $result;
			header("Location: index.php");
			exit();
		} else {
			$_SESSION['username'] = $user->name;
			header("Location: index.php");
			exit();
		}
	}

	public function login($postData)
	{
		$db = new \Db;

		$user = $db->query(
			"SELECT * FROM users WHERE username = ?",
			array($postData['username'])
		);

		if(empty($user))
		{
			return false;
		} else 
		{
			$user = $user[0];
		}

		var_dump(password_verify($postData['password'], $user['password']));
	}
}