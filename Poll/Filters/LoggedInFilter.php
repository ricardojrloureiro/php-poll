<?php namespace Poll\Filters;

class LoggedInFilter
{

    public function filter()
    {
        if(! isset($_SESSION['username']))
        {
            $_SESSION['errors'] = array(
                "You need to be logged in to access this page"
            );
            header("Location: index.php");
            exit();
        }
    }

}