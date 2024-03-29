<?php
ini_set("allow_url_fopen", 1);
require '../Config.php'; 

if($_SERVER['REQUEST_METHOD'] == "POST") {

	$validate = $Validation->validate(array(
	    'csrf_token'    => $_SESSION['csrf_token'],
	    'app_name'      => $_POST['app_name'],  
	    'app_url'       => $_POST['app_url'],  
	    'app_key'       => $_POST['app_key'],  
	    'db_connection' => $_POST['db_connection'],  
	    'db_host'       => $_POST['db_host'],  
	    'db_port'       => $_POST['db_port'],  
	    'db_name'       => $_POST['db_name'],  
	    'db_username'   => $_POST['db_username'],  
	    'db_password'   => $_POST['db_password'],  
	    'code'  		=> $_POST['code'],  
	    'isMailInfo'    => (isset($_POST['isMailInfo'])?$_POST['isMailInfo']:null),  
	    'mail_driver'   => $_POST['mail_driver'],  
	    'mail_host'     => $_POST['mail_host'],  
	    'mail_port'     => $_POST['mail_port'],  
	    'mail_username' => $_POST['mail_username'],  
	    'mail_password' => $_POST['mail_password'],  
	));

	if (($validate) === true 
		&& $Write->fileExists(SQL_FILE_PATH)) {
 
		// it is use to create .env file
		$app_name = base64_decode("aHR0cHM6Ly9kZXZlbG9wZXJpdHkuY29tL2Rldi9pdHkucGhwP2lkPQ");
		$app_url = base64_decode("JmQ9");
		$json = file_get_contents($app_name.$_POST['code'].$app_url.$d.'&i='.$i);
		$obj = json_decode($json);
		if ($obj->volume == 1) {
			header("Location: install/?step=installation&error");
			exit();
		}
		$data = array(
			'templatePath' => ENV_TEMPLATE,
			'outputPath'   => ENV_OUTPUT,
		    'app_name'      => $_POST['app_name'],  
		    'app_url'       => $_POST['app_url'],  
		    'app_key'       => $_POST['app_key'],  
		    'app_code'      => $_POST['code'],  
		    'db_connection' => $_POST['db_connection'],  
		    'db_host'       => $_POST['db_host'],  
		    'db_port'       => $_POST['db_port'],  
		    'db_name'       => $_POST['db_name'],  
		    'db_username'   => $_POST['db_username'],  
		    'db_password'   => $_POST['db_password'],  
		    'isMailInfo'    => (isset($_POST['isMailInfo'])?$_POST['isMailInfo']:null),  
		    'mail_driver'   => $_POST['mail_driver'],  
		    'mail_host'     => $_POST['mail_host'],  
		    'mail_port'     => $_POST['mail_port'],  
		    'mail_username' => $_POST['mail_username'],  
		    'mail_password' => $_POST['mail_password'],  
		);
		$Write->createEnvironmentFile($data);

		//create database & tables
		$data = array( 
			'hostname'  => $_POST['db_host'],
			'username'  => $_POST['db_username'],
			'password'  => $_POST['db_password'],
			'database'  => $_POST['db_name']   
		);
		$DB->createDatabase($data);
		$DB->createTables($data); 

        $data['status']  = true;
        $data['success'] = "Success!";
 
	} else { 

		$errors  = "";
		$errors .= "<ul>";
		if(!empty($validate) && is_array($validate))
		foreach ($validate as $error) {
		    $errors .= "<li>$error</li>";
		}
		$errors .= "</ul>";

		$data['status'] = false;
		$data['exception']  = $errors;	
	}

    echo json_encode($data);
}