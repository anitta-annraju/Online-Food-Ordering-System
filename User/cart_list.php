 <!-- Masthead-->
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                    	<h3 class="text-white">Cart List</h3>
                        <hr class="divider my-4" />
                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="menu">
        <div class="container">
        	<div class="row">
        	<div class="col-lg-8">
        		<div class="sticky">
	        		<div class="card">
	        			<div class="card-body">
                                            <?php if(isset($_SESSION['login_user_id'])){?>
	        				<div class="row">
                                                    
		        				<div class="col-md-8"><b>Card</b></div>
		        				<div class="col-md-4 text-right"><b>Total</b></div>
	        				</div>
	        			</div>
	        		</div>
	        	</div>
        		<?php 
        		
					$data = "where c.user_id = '".$_SESSION['login_user_id']."' ";	
                        
				$total = 0;
				$get = $conn->query("SELECT *,c.id as cid FROM cart c inner join product_list p on p.pro_id = c.product_id ".$data);
				while($row= $get->fetch_assoc()):
					$total += ($row['qty'] * $row['price']);
                                        $cart_id = $row['cid'];
                        ?>

        		<div class="card">
	        		<div class="card-body">
		        		<div class="row">
			        		<div class="col-md-4" style="text-align: -webkit-center">
                                                    <button style="color: red; border: none;" type="button" id="delcart" class="del"data-id="<?php echo $row['cid']?>"><i class="fa fa-trash"></i></button>
			        			<img src="assets/img/<?php echo $row['img_path'] ?>" alt="">
			        		</div>
			        		<div class="col-md-4">
			        			<p><b><large><?php echo $row['name'] ?></large></b></p>
                                                        <p class='truncate' style="overflow: hidden"> <b><small>Desc :<?php echo $row['description'] ?></small></b></p>
			        			<p> <b><small>Unit Price :<?php echo number_format($row['price'],2) ?></small></b></p>
			        			<p><small>QTY :</small></p>
			        			<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <button class="btn btn-outline-secondary qty-minus" type="button"   data-id="<?php echo $row['cid'] ?>"><span class="fa fa-minus"></button>
								  </div>
								  <input type="number" readonly value="<?php echo $row['qty'] ?>" min = 1 class="form-control text-center" name="qty" >
								  <div class="input-group-prepend">
								    <button class="btn btn-outline-secondary qty-plus" type="button" id=""  data-id="<?php echo $row['cid'] ?>"><span class="fa fa-plus"></span></button>
								  </div>
								</div>
			        		</div>
			        		<div class="col-md-4 text-right">
			        			<b><large><?php echo number_format($row['qty'] * $row['price'],2) ?></large></b>
			        		</div>
		        		</div>
	        		</div>
	        	</div>
                     

                        <?php endwhile;?>
        	</div>
        	<div class="col-md-4">
        		<div class="sticky">
        			<div class="card">
        				<div class="card-body">
        					<p><large>Total Amount</large></p>
        					<hr>
        					<p class="text-right"><b><?php echo number_format($total,2) ?></b></p>
        					<hr>
        					<div class="text-center">
        						<button class="btn btn-block btn-outline-primary" type="button" id="checkout">Proceed to Checkout</button>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	</div>
          
                        			
				
        </div>
            <?php }else { ?> <h5 style="color: orange"><center>YOU ARE NOT LOGGED IN.</center></h5> <?php }?>	
    </section>
    <style>
    	.card p {
    		margin: unset
    	}
    	.card img{
		    max-width: calc(100%);
		    max-height: calc(59%);
    	}
    	div.sticky {
		  position: -webkit-sticky; /* Safari */
		  position: sticky;
		  top: 4.7em;
		  z-index: 10;
		  background: white
		}
		.rem_cart{
		   position: absolute;
    	   left: 0;
		}
    </style>
    <script>
        
       
        $('.qty-minus').click(function(){
		var qty = $(this).parent().siblings('input[name="qty"]').val();
		update_qty(parseInt(qty) -1,$(this).attr('data-id'))
		if(qty == 1){
			return false;
		}else{
			 $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) -1);
		}
		})
	$('.qty-plus').click(function(){
			var qty =  $(this).parent().siblings('input[name="qty"]').val();
				 $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) +1);
		update_qty(parseInt(qty) +1,$(this).attr('data-id'))
		})
		function update_qty(qty,id){
			start_load()
			$.ajax({
				url:'admin/ajax.php?action=update_cart_qty',
				method:"POST",
				data:{id:id,qty},
				success:function(resp){
					if(resp == 1){
                                            alert_toast("Cart successfully updated");
                                            <?php sleep(1)?>
						location.replace("index.php?page=cart_list")
					}
				}
			})

		}
		$('#checkout').click(function(){
			if('<?php echo isset($_SESSION['login_user_id']) ?>' == 1){
				location.replace("index.php?page=checkout")
			}else{
				uni_modal("Checkout","login.php?page=checkout")
			}
		})
    
	$('.del').click(function(){
		
			$.ajax({
				url:'admin/ajax.php?action=del_cart&id='+$(this).attr('data-id'),
				method:"POST",
				
				success:function(resp){
					if(resp == 1){
                                            alert_toast("Order successfully deleted from cart");
                                            <?php sleep(1)?>
                                            location.replace("index.php?page=cart_list")
                                            
					}
				}
			})
	})
</script>
	
