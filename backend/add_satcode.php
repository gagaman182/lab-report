<?php
 header('Content-Type:application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: PUT');
 header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
 $data = json_decode(file_get_contents('php://input'),true);

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





 // หา record ล่าสุด
// $sql = "SELECT max(id) as total from pui";
 
// if ($result = mysqli_query( $conn, $sql )){
  
//    while ($row = mysqli_fetch_assoc($result)) {

//      $id=$row['total']+1;
//  }
// }




if (!empty($hn)) {
 

    
       $strvisit  = "  INSERT INTO satcode(hn,prename,fullname,tel,risk,satcode,
       type_code,day_code,name_code,number_code,other,dateadd,dateinsert) 
        VALUES('".$hn."','".$prename."','".$fullname."','".$tel."','".$risk."','".$satcode."',
        '".$type_code."','".$day_code."','".$name_code."','".$number_code."','".$other."','".$dateadd."',CURRENT_TIMESTAMP)";
        
        
        
        if ($conn->query($strvisit) === TRUE) {
          
            
            $return_message = array();
            $row_array['message'] = "เพิ่มข้อมูลสำเร็จ";
            array_push($return_message,$row_array);
        
        
        } else {
           
            $return_message = array();
            $row_array['message'] = "เพิ่มข้อมูลไม่สำเร็จ";
            array_push($return_message,$row_array);
            
        }


      }
      
mysqli_close($conn);
	
echo json_encode($return_message);

?>