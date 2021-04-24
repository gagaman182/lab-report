<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
// $opdno = $_GET["opdno"];




$data=array();

$strSQL  = "SELECT DISTINCT
OFH_LIKE.HN,
case when PATIENTS.ID_CARD is null then '-'  
when PATIENTS.ID_CARD is not null then PATIENTS.ID_CARD  end as  ID_CARD,
TO_CHAR(CONCAT(CONCAT(PATIENTS.PRENAME,PATIENTS.NAME),CONCAT(' ',PATIENTS.SURNAME))) AS FULLNAME,
OFH_LIKE.OPD_FINANCE_NO,
TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YYYY') as DATETIME,
LABCODE_DETAIL.LABCODE_DETAIL_CODE,
LABCODE_DETAIL.NAME,
LABRESULT.CHARACTER_RESULT


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
   

    order by OFH_LIKE.OPD_FINANCE_NO desc







	
";
//and DISEASE_WAREHOUSE.HN = '".$hn."'

$objParse = oci_parse ($objConnect, $strSQL);
oci_execute($objParse,OCI_DEFAULT);
while($rs_pmk=oci_fetch_array($objParse,OCI_BOTH)){


	$a['HN']=$rs_pmk[0];
    $a['ID_CARD']=$rs_pmk[1];
    $a['FULLNAME']=$rs_pmk[2];
    $a['OPD_FINANCE_NO']=$rs_pmk[3];
    $a['DATETIME']=$rs_pmk[4];
    $a['LABCODE_DETAIL_CODE']=$rs_pmk[5];
    $a['NAME']=$rs_pmk[6];
    $a['result']=$rs_pmk[7];

   

	
	
	
	


	
	array_push($data,$a);
}	
	
// $data_array2 = array("data" => $data);

echo json_encode($data);

oci_close($objConnect);





?>
