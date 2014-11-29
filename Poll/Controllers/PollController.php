<?php namespace Poll\Controllers;

use Poll\Db;
use Poll\Filters\HasVotedFilter;
use Poll\Filters\LoggedInFilter;
use Poll\Models\Poll;

class PollController
{

    public function index()
    {
        $db = new Db;

        $results = $db->query(
            "SELECT * FROM polls",
            array()
        );

        $_SESSION['polls'] = $results;

        require templatePath() . "/home.php";
    }

    public function showCreate()
    {
        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        require templatePath() . "/polls/create.php";
    }

    public function showPoll()
    {
        $hasVoted = new HasVotedFilter;
        $result = $hasVoted->filter($_GET['id']);

        if($result==true)
        {
            $_SESSION['success'] = array(
                "Since you've already voted you've been redirected to the results."
            );
            header("Location: index.php?page=showResult&id=".$_GET['id']);
            exit();
        }

        $poll = new Poll;
        if (!$poll->load($_GET['id'])) {
            pageNotFound();
        }
        require templatePath() . "/polls/show.php";
    }

    public function showResult()
    {
        require templatePath() . "/polls/results.php";
    }

    public function create($postData, $files)
    {
        $currentPoll = new Poll;

        $result = $currentPoll->save([
            'title' => $postData['title'],
            'option' => $postData['option'],
            'public' => $postData['public'],
            'multiple' => $postData['multiple'],
            'image' => $files['image']
        ]);

        if(is_array($result)){
            $_SESSION['errors'] = $result;
            header("Location: index.php?page=createPoll");
            exit();
        } else {
            $_SESSION['success'] = array(
                'Your poll has been created.'
            );
            header("Location: index.php");
            exit();
        }
    }

    public function vote($id, $optionsData)
    {
        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        $hasVoted = new HasVotedFilter;
        $result = $hasVoted->filter($id);

        if($result==true)
        {
            $_SESSION['errors'] = array(
                "You've already voted."
            );
            header("Location: index.php");
            exit();
        }

        $poll = new Poll;
        if( ! $poll->load($id))
        {
            pageNotFound();
        }



        if($optionsData == NULL)
        {
            header("Location: index.php?page=showPoll&id=".$id);
            $_SESSION['errors'] = array(
                "Please choose at least one of the options below."
            );
            exit();
        }

        $db = new Db;

        if($poll->multiple)
        {
            $questionmarks = str_repeat("?,", count($optionsData['option'])-1) . "?";

            $optionsWithId = $optionsData['option'];
            array_push($optionsWithId, $id);

            $countValidOptions = $db->query("SELECT COUNT(*) FROM options WHERE option_id IN ($questionmarks) AND poll_id = ?",
                $optionsWithId
            );
            //one or more invalid selections were made
            if($countValidOptions[0][0] != count($optionsData['option']))
            {
                pageNotFound();
            }

            $user_id = \Poll\Models\User::getIdByUsername($_SESSION['username']);

            foreach($optionsData['option'] as $option)
            {
                $db->save(
                    "INSERT INTO answers (user_id, option_id) VALUES(:user_id, :option_id)",
                    array(
                        'user_id' => $user_id,
                        'option_id' => $option
                    )
                );
            }
        } else {
            $user_id = \Poll\Models\User::getIdByUsername($_SESSION['username']);
            $db->save(
                "INSERT INTO answers (user_id, option_id) VALUES(:user_id, :option_id)",
                array(
                    'user_id' => $user_id,
                    'option_id' => $optionsData['option']
                )
            );
        }


        header("Location: index.php?page=showResult&id=".$_GET['id']);
        $_SESSION['success'] = array(
            'Your answer has been saved.'
        );
        exit();

    }

}
