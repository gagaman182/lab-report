
<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
//  $ipddetail = $_GET["ipddetail"];
//  if($ipddetail == 'ipdall'){

  $sqlipd = "SELECT * from (
    SELECT 
    TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY') AS DATETIME,
    count(CASE WHEN LABRESULT.CHARACTER_RESULT = 'Not Detected' THEN OFH_LIKE.HN END) AS no_covid,
    count(CASE WHEN LABRESULT.CHARACTER_RESULT <> 'Not Detected' THEN OFH_LIKE.HN END) AS yes_covid,
    count(OFH_LIKE.HN) as all_covid
    
    
    FROM
      LAB_FINANCE_DETAILS
    INNER JOIN OFH_LIKE ON LAB_FINANCE_DETAILS.OFH_OPD_FINANCE_NO = OFH_LIKE.OPD_FINANCE_NO
    inner join PATIENTS on OFH_LIKE.hn = PATIENTS.hn
    INNER JOIN LABCODES ON LAB_FINANCE_DETAILS.LAB1_LABCODE = LABCODES.LABCODE
    INNER JOIN PLACES ON OFH_LIKE.PLA_PLACECODE = PLACES.PLACECODE
    left join LABRESULT on  LAB_FINANCE_DETAILS.OFH_OPD_FINANCE_NO = LABRESULT.OFH_OPD_FINANCE_NO and LAB_FINANCE_DETAILS.LAB1_LABCODE = LABRESULT.lab1_labcode 
    INNER JOIN LABCODE_DETAIL ON LABRESULT.LABCODE_DETAIL_CODE = LABCODE_DETAIL.LABCODE_DETAIL_CODE
    
    WHERE
        LABRESULT.LAB1_LABCODE IN (
    'VI020-F'
        
      )
    
    
    
    
    GROUP BY TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY')
    ORDER BY TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY'))LAB
    where ROWNUM < 15
   





    
    
    
    
    

  
  
  ";





$data=array();

$strSQL  = $sqlipd;
//and DISEASE_WAREHOUSE.HN = '".$hn."'

$objParse = oci_parse ($objConnect, $strSQL);
oci_execute($objParse,OCI_DEFAULT);
while($rs_pmk=oci_fetch_array($objParse,OCI_BOTH)){


	$a['datetime']=$rs_pmk[0];
  $a['no_covid']=intval($rs_pmk[1]);
  $a['yes_covid']=intval($rs_pmk[2]);
  $a['all_covid']=intval($rs_pmk[3]);
 
	
	


	
	array_push($data,$a);

	
}	
	
// $data_array2 = array("data" => $data);

echo json_encode($data);



oci_close($objConnect);





?>