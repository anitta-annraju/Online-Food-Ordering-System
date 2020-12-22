 <!-- Masthead-->
        <header class="masthead">
             <link href='https://fonts.googleapis.com/css?family=Mr Bedfort' rel='stylesheet'>
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                        <h5 class="text-white">Welcome to<br><span style="font-size: 80px;
            font-family: 'Mr Bedfort';">Wrap & Go</span></h5>
                        <hr class="divider my-4" />
                        

                    </div>
                    
                </div>
            </div>
        </header>
 <body>
     
     <section class="page-section" id="menu" style="padding-top: 70px">
            <?php 
                    include'admin/db_connect.php';
                    $qry1 = $conn->query("SELECT * FROM admin order by rand()");
                    while($row1 = $qry1->fetch_assoc()){
                        $admin = $row1["admin_id"];
                        $ad_name = $row1["name"];?>
        
       <section style="padding: 20px; align-content: center;">
           <h3 style="color: #F2863B"><?php echo $ad_name;?></h3>
          
          <hr style="color: orange">
            <div id="menu-field" class="card-deck" >
                
                <?php 
                    $qry = $conn->query("SELECT * FROM  product_list where admin_id = $admin order by category_id");
                    while($row = $qry->fetch_assoc()):
                    ?>
                
                <div class="col-lg-3" style="padding: 15px;">
                    <div class="card menu-item ">
                         <img src="assets/img/<?php echo $row['img_path'] ?>" style=" size: auto;"class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-title" style="height: 24px;overflow: hidden;
   text-overflow: ellipsis;"><?php echo $row['name'] ?></p>
                          <p class="card-text truncate" style="height: 58px; overflow: hidden;"><?php echo $row['description'] ?></p>
                          <div class="text-center">
                              <button class="btn btn-sm btn-outline-primary view_prod btn-block" data-id=<?php echo $row['pro_id'] ?>><i class="fa fa-eye"></i> View</button>
                              
                          </div>
                        </div>
                        
                      </div>
                      </div>
                    <?php endwhile; ?>
            </div>
                   
        </section> <?php  }?>
    </section>
     
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product','view_prod.php?id='+$(this).attr('data-id'))
        })
    </script>
 </body>
