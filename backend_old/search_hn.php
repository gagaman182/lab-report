<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
  $hn = $_GET["hn"];
//  $hn = '1/49';



$data=array();

$strSQL  = "SELECT
prename,
name,
SURNAME as surname,
name ||' '|| SURNAME as fullname,
mobile as tel 
FROM
PATIENTS
where HN like  '".$hn."'

	
";
//and DISEASE_WAREHOUSE.HN = '".$hn."'

$objParse = oci_parse ($objConnect, $strSQL);
oci_execute($objParse,OCI_DEFAULT);
while($rs_pmk=oci_fetch_array($objParse,OCI_BOTH)){


	$a['prename']=$rs_pmk[0];
	$a['name']=$rs_pmk[1];
	$a['surname']=$rs_pmk[2];
	$a['fullname']=$rs_pmk[3];
	$a['tel']=$rs_pmk[4];

	
	


	
	array_push($data,$a);
}	
	
// $data_array2 = array("data" => $data);

echo json_encode($data);

oci_close($objConnect);





?>
