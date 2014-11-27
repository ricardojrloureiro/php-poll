<?php namespace Poll\Models;

use Poll\Db;

class Poll {

    public $id;
    public $title; // poll title
    public $user_id; // username of the user that created the poll
    public $options; // list of options
    public $public; // private or public
    public $multiple;
    public $image;

    public function load($id)
    {
        $db = new Db;

        $pollData = $db->query(
            "SELECT * FROM polls WHERE poll_id=:id",
            array('id' => $id)
        );

        if(count($pollData) <= 0)
        {
            return false;
        } else {
            $this->id = $pollData[0]['poll_id'];
            $this->title = $pollData[0]['title'];
            $this->user_id = $pollData[0]['user_id'];
            $this->public = $pollData[0]['public'];
            $this->multiple = $pollData[0]['multiple'];
            $this->image = $pollData[0]['image'];
        }

        $optionsData = $db->query(
            "SELECT * FROM options WHERE poll_id=:id",
            array('id' => $id)
        );

        if(count($optionsData) <= 0)
        {
            return false;
        } else {
            $this->options = $optionsData;
        }

        return true;

    }

    public function save($pollData)
    {
        $db = new Db;

        $errors = [];

        if(strlen($pollData['title']) <= 0)
        {
            $errors[] = "Please insert a poll title";
        }

        $this->user_id = $db->query(
            "SELECT user_id from users where username = ?",
            array($_SESSION['username'])
         )[0][0];

        $this->title = $pollData['title'];
        $this->options = $pollData['option'];

        $optionsCounter = 0;
        foreach($this->options as $option)
        {
            if($option !== "")
            {
                $optionsCounter++;
            }
        }

        if($optionsCounter < 2)
        {
            $errors[] = "Please insert at least two options.";
        }

        $image = new Image($pollData['image']);

        if(! $image->validate())
        {
            $errors[] = "Please upload a valid image.";
        }

        if($pollData['public'] == "on")
        {
            $pollData['public'] = 1;
        } else {
            $pollData['public'] = 0;
        }

        if($pollData['multiple'] == "on")
        {
            $pollData['multiple'] = 1;
        } else {
            $pollData['multiple'] = 0;
        }

        if(empty($errors))
        {
            $imagePath = $image->save();

            $db->save(
                "INSERT INTO polls (user_id, title, image, public, multiple) VALUES (:user_id, :title, :image, :public, :multiple)",
                array(
                    'user_id' => $this->user_id,
                    'title' => $this->title,
                    'image' => $imagePath,
                    'public' => $pollData['public'],
                    'multiple' => $pollData['multiple']
                )
            );

            $poll_id = $db->getLastId();

            foreach($this->options as $option)
            {
                if($option !== "")
                {
                    $db->save(
                        "INSERT INTO options(poll_id,value) VALUES(:poll_id,:value)",
                        array(
                            $poll_id,
                            $option
                        )
                    );
                }
            }

            return true;

        } else {
            return $errors;
        }
    }

}