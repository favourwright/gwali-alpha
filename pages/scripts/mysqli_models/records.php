<?php
class Records extends DB_con {
	public function __construct(){
		date_default_timezone_set("Africa/Lagos");
	}

	// THIS IS THE REVIEWED SCRIPT; FACEBOOK TYPE
	function elaborateDateParser($rawDate){
		$converted = strtotime($rawDate);
		$currentTime = time();
		$timeDiff = $currentTime-$converted;
		$seconds = $timeDiff;
		
		$month = date('M', $converted);
		$day = date('D', $converted);
		$year = date('Y', $converted);
		$time = date('h:ia', $converted);
		
		$minutes = round($seconds / 60); // value 60 is seconds
		$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks = round($seconds / 604800); // 7*24*60*60;
		$months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
		if ($seconds <= 60){ $display = "just now"; }
		elseif ($minutes <= 60){ if ($minutes == 1){ $display = "one minute ago"; } else { $display = "$minutes minutes ago"; } }
		elseif ($hours <= 24){ if ($hours == 1){ $display = "an hour ago"; } else { $display = "$hours hrs ago"; } }
		elseif ($days <= 7){ if ($days == 1){ $display = "yesterday"; } else { $display = "$days days ago"; } }
		elseif ($weeks <= 4.3){ if($weeks == 1){ $display = "a week ago"; } else { $display = "$weeks weeks ago"; } }
		elseif ($months <= 12){ if($months == 1){ $display = "$day, a month ago at $time"; } else { $display = "$day, $months months ago at $time"; } }
		else { if($years == 1){ $display = "a year ago on $month at $time"; } else { $display = "$years years ago on $month at $time"; } }
		
		// return an output
		return ucfirst($display);
	}
	// THIS IS THE TIMELINEY PARSER
	function timelineDateParser($rawDate){
		$converted = strtotime($rawDate);
		$currentTime = time();
		$timeDiff = $currentTime-$converted;
		$seconds = $timeDiff;
		
		$month = date('M', $converted);
		$day = date('D', $converted);
		$year = date('Y', $converted);
		$time = date('h:ia', $converted);
		
		$minutes = round($seconds / 60); // value 60 is seconds
		$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks = round($seconds / 604800); // 7*24*60*60;
		$months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

//		if ($hours <= 24){ $display = "today"; }
//		elseif ($days <= 7){ if ($days == 1){ $display = "yesterday"; } else { $display = "$days days ago"; } }
//		elseif ($weeks <= 4.3){ if($weeks == 1){ $display = "a week ago"; } else { $display = "$weeks weeks ago"; } }
//		elseif ($months <= 12){ if($months == 1){ $display = "$day, a month ago"; } else { $display = "$day, $months months ago"; } }
//		else { if($years == 1){ $display = "a year ago on $month"; } else { $display = "$years years ago on $month"; } }
		if ($hours <= 24){ $display = "less than 24 hours"; }
		elseif ($days <= 7){ if ($days == 1){ $display = "yesterday"; } else { $display = "$days days ago"; } }
		elseif ($weeks <= 4.3){ if($weeks == 1){ $display = "a week ago"; } else { $display = "$weeks weeks ago"; } }
		elseif ($months <= 12){ if($months == 1){ $display = "$day, a month ago"; } else { $display = "$day, $months months ago"; } }
		else { if($years == 1){ $display = "a year ago on $month"; } else { $display = "$years years ago on $month"; } }
		
		// return an output
		return ucfirst($display);
	}
	
	# determine time of day [ format: morning (early), afternoon, night (late) ]
	public function getDayTimeOfDay(){
		$day_time = new stdClass();
		$time = date('G');
		$day_time->day = date('l');
		
		# morning
		if($time <= 11) {
			$day_time->currentTime = 'morning';
			# check if its early morning
			if($time <= 5){ $day_time->currentTime_late = 'early morning'; }
		# afternoon
		} elseif ($time <= 15) {
			$day_time->currentTime = 'afternoon';
		# evening
		} elseif ($time <= 19) {
			$day_time->currentTime = 'evening';
		# night
		} else {
			$day_time->currentTime = 'night';
			if($time > 21){ $day_time->currentTime_late = 'late night'; }
		}
		return $day_time;
	}
	
