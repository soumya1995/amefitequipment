<?php
/*
Unishippers PriceLink API - Sample Code

Copyright 2007-2009, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
*/
 
function getDomesticXMLRequest(
	$userName,
	$userPassword,
	$requestKey,
	$upsAccountNumber,
	$unishippersCustomerNumber,
	$senderState,
	$senderZip,
	$senderCountry,
	$receiverState,
	$receiverZip,
	$receiverCountry,
	$packageType,
	$dimLength,
	$dimWidth,
	$dimHeight,
	$weight,
	$specialServices,
	$serviceType,
	$cod,
	$declaredValue,
	$shipDate)
{
       $output = $output . "<unishippersdomesticraterequest>"
	   . "<username>$userName</username>"
	   . "<password>$userPassword</password>"
	   . "<requestkey>$requestKey</requestkey>"
	   . "<upsaccountnumber>$upsAccountNumber</upsaccountnumber>"
        . "<unishipperscustomernumber>$unishippersCustomerNumber</unishipperscustomernumber>"
        . "<service>$serviceType</service>"
        . "<packagetype>$packageType</packagetype>"
        . "<weight>$weight</weight>"
        . "<length>$dimLength</length>"
        . "<width>$dimWidth</width>"
        . "<height>$dimHeight</height>";
		
		 if($declaredValue > 0.00) {
        	$output = $output . "<declaredvalue>$declaredValue</declaredvalue>";
		}
        
        $output = $output . "<fees>";
		foreach ($specialServices as $specialService) {
		 $output = $output . "<fee>$specialService</fee>";
		}
        $output = $output . "</fees>"
        . "<shipdate>$shipDate</shipdate>";
        
        if($cod > 0.00) {
        	$output = $output . "<cod>$cod</cod>";
		}
        
         $output = $output . "<senderstate>$senderState</senderstate>"
		 . "<senderzip>$senderZip</senderzip>"
        . "<sendercountry>$senderCountry</sendercountry>"
        . "<receiverstate>$receiverState</receiverstate>"
        . "<receivercountry>$receiverCountry</receivercountry>"
        . "<receiverzip>$receiverZip</receiverzip>"
        . "</unishippersdomesticraterequest>";
       
		return $output;
}
	
function getInternationalXMLRequest(
	$userName,
	$userPassword,
	$requestKey,
	$upsAccountNumber,
	$unishippersCustomerNumber,
	$packageType,
	$dimLength,
	$dimWidth,
	$dimHeight,
	$weight,
	$serviceType,
	$declaredValue,
	$shipDate,
	$senderState,
	$senderZip,
	$senderCountry,
	$receiverState,
	$receiverZip,
	$receiverCountry)
{
	$output = $output . "<unishippersinternationalraterequest>"
		. "<username>$userName</username>"
		. "<password>$userPassword</password>"
		. "<requestkey>$requestKey</requestkey>"
		. "<upsaccountnumber>$upsAccountNumber</upsaccountnumber>"
		. "<unishipperscustomernumber>$unishippersCustomerNumber</unishipperscustomernumber>"
		. "<service>$serviceType</service>"
		. "<packagetype>$packageType</packagetype>"
		. "<weight>$weight</weight>"
		. "<length>$dimLength</length>"
		. "<width>$dimWidth</width>"
		. "<height>$dimHeight</height>";
		
		if($declaredValue > 0.00) {
        	$output = $output . "<declaredvalue>$declaredValue</declaredvalue>";
		}
		
		$output = $output . "<shipdate>$shipDate</shipdate>"
		. "<sendercountry>$senderCountry</sendercountry>"
		. "<senderstate>$senderState</senderstate>"
		. "<senderzip>$senderZip</senderzip>"
		. "<receiverstate>$receiverState</receiverstate>"
        . "<receivercountry>$receiverCountry</receivercountry>"
        . "<receiverzip>$receiverZip</receiverzip>"
		. "</unishippersinternationalraterequest>";
        
        return $output;
}

