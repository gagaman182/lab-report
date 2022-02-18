<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
 DATE_FORMAT(dateadd,'%d/%m') as dateadd,
count(case when risk.riskid = '1' THEN satcode.id end )as risk1,
count(case when risk.riskid = '2' THEN satcode.id end )as risk2,
count(case when risk.riskid = '3' THEN satcode.id end )as risk3,
count(case when risk.riskid = '4' THEN satcode.id end )as risk4,
count(case when risk.riskid = '5' THEN satcode.id end )as risk5
FROM
 satcode
INNER JOIN risk on satcode.risk = risk.riskname
WHERE
 dateadd >= '2021-05-03'
GROUP BY
 DATE_FORMAT(dateadd,'%d/%m')
ORDER BY  DATE_FORMAT(dateadd,'%d/%m') desc
limit 30
";


$return_arr = array();

if ($result = mysqli_query( $conn, $sql )){
    while ($row = mysqli_fetch_assoc($result)) {
	
     array_push($return_arr,$row);
   }
 }

mysqli_close($conn);

echo json_encode($return_arr);








?>
