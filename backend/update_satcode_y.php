
 <?php
 header('Content-Type:application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: PUT');
 header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
 $data = json_decode(file_get_contents('php://input'),true);

 include 'conn.php';

 
  $sql = "UPDATE satcode
  SET marky = 'y'
  WHERE marky = '' ";





$return_arr = array();

if ($conn->query($sql) === TRUE) {
	
	
		$row_array['message'] = "อัพโหลดข้อมูลสำเร็จ";
		array_push($return_arr,$row_array);
	
        
        
	
} else {
	$row_array['message'] =  "ไม่สามารถอัพโหลดข้อมูลได้ " ;
	array_push($return_arr,$row_array);
}


mysqli_close($conn);

echo json_encode($return_arr);


?>