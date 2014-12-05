<?php namespace Poll\Controllers;

use Poll\Db;
use Poll\Filters\HasVotedFilter;
use Poll\Filters\LoggedInFilter;
use Poll\Models\Poll;
use Poll\Models\User;
use Poll\Paginator;

class PollController
{

    public function index($paginationData)
    {
        $paginator = new Paginator("SELECT * FROM POLLS WHERE public=1");


        //setting a default limit (10) and page (1)
        $paginationData['limit'] = (! isset($paginationData['limit'])) ? 10 : $paginationData['limit'];
        $paginationData['position'] = (! isset($paginationData['position'])) ? 1 : $paginationData['position'];

        $results = $paginator->getData($paginationData['limit'], $paginationData['position']);

        $paginationLinks = $paginator->createLinks(5, 'pagination pagination-sm');

        require templatePath() . "/home.php";
    }

    public function searchApi($query)
    {
        $db = new Db;

        $searchResults = $db->query(
            "SELECT title FROM polls WHERE title LIKE :query",
            array('query' => '%' . $query . '%')
        );

        $normalizedResults = [];

        foreach($searchResults as $result)
        {
            $normalizedResults[] = array(
                'value' => $result['title']
            );
        }

        echo json_encode($normalizedResults);
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
        $hasVoted->filter($_GET['id'], true);

        $poll = new Poll;
        if (!$poll->load($_GET['id'])) {
            pageNotFound();
        }
        require templatePath() . "/polls/show.php";
    }

    public function showResult()
    {
        $db = new \Poll\Db;

        $answers = $db->query(
            "SELECT COUNT(*) as answersCount,answers.option_id,options.value from answers
                INNER JOIN options on options.option_id = answers.option_id
                AND options.poll_id = ? group by answers.option_id;",
            array($_GET['id'])
        );

        $answers = array_column($answers, "answersCount", "option_id");

        $allPollOptions = $db->query(
            "SELECT * FROM options WHERE poll_id = :poll_id",
            array($_GET['id'])
        );

        $jsonArray = array();

        $jsonArray[] = array("Answers", "Answers count");

        foreach($allPollOptions as &$option)
        {
            if(array_key_exists($option['option_id'], $answers))
            {
                $option['count'] = (int) $answers[$option['option_id']];
            } else {
                $option['count'] = 0;
            }

            $jsonArray[] = array($option['value'], $option['count']);
        }

        $jsonArray = json_encode($jsonArray);

        foreach($allPollOptions as $option)

        $poll = new Poll;
        $poll->load($_GET['id']);

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
        $result = $hasVoted->filter($id, false);

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
        $isLoggedIn->filterLoggedUser();

        $db = new Db;

        //results being used in modifyPolls.php
        $results = $db->query(
            "Select * from Polls  where user_id = ?",
            array($id)
        );
        require templatePath() . "/polls/modifyPolls.php";
    }

    public function deletePoll($id)
    {
        //TODO add filters
        $user = new User;
        $userId = $user->getIdByUsername($_SESSION['username']);

        $db = new Db;

        $db->query(
            "delete from polls where poll_id=?;",
            array($id)
        );

        $db->query(
        "delete from answers where option_id IN (SELECT option_id from options where poll_id=?);",
        array($id)
        );

        $db->query(
            "delete from options where poll_id =?;",
            array($id)
        );

        header("Location: index.php?page=modifyUser&id=" . $userId);
        $_SESSION['success'] = array(
            'The chosen poll has been deleted.'
        );
    }

    public function editPollById($id)
    {
        $belongsToUserFilter = new \Poll\Filters\BelongsToUserFilter;
        $belongsToUserFilter->filter($id);

        $poll = new Poll;
        $poll->load($id);

        require templatePath() . "/polls/editPoll.php";
    }

    public function overWritePoll($id,$postData)
    {
        $db = new Db;
        //Muda o titulo na tabela polls

        if($postData['public'] == "on")
        {
            $postData['public'] = 1;
        } else {
            $postData['public'] = 0;
        }

        if($postData['multiple'] == "on")
        {
            $postData['multiple'] = 1;
        } else {
            $postData['multiple'] = 0;
        }

        $db->query(
            "update Polls set title=?, public=?, multiple=? WHERE poll_id=?",
          array(
              $postData['title'],
              $postData['public'],
              $postData['multiple'],
              $id
          )
        );
        //apaga as respostas para as opções antigas
         $db->query(
             "delete from answers where option_id IN (select option_id from options where poll_id=?);",
             array($id)
         );

        // Apaga opções antigas
        $db->query(
            "DELETE from options where poll_id= ?",
            array($id)
        );
        // Insere as novas
        foreach($postData['option'] as $option)
        {
            if($option!=="")
            {
                $db->query(
                    "Insert INTO options(poll_id,value) VALUES(?,?)",
                    array(
                        $id,
                        $option
                    )
                );
            }
        }

        $user = new User;
        $userId = $user->getIdByUsername($_SESSION['username']);

        header("Location: index.php?page=modifyUser&id=" . $userId);
        $_SESSION['success'] = array(
            'The poll has been edited.'
        );


    }
}
