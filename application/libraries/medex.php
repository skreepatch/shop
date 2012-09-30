<?php

class Medex {

    function uploadOrder($order = NULL) {

	$client = new SoapClient("http://api.medexltd.com/webservice.wsdl", array('trace' => 1));
	$objAuth = new stdClass();
	$objAuth->username = 'bkingtiger';
	$objAuth->password = 'kdsjiew38jd3e8';

	$objOrder = new stdClass();
	$objOrder->authentication = $objAuth; // authorization
	$objOrder->order_customer = $order->fullname; // customer's First & Last Name
	$objOrder->order_country = $order->country; // customer's country
	$objOrder->order_address = $order->address; // Delivery address
	$objOrder->order_number = $order->id; // Your system order ID
	$objOrder->order_city = $order->city; // delivery city
	$objOrder->order_state = isset($order->state) ? $order->state : '-'; // if appropriate -  input a state for delivery. if not appropriate equals to '-'(dash)
	$objOrder->order_zip = $order->zip; // delivery address Zip code
	$objOrder->shipping_id = $order->shipping_id; // shipping method ID

	$objRequest->products = array(); //array() create products array
	foreach ($order->orderitem->get() as $product) {
	    $objProduct = new stdClass(); // create object for a product
	    $objProduct->product_id = $product->id; // product ID
	    $objProduct->quantity = $product->quantity; // quantity
	    $objOrder->products[] = $objProduct; // add a product to the order
	}
	$response = $client->sendOrder($objOrder);
	if (false == is_soap_fault($response)) {
	    return TRUE;
	} else {
	    echo "error code: " . $response->faultstring . "<br>";
	    echo "error message: " . $response->detail . "<br>";
	}
    }
    
    function reShippment($order = NULL, $comment = NULL){
	$client = new SoapClient("http://api.medexltd.com/webservice.wsdl", array('trace' => 1));

	$objAuth = new stdClass();
	$objAuth->username = 'bkingtiger';
	$objAuth->password = 'kdsjiew38jd3e8';

	$objReship = new stdClass();
	$objReship->authentication = $objAuth;
	$objReship->order_number = $order->id;
	$objReship->comment = $comment;
	$response = $client->reshipOrder($objReship);
	if(false == is_soap_fault($response)){
		   print_r($response);
	}else{
		   echo   "error code: " . $response->faultcode . "<br>";
		   echo   "error message: " . $response->faultstring . "<br>";
	}
    }

    function requestTracking(){
	$client = new SoapClient("http://api.medexltd.com/webservice.wsdl", array('trace' => 1));

        $objAuth = new stdClass();
	$objAuth->username = 'bkingtiger';
	$objAuth->password = 'kdsjiew38jd3e8';

        $objData = new stdClass();
        $objData->authentication = $objAuth;
        $objData->order_number = 'номер заказа';
                $response = $client->getTrackings($objData);
        if(false == is_soap_fault($response)){

             print_r($response);

        }else{

             echo "error code: " . $response->faultstring . "<br>";

             echo "error message: " . $response->detail . "<br>";

        }
    }
    
    function onlineCheckup($track_id){
	$client = new SoapClient("http://api.medexltd.com/webservice.wsdl", array('trace' => 1));

	$objAuth = new stdClass();
	$objAuth->username = 'bkingtiger';
	$objAuth->password = 'kdsjiew38jd3e8';

	$objTrack = new stdClass();
	$objTrack->authentication = $objAuth;
	$objTrack->tracking_id = $track_id;
	$response = $client->checkTrackNow($objTrack);
	if(false == is_soap_fault($response)){
		   print_r($response);
	}else{
		   echo   "error code: " . $response->faultcode . "<br>";
		   echo   "error message: " . $response->faultstring . "<br>";
	}
    }
    
}