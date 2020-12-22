<?php 
  include'admin/db_connect.php';
    $qry = $conn->query("SELECT * FROM  product_list where pro_id = ".$_GET['id'])->fetch_array();
?>
<div class="container-fluid">

    <div class="card " style="height: 200px">
        <img src="assets/img/<?php echo $qry['img_path'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo $qry['name'] ?></h5>
          <p class="card-text" style="overflow: scroll; height: 100px" ><em><?php echo $qry['description'] ?></em></p>
          <div class="form-group">
          </div>
          <div class="row">
          	<div class="col-md-2"><label class="control-label">Qty</label></div>
          	<div class="input-group col-md-7 mb-3">
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-secondary" type="button" id="qty-minus"><span class="fa fa-minus"></button>
			  </div>
			  <input type="number" readonly value="1" min = " 1" class="form-control text-center" name="qty" >
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-secondary" type="button" id="qty-plus"><span class="fa fa-plus"></span></button>
			  </div>
			</div>
          </div>
          <div class="text-center">
          	<button class="btn btn-outline-primary btn-sm btn-block" id="add_to_cart_modal"><i class="fa fa-cart-plus"></i> Add to Cart</button>
          </div>
        </div>
        
      </div>
</div>
<style>
	#uni_modal_right .modal-footer{
		display: none;
	}
</style>

<script>
	$('#qty-minus').click(function(){
		var qty = $('input[name="qty"]').val();
		if(qty == 1){
			return false;
		}else{
			$('input[name="qty"]').val(parseInt(qty) -1);
		}
	})
	$('#qty-plus').click(function(){
		var qty = $('input[name="qty"]').val();
			$('input[name="qty"]').val(parseInt(qty) +1);
	})
	$('#add_to_cart_modal').click(function(){
		
		$.ajax({
			url:'admin/ajax.php?action=add_to_cart',
			method:'POST',
			data:{pid:'<?php echo $_GET['id'] ?>',qty:$('[name="qty"]').val()},
			success:function(resp){
				if(resp == 1 ){
                                    start_load()
					alert_toast("Order successfully added to cart");
					$('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()))
					$('.modal').modal('hide')
					end_load()
                                    }else if (resp == 2 ){
                                        alert_toast("Please, login first.");
                                        uni_modal("Login","login.php")
                                        
                                    }else if (resp == 3 ){
                                        alert_toast("You can only order from one restaurant at a time.");
                                    }else if (resp == 4){
                                        alert_toast("Product is already in cart.");
                                    }else {
                                        start_load()
					alert_toast("Order successfully added to cart");
					$('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()))
					$('.modal').modal('hide')
					end_load()
                                    }
			}
		})
	})
</script>