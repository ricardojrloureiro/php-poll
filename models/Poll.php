<?php namespace Models;
session_start(); // allows to reach the query results below

class Poll {

    public $title; // poll title
    public $user_id; // username of the user that created the poll
    public $options; // list of options
    public $mode; // private or public

    public function save($pollData)
    {
        $db = new \Db;

        $errors = [];

        /**
         * Acrescentar condições de erro na criação de uma poll
         */


        /**
         * acrescentar associações boyz
         */

        $this->user_id = $db->query(
            "SELECT user_id from Users where username = ?",
            array($_SESSION['username'])
         )[0][0];

        $this->title = $pollData['title'];

        if(empty($errors))
        {
            $db->save(
                "INSERT INTO poll (user_id, title, image, public) VALUES (:user_id, :title, :image, :public)",
                array(
                    'user_id' => $this->user_id,
                    'title' => $this->title,
                    'image' => '',
                    'public' => ''
                )
            );
            return true;
        }else{
            return $errors;
        }
    }


}