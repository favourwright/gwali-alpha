<?php
class Student extends Records{
	# database connection string
	protected $dbcon = NULL;
	public function __construct(){
		# pull this database connection variable into this method
		# to it'll be vailable for the entire class
		global $dbconnect;
		$this->dbcon = $dbconnect;
		# initiate default timezone here too
		date_default_timezone_set("Africa/Lagos");
	}
	
	public function studentIdentifier($parsedUid=NULL){
		# get the current user and store for use in entire site
		$userIdentity = new stdClass();
		$userIdentity->uLoggedInId = NULL;
		$userIdentity->uCookieId = NULL;
		$userIdentity->uId = NULL;
		$userIdentity->g_admin = NULL;
		$userIdentity->s_admin = NULL;
		
		# check if the script is called with args or not
		$userIdentity->userDetails = new stdClass();
		if(!empty($parsedUid)){ $userIdentity->uId = (int)$parsedUid; }
		elseif(!empty($_SESSION['gwalian_login_session'])){
			$userIdentity->loggedInId = $_SESSION['gwalian_login_session'];
			$userIdentity->uId = (int)$userIdentity->loggedInId;
		} elseif(!empty($_COOKIE['gwalian_persist'])){
			$userIdentity->uPersistId = base64_decode($_COOKIE['gwalian_persist']);
			$userIdentity->uId = (int)$userIdentity->uPersistId;
		} elseif(!empty($_COOKIE['gwali_identity_cookie'])){
			$cookie = json_decode($_COOKIE['gwali_identity_cookie']);
			$userIdentity->uCookieId = $cookie->user_cookieId;
		}

		if(!empty($userIdentity->uId)){
			# this means that the user is logged in
			# check if the user exist on the database
			if($this->checkRecord("user", "uId", $userIdentity->uId)==true){
				$userRs = $this->getRecord("user", "uId", $userIdentity->uId);
				$userIdentity->userDetails = $userRs;
				$names = json_decode($userRs->name);
				$userIdentity->userDetails->nickname = NULL;
				$userIdentity->userDetails->firstname = $names->firstname;
				$userIdentity->userDetails->lastname = $names->lastname;
				# use a designed typograph of the first later of their name
				$init_char = strtolower(substr($names->firstname,0,1));
				$userIdentity->userDetails->initial = $init_char;
				if(!empty($names->nickname)){ $userIdentity->userDetails->nickname = $names->nickname; }
				
				# this sets the login session for returning users that enabled
				# remember me feature
				if(empty($_SESSION['gwalian_login_session'])){ $_SESSION['gwalian_login_session'] = $userIdentity->uId;}
				
				# perform another check to know if user is an admin
				if($this->checkRecord("g_admin", "uId", $userIdentity->uId)==true){
					# user is in the general admin table
					$g_admin = $this->getRecord("g_admin", "uId", $userIdentity->uId);
					# check if this admin has been authenticated
					if($g_admin->auth==1){ $userIdentity->g_admin = $userIdentity->uId; }
				}
				if($this->checkRecord("s_admin", "uId", $userIdentity->uId)==true){
					# user is in the super admin table
					$s_admin = $this->getRecord("s_admin", "uId", $userIdentity->uId);
					if($s_admin->auth==1){ $userIdentity->s_admin = $userIdentity->uId; }
				}
			}
		}
		return $userIdentity;
	}
	# check user by email and password
	public function checkLoginDetails($username, $password){
		$user = new stdClass();
		$user->data = NULL;
		$user->response = NULL;
		# firstly check if the email is on the database
		if($this->checkRecord_loose("user", "mail", "'{$username}'")==true){
			if($user->data = $this->getRecord_loose("user", "mail", "'{$username}'", NULL, "uPass", "'{$password}'")){
				$user->response = 200;
			# user exist but the password was incorrect
			} else { $user->response = "incorrect"; }
		# user with email not found
		} else { $user->response = 404; }
		return $user;
	}
	
	# check if this user is an admin
	public function adminCheck(){
		
	}
	
	# method that gets user avatar if its available
	public function getAvatar($parsedUid=NULL){
		$avatar = NULL;
		if(!empty($parsedUid)){
			$data = $this->studentIdentifier($parsedUid);
			$avatar = $data->userDetails->thumb;
			# check if the user has any image uploaded
			if(!empty($avatar)){
				$avatar = "resized_{$avatar}";
			}
		}
		return $avatar;
	}
	
