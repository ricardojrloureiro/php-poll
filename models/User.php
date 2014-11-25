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
			$errors[] = "Invalid password, it requires at least 6 characters.";

		if($userData['password'] !== $userData['password_confirmation'])
			$errors[] = "The passwords do not match.";

        $result = $db->query(
            "SELECT COUNT(*) FROM users WHERE username = ?",
            array($userData['username']));
        if($result[0][0] !== '0')
        {
            $errors[] = "That username already exists.";
        }

		$this->username = $userData['username'];
		$this->password = password_hash($userData['password'], PASSWORD_BCRYPT);

		if(empty($errors))
		{
			$db->save(
				"INSERT INTO users (username, password) VALUES (:username, :password)",
				array(
					'username' => $this->username,
					'password' => $this->password
				)
			);
			return true;
		} else {
			return $errors;
		}

	}

}