<div class="container-fluid">
    <?php 
                    include 'admin/db_connect.php';
                    $id =$_GET['id'];
                    $c = 0;
                    $line = "";
                    $qry1 = $conn->query("SELECT * from admin a,order_list ol where ol.admin_id = a.admin_id and ol.order_id =$id group by ol.admin_id");
                    while($row1 = $qry1->fetch_assoc()){
                        if ($c==0){
                            $c=1;
                        }else{
                           $line .=  " & ";
                        }
                    $line .= $row1['name'];}
                                ?>
                        <h5 style="color: orange"><?php echo $line ?></h5>
                        
            
	
	<table class="table table-bordered">
		<thead>
			<tr>

				<th>Order</th>
                                <th>Qty</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total = 0;
			
                        
			$qry = $conn->query("SELECT * FROM order_list o inner join product_list p on o.product_id = p.pro_id  where o.order_id =$id");
			while($row=$qry->fetch_assoc()):
				$total += $row['qty'] * $row['price'];
			?>
			<tr>
				
				<td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['qty'] ?></td>
				<td><?php echo number_format($row['qty'] * $row['price'],2) ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2" class="text-right">TOTAL</th>
				<th ><?php echo number_format($total,2) ?></th>
			</tr>

		</tfoot>
	</table>
	<div class="text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

	</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>

