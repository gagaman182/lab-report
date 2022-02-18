<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
// $opdno = $_GET["opdno"];




$data=array();

$strSQL  = "SELECT * FROM (
	SELECT 
	
	
	TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD') as dates,
	to_char('RTPCR ตรวจทั้งหมด = ' || count(OFH_LIKE.OPD_FINANCE_NO) ||' ราย / '|| '  พบเชื้อ = ' || COUNT(case when LABRESULT.CHARACTER_RESULT LIKE '%ORF%' 
	or LABRESULT.CHARACTER_RESULT LIKE 'Detected' 
	
	
	
	 THEN OFH_LIKE.OPD_FINANCE_NO END )|| ' ราย  ' ) as title ,
	'#5089C6' as color
	
	
	
	
	
	
	
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
	'VI020-F',
	'VI022',
	'VI025'
			
		)
	   
	group BY TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD')
	
	UNION
	
	SELECT 
	
	
	TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD') as dates,
	to_char('ATK ตรวจทั้งหมด = ' || count(OFH_LIKE.OPD_FINANCE_NO) ||' ราย / '|| '  พบเชื้อ = ' || COUNT(case when LABRESULT.CHARACTER_RESULT LIKE 'Positive' 
	or LABRESULT.CHARACTER_RESULT LIKE 'Detected' 
	
	 THEN OFH_LIKE.OPD_FINANCE_NO END )|| ' ราย ' ) as title,
	'#34BE82' as color
	
	
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
	'VI23',
	'VI023',
	'VI24'
			
		)
	   
	group BY TO_CHAR(OFH_LIKE.DATETIME,'YYYY-MM-DD')) LAB_COVIDS
	ORDER BY LAB_COVIDS.DATES
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	












	
";
//and DISEASE_WAREHOUSE.HN = '".$hn."'

$objParse = oci_parse ($objConnect, $strSQL);
oci_execute($objParse,OCI_DEFAULT);
while($rs_pmk=oci_fetch_array($objParse,OCI_BOTH)){


	$a['date']=$rs_pmk[0];
    $a['title']=$rs_pmk[1];
	$a['color']=$rs_pmk[2];
    

   

	
	
	
	


	
	array_push($data,$a);
}	
	
// $data_array2 = array("data" => $data);

echo json_encode($data);

oci_close($objConnect);





?>
