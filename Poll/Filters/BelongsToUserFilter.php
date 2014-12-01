<?php namespace Poll\Filters;

use Poll\Db;
use Poll\Models\User;

class BelongsToUserFilter {

    public function filter($poll_id)
    {
        $user_id = User::getIdByUsername($_SESSION['username']);

        $db = new Db;

        $pollUser = $db->query(
            "SELECT user_id FROM polls WHERE poll_id = :poll_id;",
            array(
                'poll_id' => $poll_id
            )
        );

        if($pollUser[0]['user_id'] != $user_id)
        {
            $_SESSION['errors'] = array(
                "Please edit a valid poll."
            );
            header("Location: index.php");
            exit();
        }

        return true;

    }


} 