	public function getDateDays($rawDate){
		# function to return the number of days ofset from current day
		$converted = strtotime($rawDate);
		$currentTime = time();
		$timeDiff = $currentTime-$converted;
		$seconds = $timeDiff;
		
		$day = date('D', $converted);
		
		$days = round($seconds / 86400); //86400 = 24 * 60 * 60;

		// return the number of days
		return $days;
	}
	
	# simple formated date
	public function simpleDateFormater($rawDate){
		$converted = strtotime($rawDate);
		# format example: monday 6th september 2019
		$date = date('l jS F Y', $converted);
		// return the date
		return $date;
	}
	
	# this is me trying to be smart :-) and change links to " clickable " ones
	public function detectLinks_mine($string){
		$wordsToDetect = array("https", "http", "www");
		# empty array to pack all link strings
		$unstructuredLinks = array();
		$cache = $string;
		# index for the placeholder after each loop... ie: if more than one link is found
		$placeHolderIndex = 0;
		foreach($wordsToDetect as $word){
			# if $word is found in cache
			if(stristr($cache, $word)){
				$unparsed_hyperL = stristr($cache, $word);
				# because I know that after the link, there must be a space char, I did this
				$unparsed_hyperL_arr = explode(" ", $unparsed_hyperL);
				$hyperL = $unparsed_hyperL_arr[0];
				# because there might be a break tag attached to it, do this
				$hyperLArr = explode("<", $hyperL);
				$hyperL = $hyperLArr[0];
				$unstructuredLinks[] = $hyperL;
				
				# replace it with a placeholder so that it'll not be found again when the
				# loop re-runs
				$cache = str_replace($hyperL, "{{{$placeHolderIndex}}}", $cache);
				$placeHolderIndex++;
			}
		}
		
		# loop over all the found links
		for($i=0;$i<count($unstructuredLinks);$i++){
			$link = $unstructuredLinks[$i];
			# if the word detected was "www" I need to include http:// unless
			# it will not load as an external url
			if(substr(strtolower($link),0,3)=="www"){ $link="http://".$link; }
			
			$miniL = $link;
			# shorten displayed link text if its long
			if(strlen($link)>28){ $miniL = substr($link,0,28)."..."; }
			# remove these if found for the displayed link text
			$miniL = str_replace("http://www.", "", strtolower($miniL));
			$miniL = str_replace("https:www//", "", strtolower($miniL));
			$miniL = str_replace("https://", "", strtolower($miniL));
			$miniL = str_replace("http://", "", strtolower($miniL));
			$miniL = str_replace("www.", "", strtolower($miniL));
			# construct the hyperlink
			$clickable = "<a href='{$link}' target='_blank'>{$miniL}</a>";
			# using the placeholder index, replace with the associated link
			$output = str_replace("{{{$i}}}", $clickable, $cache);
			$cache = $output;
		}
		$output = $cache;
		return $output;
	}
	
