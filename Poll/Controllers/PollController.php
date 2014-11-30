<?php namespace Poll\Controllers;

use Poll\Db;
use Poll\Filters\HasVotedFilter;
use Poll\Filters\LoggedInFilter;
use Poll\Models\Poll;
use Poll\Models\User;

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
        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        $hasVoted = new HasVotedFilter;
        $result = $hasVoted->filter($_GET['id']);

        if ($result == true) {
            $_SESSION['success'] = array(
                "Since you've already voted you've been redirected to the results."
            );
            header("Location: index.php?page=showResult&id=" . $_GET['id']);
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
        $db = new \Poll\Db;

        $results = $db->query(
            "select COUNT(*),answers.option_id,options.value from answers
                INNER JOIN options on options.option_id = answers.option_id
                AND options.poll_id = ? group by answers.option_id;",
            array($_GET['id'])
        );

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

        if (is_array($result)) {
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

        if ($result == true) {
            $_SESSION['errors'] = array(
                "You've already voted."
            );
            header("Location: index.php");
            exit();
        }

        $poll = new Poll;
        if (!$poll->load($id)) {
            pageNotFound();
        }


        if ($optionsData == NULL) {
            header("Location: index.php?page=showPoll&id=" . $id);
            $_SESSION['errors'] = array(
                "Please choose at least one of the options below."
            );
            exit();
        }

        $db = new Db;

        if ($poll->multiple) {
            $questionmarks = str_repeat("?,", count($optionsData['option']) - 1) . "?";

            $optionsWithId = $optionsData['option'];
            array_push($optionsWithId, $id);

            $countValidOptions = $db->query("SELECT COUNT(*) FROM options WHERE option_id IN ($questionmarks) AND poll_id = ?",
                $optionsWithId
            );
            //one or more invalid selections were made
            if ($countValidOptions[0][0] != count($optionsData['option'])) {
                pageNotFound();
            }

            $user_id = \Poll\Models\User::getIdByUsername($_SESSION['username']);

            foreach ($optionsData['option'] as $option) {
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


        header("Location: index.php?page=showResult&id=" . $_GET['id']);
        $_SESSION['success'] = array(
            'Your answer has been saved.'
        );
        exit();

    }


    public function managePollsFromUser($id)
    {
        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        $db = new Db;

        $results = $db->query(
            "Select * from Polls  where user_id = ?",
            array($id)
        );
        require templatePath() . "/polls/modifyPolls.php";
    }

    public function deletePoll($id)
    {

        $isLoggedIn = new LoggedInFilter;
        $isLoggedIn->filter();

        $db = new Db;

        //TODO adicionar duas querys para tambem remover as opcoes e as respostas da base de dados

        $db->query(
            "delete from polls where poll_id=?;",
            array($id)
        );

        $user = new User;
        $userId = $user->getIdByUsername($_SESSION['username']);

        header("Location: index.php?page=modifyUser&id=" . $userId);
        $_SESSION['success'] = array(
            'The chosen poll has been deleted.'
        );
    }

}
