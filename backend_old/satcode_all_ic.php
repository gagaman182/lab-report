<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
 hn ,
prename ,
fullname ,
tel ,
risk ,
satcode,
DATE_FORMAT(dateadd,'%d-%m-%Y') as dateadd,
other 
 FROM
  satcode
 where 
 marky = 'y'
 and dateadd >= DATE_FORMAT(now(),'%Y-%m-%d')


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