	# this is better(gotten online) does the same thing as the above method...
	# only better and less bugs and more range
    public function linkify($value, $protocols = array('http', 'mail'), array $attributes = array()) {
        # Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) { $attr .= ' ' . $key . '="' . htmlentities($val) . '"'; }
        $links = array();
        # Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
        
        # Extract text links for each protocol
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':
					$value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
					function ($match) use ($protocol, &$links, $attr) {
						if ($match[1]) $protocol = $match[1];
							$link = $match[2] ?: $match[3];
							$disp = $this->shortener($link);
							return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target=\"_blank\">$disp</a>") . '>';
					}, $value);
					break;
                case 'mail':
					$value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~',
					function ($match) use (&$links, $attr) {
						return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
					}, $value);
					break;
                case 'twitter':
					$value = preg_replace_callback('~(?<!\w)[@#](\w++)~',
					function ($match) use (&$links, $attr) {
						return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\" target=\"_blank\">{$match[0]}</a>") . '>';
					}, $value);
					break;
                default:
					$value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i',
					function ($match) use ($protocol, &$links, $attr) {
						$disp = $this->shortener($match[1]);
						return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" target=\"_blank\">{$disp}</a>") . '>';
					}, $value);
					break;
            }
        }
        # Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
    }
	# created this to strip the http... from the url dsplayed for the user
	public function shortener($link){
		$miniL = $link;
		# shorten displayed link text if its long
		if(strlen($link)>28){ $miniL = substr($link,0,28)."..."; }
		# remove these if found for the displayed link text
		$miniL = str_replace("https://www.", "", strtolower($miniL));
		$miniL = str_replace("http://www.", "", strtolower($miniL));
		$miniL = str_replace("https://", "", strtolower($miniL));
		$miniL = str_replace("http://", "", strtolower($miniL));
		$miniL = str_replace("www.", "", strtolower($miniL));
		return $miniL;
	}
	
	
	# sanitize the value that gets passed in
	public function sanitizeNum($input){
		if(spaceCheck($input)!=""){
			$input = (int)stripChars(addslashes($input));
			return $input;
		}
	}
	
	public function slim_fetch_sql($column, $table, $condition=0, $condVal=0, $condition2=0, $condVal2=0, $condition3=0, $condVal3=0, $condition4=0, $condVal4=0){
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

	public function slim_fetch_all_sql($column, $table, $condition=0, $condVal=0, $order=0, $condition2=0, $condVal2=0, $condition3=0, $condVal3=0, $condition4=0, $condVal4=0){
		$result = array();
		$orderQ = "ORDER BY ";
		if(!empty($order)){
			if(gettype($order)=='object'){
				$orderQ .= "{$order->column} {$order->order}";
			} else { $orderQ .= $order; }
		} else { $orderQ = ''; }
		if(!empty($condition4)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3 AND $condition4 = $condVal4 {$orderQ}";
		} elseif(!empty($condition3)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3 {$orderQ}";
		} elseif(!empty($condition2)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal AND $condition2 = $condVal2 {$orderQ}";
		} elseif(!empty($condition)){
			$Sql = "SELECT $column FROM $table WHERE $condition = $condVal {$orderQ}";
		} else {
			$Sql = "SELECT {$column} FROM {$table} {$orderQ}";
		}
		$Query = mysqli_query($this->dbconnect(), $Sql);
		if($Query){
			$records = mysqli_fetch_object($Query);
			do { $result[] = $records; } while(mysqli_fetch_object($Query));
			return $result;
		} else {
			return NULL;
		}
	}

	public function slim_count_sql($column, $table, $condition=0, $condVal=0, $condition2=0, $condVal2=0, $condition3=0, $condVal3=0, $condition4=0, $condVal4=0){
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
	
	# function for updating records
	public function slim_update_sql($table, $columns_n_values, $condition, $condVal, $condition2=0, $condVal2=0, $condition3=0, $condVal3=0, $condition4=0, $condVal4=0){
		if(!empty($condition4)){
			$Sql = "UPDATE $table SET $columns_n_values WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3 AND $condition4 = $condVal4";
		} elseif(!empty($condition3)){
			$Sql = "UPDATE $table SET $columns_n_values WHERE $condition = $condVal AND $condition2 = $condVal2 AND $condition3 = $condVal3";
		} elseif(!empty($condition2)){
			$Sql = "UPDATE $table SET $columns_n_values WHERE $condition = $condVal AND $condition2";
		} else {
			$Sql = "UPDATE $table SET $columns_n_values WHERE $condition = $condVal";
		}
		$Query = mysqli_query($this->dbconnect(), $Sql);
		if($Query){
			return true;
		} else {
			return NULL;
		}
	}
	
	# checks if a particular recordId exists in the databases
	public function checkRecord($table, $idName, $recordId){
		$recordId = $this->sanitizeNum($recordId);
		$checkSql = "SELECT $idName FROM $table WHERE $idName=".$recordId;
		$checkQuery = mysqli_query($this->dbconnect(), $checkSql);
		if($checkQuery){
			// the students exists
			if(mysqli_num_rows($checkQuery)>=1){
				return true;
			}
		} else {
			return NULL;
		}
		
	}
	public function checkRecord_loose($table, $idName, $recordId){
		$checkSql = "SELECT $idName FROM $table WHERE $idName=".$recordId;
		$checkQuery = mysqli_query($this->dbconnect(), $checkSql);
		if($checkQuery){
			// the students exists
			if(mysqli_num_rows($checkQuery)>=1){
				return true;
			}
		} else {
			return NULL;
		}
		
	}
	
	# fetch complete details belonging to this record
	public function getRecord($table, $idName, $recordId, $targetColumn=0){
		$recordId = $this->sanitizeNum($recordId);
		if(!empty($targetColumn)){
			$record = $this->slim_fetch_sql($targetColumn, $table, $idName, $recordId);
		} else {
			$record = $this->slim_fetch_sql('*', $table, $idName, $recordId);
		}
		return $record;
	}
	public function getRecord_loose($table, $idName, $recordId, $targetColumn=0, $optCond=0, $optCondVal=0){
		if(!empty($optCond) && !empty($targetColumn)){
			$record = $this->slim_fetch_sql($targetColumn, $table, $idName, $recordId, $optCond, $optCondVal);
		} elseif(!empty($optCond)){
			$record = $this->slim_fetch_sql('*', $table, $idName, $recordId, $optCond, $optCondVal);
		} elseif(!empty($targetColumn)){
			$record = $this->slim_fetch_sql($targetColumn, $table, $idName, $recordId);
		} else {
			$record = $this->slim_fetch_sql('*', $table, $idName, $recordId);
		}
		return $record;
	}
	
	
	# fetch complete records with details satisfying the query
	public function getRecords($targetColumn=0, $table, $idName=0, $Id=0){
		$Id = $this->sanitizeNum($Id);
		if(empty($targetColumn) && empty($idName)){
			$record = $this->slim_fetch_all_sql("*", $table);
		} elseif(empty($targetColumn)){
			$record = $this->slim_fetch_all_sql("*", $table, $idName, $Id);
		} else {
			$record = $this->slim_fetch_all_sql($targetColumn, $table, $idName, $Id);
		}
		return $record;
	}
	
	
	# get the available course codes
	public function getCourseCodes(){
		$output = new stdClass();
		$cc = NULL;
		$sql = "SELECT * FROM course";
		$query = mysqli_query($this->dbconnect(), $sql);
		if($rs = mysqli_fetch_object($query)){
			do {
				$cc .= $rs->course_code."*";
			} while($rs = mysqli_fetch_object($query));
		}
		$changed = str_replace("_", " ", $cc);
		$output->ccOriginalArr = explode("*", $cc);
		$output->ccChangedArr = explode("*", $changed);
		return $output;
	}
	public function getCourseCode($cId){
		$cc = new stdClass();
		$cc->_cc = NULL;
		$cc->cc = NULL;
		if($cRs = $this->getRecord("course", "courseId", $cId, "courseCode")){
			$cc->_cc = $cRs->courseCode;
			$cc->cc = str_replace("_", " ", $cRs->courseCode);
		}
		return $cc;
	}
	public function getCourseId($cc=0){
		$cId = NULL;
		if(!empty($cc)){
			if($ccRs = $this->getRecord_loose("course", "courseCode", "'{$cc}'", "courseId")){
				$cId = $ccRs->courseId;
			}
		}
		return $cId;
	}
	
	
	# count the number of users that had viewed an entry
	public function getViewers($table, $idName, $identity=0){
		$views = new stdClass();
		$views->uniqueCount = NULL;
		$views->totalCount = NULL;
		if(!empty($identity)){
			# make sure that there isn't a missing views record for an entry
			# else ignor
			$order = "JSON_EXTRACT(`fingerprint`, '$.datetime') DESC";
			if($viewsRs = $this->slim_fetch_all_sql('*', $table, $idName, $identity, $order)){
				$count = 0;
				$check = NULL;
				if(sizeof($viewsRs)>1){ $check=true; }
				elseif(sizeof($viewsRs)==1){ if(!empty($viewsRs[0])){ $check=true; } }
				$commentersUId = NULL;
				$commentersCookieId = NULL;
				# I'll be back here because this is where I need to determine the unique views
				# ie one view per user for a particular post
				if($check==true){
					foreach($viewsRs as $view){
						$fingerprint = json_decode($view->fingerprint);
						$count += 1;
					}
				}
				# returns the total number of views regardless of repeatition by a user
				$views->totalCount = $count;
 			}
		}
		return $views->totalCount;
	}
	
	# fetch the items (assignments or notes) that is displayed on homepage
	public function getHomeRecords($filter=0){
		# apply filter
		$cond = NULL;
		if(!empty($filter)){
			# check if it exist
			if($this->checkRecord_loose("course", "courseCode", "'{$filter}'")==true){
				$filter_rs = $this->getRecord_loose("course", "courseCode", "'{$filter}'", "courseId");
				$filter = $filter_rs->courseId;
				
				# at this point, check if the course code is an "entry"
				if($this->checkRecord("entry", "courseId", $filter)){
					$cond = "AND courseId=$filter";
				}
				
				# this is really necessary here so when filter is applied, the record count will not be
				# dependent on the loadMore session unless they actually load more content while viewing
				# records with the filter
				unset($_SESSION['auto_loadMore']);
			}
		}
		
		# a class to pack all results
		$output = new stdClass();
		$postCount = NULL;
		$limit = 10;
		# if user has loaded more records change the limit
		if(!empty($_SESSION['auto_loadMore'])){ $limit = $_SESSION['auto_loadMore']; }
		# array that all the available records will be packed into
		$entries = array();
		$sql = "SELECT * FROM entry WHERE live=1 $cond ORDER BY uploadDate DESC LIMIT {$limit}";
		if($query = mysqli_query($this->dbconnect(), $sql)){
			if($rs = mysqli_fetch_object($query)){
				# count the number of records with another SQL
				$countSql = "SELECT * FROM entry WHERE live=1 $cond";
				$countQuery = mysqli_query($this->dbconnect(), $countSql);
				$postCount = mysqli_num_rows($countQuery);
				
				do {
					$records = new stdClass();
					$records->id = $rs->entryId;
					$records->type = $rs->type;
					$records->uploadDate = $rs->uploadDate;
					$records->uploader = $rs->uploaderId;
					$records->courseId = $rs->courseId;
					$records->title = ucfirst($rs->title);
					# if the character length for title is too long... trim it
					if(strlen($records->title)>52){ $records->title = substr($records->title,0,52)."..."; }
					$records->_file = $rs->file;
					$records->cc = NULL;
					$records->uploadDate = $this->elaborateDateParser($records->uploadDate);
					$records->views = NULL;
					$records->avatar = "avatar.png";
					
					# getting course code
					if($this->checkRecord("course", "courseId", $records->courseId)==true){
						$cc = $this->getRecord("course", "courseId", $records->courseId, "courseCode");
						$records->cc = strtoupper(str_replace("_", " ", $cc->courseCode));
					}
					# getting uploader image
					if($this->checkRecord("user", "uId", $records->uploader)==true){
						$user = $this->getRecord("user", "uId", $records->uploader, "thumb");
						if(!empty($user->thumb)){ $records->avatar = "resized_{$user->thumb}"; }
					}
					
					# getting number of views
					$records->views = $this->getViewers("views", "entryId", $records->id);
					$viewSuffix = "views";
					if($records->views==1){$viewSuffix = "view";}
					
					# this is done here because of seo
					#$viewLink = REL_DIR."?page=view_page&{$records->type}Id={$records->id}";
					#preview/([a-zA-Z]+)/([0-9]+)
					$viewLink = REL_DIR."preview/{$records->type}/{$records->id}";
					
					$data = "
						<div class='each'>
							<div class='survey'></div>
							<div class='main'>
								<div class='avatar'>
									<div class='img'>
										<img src='".REL_DIR."images/user/{$records->avatar}' />
									</div>
								</div>
								<div class='title'>{$records->title}</div>
								<div class='views'><i class='icon-eye'></i> {$records->views} {$viewSuffix}</div>
								<div class='itags'>
									<div class='type'><i class='icon-document'></i> {$records->type}</div>
									<div class='courseCode'><i class='icon-layers'></i> {$records->cc}</div>
									<div class='dated'><i class='icon-time1'></i> {$records->uploadDate}</div>
								</div>
							<a href='{$viewLink}'></a>
							</div>
						</div> ";
					# pack each entry into the array
					$entries[] = $data;
				} while($rs = mysqli_fetch_object($query));
			}
		}
		# pack them in
		$output->entries = $entries;
		$output->postCount = $postCount;
		return $output;	
	}
	
	# deterine what type of record this is and fetch details
	public function getViewDetail($getArr){
		$details = new stdClass();
		$details->get = $getArr;
		$details->type = NULL;
		$details->recordId = NULL;
		$details->data = NULL;
		$details->courseCode = NULL;
		$details->uploader = "a Gwalian";
		$details->response = NULL;
		
		if(!empty($details->get["noteId"])){
			$details->type = "note";
			$details->recordId = (int)$details->get["noteId"];

		} elseif(!empty($details->get["assignmentId"])){
			$details->type = "assignment";
			$details->recordId = (int)$details->get["assignmentId"];
		}
		if($this->checkRecord("entry", "entryId", $details->recordId)==true){
			$record = $this->getRecord("entry", "entryId", $details->recordId);
			$details->data = $record;
			$details->uploadDate = $this->elaborateDateParser($record->uploadDate);
			$details->dated = $this->simpleDateFormater($record->uploadDate);
			
			$details->file = json_decode($record->file);
			# here is where I check if the filesize is greater than kb
			if((($details->file->size)/1000)<1){ $details->file->size = ($details->file->size)."kb"; }
			else { $details->file->size = (($details->file->size)/1000)."mb"; }
			$details->courseCode = strtoupper($this->getCourseCode($record->courseId)->cc);
			
			# getting uploader name
			if($this->checkRecord("user", "uId", $record->uploaderId)==true){
				$user = $this->getRecord("user", "uId", $record->uploaderId, "name, uId");
				$details->uploader = $user;
				$details->uploader->name = ucfirst(json_decode($user->name)->firstname);
			}
			$details->response = "done";
		}
		return $details;
	}
	
	# fetch a timeline looking result of links for home page
	public function seePrevious($filter=0){
		# apply filter
		$cond = NULL;
		if(!empty($filter)){
			# check if it exist
			if($this->checkRecord_loose("course", "courseCode", "'{$filter}'")==true){
				$filter_rs = $this->getRecord_loose("course", "courseCode", "'{$filter}'", "courseId");
				$filter = $filter_rs->courseId;
				
				# at this point, check if the course code is an "entry"
				if($this->checkRecord("entry", "courseId", $filter)){
					$cond = "WHERE courseId=$filter";
				}
			}
		}
		
		# array that all the available records will be packed into
		$entries = array();
		$sql = "SELECT * FROM entry $cond ORDER BY uploadDate DESC";
		$query = mysqli_query($this->dbconnect(), $sql);
		if($rs = mysqli_fetch_object($query)){
			do {
				$records = new stdClass();
				$records->id = $rs->entryId;
				$records->type = $rs->type;
				$records->uploadDate = $rs->uploadDate;
				$records->courseId = $rs->courseId;
				$records->title = $rs->title;
				# if the character length for title is too long... trim it
				if(strlen($records->title)>52){ $records->title = substr($records->title,0,52)."..."; }
				$records->cc = NULL;
				
				# getting course code
				if($this->checkRecord("course", "courseId", $records->courseId)==true){
					$cc = $this->getRecord("course", "courseId", $records->courseId, "courseCode");
					$records->cc = strtoupper(str_replace("_", " ", $cc->courseCode));
				}
				
				# this is done here because of seo
				#$viewLink = REL_DIR."?page=view_page&{$records->type}Id={$records->id}";
				#preview/([a-zA-Z]+)/([0-9]+)
				$viewLink = REL_DIR."preview/{$records->type}/{$records->id}";
				
				$converted = strtotime($records->uploadDate);
				# did this convert because the day doesn't start just at any time but at 00:00:00
				$formated = date("Y-m-d 24:00:00",$converted);
				$timelineDate = $this->timelineDateParser($formated);
				$data = "
					<div class='each'>
						<div class='courseCode'><i class='icon-layers'></i> {$records->cc}</div>
						<span>&#8226;</span>
						<div class='title'>{$records->title}</div>
						<a href='{$viewLink}'></a>
					</div> ";
				# pack each entry into the multi-dimensional array with day-name as key
				# subsequent repeats are added under the first one
				$entries[$timelineDate][] = $data;
			} while($rs = mysqli_fetch_object($query));
			# array having all entries
			$all = array();
			# the first loop captures all the days
			foreach($entries as $day=>$value){
				$each = NULL;
				$date = "<div class='divider unselectable'><span>{$day}</span></div>";
				$each .= $date;
				# second loop is over each days array
				foreach($entries[$day] as $entry){
					$each .= $entry;
				}
				$all[] = $each;
			}
			# output
			return $all;
		}
	}
	
	# this is my effort to merge the comments, views of a particular user that previously
	# was identified by cookieId
	public function resolveToUid(){
		
	}
	
	# this shows the entire student on the platform
	public function totalStudentCount(){
		
	}
}