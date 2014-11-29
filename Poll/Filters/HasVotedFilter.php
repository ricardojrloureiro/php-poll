<?php namespace Poll\Filters;


use Poll\Db;
use Poll\Models\User;

class HasVotedFilter {

    public function filter($poll_id)
    {
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
           return true;
        }
        return false;
    }
} 