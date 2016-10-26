<?php


/**
* Manage Route
*/
class Route
{
	private $_db, $_data;
	function __construct($r_id=null)
	{
		$this->_db = DB::getInstance();
		if ($r_id) {
			$this->getRouteByID($r_id);
		}
	}
	/*Setter*/
	public function updateRoute($id, $fields)
	{
		return $this->_db->update("routes", $id, $fields);
	}
	public function addRoute($fields)
	{
		$r = $fields['route_name'];
		$routeExist = $this->_db->get("routes", ["route_name", "LIKE", "%$r%"]);
		if (!$routeExist->count() && $fields) {
			return $this->_db->insert("routes", $fields);
		}

		return false;
	}
	public function data()
	{
		return $this->_data;
	}
	/*Getters */
	public function getRouteByID($r_id)
	{
		if ($r_id) {
			$result = $this->_db->get("routes", ["id", "=", $r_id])->first();
			$this->_data = $result;
			return $result;
		}
		return false;
	}
	public function getAll()
	{
		return $this->_db->get("routes", [1,"=",1])->results();
	}

	public function delete($value='')
	{
		if (!$value) {
			$id = $this->data()->id;
		}
		return $this->_db->delete("routes", ["id", "=", $id]);
	}
}