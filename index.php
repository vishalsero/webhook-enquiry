<?php 
$method = $_SERVER['REQUEST_METHOD'];
// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$text = $json->result->action;
	switch ($text) {
		
		case 'Program':
			
			$speech = "<label>Please choose the Program:</label> <select><option value='volvo'>Volvo</option>
  <option value='saab'>Saab</option>
  <option value='mercedes'>Mercedes</option>
  <option value='audi'>Audi</option>
</select>";
				break;
		
		default:
			$speech = "Sorry, I didn't get that. Can you rephrase?";
				break;
	}
	
	$textResponse = $speech; 
	$textResponse = str_replace('/\\n/g','\n',$textResponse);
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
}
else
{
	echo "Method not allowed";
}
?>
