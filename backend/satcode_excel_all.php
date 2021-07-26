<?php
	 header('Access-Control-Allow-Origin: *');
   
	 include 'conn.php';

 

 $sql = "SELECT
 hn as HN,
prename as 'คำนำหน้าชื่อ',
fullname as 'ชื่อ-สกุล',
tel as 'เบอร์โทร',
risk as 'ความเสี่ยง',
satcode as 'SAT CODE',
DATE_FORMAT(dateadd,'%d-%m-%Y') as 'วันที่ตรวจ',
other as 'ช่วงเวลา'
 FROM
  satcode
 where 
 marky = 'y'

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
