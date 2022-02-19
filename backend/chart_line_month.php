
<?php
	 header('Access-Control-Allow-Origin: *');
   

include 'connect.php';
  $chartbtn = $_GET["chartbtn"];
  if($chartbtn == 'days'){

  $sqlipd = "select * from (
    SELECT * from (
        SELECT * from (
            SELECT 
            TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY') AS DATETIME,
              count(CASE WHEN LABRESULT.CHARACTER_RESULT not LIKE 'Detected' THEN OFH_LIKE.HN
WHEN LABRESULT.CHARACTER_RESULT not LIKE '%ORF%' and  TO_CHAR(OFH_LIKE.DATETIME,'yyyy/mm/dd') < '2021/11/08'   THEN OFH_LIKE.HN
 END) AS no_covid,
            
 
            count(CASE WHEN LABRESULT.CHARACTER_RESULT LIKE 'Detected'  THEN OFH_LIKE.HN
WHEN LABRESULT.CHARACTER_RESULT LIKE '%ORF%' and  TO_CHAR(OFH_LIKE.DATETIME,'yyyy/mm/dd') < '2021/11/08'  THEN OFH_LIKE.HN
 END) AS yes_covid,
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
            'VI020-F',
'VI022',
'VI025'
                
              )
            
            
            
            
            GROUP BY TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY')
            ORDER BY TO_CHAR(OFH_LIKE.DATETIME,'DD-MM-YY') asc)LAB
          
        
            ORDER BY TO_DATE(LAB.DATETIME,'DD-MM-YY') desc)z
        where ROWNUM <= 15)ee
    ORDER BY TO_DATE(ee.DATETIME,'DD-MM-YY') asc
        
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
  }elseif($chartbtn ==  'weeks'){	
    $sqlipd = "SELECT * from (
      SELECT 
                 to_char(OFH_LIKE.DATETIME,'WW') AS DATETIME,
                   count(CASE WHEN LABRESULT.CHARACTER_RESULT not LIKE 'Detected' THEN OFH_LIKE.HN
     WHEN LABRESULT.CHARACTER_RESULT not LIKE '%ORF%' and  TO_CHAR(OFH_LIKE.DATETIME,'yyyy/mm/dd') < '2021/11/08'   THEN OFH_LIKE.HN
      END) AS no_covid,
                 
      
                 count(CASE WHEN LABRESULT.CHARACTER_RESULT LIKE 'Detected'  THEN OFH_LIKE.HN
     WHEN LABRESULT.CHARACTER_RESULT LIKE '%ORF%' and  TO_CHAR(OFH_LIKE.DATETIME,'yyyy/mm/dd') < '2021/11/08'  THEN OFH_LIKE.HN
      END) AS yes_covid,
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
                 'VI020-F',
                 'VI022',
                 'VI025'
                     
                   )
                 
                 
                 
                 
                 GROUP BY    to_char(OFH_LIKE.DATETIME,'WW')
      ORDER BY  to_char(OFH_LIKE.DATETIME,'WW') desc )lab_week 
     where rownum <= 14
     ORDER BY datetime asc
     
          
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
  }
	
// $data_array2 = array("data" => $data);

echo json_encode($data);



oci_close($objConnect);





?>
