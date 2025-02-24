<?php
//include 'C:\xampp\htdocs\restapi\db.php';


function execRequests($pdo, $input = null) {
	$requests = getRequests($pdo, $input);

	if ( ! $requests ) {
		dd("NO IMSI STATUS REQUESTS Waiting !");
	} else {
		foreach ($requests as $request) {

	    setRequestStatus($pdo, $request, 2);
	    if (! parseResponseFile($pdo, $request) ) {
	    	runRequestBatch($request['iccid'], $request['filename_prefix'], $request['filename_extension']);
	    	//sleep(2);
	    	if (! parseResponseFile($pdo, $request) ) {
	    		setRequestStatus($pdo, $request, 0);
	    	}
	    }
		}
	}
}


/**
 * Runs bat file in background mode
 *
 */
 function runRequestBatch($iccid, $fileprefix, $fileextension) {
		//$handle = exec('c:\WINDOWS\system32\cmd.exe /c START C:\xampp\htdocs\restapi\imsistatus\execsqlaris.bat ' . $iccid . " " . $fileprefix . " " . $fileextension);
		$handle = exec('start C:\xampp\htdocs\restapi\imsistatus\execsqlaris.bat ' . $iccid . " " . $fileprefix . " " . $fileextension);
		//exec("start cmd /c C:\xampp\htdocs\restapi\imsistatus\execsqlaris.bat " . $iccid . " " . $fileprefix . " " . $fileextension, $request_result);

    return $handle;
 }

 function getRequests($pdo, $input = null) {
		$sql = "SELECT imsistatus_requests.id, imsistatus_requests.filename_prefix, imsistatus_requests.filename_extension, esims.imsi, esims.iccid ";
		$sql = $sql . "FROM imsistatus_requests ";
		$sql = $sql . "INNER JOIN esims ON esims.id=imsistatus_requests.esim_id ";
		$sql = $sql . "WHERE imsistatus_requests.responded = 0 ";

		if (! is_null($input) ) {
			$sql = $sql . "AND esims.iccid = '" . trim($input['iccid']) . "' ";
		}

		$stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getOneRequest($pdo, $input) {
		$sql = "SELECT imsistatus_requests.id, imsistatus_requests.request_id, imsistatus_requests.response_url, imsistatus_requests.filename_prefix, imsistatus_requests.filename_extension, imsistatus_requests.created_at, imsistatus_requests.responded_at, esims.imsi, esims.iccid ";
		$sql = $sql . "FROM imsistatus_requests ";
		$sql = $sql . "INNER JOIN esims ON esims.id=imsistatus_requests.esim_id ";
		$sql = $sql . "WHERE imsistatus_requests.id = :id";

		$stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $input['id']]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function parseResponseFile($pdo, $request) {
	$rows_min = 3;
	$row_resp = 2;

	$request_file = "C:\\xampp\\htdocs\\restapi\\imsistatus\\requestfiles\\" . $request['filename_prefix'] . "_req." . $request['filename_extension'];
	$response_file = "C:\\xampp\\htdocs\\restapi\\imsistatus\\requestfiles\\" . $request['filename_prefix'] . "9e4206fa_res.csv";

	if (! file_exists($response_file)) {
		dd("FILE DOES NOT EXISTS : ");
		dd($response_file);
		return false;
	}
	if (($open = fopen($response_file, "r")) !== false) {
    while (($data = fgetcsv($open, 1000, "|")) !== false) {
        $array[] = $data;
    }

    fclose($open);
	}

	if (! (count($array) >= $rows_min) ) {
		parseErrorFile($pdo, $request, $array);
		return true;
	}

	if ( isset($array[$row_resp][0]) && isset($array[$row_resp][1]) && isset($array[$row_resp][2]) ) {
		$response_code = 1;
		$response_message = "OK - Successful Response !";
		insertResponse($pdo, $request, $array, $row_resp);
		unlink($request_file);
		unlink($response_file);
	} else {
		$response_code = -3;
		$response_message = "PARSE ERROR - UNMATCHED COLUMNS !";
	}

	$new_request = updateRequest($pdo, $request, $response_code, $response_message);

	if ($response_code === 1) {
		sendResponseToGtEsim($new_request, $array, $row_resp, $response_message);
	}

	dd("PARSE FILE DONE (" . $response_code . ") : ");
	dd($response_message);
	return true;
}

function parseErrorFile($pdo, $request, $array) {

	if ( isset($array[0][0]) ) {
		$response_code = -2;
		$response_message = $array[0][0];
	} else {
		$response_code = -1;
		$response_message = "UNKNOWN ERROR !";
	}

	updateRequest($pdo, $request, $response_code, $response_message);
	dd("PARSE FILE ERROR (" . $response_code . ") : ");
	dd($response_message);
}

function setRequestStatus($pdo, $request, $request_code) {
	$sql = "UPDATE imsistatus_requests SET responded = :responded, last_state_at = NOW() WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['responded' => $request_code, 'id' => $request['id']]);
}

function updateRequest($pdo, $request, $response_code, $response_message) {
	$sql = "UPDATE imsistatus_requests SET responded = :responded, response_message = :response_message, responded_at = NOW(), last_state_at = NOW() WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['responded' => $response_code, 'response_message' => $response_message, 'id' => $request['id']]);

  return getOneRequest($pdo, $request);
}

function insertResponse($pdo, $request, $array, $row_resp) {
	// ARIS Status: [U => Utilise, A => Libre ...]
	$sql = "INSERT INTO imsistatus_responses (request_id, icc, status, status_change_date, created_at) VALUES (:request_id, :icc, :status, :status_change_date, NOW())";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['request_id' => $request['id'], 'icc' => trim($array[$row_resp][0]), 'status' => trim($array[$row_resp][1]), 'status_change_date' => $array[$row_resp][2]]);
}

function getOneResponse($pdo, $input) {
		$sql = "SELECT * ";
		$sql = $sql . "FROM imsistatus_requests ";
		$sql = $sql . "WHERE id = :id";

		$stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $input['id']]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function sendResponseToGtEsim($request, $array, $row_resp, $response_message) {
	// http://gtesimtest.moov-africa.ga/dashboard
	// Define the URL and data
	$url = $request['response_url'];//'http://gtesimtest.moov-africa.ga/api/arisstatuses';

	$data = ['iccid' => $request['iccid']];
	$data['icc'] = trim($array[$row_resp][0]);
	$data['status'] = trim($array[$row_resp][1]);
	$data['status_change_date'] = $array[$row_resp][2];
	$data['requested_at'] = $request['created_at'];
	$data['responded_at'] = $request['responded_at'];
	$data['request_id'] = $request['request_id'];
	$data['response_message'] = $response_message;

	// Prepare POST data
	$options = [
	    'http' => [
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => http_build_query($data),
	    ],
	];

	// Create stream context
	$context  = stream_context_create($options);

	// Perform POST request
	$response = file_get_contents($url, false, $context);

	// Display the response
	//echo $response;
}

function dd($data) {
  var_dump($data);
  echo "\n";
}
?>
