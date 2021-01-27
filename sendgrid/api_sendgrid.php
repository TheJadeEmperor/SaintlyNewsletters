<?php
//sends one email to a recipient
function sendEmail ($sendgrid, $email, $newsletterData) {
	
	global $approvedSenderEmail;
	
	//echo ' sendEmail '.$approvedSenderEmail.'..';
	
	$email->setFrom($approvedSenderEmail, $newsletterData['senderName']);
	$email->setSubject($newsletterData['subject']);
	$email->addTo($newsletterData['subscriberEmail'], $newsletterData['subscriberName']);
	$email->addContent(
		"text/html", $newsletterData['htmlContent']
	);

	try {
		$response = $sendgrid->send($email);
		print $response->statusCode() . "\n";
		print_r($response->headers());
		print $response->body() . "\n";
	} catch (Exception $e) {
		echo 'Caught exception: '. $e->getMessage() ."\n";
	}
	
	return $response;
}



class sendGridAPI {
	
	public $approvedSenderEmail;
	public $sendGridMail;
	public $sendgridAPIKey;
	
	function __construct($sendgridAPIKey) {
        
		$this->sendgridAPIKey = $sendgridAPIKey;
		// echo '__construct '.$this->sendgridAPIKey;
    }
	

	public function list_add ($json) {
			
		$curl = curl_init();

		curl_setopt_array($curl, 
			array(
			CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/lists",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey,
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
		
		return $response; 
	} //function list_add

	public function list_get ($list_id) {
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/lists/".$list_id."?contact_sample=true",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "{}",
		  CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey,
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			
		  $list = json_decode($response);
		  
		 // var_dump( $list );
			return $list; 
			
		}
	}
	
	//{"errors":[{"field":null,"message":"access forbidden"}]}
	public function list_delete ($list_id) {
				
			//	echo "https://api.sendgrid.com/v3/contactdb/lists/".$list_id."?delete_contacts=true";
		echo $this->sendgridAPIKey;
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendgrid.com/v3/contactdb/lists/".$list_id."?delete_contacts=true",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "DELETE",
		  CURLOPT_POSTFIELDS => "null",
		  CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey,
			": The subuser's username. This header generates the API call as if the subuser account was making the call"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	
	public function contact_count ($list_id) {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/lists/".$list_id."/contacts/count",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "{}",
			CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".SENDGRID_API_KEY
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	
	public function contact_add ($contact_data) {
		$curl = curl_init();
		
		//echo $contact_data['list_id'].' ';
		echo $contact_data['contact']['email'];

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/contacts",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => '{"list_ids":["'.$contact_data['list_id'].'"],"contacts":[{"email":"'.$contact_data['contact']['email'].'","first_name":"'.$contact_data['contact']['first_name'].'","city":"'.$contact_data['contact']['join_date'].'","state_province_region":"'.$contact_data['contact']['origin'].'","custom_fields":{}}]}',
			CURLOPT_HTTPHEADER => array(
			  "authorization: Bearer ".$this->sendgridAPIKey,
			  "content-type: application/json"
			),
		  ));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	
	public function contact_search ($info) {
		//search for contact id based on email
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/contacts/search",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"query\":\"email LIKE '".$info['email']."%' AND CONTAINS(list_ids, '".$info['list_id']."')\"}",
		  CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey,
			"content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  	$array = json_decode($response);
		
			//var_dump($array);  
		}
		
		//get the contact's id 
		echo $contact_email = $array->result[0]->email.' ';
		$contact_id = $array->result[0]->id;
		echo 'contact_id: '.$contact_id;
		return $contact_id;
	}
	
	//get details of contact
	public function contact_get ($info) {
		$contact_id = $this->contact_search ($info);
		
		echo $contact_id;
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/contacts/".$contact_id,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "{}",
		  CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$array = json_decode($response);
			var_dump($array);
			echo $array->created_at;
			return $array;
		}
	}
	
	
	public function contact_delete ($info) {

		$contact_id = $this->contact_search ($info['email']);
		echo '<br />';
		
		if(!$contact_id) return;
		
		//
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/contacts?ids=".$contact_id,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "DELETE",
		  CURLOPT_POSTFIELDS => '',
		  CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ".$this->sendgridAPIKey
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	
}
 

?>