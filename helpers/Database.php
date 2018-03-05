<?php
class Database
{
	private $pdo;
	private $dbname;
	private $uname;
	private $password;
	private $host;
	public function __construct($dbn, $un, $paswrd, $hst) {
		$this->dbname = $dbn;
		$this->uname = $un;
		$this->password = $paswrd;
		$this->host = $hst;

		try	{
			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->uname, $this->password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec('SET NAMES "utf8"');
		}
		catch (Exception $e) {
			echo 'Unable to connect to the database server.';
			exit;
		}
	}
	public function pdoSelectQuery($fetch_query, $plcholder) {
		var_dump($fetch_query);
		var_dump($plcholder);
		exit;
		try	{
			$result = $this->pdo->prepare($fetch_query);
			$result->execute($plcholder);
			$query_result = $result->fetchAll(PDO::FETCH_ASSOC);
			return $query_result;
		}
		catch (PDOException $e)	{
			return array(false,$e->getMessage());
			#echo "There's an error within your query: " . $e->getMessage();
			#exit;
		}
	}

	public function pdoInsUpdDelQuery($query, $plcholder) {
		try	{
			$result = $this->pdo->prepare($query);
			$result->execute($plcholder);
			return array(true, $result->rowCount());
		}
		catch (PDOException $e)	{
			return array(false,$e->getMessage());
		}
	}
}

?>