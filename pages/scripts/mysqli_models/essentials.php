<?php
class Students extends DB_con {
	# sanitize the num value that gets passed in
	public function sanitizeNum($input){
		if(spaceCheck($input)!=""){
			$input = (int)stripChars(addslashes($input));
			return $input;
		}
	}
	
	public function slim_fetch_sql($column, $table, $condition=NULL, $condVal=NULL, $condition2=NULL, $condVal2=NULL, $condition3=NULL, $condVal3=NULL, $condition4=NULL, $condVal4=NULL){
		if(!empty($condition4)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3 AND $condition4 = $condVal4";
		} elseif(!empty($condition3)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3";
		} elseif(!empty($condition2)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2";
		} elseif(!empty($condition)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal";
		} else {
			$Sql = "SELECT ".$column." FROM ".$table;
		}
		$Query = mysqli_query($this->dbconnect(), $Sql);
		if($Query){
			return mysqli_fetch_object($Query);
		} else {
			return NULL;
		}
	}
	

	public function getCount($column, $table, $condition=NULL, $condVal=NULL, $condition2=NULL, $condVal2=NULL, $condition3=NULL, $condVal3=NULL, $condition4=NULL, $condVal4=NULL){
		if(!empty($condition4)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3 AND $condition4 = $condVal4";
		} elseif(!empty($condition3)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3";
		} elseif(!empty($condition2)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2";
		} elseif(!empty($condition)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal";
		} else {
			$Sql = "SELECT ".$column." FROM ".$table;
		}
		$Query = mysqli_query($this->dbconnect(), $Sql);
		if($Query){
			return mysqli_num_rows($Query);
		} else {
			return NULL;
		}
	}
	
	#---------------------===== STUDENT SECTION OF GET.CHECK =====---------------------#
	
	# checks if a particular userId exists in the databases
	public function checkStudent($userId){
		$userId = $this->sanitizeNum($userId);
		$checkSql = "SELECT uId FROM user WHERE uId=".$userId;
		$checkQuery = mysqli_query($this->dbconnect(), $checkSql);
		if($checkQuery){
			// the students exists
			if(mysqli_num_rows($checkQuery)==1){
				return true;
			}
		} else {
			return NULL;
		}
		
	}
	# fetch complete details belonging to this user
	public function getStudent($userId){
		$userId = $this->sanitizeNum($userId);
		$record = $this->slim_fetch_sql('*', 'user', 'uId', "$userId");
		return $record;
	}
	# fetch requisite details belonging to this user
	public function getStudentRequisite($userId){
		$userId = $this->sanitizeNum($userId);
		$record = $this->slim_fetch_sql('nickname, name, thumb, regNumber, department, level', 'user', 'uId', "$userId");
		return $record;
	}
	# fetch id from regnumber
	public function getIdFromReg($userReg){
		$data = $this->slim_fetch_sql('uId', 'user', 'regNumber', "'$userReg'");
		return $data;
	}
	
	
	# get the information required in most pages belonging to each student
	public function getCredentials($regNum){
		# initiate these important variables
		$credentials = new stdClass();
		$credentials -> studentId = NULL;
		$credentials -> profileImg = NULL;
		$credentials -> name = NULL;
		$credentials -> nickname = NULL;
		$credentials -> email = NULL;
		$credentials -> phone_1 = NULL;
		$credentials -> phone_2 = NULL;
		$credentials -> pass = NULL;
		$credentials -> gender = NULL;
		$credentials -> regNum = NULL;
		$credentials -> faculty = NULL;
		$credentials -> facultyId = NULL;
		$credentials -> department = NULL;
		$credentials -> departmentId = NULL;
		$credentials -> level = NULL;
		$credentials -> repAuth = NULL;
		# fetch the user id
		$data = $this->getIdFromReg($regNum);
		$userId = $data->uId;
		# determine the loged-in user
		if($this->checkStudent($userId)==true){
			$studentRs = $this->getStudent($userId);
		
			$credentials->studentId = $userId;
			if(isset($studentRs->thumb)){ $credentials->profileImg = $studentRs->thumb; }
			$credentials->name = $studentRs->name;
			if(isset($studentRs->nickname)){ $credentials->nickname = $studentRs->nickname; }
			$credentials->email = $studentRs->mail;
			if(!empty($studentRs->contact1)){ $credentials->phone_1 = $studentRs->contact1; }
			if(!empty($studentRs->contact2)){ $credentials->phone_2 = $studentRs->contact2; }
			$credentials->pass = $studentRs->uPass;
			$credentials->gender = $studentRs->gender;
			$credentials->regNum = $studentRs->regNumber;
			$credentials->faculty = $studentRs->faculty;
			$credentials->department = $studentRs->department;
			$credentials->level = $studentRs->level;
			# getting the faculty ID
			$facultyRs = $this->slim_fetch_sql("facultyId", "faculty", "name", "'$credentials->faculty'");
			if($facultyRs){
				$credentials->facultyId = $facultyRs->facultyId;
			}
			
			# getting the departments ID
			$departmentRs = $this->slim_fetch_sql("departmentId", "department", "name", "'$credentials->department'");			
			if($departmentRs){
				$credentials->departmentId = $departmentRs->departmentId;
			}

			# check if this user is actually a course rep
			$repAuth = $this->getCount("studentId", "course_rep", "studentId", $credentials->studentId, "approval", 1);
			if($repAuth>0){ $credentials->repAuth = true; }
		}
		return $credentials;
	}
	
	# function that returns a user name basically from its id
	public function getShortName($id){
		if($this->checkStudent($id)==true){
			$student = $this->getStudentRequisite($id);
			if(isset($student->nickname) && $student->nickname!=""){
				$name = ucfirst($student->nickname);
			} else {
				$exploded = explode(" ", $student->name);
				$name = ucfirst($exploded[0]);
			}
		} else { return NULL; }
		return $name;
	}



	# this shows the entire student on the platform
	public function totalStudentCount(){
		
	}
	# this shows the entire student in a particular faculty
	public function facStageCount(){
		
	}
	# this shows the entire student in a particular department
	public function deptCount(){
		
	}
	# this shows the student from a particular departmental level
	public function deptFocusCount(){
		
	}

}