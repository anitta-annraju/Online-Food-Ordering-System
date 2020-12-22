 <!-- Masthead-->
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                    	 <h1 class="text-white">My Orders</h1>
                        <hr class="divider my-4" />
                    </div>
                    
                </div>
            </div>
        </header>

    <section class="page-section">
        <div class="container">
            <div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<?php 
        		if(isset($_SESSION['login_user_id'])){
                        $user_id =$_SESSION['login_user_id'];	
				$get = $conn->query("SELECT o.order_id,o.status FROM orders o,order_list ol where ol.user_id = o.user_id and ol.user_id = $user_id group by o.order_id  ");
                                
				
        		$Supportquery = $conn->query("SELECT o.order_id,o.status FROM orders o,order_list ol where ol.user_id = o.user_id group by o.order_id  ");
                $cnt = mysqli_num_rows($Supportquery);
                if($cnt > 0){?>
                    <table style="width:100%;">
                <tr style="background-color: oldlace; height: 60px">
                    <th><center>#</center></th>
                    <th><center>ORDER ID</center></th>
                    <th><center>STATUS</center></th>
                    <th></th>
                    
                </tr>
               
                
                <?PHP 
                $i=1;
                    while($row = mysqli_fetch_array($get)){
                               
                             $order_id=$row['order_id'];
                             $status=$row['status'];
                             
                        ?>  
                
                <tr style="padd">
                    <td><center><?php echo $i++; ?></center></td>
                         
                    <td><center><?PHP echo $order_id; ?></center></td>
                           <td><center><?PHP if( $status==1){ ?>
                           Confirmed <?php } else {?>
                           Yet to Confirm <?php } ?>
                           </center></td>
                           <td><center>
			 			<button class="btn btn-sm btn-primary view_order" data-id="<?php echo $order_id ?>" >View Order</button>
                           </center></td>
                           
                            
                     </tr>
                       
                    <?PHP }}else{
                        ?> <center>NO ORDERS YET</center><?php }}else { ?>
                     <center>YOU ARE NOT LOGGED IN</center> <?php } ?>
            </table>
        </div>
            </div>
            </div> 
            </div>
    </section>
 <script>
	$('.view_order').click(function(){
		uni_modal('Order','view_order.php?id='+$(this).attr('data-id'))
	})
</script>