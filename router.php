<?php
foreach (glob("controllers/*.php") as $filename)
{
    include $filename;
}

switch($_GET['page']) {
	case "register":
		$usersController = new Controllers\UsersController;
		$usersController->register($_POST);
		break;

	case "login":
		$usersController = new Controllers\UsersController;
		$usersController->login($_POST);
		break;
}