<style>
	.logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 5px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
}
</style>

<nav class="navbar navbar-dark bg-dark fixed-top " style="padding:0 ;border-bottom: solid #04c2c9; " >
     <link href='https://fonts.googleapis.com/css?family=Mr Bedfort' rel='stylesheet'>
  <div class="container-fluid mt-2 mb-2">
      <div class="col-lg-12" style="display: flex">
  		
          <div class="col-md-4 float-left text-white" style="margin-right:200px; padding-top: 5px">
        <large><span style="font-size: 30px;
                     font-family: 'Mr Bedfort';"><?php echo $_SESSION['login_name']?></span></large>    ~    ADMIN PAGE
      </div>
            <div>
                <img src="assets/img/wlogo.png" style="width: 80px"></img></div>
            <div class="col-md-2 float-right text-white" style="padding-top: 10px; left: 400px">
	  		<a href="ajax.php?action=logout" class="text-white">Logout <i class="fa fa-power-off"></i></a>
	    </div>
    </div>
  </div>
  
</nav>