	# display a friendly greeting
	public function showCare($name=NULL){
		$g_name = 'Gwalian';
		if(!empty($name)){ $g_name = ucwords($name); }
		# if the character length the name is too long... trim it
		if(strlen($g_name)>13){ $g_name = substr($g_name,0,13)."..."; }
		$data_time = $this->getDayTimeOfDay();
		$words = array("great", "wonderful", "beautiful", "blissful", "lovely", "delightful", "fine");
		$rand = rand(0, count($words)-1);
		$choice = $words[$rand];
		$emoji = array("😘", "🤗", "😉", "😎", "👌");
		$rand = rand(0, count($emoji)-1);
		$choiceEmoji = $emoji[$rand];
		# do some fancy stuff
		$message = "<span>Hi {$g_name}, it's a {$choice} {$data_time->currentTime} ain't it</span> {$choiceEmoji}";
		return $message;
	}
	
	# method that checks signup data and outputs error in case of any
	public function dataVerification($data){
		$safeData = new stdClass();
		$safeData->email = NULL;
		$safeData->password = NULL;
		$safeData->regNumber = NULL;
		$safeData->faculty = NULL;
		$safeData->department = NULL;
		$safeData->level = NULL;
		$safeData->firstname = NULL;
		$safeData->lastname = NULL;
		$safeData->nickname = NULL;
		$safeData->gender = NULL;
		$safeData->num1 = NULL;
		$safeData->num2 = NULL;
		$safeData->terms = NULL;
		$safeData->message = new stdClass();
		
		# error object
		$error = new stdClass();
		$error->fn = "first name";
		$error->ln = "last name";
		$error->ws = "only letters and white space allowed";
		$error->n = "only numbers allowed";
		$error->e = "invalid email format";
		$error->eu = "email's already in use";
		$error->wp = "your password is too weak";
		$error->pm = "your passwords don't match";
		$error->bp = "blank space is not a password";
		$error->bn = "blank space is not a name";
		$error->sn = "single name expected here";
		$error->rn = "incorrect reg-number format";

		# I know that the only data type I'm expecting is an object or JSON
		if(gettype($data)!="object"){ $data = json_decode($data); }
		
		# sanitize and check
		$safeData->email = strtolower(mysqli_real_escape_string($this->dbcon, $data->email));
		if(!filter_var($safeData->email, FILTER_VALIDATE_EMAIL)){ $safeData->message->email = $error->e; }
		# check if someone else is already using this email
		if($this->checkRecord_loose("user", "mail", "'$safeData->email'")==true){ $safeData->message->email = $error->eu; }
		if(spaceCheck($data->pass1)!=""){
			$originalPass = spaceCheck($data->pass1);
		} else { $safeData->message->password = $error->bp; }
		if(spaceCheck($data->pass2)!=""){
			$originalPassConf = spaceCheck($data->pass2);
			$safeData->password = mysqli_real_escape_string($this->dbcon, sha1(stripChars($data->pass2)));
			# check if passwords match
			if($originalPass!=$originalPassConf){ $safeData->message->password = $error->pm; }
			# check the character count of the input password to know if its less than number
			if(strlen($originalPassConf) < 6){ $safeData->message->password = $error->wp; }
		} else { $safeData->message->password = $error->bp; }
		# later, I need to perform checks for reg-number
		if(!empty($data->regNumber)){ $safeData->regNumber = strtolower(mysqli_real_escape_string($this->dbcon, $data->regNumber)); }
		if(!empty($data->faculty)){ $safeData->faculty = stripChars($data->faculty); }
		if(!empty($data->department)){ $safeData->department = stripChars($data->department); }
		if(!empty($data->level)){ $safeData->level = stripChars($data->level); }
		# permit only white space and letter on these name fields
		if(spaceCheck($data->firstname)!=""){
			if(!preg_match("/^[a-zA-Z ]*$/", $data->firstname)){
				$safeData->message->firstname = $error->ws;
			} else {
				$safeData->firstname = strtolower(spaceCheck($data->firstname));
				# check if user entered two names in first name field
				$multi = explode(" ", $data->firstname);
				if(isset($multi[1]) && spaceCheck($multi[1])!=""){ $multi = NULL; }
				if($multi==NULL){ $safeData->message->firstname = $error->sn; }
			}
		} else { $safeData->message->firstname = $error->bn;}
		if(spaceCheck($data->lastname)!=""){
			if(!preg_match("/^[a-zA-Z ]*$/", $data->lastname)){
				$safeData->message->lastname = $error->ws;
			} else {
				$safeData->lastname = strtolower(spaceCheck($data->lastname));
				# check if user entered two names in last name field
				$multi = explode(" ", $data->lastname);
				if(isset($multi[1]) && spaceCheck($multi[1])!=""){ $multi = NULL; }
				if($multi==NULL){ $safeData->message->lastname = $error->sn; }
			}
		} else { $safeData->message->lastname = $error->bn;}
		# user can have anything as nickname
		if(!empty($data->nickname)){
			if(spaceCheck($data->nickname)!=""){
				$safeData->nickname = stripChars(mysqli_real_escape_string($this->dbcon, strtolower($data->nickname)));
			}
		}
		$safeData->gender = stripChars($data->gender);
		if(!empty($data->num1)){
			$safeData->num1 = $data->num1;
			# negative number
			if($safeData->num1<0){ $safeData->num1 = (-($safeData->num1)); }
		}
		if(!empty($data->num2)){
			$safeData->num2 = $data->num2;
			if($safeData->num2<0){ $safeData->num2 = (-($safeData->num2)); }
		}
		$safeData->terms = stripChars($data->terms);
		$safeData->uId = rand(1000000, 10000000);
		$safeData->signupDate = date("Y-m-d H:i:s");
		
		# return the "safe" data
		return $safeData;
	}
	
