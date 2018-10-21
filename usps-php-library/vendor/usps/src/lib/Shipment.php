<?php
namespace Usps\lib;
use Usps\curl\Request;


class Shipment {


	protected static $to_address = array();
	protected static $from_address = array();
	protected static $response = array();
	protected static $lablePath = '';



	public function __construct()
	{

	}


	 /**
     * create a shipment
     *
     * @param mixed  $params
     * @param string $apiUserName
     * @param string $apiPassword
     * @return mixed
     */
    public static function create($params = null, $apiUserName = null, $apiPassword = null)
    {

    	$xml = self::_create($params,usps::$apiUspsPermit, usps::$apiUserName, usps::$apiPassword);
    	self::$lablePath = $params['path'];
    	$requestor = new Request();
    	$result = $requestor->request(usps::$apiBase,'API=MerchandiseReturnV4&XML=',$xml);
   
        return self::_response($result);
    }

   	/**
     * create a shipment process
     *
     * @param mixed  $params
     * @param string $apiUserName
     * @param string $apiPassword
     * @return mixed
     */
    public static function _create($params = null,$apiUspsPermit=null, $apiUserName = null, $apiPassword = null)
    {
    	self::$to_address = $params['to_address'];
    	self::$from_address = $params['from_address'];
    	$customer = self::_customer();
    	$retailer = self::_retailer($apiUspsPermit);
    	$package = self::_packageDeliver();
		$xml = '<EMRSV4.0Request USERID="' . $apiUserName . '" PASSWORD="' . $apiPassword . '">';
		$xml .= $customer;
		$xml .= $retailer;
		$xml .= $package;

		$xml .= '<ServiceType>First Class Package Service</ServiceType>
	            <DeliveryConfirmation>False</DeliveryConfirmation>
	            <InsuranceValue />
	            <MailingAckPackageID></MailingAckPackageID>
	            <WeightInPounds>0</WeightInPounds>
	            <WeightInOunces>10</WeightInOunces>
	            <RMA>RMA 123456</RMA>
	            <RMAPICFlag>False</RMAPICFlag>
	            <ImageType>PDF</ImageType>';

        if(isset($params['email']) && $params['email']== TRUE){
        	$xml .=self::_getEmailParam();
        }
		

		$xml .= '<RMABarcode>True</RMABarcode>
            <AllowNonCleansedDestAddr>False</AllowNonCleansedDestAddr>';

		$xml .= '</EMRSV4.0Request>';


        return $xml;
    }

    public static function _customer(){

    	$xml = '<Option>RIGHTWINDOW</Option>
	            <CustomerName>' . self::$from_address['name'] . '</CustomerName>
	            <CustomerAddress1>' .self::$from_address['address2'] . '</CustomerAddress1>
	            <CustomerAddress2>' . self::$from_address['address1'] . '</CustomerAddress2>
	            <CustomerCity>' . self::$from_address['city']. '</CustomerCity>
	            <CustomerState>' .self::$from_address['state'] . '</CustomerState>
	            <CustomerZip5>' . self::$from_address['zip1'] . '</CustomerZip5>
	            <CustomerZip4 />';

	    return $xml;

    }

    public static function _retailer($apiUspsPermit){

    	$xml = '<RetailerName>' . self::$to_address['name'] . '</RetailerName>
	            <RetailerAddress>' . self::$to_address['address1'] . '</RetailerAddress>
	            <PermitNumber>' . $apiUspsPermit . '</PermitNumber>
	            <PermitIssuingPOCity>' . self::$to_address['city'] . '</PermitIssuingPOCity>
	            <PermitIssuingPOState>' . self::$to_address['state'] . '</PermitIssuingPOState>
	            <PermitIssuingPOZip5>' . self::$to_address['zip1'] . '</PermitIssuingPOZip5>';
        return $xml;
    	
    }
    public static function _packageDeliver(){
    	$xml = '';
    	$zip2 = isset(self::$to_address['zip2']) ? self::$to_address['zip2'] : '';
    	if(!empty(self::$to_address)):
    	$xml .= '<PDUPOBox>' . self::$to_address['address1'] . '</PDUPOBox>
	            <PDUCity>' . self::$to_address['city'] . '</PDUCity>
	            <PDUState>' . self::$to_address['state'] . '</PDUState>
	            <PDUZip5>' . self::$to_address['zip1'] . '</PDUZip5>
	            <PDUZip4>' . $zip2 . '</PDUZip4>';
	    endif;
        return $xml;
    	
    }

   	public static function _getEmailParam(){
   		

   		$xml ='<SenderName>'.self::$to_address['name'].'</SenderName>
            <SenderEMail>'.self::$to_address['email'].'</SenderEMail>
            <RecipientName>'.self::$from_address['name'].'</RecipientName>
            <RecipientEMail>'.self::$from_address['email'].'</RecipientEMail>';
      
        return $xml;
    	
    }

    protected static function _response($response)
    {
    	$result = array();

    	$xml_response = new \SimpleXMLElement($response);
    	$xml_to_array = self::simpleXmlToArray($xml_response);

    	$string = base64_decode($xml_to_array['MerchandiseReturnLabel']);
	   if ($string) {
	       $filename = time().'-usps-label.pdf';
	       $pdf_file = fopen(self::$lablePath.'/'.$filename, "w");
	       fwrite($pdf_file, $string);
	       fclose($pdf_file);
	      $result = array(
	      		'success'=>true,
	      		'shipping_label'=>$filename,
	            'merchandise_return_number'=>$xml_to_array['MerchandiseReturnNumber']
	       	);
	   } else {
	       $result =  array('success'=>false,'message'=>$xml_to_array['Description']);
	   }

       return self::$response = $result;
    }

    /**
	 * Convert a SimpleXML object to an associative array
	 *
	 * @param object $xmlObject
	 *
	 * @return array
	 * @access public
	 */
	public static function simpleXmlToArray($xmlObject)
	{
	    $array = [];
	    foreach ($xmlObject->children() as $node) {
	        $array[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
	    }
	    return $array;
	}


}