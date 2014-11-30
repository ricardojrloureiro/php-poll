<?php namespace Poll\Filters;

use Poll\Models\User;

class LoggedInFilter
{

    public function filter()
    {
        if(! isset($_SESSION['username']))
        {
            $_SESSION['errors'] = array(
                "You need to be logged in to access this page."
            );
            header("Location: index.php");
            exit();
        }
    }

    public function filterById($id)
    {
        if(!isset($_SESSION['username']))
        {
            $_SESSION['errors'] = array(
              "You don't have access to required page."
            );
            header("Location: index.php");
            exit();
        }

        $user = new User;
        $currentId = $user->getIdByUsername($_SESSION['username']);


        if($currentId !== $id)
        {
            $_SESSION['errors'] = array(
                "You are only available to manage your own polls."
            );
            header("Location: index.php");
            exit();
        }
    }

}