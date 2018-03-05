<?php
class Model extends Database {
	protected $table;
	public function __construct() {
		foreach ($GLOBALS['config'] as $key => $value) {
			$this->$key = $value;
		}

		parent::__construct($this->db_name, $this->db_uname, $this->db_pass, $this->host);
		
		include_once 'system/Sessions.php';
		include_once 'system/Help.php';

		$this->session = new Sessions();
		$this->help = new Help();
	}

	public function model($model, $var_name="") {
		include_once 'models/'.$model.'.php';

		if (empty($var_name)) {
			$model=strtolower($model);
			$this->$model = new $model();
		}
		else {
			$this->$var_name = new $model();
		}
		#return new $model($arg);
	}


	public function fetchById ($id) {
		$ret = $this->pdoSelectQuery("SELECT * FROM ".$this->table." WHERE id=:id", array(':id'=>$id));
		return $ret[0];
	}
	public function query ($query, $plcholder=array()) {
		$ret = $this->pdoSelectQuery($query, $plcholder);
		return $ret;
	}


	public function insUpdDelQuery ($query, $plcholder=array()) {
		$resp = $this->pdoInsUpdDelQuery($query, $plcholder);
		if ($resp[0]) {
			if ($return == 'row') {
				$id = $this->getLastInsertId();
				$insert_row = $this->pdoSelectQuery("SELECT * FROM ".$this->table." WHERE id=:id", array(':id'=>$id));
				$insert_row = $insert_row[0];
				#if ($return == 'row') $resp[1] = $insert_row;
				$resp[1] = $insert_row;
			}
		}
		return $resp;
	}



	public function fetchBy ($needle, $clause="", $where_separator="AND") {
		#expects something like array('column_name'=>'column_value'), if elements are more than 1, they are jointed by $where_separator
		if (!is_array($needle)) return false;
		$where = ""; $k=0; $plcholder=array();
		foreach ($needle as $key => $value) {
			if (++$k > 1) $where .= " $where_separator ";
			$where .= $key." LIKE :".$key;
			$plcholder[':'.$key] = '%'.$value.'%';
		}
		if (empty($needle)) $where = "1";
		return $this->pdoSelectQuery("SELECT * FROM ".$this->table." WHERE $where $clause", $plcholder);
	}

	public function fetchAll () {
		return $this->pdoSelectQuery("SELECT * FROM $table", array());
	}
	public function insert ($insert, $return='row') {#optional $return could be 'row' or 'rowcount'
		#expects something like array('column_name'=>'column_value')
		if (!is_array($insert) || empty($insert)) return false;
		$ins = ""; $k=0; $plcholder=array();
		foreach ($insert as $key => $value) {
			if (++$k > 1) $ins .= ", ";
			if (strstr($value, '()')) {
				$ins .= "`".$key."` = ".$value;
			}
			else {
				$ins .= "`".$key."` = :".$key;
				$plcholder[':'.$key] = $value;
			}
		}
		$query = "INSERT INTO ".$this->table." SET $ins";

		$resp = $this->pdoInsUpdDelQuery($query, $plcholder);
		if ($resp[0]) {
			if ($return == 'row') {
				$id = $this->getLastInsertId();
				$insert_row = $this->pdoSelectQuery("SELECT * FROM ".$this->table." WHERE id=:id", array(':id'=>$id));
				$insert_row = $insert_row[0];
				#if ($return == 'row') $resp[1] = $insert_row;
				$resp[1] = $insert_row;
			}
		}
		return $resp;
	}

	public function update ($update, $upd_key, $return='row') {#optional $return could be 'row' or 'rowcount', in the case of batch update
		#expects something like array('column_name'=>'column_value')
		if (!is_array($update) || empty($update)) return false;
		$upd = ""; $k=0; $plcholder=array();
		foreach ($update as $key => $value) {
			if ($key != $upd_key) {
				if (++$k > 1) $upd .= ", ";

				if (strstr($value, '()')) {
					$upd .= "`".$key."` = ".$value;
				}
				else {
					$upd .= "`".$key."` = :".$key;
					$plcholder[':'.$key] = $value;
				}
				#$upd .= "`".$key."` = :".$key;
				#$plcholder[':'.$key] = $value;
			}
		}
		$query = "UPDATE ".$this->table." SET $upd WHERE $upd_key LIKE :updk";
		$plcholder[':updk'] = $update[$upd_key];

		$resp = $this->pdoInsUpdDelQuery($query, $plcholder);
		if ($resp[0]) {
			if ($return == 'row') {
				$update_row = $this->pdoSelectQuery("SELECT * FROM ".$this->table." WHERE $upd_key LIKE :k", array(':k'=>$update[$upd_key]));
				$update_row = $update_row[0];
				#if ($return == 'row') $resp[1] = $update_row;
				$resp[1] = $update_row;
			}
		}
		return $resp;
	}
}
?>