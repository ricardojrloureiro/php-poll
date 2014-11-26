<?php namespace Controllers;

include 'models/Poll.php';

class PollController
{

    public function create($postData)
    {
        $currentPoll = new \Models\Poll;
        /**
         * Add more information to put into the database
         */
        $result = $currentPoll->save([
            'title' => $postData['title']
        ]);

        if(is_array($result)){
            $_SESSION['errors'] = $result;
            header("Location: index.php");
            exit();
        }else {
            header("Location: index.php");
            exit();
        }
    }

    public function view_poll()
    {

    }

}
