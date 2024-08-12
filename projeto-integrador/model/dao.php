<?php
include_once 'conexao.php';

class DAO extends Conexao
{
	public function __construct()
	{
		parent::__construct();
	}

	public function escape_string($value)
	{
		return $this->conn->real_escape_string($value);
	}

	public function execute($query)
	{
		$result = $this->conn->query($query);

		if ($result === false) {
			throw new Exception('Error: ' . $this->conn->error);
		}

		return true;
	}

	public function getData($query)
	{
		$result = $this->conn->query($query);

		if ($result === false) {
			throw new Exception('Error: ' . $this->conn->error);
		}

		$rows = array();

		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}

		return $rows;
	}

	public function delete($query)
	{
		$result = $this->conn->query($query);

		if ($result === false) {
			throw new Exception('Error: ' . $this->conn->error);
		}
		return true;
	}

	public function close()
	{
		$this->conn->close();
	}
}
