<?php namespace Models;

include 'db.php';
include 'password_hash.php';

class User {

	public $username;
	public $password;

	public function save($userData)
	{
		$db = new \Db;

		$errors = [];

		if(strlen($userData['username']) <= 0)
			$errors[] = "Invalid username.";

		if(strlen($userData['password']) <= 5)
			$errors[] = "Invalid password.";

		if($userData['password'] !== $userData['password_confirmation'])
			$errors[] = "The passwords do not match.";

		if($db->query(
			"SELECT COUNT(*) FROM users WHERE username = :username",
			array(['username' => $userData['username']])
		))
		{
			$errors[] = "That username already exists.";
		}

		$this->name = $userData['username'];
		$this->password = password_hash($userData['password'], PASSWORD_BCRYPT);

		if(empty($errors))
		{
			$db->save(
				"INSERT INTO users (username, password) VALUES (:username, :password)",
				array(
					'username' => $this->name,
					'password' => $this->password
				)
			);
			return true;
		} else {
			return $errors;
		}


	}

}