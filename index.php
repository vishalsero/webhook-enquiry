<?php 
$method = $_SERVER['REQUEST_METHOD'];
// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$text = $json->result->action;
	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;
		case 'Demo':
			$speech = "Sure, we’d love to. But before that we’d like to advise you to first take a brief online demo of the product. Kindly provide your basic details so that our team can reach out to you.
Please follow this link: <a href='https://www.academiaerp.com/request-demo' target='_blank'>Demo</a>";
			break;
		case 'anything':
			$speech = "Yes, you can type anything here.";
			break;
		case 'BenefitsOfERP':
			$speech = "Academia by Serosoft is an award-winning Student Information System powering over 200 institutions across the globe. The robust, feature-rich, analytics-equipped, user-friendly Academia - built on a cutting-edge and flexible architecture - enables educational institutions to automate & streamline their functions and processes for both learning and administration, from prospecting to graduation. It boasts of tremendous capability to handle multi-center operations as well.
Academia ERP is a comprehensive, scalable, highly reliable, secure and built on latest technology stack to manage every aspect of education process and deliver the best possible user experience to educational institutions. Academia is highly configurable, scalable, feature rich, mobile ready and comes with extensive reporting capability from the start to serve the needs of a top-class Universities/Colleges/Schools. It will make processes efficient, optimize your resources, reduce your operational risk and focus on teacher & student success.";
			break;
		case 'Modules':
			
			$speech = "Academia has the multiple numbers of modules ranging from pre-admission to completion.
Kindly find the list of the modules below:
- Organization Setup
- Campaigns & Enquiries
- Admission
- Student Information Management
- Program & Courses
- Timetable
- Attendance
- Exams & Transcripts
- Fees & Payments
- Integration with Accounting Software
- Certificates & Documents
- File Management
- Transport Management
- Resource Booking
- Messaging Engine
- SMS & Email
- Scholarship & Sponsorship
- Surveys
- Integration with LMS
- Employee Records
- Student / Teacher Portals & Apps
- Placement Management
- User & Role Management
- Front-desk Management
- Security Gate Management
- Completion Management
- Dashboards & Reports";
	               
	break;
		case 'AboutERP':
		$speech = "About Academia ERP-
Academia by Serosoft is an award-winning Student Information System powering over 200 institutions across the globe. The robust, feature-rich, analytics-equipped, user-friendly Academia - built on a cutting-edge and flexible architecture - enables educational institutions to automate & streamline their functions and processes for both learning and administration, from prospecting to graduation. It boasts of tremendous capability to handle multi-center operations as well.
There are competing educational software available on the market which may seem similar to our solution, but majority of these are web-based applications with limited functionality, reporting and non-scalable in future. In addition, they all require extra customization in future to map with changing client processes. Moreover, there are problems of software integration with their system and adaptability to their requirements. 
Academia ERP is a comprehensive, scalable, highly reliable, secure and built on latest technology stack to manage every aspect of education process and deliver the best possible user experience to educational institutions. Academia is highly configurable, scalable, feature rich, mobile ready and comes with extensive reporting capability from the start to serve the needs of a top-class Universities/Colleges/Schools. It will make processes efficient, optimize your resources, reduce your operational risk and focus on teacher & student success. ";
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
