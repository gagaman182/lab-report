<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
// $opdno = $_GET["opdno"];




$data=array();

$strSQL  = "SELECT 


TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD') as dates,
to_char('ตรวจทั้งหมด = ' || count(OFH_LIKE.OPD_FINANCE_NO) ||' ราย / '|| '  พบเชื้อ = ' || COUNT(case when LABRESULT.CHARACTER_RESULT LIKE '%ORF%'  THEN OFH_LIKE.OPD_FINANCE_NO END )|| ' ราย' ) as title


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
   
group BY TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD')
order by TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD')













	
";
//and DISEASE_WAREHOUSE.HN = '".$hn."'

$objParse = oci_parse ($objConnect, $strSQL);
oci_execute($objParse,OCI_DEFAULT);
while($rs_pmk=oci_fetch_array($objParse,OCI_BOTH)){


	$a['date']=$rs_pmk[0];
    $a['title']=$rs_pmk[1];
    

   

	
	
	
	


	
	array_push($data,$a);
}	
	
// $data_array2 = array("data" => $data);

echo json_encode($data);

oci_close($objConnect);





?>
