<?php
require 'bootstrap.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$requestedPage = isset($_GET['page']) ? $_GET['page'] : "index";

if($httpMethod === "GET")
{
    switch($requestedPage) {
        case "index":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->index();
            break;

        case "register":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->showRegister();
            break;

        case "login":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->showLogin();
            break;

        case "logout":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->logout();
            break;

        case "createPoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->showCreate();
            break;

        case "showPoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->showPoll($_GET['id']);
            break;

        case "showResult":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->showResult();
            break;

        case "modifyUser":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->managePollsFromUser($_GET['id']);
            break;

        case "deletePoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->deletePoll($_GET['id']);
            break;

        case "editPoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->editPollById($_GET['id']);
            break;

        case "availableUsername":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->availableUsername($_GET['username']);
            break;

        default:
            $_SESSION['errors'] = array(
                'Page not found.'
            );
            header("Location: index.php");
            break;
    }
}

if($httpMethod === "POST")
{
    switch($requestedPage) {
        case "register":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->register($_POST);
            break;

        case "login":
            $usersController = new \Poll\Controllers\UsersController;
            $usersController->login($_POST);
            break;

        case "createPoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->create($_POST, $_FILES);
            break;

        case "showPoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->vote($_GET['id'], $_POST);
            break;

        case "overWritePoll":
            $pollController = new \Poll\Controllers\PollController;
            $pollController->overWritePoll($_GET['id'],$_POST);
            break;

        default:
            $_SESSION['errors'] = array(
                'Page not found.'
            );
            header("Location: index.php");
            break;
    }
}