<?php namespace Poll\Filters;


use Poll\Db;
use Poll\Models\User;

class HasVotedFilter {

    public function filter($poll_id, $redirect)
    {
        if( ! isset($_SESSION['username']))
        {
            $_SESSION['errors'] = array(
                "You must login first."
            );
            header("Location: index.php");
            exit();
        }

        $user_id = User::getIdByUsername($_SESSION['username']);

        $db = new Db;

        $hasAnswered = $db->query(
            "SELECT COUNT(*) FROM answers INNER JOIN options ON options.poll_id = :poll_id AND options.option_id = answers.option_id AND answers.user_id = :user_id;",
            array(
                'user_id' => $user_id,
                'poll_id' => $poll_id
            )
        );

        if($hasAnswered[0][0] > 0)
        {
            if($redirect)
            {
                $_SESSION['success'] = array(
                    "Since you've already voted you've been redirected to the results."
                );
                header("Location: index.php?page=showResult&id=" . $_GET['id']);
                exit();
            } else {
                $_SESSION['errors'] = array(
                    "You've already voted."
                );
                header("Location: index.php");
                exit();
            }

        }

        return false;
    }
} 