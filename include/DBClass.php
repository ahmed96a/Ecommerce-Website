<?php

	class database
	{

		private $pdo;

		public function __construct($dbName) // Connect to the mysql database
		{
			try{ // or we should use  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
				$this->pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8", 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch(PDOException $e){
				echo "Connection Error: " . $e->getMessage();
			}
		}

		public function getRow($query,$params=array())
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->fetch();
		}

		public function getRows($query,$params=array())
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->fetchAll();
		}

		public function getRowsNum($query,$params=array())
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->fetchAll(PDO::FETCH_NUM);
		}

		public function getObjs($query,$params=array())
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}

		public function getCount($query,$params=array())
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->rowCount(); // return 0 if no rows are returned
		}

		public function insertRow($query,$params)
		{
			$stm = $this->pdo->prepare($query);
			$stm->execute($params);
			return $stm->rowCount();
		}

		public function lastInsertedId() // Note :- to get that last id the id column should be auto_increment and there is must be an insrted query performed before it
		{
			return $this->pdo->lastInsertId();
		}

		public function updateRow($query,$params)
		{
			return $this->insertRow($query,$params);
		}

		public function deleteRow($query,$params)
		{
			return $this->insertRow($query,$params);
		}

		public function myExec($query)
		{
			return $this->pdo->exec($query);
		}

	}

	$db = new database('shop');
?>