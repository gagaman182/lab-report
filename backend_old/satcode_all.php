<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
*
FROM
 satcode
where 
marky = 'y'
order by id desc

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
