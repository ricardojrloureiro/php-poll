<?php namespace Poll;

class Db {

    protected $db;

    function __construct()
    {
        $this->db = new \PDO('sqlite:proj.db');
    }

    public function query($query, $parameters)
	{

		$stmt = $this->db->prepare($query);
		$stmt->execute($parameters);
		$result = $stmt->fetchAll();

		return $result;
	}

	public function save($query, $parameters)
	{

		$stmt = $this->db->prepare($query);
		$stmt->execute($parameters);
	}

    public function getLastId()
    {
        return $this->db->lastInsertId();
    }

}