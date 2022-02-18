
 <?php
 header('Content-Type:application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: PUT');
 header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
 $data = json_decode(file_get_contents('php://input'),true);
 $id = $data['id'];
 $hn = $data['hn'];
 $prename = $data['prename'];
 $fullname = $data['fullname'];
 $tel = $data['tel'];
 $risk = $data['risk'];
 $satcode = $data['satcode'];
 $type_code = $data['type_code'];
 $day_code = $data['day_code'];
 $name_code = $data['name_code'];
 $number_code = $data['number_code'];
 $other = $data['other'];
 $dateadd = $data['dateadd'];

 include 'conn.php';

 
  $sql = "UPDATE satcode
SET hn = '" . $hn ."',
prename = '" . $prename ."',
fullname = '" . $fullname ."',
tel = '" . $tel ."',
risk = '" . $risk ."',
satcode = '" . $satcode ."',
type_code = '" . $type_code ."',
day_code = '" . $day_code ."',
name_code = '" . $name_code ."',
number_code = '" . $number_code ."',
other = '" . $other ."',
dateadd = '" . $dateadd ."',
dateupdate = CURRENT_TIMESTAMP


WHERE id = '" . $id ."' ";





$return_arr = array();

if ($conn->query($sql) === TRUE) {
	
	
		$row_array['message'] = "แก้ไขข้อมูลสำเร็จ";
		array_push($return_arr,$row_array);
	
        
        
	
} else {
	$row_array['message'] =  "ไม่สามารถแก้ไขข้อมูลได้ " ;
	array_push($return_arr,$row_array);
}


mysqli_close($conn);

echo json_encode($return_arr);


?>