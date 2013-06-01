<?php
	include 'config_files.php';
	/*
		This php file checks if the necessary parameters
		are being passed and if every parameter is being
		passed, write those parameters in a serialized form
		in a text file, and re-read the text file to return
		the parameters back, so the client can make sure
		the parameters are properly written. The returned
		parameters are in JSON format.
	*/

	/*
		IMPORTANT:
		mkdir needs write/execute permission to make a directory
		when a path is not found
		make sure to set up appropriate permissions
	*/
	$PARAMETERS;
	if(isset($_REQUEST["autoconditionid"]) && $_REQUEST["autoconditionid"]){
		$PARAMETERS = array("taskBarCSS","buttonText","returnURL","taskText",
						"taskHTML","tabShowText","tabHideText","autoconditionid");
		//set condition ID and CSS URL from the sessions.txt
		setConditionIDAndCSSURL($sessionDataFile);
	}else{
		$PARAMETERS = array("conditionId","cssURL","taskBarCSS",
						"buttonText","returnURL","taskText",
						"taskHTML","tabShowText","tabHideText","autoconditionid");
	}

	$is_complete_request = true;
	for($i=0; $i<count($PARAMETERS); $i++){
		if(!isset($_REQUEST[$PARAMETERS[$i]])){
			$is_complete_request = false;
			echo "Parameter " . $PARAMETERS[$i] . " is missing.<br/>";
		}else if($i == count($PARAMETERS)-1 && $is_complete_request){
			header('Content-type: application/json');
			echo json_encode(registerConfig($_REQUEST,$CONFIG_FILE_PATH,$CONFIG_FILE_NAME));
		}
	}

	function setConditionIDAndCSSURL($filename){
	    //first, obtain the data initially present in the text file
	    $ini_handle = fopen($filename, "r");
	    $old_string = fread($ini_handle, filesize($filename));

	    //parse string
	    $array = explode(" ", $old_string);
	    $conditionID = $array[1];
	    $cssURL = $array[2];
	    $PARAMETERS["conditionId"] = $conditionID;
	    $PARAMETERS["cssURL"] = $cssURL;
	}

	function registerConfig($params,$path,$file_name){
		if (!is_dir($path)){
			// dir doesn't exist, make it
			$old_umask = umask(0);
			mkdir($path);
			umask($old_umask);
		}
		if(is_dir($path)){
			file_put_contents($path.$file_name, serialize($params));
			$re_read_params = unserialize(file_get_contents($path.$file_name));
			return $re_read_params;
		}else{
			return "The server was unable to create the folder. Please check if permissions are properly set up.";
		}
	}
?>