	# method that creates new user
	public function createNewUser($data){
		# I know that the only data type I'm expecting is an object or JSON
		if(gettype($data)!="object"){ $data = json_decode($data); }

		$Data = new stdClass();
		$Data->email = NULL;
		$Data->password = NULL;
		$Data->regNumber = NULL;
		$Data->faculty = NULL;
		$Data->department = NULL;
		$Data->level = NULL;
		$Data->firstname = NULL;
		$Data->lastname = NULL;
		$Data->nickname = NULL;
		$Data->gender = NULL;
		$Data->num1 = NULL;
		$Data->num2 = NULL;
		$response = NULL;

		$Data->uId = $data->uId;
		$Data->signupDate = $data->signupDate;
		$Data->email = $data->email;
		$Data->password = $data->password;
		$Data->regNumber = $data->regNumber;
		$Data->faculty = $data->faculty;
		$Data->department = $data->department;
		$Data->level = $data->level;
		$Data->firstname = $data->firstname;
		$Data->lastname = $data->lastname;
		$Data->nickname = $data->nickname;
		$Data->gender = $data->gender;
		$Data->num1 = $data->num1;
		$Data->num2 = $data->num2;
		
		# finally insert the data to database
		$Sql = "INSERT INTO user(uId,signupDate,auth,mail_ver,mail,uPass,thumb,name,academicData,gender,contact) VALUES ($Data->uId, '$Data->signupDate', 0, 0, '$Data->email', '$Data->password', '', JSON_OBJECT( 'firstname', '$Data->firstname', 'lastname', '$Data->lastname', 'nickname', '$Data->nickname' ), JSON_OBJECT( 'regNumber', '$Data->regNumber', 'faculty', '$Data->faculty', 'department', '$Data->department', 'level', '$Data->level' ), '$Data->gender', JSON_OBJECT( 'contact1', '$Data->num1', 'contact2', '$Data->num2' ) )";
		if($Query = mysqli_query($this->dbcon, $Sql)){ $response = 200; }
		# return response; where 200 == ok or done
		return $response;
	}
	
	# An attempt to structure schools and their supported faculties, departments its study duration
	function schoolsAndItsData(){
		# object that has everything
		$schoolsData = new stdClass();
		
		# object that has all supported schools
		$schools = array();
		$schoolSql = "SELECT * FROM school";
		if($schoolQuery = mysqli_query($this->dbcon, $schoolSql)){
			if($schoolRs = mysqli_fetch_object($schoolQuery)){
				do{
					# push each school to the array outside this loop
					$schools[] = $schoolRs;
					$schoolRs->faculties = array();
					
					# second level of query to obtain the faculties
					$facultySql = "SELECT * FROM faculty WHERE schoolId={$schoolRs->id}";
					if($facultyQuery = mysqli_query($this->dbcon, $facultySql)){
						if($facultyRs = mysqli_fetch_object($facultyQuery)){
							do{
								# push each faculty into the array
								$schoolRs->faculties[] = $facultyRs;
								$facultyRs->departments = array();
								
								# third level of query to obtain the departments
								$departmentSql = "SELECT * FROM department WHERE schoolId={$schoolRs->schoolId} AND facultyId={$facultyRs->facultyId}";
								if($departmentQuery = mysqli_query($this->dbcon, $departmentSql)){
									if($departmentRs = mysqli_fetch_object($departmentQuery)){
										do{
											$facultyRs->departments[] = $departmentRs;
										} while($departmentRs = mysqli_fetch_object($departmentQuery));
									}
								}
							} while($facultyRs = mysqli_fetch_object($facultyQuery));
						}
					}
				} while($schoolRs = mysqli_fetch_object($schoolQuery));
			}
		}
		$schoolsData->schools = $schools;
		
		# return the schools and their data
		return $schoolsData;
	}
}