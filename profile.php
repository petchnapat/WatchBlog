<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link href="main.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Webboard</title>
    <?php 
            require 'db/db_connect.php';
            connect();
            if(@$_GET['profile']){
                $profileID = $_GET['profile'];
            }else{
                $profileID = $_SESSION['userID'];
            }
            
            $DataUserLoginSql = 'SELECT users.* ,COUNT(board.userID) AS boardtotal 
            FROM users 
            LEFT JOIN board ON board.userID = users.userID 
            WHERE users.userID = ? GROUP BY users.userID';
            $prepareDataUserLogin = $GLOBALS['conn']->prepare($DataUserLoginSql); 
            $prepareDataUserLogin->bind_param("i",$profileID);
            $prepareDataUserLogin->execute();
            $result = $prepareDataUserLogin->get_result();
            $prepareDataUserLogin->close();
            
            if($result->num_rows > 0 ){
                $user = $result->fetch_assoc();
                $boardtotal = $user['boardtotal'];
                
                $userID = $user['userID'];  
                $email = $user['email'];
                $firstName = $user['firstName'];
                $lastName = $user['lastName'];
                $userDate = $user['userDate'];
                $userTime = $user['userTime'];
                $userImage = $user['userImage'];
            }else{
                echo 'Nodata';
            }
    ?>
</head>
<body>
    <?php require 'req/navbar.php';  ?>

    <div class="container-fluid mb-2">
        <div class="row mt-4">
            <div class="col-lg-4 "> 
            </div>

            <div class="col-lg-4">
                <h3 class="text-center mb-3">โปรไฟล์ของฉัน</h3>
                <div class="boxcard ">
                    <div class="card-body">
                        <h5 class="card-title text-center ">
                        <?php if(@$_SESSION['userID'] == $profileID ) { ?> 
                        
                        <?php }else{ ?>
                            โปรไฟล์ของ <?php echo $firstName ?>
                        <?php } ?>
                        </h5>
                        <?php if($userImage!=null) { ?>
                        <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6"> <img src="img/userImg/<?php echo $userImage  ?>" class="img-fluid rounded-circle mt-2 mb-2" alt="..."></div>
                        <div class="col-sm-3"></div>
                        </div>
                        <?php } ?>
                        <p class="card-text form-inline">
                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">หมายเลขสมาชิก</span>
                                <div class="col-sm-8 ">
                                <span > 
                                    <?php  echo $userID; ?>
                                </span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">อีเมล</span>
                                <div class="col-sm-8 ">
                                <span  ><?php echo $email; ?> </span>
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">ชื่อ</span>
                                <div class="col-sm-8">
                                <span><?php echo $firstName; ?></span>
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">นามสกุล</span>
                                <div class="col-sm-8">
                                <span><?php echo $lastName; ?></span>
                                </div>
                            </div>

                            
                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">วันที่สมัครสมาชิก</span>
                                <div class="col-sm-8">
                                <span> <?php $date=date_create($userDate);
                                        echo date_format($date,"d/m/Y"); ?></span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                            <span  class="col-sm-4  text-while">เวลาที่สมัครสมาชิก</span>
                                <div class="col-sm-8">
                                <span><?php echo $userTime; ?></span>
                                </div>
                            </div>
                            
                            <div class="row ">
                            <?php if(@$_SESSION['userID'] == $profileID ) { ?>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8"> 
                                    <a href="editProfile.php" class="btn btn-outline-warning text-dark w-100" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                        แก้ไขข้อมูล
                                    </a>
                                    
                                     </div>
                                     <?php } ?>
                                <div class="col-lg-2"></div>
                            </div>
                            
                        </p>
                    </div>
                </div>
            
            </div>

            <div class="col-lg-4"> 
                <div class="boxcard w-75 mt-5">
                    <div class="card-body">
                        <h5 class="card-title"> 
                            <a href="myboard.php?userID=<?php echo $profileID ?>" class="text-dark text-decoration-none" >
                            จำนวนบอร์ดทั้งหมดของ <?php echo $firstName ?>  = <?php echo $boardtotal  ?> 
                            </a>
                        </h5>
                        <h5 class="card-title">จำนวนคอมเม้นทั้งหมดของ <?php echo $firstName ?>  = <?php 
                        $countcommentSQL = 'SELECT count(*) as total FROM comment WHERE userID = ? ';
                        $preparecountcommentSQL = $GLOBALS['conn']->prepare($countcommentSQL);
                        $preparecountcommentSQL->bind_param("i",$profileID);
                        $preparecountcommentSQL->execute();
                        $result = $preparecountcommentSQL->get_result();
                        $commenttotal = $result->fetch_assoc();
                        $preparecountcommentSQL->close();
                        echo $commenttotal['total'];
                        ?> </h5>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <?php require 'req/footer.php' ?>
    </body>
</html>