<?php
/* 
*  _ in notation of private property and method
*/
class DB{
	private static $_instance = null;
	private $_pdo, 
			$_query,
			$_error = false,
			$_results,
			$_count = 0;

	private function __construct()
	{
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	public function query($sql, $param = array())
	{
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if (count($param)) {
					foreach ($param as $bit) {
						$this->_query->bindValue($x, $bit);
						$x++;
					}
			}
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount(); 
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}
	public function action($action, $table, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=', 'LIKE');
			$field 		= $where[0];
			$operator   = $where[1];
			$value 		= $where[2];
			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}
	/* 
	Get Query to the DB
	@var:
		$where = ["table", "operator", "value"]
		$table = "tablename"
	*/
	public function get($table, $where)
	{
		return $this->action('SELECT *', $table, $where);
	}
	public function delete($table, $where)
	{
		return $this->action('DELETE', $table, $where);	
	}

	public function insert($table, $fields = array())
	{
		//field will be inform of 'table_name' => 'data to insert'
		//check if filed has elements
		if (count($fields)) {
			//grab array keys => keys will be an array of column names
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			foreach ($fields as $field) {
				$values .= '?';
				if ($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}
			$sql = "INSERT INTO $table (`". implode('`, `', $keys) ."`) VALUES($values)";
			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}
	public function update($table, $id ,$fields)
	{
		$set = '';
		$x = 1;
		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .= " , ";
			}
			$x++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}
	public function error()
	{
		return $this->_error;
	}
	public function count()
	{
		return $this->_count;
	}
	public function results()
	{
		return $this->_results;
	}
	public function first()
	{
		return $this->_results[0];
	}

}