<?php

class Db {

	public function query($query, $parameters)
	{
		$db = new PDO('sqlite:proj.db');

		$stmt = $db->prepare($query);
		$stmt->execute($parameters);
		$result = $stmt->fetchAll();

		return $result;
	}

	public function save($query, $parameters)
	{
		$db = new PDO('sqlite:proj.db');

		$stmt = $db->prepare($query);
		$stmt->execute($parameters);
	}

}