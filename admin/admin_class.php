<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM admin where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
                                
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			$this->db->query("UPDATE cart set user_id = '".$_SESSION['login_user_id']."' where client_ip ='$ip' ");
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO admin set ".$data);
		}else{
			$save = $this->db->query("UPDATE admin set ".$data." where id = ".$admin_id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " first_name = '$first_name' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where email = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$login = $this->login2();
			return 1;
		}
	}

	
	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
                        $admin_id = $_GET['admin_id'];
                        $data .= ", admin_id = '$admin_id' ";
			$save = $this->db->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE category_list set ".$data." where cat_id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category_list where cat_id = ".$id);
		if($delete)
			return 1;
	}
	function save_menu(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";

		if($_FILES['img']['tmp_name'] != ''){
                                                
                    
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					        $data .= ", img_path = '$fname' ";

		}
		if(empty($id)){
                        $admin_id = $_GET['admin_id'];
                        $data .= ", admin_id = '$admin_id' ";
			$save = $this->db->query("INSERT INTO product_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE product_list set ".$data." where pro_id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_menu(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM product_list where pro_id = ".$id);
		if($delete)
			return 1;
	}

	function add_to_cart(){
		extract($_POST);
		$data = " product_id = $pid ";	
		$qty = isset($qty) ? $qty : 1 ;
		$data .= ", qty = $qty ";	
		if(isset($_SESSION['login_user_id'])){
			
                        $id = $_SESSION['login_user_id'];
                        $qry = $this->db->query("SELECT p.admin_id,c.product_id FROM cart c,product_list p WHERE c.user_id = $id and c.product_id = p.pro_id");
                        $qry1 = $this->db->query("SELECT admin_id FROM  product_list  WHERE pro_id = $pid ");
                        $row = $qry->fetch_assoc();
                        $row1 = $qry1->fetch_assoc();
                        if ($row['admin_id']==$row1['admin_id']or empty($row['admin_id'])){
                            if ($row['product_id']!=$pid or empty($row['admin_id'])){
                           $data .= ", user_id = '".$_SESSION['login_user_id']."' ";
                           $save = $this->db->query("INSERT INTO cart set ".$data);
                            return 1;
                            }else{
                                return 4;
                            }
                        }
                        else{
                            return 3;
                        }
                        
		}else{
			return 2;

		}
		
	}
	function get_cart_count(){
		extract($_POST);
		if(isset($_SESSION['login_user_id'])){
			$where =" where user_id = '".$_SESSION['login_user_id']."'  ";
		}
		else{
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			$where =" where client_ip = '$ip'  ";
		}
		$get = $this->db->query("SELECT sum(qty) as cart FROM cart ".$where);
		if($get->num_rows > 0){
			return $get->fetch_array()['cart'];
		}else{
			return '0';
		}
	}

	function update_cart_qty(){
		extract($_POST);
		$data = " qty = $qty ";
		$save = $this->db->query("UPDATE cart set ".$data." where id = ".$id);
		if($save)
		return 1;	
	}

	function save_order(){
		extract($_POST);
                $ID = $_SESSION['login_user_id'];
		$data = " name = '".$first_name." ".$last_name."' ";
		$data .= ", address = '$address' ";
                $data .= ", user_id =  '$ID'";
		$data .= ", mobile = '$mobile' ";
		$data .= ", email = '$email' ";
		$save = $this->db->query("INSERT INTO orders set ".$data);
		if($save){
			$id = $this->db->insert_id;
			$qry = $this->db->query("SELECT * FROM cart where user_id =".$_SESSION['login_user_id']);
			while($row= $qry->fetch_assoc()){

					$data = " order_id = '$id' ";
					$data .= ", product_id = '".$row['product_id']."' ";
                                        $qry1 = $this->db->query("SELECT admin_id FROM product_list where pro_id =".$row['product_id']);
                                        while($row1= $qry1->fetch_assoc()){
                                            $data .= ", admin_id = '".$row1['admin_id']."' ";
                            
                                        }
					$data .= ", qty = '".$row['qty']."' ";
                                        $data .=", user_id = '$ID'";
					$save2=$this->db->query("INSERT INTO order_list set ".$data);
					if($save2){
						$this->db->query("DELETE FROM cart where id= ".$row['id']);
					}
			}
			return 1;
		}
	}
function confirm_order(){
	extract($_POST);
		$save = $this->db->query("UPDATE orders set status = 1 where order_id= ".$id);
		if($save)
			return 1;
}
                
function del_cart(){
	extract($_POST);
                $cid = $_GET['id'];
                $this->db->query("DELETE FROM cart where id =".$cid);
		return 1; 
        }
}

