<?php

$base_url = 'http://amazon.academiaerp.com/';
$method = $_SERVER['REQUEST_METHOD'];
// Process only when method is POST
if ($method == 'POST') {
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);
    $text = $json->result->action;
    switch ($text) {

        case 'Program':
            $token = getToken();
            $params = json_decode($token);
            $enq = sendEnquire($params->access_token, $text);
            echo $enq;
            $speech = "<label>Please choose the Program</label> <select id='program' onchange='programChange(this.value)'><option value='MBA'>MBA</option>
            <option value='MCA'>MCA</option>
            <option value='MSC'>MSC</option>
            </select>";
            break;

        default:
            $speech = "Sorry, I didn't get that. Can you rephrase?";
            break;
    }

    $textResponse = $speech;
    $textResponse = str_replace('/\\n/g', '\n', $textResponse);
    //$textResponse = $textResponse.replace(/\\n/g, '\n\n');
    //$textResponse = nl2br($speech);
    //$response = new \stdClass();
    //$response = array('type'=>0,'speech'=>$textResponse);
    //$response = array('messages'=>array($response));
    //$response = array('fulfillment'=>$response);
    //$response = array('result'=>$response);
    $response = new \stdClass();
    $response->speech = $speech;
    $response->displayText = $speech;
    $response->source = "webhook";
    //print_r($response);
    //die();
    //$response->result->fulfillment->speech = textResponse;

    echo json_encode($response);
} else {
    echo "Method not allowed";
}

function getToken() {

    $url = $base_url.'oauth/token';

    $fields = array(
        'client_id' => 'publicclient',
        'client_secret' => '$edu#pub@21',
        'grant_type' => 'password',
        'username' => 'PUBLIC_PORTAL_USER',
        'password' => 'password',
        'portal_code' => 'PUBLIC_PORTAL',
        'code' => 'PUBLIC_PORTAL'
    );

    $fields_string = "";

    //url-ify the data for the POST
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //execute post
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function sendEnquire($access_token, $input_json) {
    // $input_json = json_decode($input);
    $input_result = $input_json->result->parameters;
    //print_r($input_result);
    $studentLastName = $input_result->studentLastName;
    $lastName = $input_result->lastName;
    $whetherSiblingStudying = $input_result->whetherSiblingStudying;
    $registeredByType = $input_result->registeredByType;
    $followUpUser = $input_result->followUpUser;
    $motherEmployed = $input_result->motherEmployed;
    //$program = $input_result->program;
    $whetherDeleted = $input_result->whetherDeleted;
    $phoneNo = $input_result->phoneNo;
    $firstName = $input_result->firstName;
    $primaryeEmailId = $input_result->primaryeEmailId;
    $enquiryType = $input_result->enquiryType;
    $fatherEmployed = $input_result->fatherEmployed;
    $phoneCountryCode = $input_result->phoneCountryCode;
    $enquiryDate = date('d-m-Y');
    $enquirySource = $input_result->enquirySource;
    $studentFirstName = $input_result->studentFirstName;

    $applicantjson = '{
	"enquiryType": {
		"id": "' . $enquiryType . '",
		"value": "Admission"
	},
	"enquiryStudentDetails": [{
		"salutation": {
			"id": 1
		},
		"studentFirstName": "' . $studentFirstName . '",
		"studentMiddleName": "",
		"studentLastName": "' . $studentLastName . '",
		"whetherDeleted": "' . $whetherDeleted . '",
		"fatherEmployed": "' . $fatherEmployed . '",
		"motherEmployed": "' . $motherEmployed . '",
		"whetherSiblingStudying": "' . $whetherSiblingStudying . '",
		"admissionEnquiryDetails": [{
			"academyLocation": {
				"id": 3
			},
			"program": {
				"id": 11
			},
			"batch": {
				"id": 13
			},
			"programBatchSeatConfiguration": {
				"id": 17
			},
			"whetherDeleted": false
		}]
	}],
	"firstName": "' . $firstName . '",
	"lastName": "' . $lastName . '",
	"middleName": "",
	"followUpUser": {
		"id": "' . $followUpUser . '"
	},
	"enquiryDate": "' . $enquiryDate . '",
	"enquirySource": {
		"id": "' . $enquirySource . '"
	},
	"registeredByType": "' . $registeredByType . '",
	"status": "O",
	"whetherDeleted": false,
	"academyLocation": {
		"id": 3
	},
	"user": {
		"id": 1
	},
	"primaryeEmailId": "' . $primaryeEmailId . '",
	"phoneNo": "' . $phoneNo . '",
	"phoneCountryCode": "' . $phoneCountryCode . '",
	"followUpDate": "17-09-2018",
	"customData": [{
		"cf1": "",
		"cf11": "",
		"id": "",
		"version": ""
	}],
	"salutation": {
		"id": 1
	},
	"campaign": {
		"id": null
	},
	"alternatePhoneNo": ""
    }';

    $authorization = "Authorization: Bearer " . $access_token;
    $url = $base_url.'rest/enquiry/saveEnquiry';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicantjson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json', $authorization,
            )
    );

    $resultcurlsub = curl_exec($ch);
    //print_r($resultcurlsub);
    if ($resultcurlsub == 'SUCCESS') {
        $message = "Record inserted !!!";
    } else {
        $message = "Record Not inserted !!!";
    }
    return $message;
}

?>
