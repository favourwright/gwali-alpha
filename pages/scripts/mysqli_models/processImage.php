<?php
class ProcessImage extends DB_con {
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
	
	# checks if a particular recordId exists in the databases
	public function checkRecord($table, $idName, $recordId){
		$recordId = $this->sanitizeNum($recordId);
		$checkSql = "SELECT $idName FROM $table WHERE $idName=".$recordId;
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
	
	# image resizing method
	public function imgResizeScript($target, $resized, $width, $height, $extension){
		list($orig_width, $orig_height) = getimagesize($target);
		$scale_ratio = $orig_width / $orig_height;
		
		if(($width / $height) > $scale_ratio){
			$width = $height * $scale_ratio;
		} else {
			$height = $width / $scale_ratio;
		}
		
		$img = "";
		if($extension == "png" || $extension == "PNG"){
			$img = imagecreatefrompng($target);
		} elseif($extension == "gif" || $extension == "GIF"){
			$img = imagecreatefromgif($target);
		} else {
			$img = imagecreatefromjpeg($target);
		}
		
		$true_color = imagecreatetruecolor($width, $height);
		imagecopyresampled($true_color, $img, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
		# if the resize was successful
		if(imagejpeg($true_color, $resized, 80)){
			return true;
		} else { return NULL; }
	}
	
	# method for performing tests and uploading image and performing a resize
	public function singleImageUpload($name, $tmp_name, $size, $target_dir){
		$slicedName = explode(".", $name);
		$slicedLastElem = count($slicedName)-1;
		$fileExtension = $slicedName[$slicedLastElem];
	
		$target_file = $target_dir . basename($name);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($tmp_name);
		if($check !== false) {
			$notImgOk = "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$notImgErr = "File is not an image.";
			$uploadOk = 0;
			return $notImgErr;
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			$alreadyExistErr = "Sorry, file already exists.";
			$uploadOk = 0;
			return $alreadyExistErr;
		}
		// Check file size
		if ($size > 2000000) {
			$tooLargeErr = "Sorry, your file is too large.";
			$uploadOk = 0;
			return $tooLargeErr;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$fileTypeErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
			return $fileTypeErr;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$uncaughtErr = "Sorry, your file was not uploaded.";
			return $uncaughtErr;
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($tmp_name, $target_file)) {
				// at this point it is important for me to use the image resizing
				// function on what ever file has been uploaded
				$file = $target_dir.$name;
				$resized_file = $target_dir."resized_".$name;
				$max_width = 250;
				$max_height = 200;
				$this->imgResizeScript($file, $resized_file, $max_width, $max_height, $fileExtension);
				
				# if everything went well
				return "success";
			} else {
				$finalErr = "Sorry, there was an error uploading your file.";
				return $finalErr;
			}
		}
	}
}