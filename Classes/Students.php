<?php

/**
* Students Class
*/
class Students
{
	private $db, $_data;
	public function __construct($sid=null)
	{
		$this->db = DB::getInstance();
		if($sid && is_numeric($sid)){
			$this->getStudentByID($sid);
		}
	}
	public function getStudentList(){

		$students = $this->db->get("students", [1, "=", 1])->results();
		return $students;
	}	
	public function addStudent($data)
	{	
		$q = $this->db->insert("students", $data);
		if($q){
			// echo "Done";
			Session::flash("msg", "Student Added Succefully");
		}
	}
	public function update($id, $data)
	{
		if ( $this->db->update("students", $id, $data) ) {
			Session::flash("msg", "Student Profile Updated!");
		}
		return;
	}

	public function delete($id=null)
	{
		if (!$id)
			$id = $this->data()->id;
		if ($this->db->delete("students", ["id", "=", $id])) {
			return true;
		}

		return false;
	}
	public function search($value='')
	{
		$pivot = "%$value%";
		$dbq = $this->db->get("students", ["name", "LIKE", $pivot]);
		if ($dbq->count()) {
			return $dbq->results();
		}

		return false;
	}
	// /**
	//  * @var $studentList { type: Array of student Object}
	//  */
	// public function showList($studentsList)
	// {
	// 	foreach ($studentsList as $student) {
	// 		echo "<a href=\"Student.php?sid=$student->id\">$student->name</a><br>";
	// 	}
	// }

	public function getStudentByID($id=null)
	{
		if ($id) {
			$student = $this->db->get("students", ["id", "=", $id])->first();
			$this->_data = $student;
			return $student;
		}
	}
	public function getRouteByStudentID()
	{
		$id = $this->data()->route_id;
		if ($id) {
			return $this->db->get("routes", ["id", "=", $id])->first();
		}
	}
	public function getStudentByClassID($classid='', $lim)
	{
		if ($classid) {
			$student = $this->db->get("students", ["class_id", "=", $classid])->results();
			$this->_data = $student;
			return count($student) ? $student : false;
		}
	}
	public function getClassNameByID($classID)
	{
		return $this->db->get("class", ["id", "=", $classID])->first()->class_name;
	}
	public function getClass()
	{
		return $this->db->get("class", [1,"=", 1])->results();
	}
	public function payFee($month, $transport=False)
	{
		$sid = $this->data()->id;
		$cfee = $tfee = false;
		$session = "Something Went Wrong";
		$classid = $this->getStudentByID($sid)->class_id;
		if ($month) {
			$q = "SELECT * FROM fee WHERE student_id = ? AND month = ?";
			$dbq = $this->db->query($q, [$sid, $month]);
			if ( !$dbq->count() ){
				$month = $month . date("y");
				if( $this->db->insert("fee", ["student_id"=>$sid, "status"=>"Paid","month"=>$month]) ){
					$cfee = true;
					// echo "Paid";
				}
				var_dump($this->db);
			}else $session = "Already Paid!";
		}
		if ($transport) {
			$month = $transport . date("y");
			echo $month;
			$q = "SELECT * FROM transport WHERE student_id = ? AND month = ?";
			if ( !$this->db->query($q, [$sid, $month])->count() ){
				if ($this->db->insert("transport", [
													"student_id"	=>$sid, 
													"class_id"		=>$classid, 
													"month"			=>$month]
				)) {
					$tfee = true;

				}
			}else $session = "Already Paid!";
		}
		// check for both to be paid
		if ($cfee || $tfee) {
			$session = "Paid Succefully";
		}
		Session::flash("msg", $session);
		Redirect::to("Student.php?sid=$sid");
	}
	public function currentMonthFeePaid($id=null)
	{
		if ($id) {
			$fee = $this->db->get("fee", ["student_id", "=", $id]);
			// check if student is new and has no fee details...
			if (!$fee->count()) {
				return false;
			}
			$identifier = date("F Y");
			$nowArray = split(" ", $identifier);
			$identifier = substr($nowArray[0], 0, 3) . substr($nowArray[1], 2);
			$feeDetails = $fee->results();
			foreach ($feeDetails as $f) {
				// var_dump($f);
				if( $identifier === $f->month){
					return true;
					break;
				} 
			}

			return false;
		}

	}
	public function getTransportCurrentMonth($sid)
	{
		$pivot = split(" " , date("F Y") );
		$month = substr( $pivot[0], 0, 3 );
		$year  = substr( $pivot[1], -2);
		$identifier = $month.$year;
		$q = $this->db->get("transport", ["student_id", "=", $sid]);
		if ($q->count()) {
			foreach ($q->results() as $f) {
				if ($f->month == $identifier) {
					return true;
				}
			}
		}
	}
	public function getTransport($sid)
	{
		$t = $this->getStudentByID($sid);
		$t = (bool)$t->transport;
		if ($t) {
			// chosen for tranport then lookup for fee payment
			$transportFee = $this->db->get("transport", ["student_id" , "=", $sid]);
			if ( $transportFee->count() ) {
				// there is some fees entry fetch them
				$tfee = $transportFee->results();
				$months = [];
				foreach ($tfee as $fee) {
					$months[] = substr($fee->month, 0, 3);
				}
				$dueMonths = $this->filterMonths($months);
				return $dueMonths;
			}else{
				return ["err" => "No Fee Paid Yet"];
			}

			// render form here if paid or not

		}else{
			return ["err" => "Not Chosen For Transport"];
		}
	}
	public function totalDue($id=null)
	{
		if ($id) {
			$fee = $this->db->get("fee", ["student_id", "=", $id]);
			// check if student is new and has no fee details...
			if (!$fee->count()) {
				return false;
			}
			$fee = $fee->results();
			foreach ($fee as $f) {
				$months[] =  substr($f->month, 0, 3);
			}
			// filter values based on 12 months
			$abbrMonths = [
	            'Apr',
	            'May',
	            'Jun',
	            'Jul',
	            'Aug',
	            'Sep',
	            'Oct',
	            'Nov',
	            'Dec',
	            'Jan',
	            'Feb',
	            'Mar'
				];
			$currentMonth = substr( date("F"), 0, 3 ); // get current month 

			$currentMonthKey = array_search($currentMonth , $abbrMonths ); //search currentmonth key in total monts
			
			$abbrMonths = array_slice($abbrMonths, $currentMonthKey); // slice the array from that month because we dont need any previous monts
			$unpaid = array_diff($abbrMonths, $months); // not take a differentiaion between paid and total monts
			return $unpaid; //return array of all unpaid months
		}
	}
	public function data()
	{
		return $this->_data;
	}

