<?php namespace Poll\Controllers;

use Poll\Db;
use Poll\Filters\LoggedInFilter;
use Poll\Models\User;

class UsersController
{

    public function showRegister()
    {
        require templatePath() . "/users/register.php";
    }

    public function showLogin()
    {
        require templatePath() . "/users/login.php";
    }

    public function logout()
    {
        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        $_SESSION = array();
        session_destroy();
        session_start();
        $_SESSION['success'] = array(
            "You've been logged out."
        );
        header("Location: index.php");
    }

	public function register($postData)
	{
		$user = new User;
		$result = $user->save([
			'username' => $postData['username'],
			'password' => $postData['password'],
			'password_confirmation' => $postData['password_confirmation']
		]);

		if(is_array($result))
		{
			$_SESSION['errors'] = $result;
			header("Location: index.php?page=register");
			exit();
		} else {
			$_SESSION['username'] = $user->username;
            $_SESSION['success'] = array(
                "You've been successfully registered."
            );
			header("Location: index.php");
			exit();
		}
	}

	public function login($postData)
	{
		$db = new Db;

		$user = $db->query(
			"SELECT * FROM users WHERE username = ?",
			array($postData['username'])
		);

		if(empty($user))
		{
            $_SESSION['errors'] = array('Incorrect username.');
            header("Location: login.php");
            exit();
		} else 
		{
			$user = $user[0];
		}

		if(password_verify($postData['password'], $user['password']))
        {
            $_SESSION['username'] = $user['username'];
            $_SESSION['success'] = array(
                "You've been successfully logged in."
            );
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['errors'] = array('Incorrect password for the given username.');
            header("Location: index.php?page=login");
            exit();
        }
	}
}