function sendToHost($host,$method,$path,$data,$useragent=0)
{
    // Supply a default method of GET if the one passed was empty
    if (empty($method)) {
        $method = 'GET';
    }
    $method = strtoupper($method);
    $fp = fsockopen($host, 80);
    if ($method == 'GET') {
        $path .= '?' . $data;
    }
    fputs($fp, "$method $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp,"Content-type: application/x-www-form- urlencoded\r\n");
    fputs($fp, "Content-length: " . strlen($data) . "\r\n");
    if ($useragent) {
        fputs($fp, "User-Agent: MSIE\r\n");
    }
    fputs($fp, "Connection: close\r\n\r\n");
    if ($method == 'POST') {
        fputs($fp, $data);
    }

    while (!feof($fp)) {
        $buf .= fgets($fp,128);
    }
    fclose($fp);
    return $buf;
}

function httppost($host = "uone-price.unishippers.com",$path = "/price/pricelink",$postdata = "") { 
	$output = "";
      // open the host 
	
    $fp = fsockopen($host, 80, $errno, $errstr, 200);  
     
    if( !$fp ) { 
        print "$errstr ($errno)<br>\n"; 
	} else {
        fputs( $fp, "POST $path HTTP/1.0\n"); 
        fputs( $fp, "Accept: */*\n"); 
        fputs( $fp, "Accept: image/gif\n"); 
        fputs( $fp, "Accept: image/x-xbitmap\n"); 
        fputs( $fp, "Accept: image/jpeg\n"); 
    
        
		$strlength = strlen( $postdata);
		fputs( $fp,"Content-type: application/x-www-form-urlencoded\n"); 
		fputs( $fp, "Content-length: ".$strlength."\n\n"); 
		fputs( $fp, $postdata."\n"); 
		fputs( $fp, "\n" , 1); 
		
		while( !feof( $fp ) ) { 
			$output .= fgets( $fp, 4096); 
		} 
	        
		
		fclose( $fp); 
	}  
	return $output;
 }  

 
$specials = array('REP','SUR');
$dRateRequest = getDomesticXMLRequest("testups","testups","testing","123UPS","U1236822371","OR","97124","US","UT","84107","US","P",0,0,0,1,$specials,"ALL",100,101,"2009-06-09");
echo '<div><xmp>' . $dRateRequest . '</xmp></div>';

$dRateResponse = sendToHost('uone-price.unishippers.com', 'post','/price/pricelink',$dRateRequest);
if($dRateResponse)
{
	echo '<div><xmp>' . $dRateResponse . '</xmp></div>';
	$pos1 = stripos($dRateResponse, '<');

	$dRateResponse = substr($dRateResponse,$pos1);
	$xmldoc = DOMDocument::loadXML($dRateResponse);
	$xsldoc = new DOMDocument();
	$xsldoc->load('domesticresponse.xsl');

	$proc = new XSLTProcessor();
	$proc->registerPHPFunctions();
	$proc->importStyleSheet($xsldoc);
	echo $proc->transformToXML($xmldoc);
}

/*$iRateRequest = getInternationalXMLRequest(	"testups","testups","testing","123UPS","U1236822371","P",0,0,0,1,"ALL",100,"2009-06-09","UT","84107","US","AB","T2G3C3","CA");
echo '<div style="clear:both;"><xmp>' . $iRateRequest . '</xmp></div>';
$iRateResponse = sendToHost('uone-price.unishippers.com', 'post','/price/pricelink',$iRateRequest);
if($iRateResponse)
{
	echo '<div style="clear:both;"><xmp>' . $iRateResponse . '</xmp></div>';
	$pos1 = stripos($iRateResponse, '<');
	$iRateResponse = substr($iRateResponse,$pos1);
	$ixmldoc = DOMDocument::loadXML($iRateResponse);
	$ixsldoc = new DOMDocument();
	$ixsldoc->load('internationalresponse.xsl');

	$iproc = new XSLTProcessor();
	$iproc->registerPHPFunctions();
	$iproc->importStyleSheet($ixsldoc);
	echo $iproc->transformToXML($ixmldoc);
}*/

 
?> 