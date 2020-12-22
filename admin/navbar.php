
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' style="padding-top: 5px; width: 100px" >
		
		<div class="sidebar-list" >

				
                    <a href="index.php?page=orders" class="nav-item nav-orders" data-toggle="tooltip" title="Orders" style="font-size: 30px; padding-left: 35px;"><span class='icon-field'><i class="fas fa-clipboard-list"></i></span></a>
                                <a href="index.php?page=categories" class="nav-item nav-categories" data-toggle="tooltip" title="Categories" style="font-size: 30px; padding-left: 35px;"><span class='icon-field'><i class="fas fa-grip-vertical"></i></span></a>
				<a href="index.php?page=menu" class="nav-item nav-menu" data-toggle="tooltip" title="Menu" style="font-size: 30px; padding-left: 30px;"><span class='icon-field'><i class="fa fa-list"></i></span></a>
				
				
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
        
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({html: true,placement: "right",animation: true, delay: 100});   
});
</script>