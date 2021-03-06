<?php

require "../../mpgClasses.php";

/************************ Request Variables **********************************/

$store_id='monusqa002';
$api_token='qatoken';

/************************ Transaction Variables ******************************/

$orderid='ord-'.date("dmy-G:i:s");
$amount='1.00';
$custid = 'my cust id';

/************************ Transaction Array **********************************/

$txnArray=array(type=>'ach_debit',  
         		order_id=>$orderid,
         		cust_id=>$custid,
         		amount=>$amount
          		);

/************************** ACH Info Variables *****************************/

$sec = 'ppd';
$cust_first_name = 'Bob';
$cust_last_name = 'Smith';
$cust_address1 = '101 Main St';
$cust_address2 = 'Apt 102';
$cust_city = 'Chicago';
$cust_state = 'IL';
$cust_zip = '123456';
$routing_num = '490000018';
$account_num = '23456';
$check_num = '100';
$account_type = 'savings';

/********************** ACH Info Associative Array *************************/

$achTemplate = array(
		     		 sec =>$sec,
                     cust_first_name => $cust_first_name,
                     cust_last_name => $cust_last_name,
                     cust_address1 => $cust_address1,
                     cust_address2 => $cust_address2,
                     cust_city => $cust_city,
                     cust_state => $cust_state,
                     cust_zip => $cust_zip,
                     routing_num => $routing_num,
                     account_num => $account_num,
                     check_num => $check_num,
                     account_type => $account_type
                    );

/************************** ACH Info Object ********************************/

$mpgAchInfo = new mpgAchInfo ($achTemplate);

/************************** Recur Variables *****************************/

$recurUnit = 'day';
$startDate = '2015/11/30';
$numRecurs = '4';
$recurInterval = '10';
$recurAmount = '31.00';
$startNow = 'true';

/****************************** Recur Array **************************/

$recurArray = array(recur_unit=>$recurUnit,  // (day | week | month)
					start_date=>$startDate, //yyyy/mm/dd
					num_recurs=>$numRecurs,
					start_now=>$startNow,
					period => $recurInterval,
					recur_amount=> $recurAmount
					);

/****************************** Recur Object **************************/

$mpgRecur = new mpgRecur($recurArray);

/************************ Transaction Object *******************************/

$mpgTxn = new mpgTransaction($txnArray);

/************************ Set ACH Info *************************************/

$mpgTxn->setAchInfo($mpgAchInfo);

/****************************** Set Recur Object **********************/

$mpgTxn->setRecur($mpgRecur);

/************************ Request Object **********************************/

$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("US"); //"CA" for sending transaction to Canadian environment
$mpgRequest->setTestMode(true); //false or comment out this line for production transactions

/************************ mpgHttpsPost Object ******************************/

$mpgHttpPost = new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/************************ Response Object **********************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();


print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());
print("\nRecurSuccess = " . $mpgResponse->getRecurSuccess());

?>
