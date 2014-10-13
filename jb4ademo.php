<?php


	$email_one_name = "jb4a 1";
	$email_one_html = '
<html>
<body>
<p>Thank you for registering! Don\'t forget to <a href="http://www.example.com/download/">download our mobile app</a>!</p>
<small>
  <p>This email was sent by:</p>
  <p>
    %%Member_Busname%%
    <br />
    %%Member_Addr%%
    <br />
    %%Member_City%%, %%Member_State%% %%Member_PostalCode%%
    <br />
    %%Member_Country%%
  </p>
  <a href="%%profile_center_url%%">Profile Center</a>
</small>
<custom name="opencounter" type="tracking">
</body>
</html>';


	$email_two_name = "jb4a 2";

	$email_two_html = '
<html>
<body>
<p>... we have an app? <a href="http://www.example.com/download/">Download it today</a> and save 20% on renewal next year!</p>
<small>
  <p>This email was sent by:</p>
  <p>
    %%Member_Busname%%
    <br />
    %%Member_Addr%%
    <br />
    %%Member_City%%, %%Member_State%% %%Member_PostalCode%%
    <br />
    %%Member_Country%%
  </p>
  <a href="%%profile_center_url%%">Profile Center</a>
</small>
<custom name="opencounter" type="tracking">
</body>
</html>';

	$dataExtensionName = "jb4a - dreamforce";
	$customerEmail = "jb4a@bh.exacttarget.com";
	$customerFullName = "Robert Paulson";


	require('sdk/ET_Client.php');
	$myclient = new ET_Client();


	/*************
	 * Create the Data Extension
	 * ***********/

	$dataextension = new ET_DataExtension();
	$dataextension->authStub = $myclient;

	$dataextension->props = array(
		"Name" => $dataExtensionName,
		"CustomerKey" => $dataExtensionName,
		"Description" => "Data Extension holding my Customers",
		"IsSendable" => true,
		"SendableDataExtensionField" => array(
			"Name" => "EmailAddress", "Value" => null
		),
		"SendableSubscriberField" => array(
			"Name" => "Subscriber Key", "Value" => null
		)
	);

	$dataextension->columns = array();
	$dataextension->columns[] = array(
		"Name" => "EmailAddress", 
		"FieldType" => "EmailAddress", 
		"IsPrimaryKey" => true,
		"IsRequired" => true
	);
	$dataextension->columns[] = array(
		"Name" => "FullName", 
		"FieldType" => "Text",
		"MaxLength" => "50", 
		"IsRequired" => false
	);
	$dataextension->columns[] = array(
		"Name" => "hasAppInstalled", 
		"FieldType" => "Boolean",
		"IsRequired" => false,
	);

	echo("Creating the Data Extension.\n------\n");
	$response = $dataextension->post();
	echo("[{$response->results[0]->StatusCode}]: {$response->results[0]->StatusMessage}\n");

	/*************
	 * Add customer data to the Data Extension
	 * ***********/

	$deRow = new ET_DataExtension_Row();
	$deRow->authStub = $myclient;

	// specify the name of the data extension
	$deRow->Name= $dataExtensionName;	

	// specify the values of the data extension row
	$deRow->props = array(
		"EmailAddress" => $customerEmail, 
		"FullName" => $customerFullName
	);

	echo("Adding Customer to the Data Extension.\n------\n");
	$response = $deRow->post();
	echo("[{$response->results[0]->StatusCode}]: {$response->results[0]->StatusMessage}\n");

	/*************
	 * Create the Emails
	 * ***********/

	/*

	$email1= new ET_Email();
	$email1->authStub = $myclient;
	$email1->props = array(
		"CustomerKey" => $email_one_name, 
		"Name"=>$email_one_name,
		"Subject"=>"Welcome to the Platform!", 
		"HTMLBody"=> $email_one_html,
		"EmailType" => "HTML", 
		"IsHTMLPaste" => "true"
	);
	echo("Creating Email 1.\n------\n");
	$response = $email1->post();
	echo("[{$response->results[0]->StatusCode}]: {$response->results[0]->StatusMessage}\n");

	$email2= new ET_Email();
	$email2->authStub = $myclient;
	$email2->props = array(
		"CustomerKey" => $email_two_name, 
		"Name"=>$email_two_name,
		"Subject"=>"Our Mobile App generates kittens!", 
		"HTMLBody"=> $email_two_html,
		"EmailType" => "HTML", 
		"IsHTMLPaste" => "true"
	);
	
	echo("Creating Email 2.\n------\n");
	$response = $email2->post();	
	echo("[{$response->results[0]->StatusCode}]: {$response->results[0]->StatusMessage}\n");


?>
