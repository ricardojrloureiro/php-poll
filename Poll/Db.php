<?php namespace Poll;

class Db {

    protected $db;
    protected $lastResult = null;

    function __construct()
    {
        $this->db = new \PDO('sqlite:proj.db');
    }

    public function query($query, $parameters)
	{

		$stmt = $this->db->prepare($query);
		$stmt->execute($parameters);
		$result = $stmt->fetchAll();

        $this->lastResult = $result;

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

    public function getNumRows()
    {
        if(! is_null($this->lastResult)) {
            return count($this->lastResult);
        }

        throw new \Exception("No query was called before the getNumRows function call.");

    }

}