	public function filterMonths($monthsArray)
	{
		// filter values based on 12 months
			$abbrMonths = [
	            'Apr',
	            'May',
	            'Jun',
	            'Jul',
	            'Aug',
	            'Sep',
	            'Oct',
	            'Nov',
	            'Dec',
	            'Jan',
	            'Feb',
	            'Mar'
				];
			$currentMonth = substr( date("F"), 0, 3 ); // get current month 

			$currentMonthKey = array_search($currentMonth , $abbrMonths ); //search currentmonth key in total monts
			
			$abbrMonths = array_slice($abbrMonths, $currentMonthKey); // slice the array from that month because we dont need any previous monts
			$unpaid = array_diff($abbrMonths, $monthsArray); // not take a differentiaion between paid and total monts
			return $unpaid; //return array of all unpaid months
	}
/**
 * Static Methods Declarations!!
 */
	public static function getClassLists()
	{
		$list = DB::getInstance()->get("class", [1,"=",1])->results();
		foreach ($list as $l) {
			$classes[$l->id] = $l->class_name;
		}
		return $classes;
	}
	public static function getRoutes()
	{
		$list = DB::getInstance()->get("routes", [1,"=",1])->results();
		foreach ($list as $l) {
			$routes[$l->id] = $l->route_name;
		}
		return $routes;
	}
	public static function uploadAvator()
	{
		if(isset($_FILES['avator'])){
			$name = $_FILES['avator']['name'];
			$size = $_FILES['avator']['size'];
			$type = $_FILES['avator']['type'];
			$extension = strtolower(substr($name, strripos($name, '.')+1));
			$tmp_name = $_FILES['avator']['tmp_name'];
			$location = 'avators/';
			$filename = md5($name.$size).".".$extension;
			if (!empty($name)) {
				if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
					if (move_uploaded_file($tmp_name, $location.$filename)) {
						return $location.$filename;
					}
				}
			}
		}

		return false;
	}
}