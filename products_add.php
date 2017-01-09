<?php 
ob_start();
session_start();
if ($_SESSION){ 
		if ($_SESSION['email']=="admin@admin.com")
		{include "include/header3.php";}
	else {include "include/header2.php";}
	}
	else  
	{include "include/header.php";}
	include "include/conn.php";
$act=1;
if(filter_input(INPUT_POST,'submit')){
	$pname = (filter_input(INPUT_POST,'pname'));
	$price = (filter_input(INPUT_POST,'price'));
	$product_detail = (filter_input(INPUT_POST,'product_detail'));
	$ptid = (filter_input(INPUT_POST,'ptid'));
	$pbid = (filter_input(INPUT_POST,'pbid'));
	$sql = "select max(product_id) as mxid FROM product";
	$result = $db->query($sql);
	$row_cnt = $result->num_rows;
	if ($row_cnt>0){
		$row = $result->fetch_array();
		$product_id = $row[0]+1 ;
	}else{
		$product_id = 1;
	}	
	
	for($i=0;$i<count($_FILES['imageupload']['name']);$i++){
		
	$imageupload = isset($_FILES['imageupload']['tmp_name'][$i])?$_FILES['imageupload']['tmp_name'][$i]: "";
	$imageupload_name = isset($_FILES['imageupload']['name'][$i])?$_FILES['imageupload']['name'][$i] : "";

	if($imageupload){
		$arraypic = explode(".",$imageupload_name); // Explode คือตัวแบ่งไฟล์กับนามสกุลออกจากกัน
		
		$filename = $arraypic[0]; //ชื่อไฟล์
		$filetype = $arraypic[1]; //นามสกุลไฟล์
		
		if($filetype=="jpg" || $filetype=="jpeg" || $filetype=="png" || $filetype=="gif")
		{
			if($i==0){
				$newimage = $product_id.".".$filetype;
				$newimage1 = $newimage;
			}else{
				$newimage = $product_id."_".$i.".".$filetype;
				$sql= "insert into product_pic (product_id,ppname)values('$product_id','$newimage')";
				$result =$db->query($sql);
 }
			 //รวมชื่อกับนามสกุลเข้าด้วยกัน
			copy($imageupload,"upload/".$newimage); //โฟเดอเกบรูป
		}
		else{
			echo "<h3>ERROR : ไม่สามารถ Upload รูปภาพ</h3>";
	        }
	  
	    }
		
	}
	
	$sql= "insert into product (product_id,pname,price ,product_detail,ptid,pbid,ppid)values('$product_id','$pname','$price','$product_detail','$ptid','$pbid','$newimage1')";
 $result =$db->query($sql);
	  //echo $sql;

	for ($i = 36; $i<46 ; $i++){
		$s="s".$i;
		$psize = (filter_input(INPUT_POST,$s)); 
	if ($psize){
		$sql= "insert into product_size(product_id,psize,qty)values('$product_id','$i','$psize')"; }
	//echo $sql ;
	 $result =$db->query($sql);
	 
		} 
     header('location: products.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>N-Air a E-commerce category Flat Bootstrap Responsive Website Template | Checkout :: w3layouts</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="N-Air Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() {setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<meta charset utf="8">
		<!--fonts-->
		<link href='//fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
		
		<!--fonts-->
		<!--bootstrap-->
			 <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<!--coustom css-->
			<link href="css/style.css" rel="stylesheet" type="text/css"/>
        <!--shop-kart-js-->
        <script src="js/simpleCart.min.js"></script>
		<!--default-js-->
			<script src="js/jquery-2.1.4.min.js"></script>
		<!--bootstrap-js-->
			<script src="js/bootstrap.min.js"></script>
		<!--script-->
         <!-- FlexSlider -->
            <script src="js/imagezoom.js"></script>
              <script defer src="js/jquery.flexslider.js"></script>
            <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

            <script>
            // Can also be used with $(document).ready()
            $(window).load(function() {
              $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
              });
            });
            </script>
        <!-- //FlexSlider-->
</head>
<body>
<div class="reg-form">
		<div class="container">
			<div class="reg">
				<h3>เพิ่มข้อมูลสินค้า</h3>

				 <form method="post" enctype="multipart/form-data">
                 <ul>
						<li class="text-info">ชื่อสินค้า</li>
						<li><input type="text" name="pname" required>
					</ul>
                    <ul>
						<li class="text-info">ราคา</li>
						<li><input type="text" name="price" required>
					</ul>
                    <ul>
						<li class="text-info">รายละเอียด</li>
						  <textarea name="product_detail" rows="5" cols="40"></textarea>
					  
                        <li class="text-info">ประเภทสินค้า</li>
						<li><select name="ptid">
                    <option value="">ประเภทสินค้า</option>
                    <?php 
						$sql ="select * from product_type";
						$result =$db->query($sql);
						while($row = $result->fetch_array())
							{
							echo '<option value="'.$row['ptid'].'">'.$row['ptname'].'</option>';
							}
						?>
                    </select></li>
					</ul>
                    <ul>
				   <li class="text-info">ยี่ห้อ</li>
                        
						<li><select name="pbid">
                    <option value="">ยี่ห้อ</option>
                    <?php 
						$sql ="select * from product_brand";
						$result =$db->query($sql);
						while($row = $result->fetch_array())
							{
							echo '<option value="'.$row['pbid'].'">'.$row['pbname'].'</option>';
							}
						?>
                    </select></li>
                    </ul><br><br>
					 
                    
                      <?php  
					  for ($i = 36; $i<46 ; $i++){
					  echo $i;  ?>
				   <input type="number" name="s<?php echo $i; ?>" ><br><br><?php } ?>
					 
                     </li>
                      
                    <ul>
					  <li class="text-info">รูปสินค้าหลัก</li>
						<li><input type="file" name="imageupload[]" >
					</ul>
                    <ul>
						<li class="text-info">รูปสินค้าอื่นๆ</li>
						<li><input type="file" name="imageupload[]" ><br>
                        <li><input type="file" name="imageupload[]" ><br>
                        <li><input type="file" name="imageupload[]" >
					</ul>
                   
  <input type="submit" name="submit" value="ตกลง">
        </form>
        </div>
		</div>
	</div>
        <?php include "include/footer.php"; ?>
	</div>
	</div>
</body>
</html>