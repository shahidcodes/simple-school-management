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
			echo "Done";
			Session::flash("msg", "Student Added Succefully");
		}
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
	/**
	 * @var $studentList { type: Array of student Object}
	 */
	public function showList($studentsList)
	{
		foreach ($studentsList as $student) {
			echo "<a href=\"Student.php?sid=$student->id\">$student->name</a><br>";
		}
	}

	public function getStudentByID($id=null)
	{
		if ($id) {
			$student = $this->db->get("students", ["id", "=", $id])->first();
			$this->_data = $student;
			return $student;
		}
	}
	public function payFee($month)
	{
		if ($month) {
			$sid = $this->data()->id;
			$month = $month . substr(date('Y'), 2);
			if( $this->db->insert("fee", ["student_id"=>$sid, "status"=>"Paid","month"=>$month]) ){
				Session::flash("msg", "Paid Succefully");
				Redirect::to("Student.php?sid=$sid");
			}

			Redirect::to("Student.php?sid=$sid");
		}
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