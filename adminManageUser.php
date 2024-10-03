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
           // print_r($_SESSION);
           
            if($_SESSION['userRole']!=1){
                header('refresh:0; url=index.php');
            }else if(empty($_GET)) {
                header('refresh:0;url=adminUser.php');
            }else if (@$_GET['d']==1){ 
                // GET boardID FOR Delete
                $selectBoardSQL  = 'SELECT boardID FROM board WHERE userID = ?  ';
                $prepareselectBoardSQL = $GLOBALS['conn']->prepare($selectBoardSQL);
                $prepareselectBoardSQL->bind_param("i",$_GET['userID']);
                $prepareselectBoardSQL->execute();
                $boardresult = $prepareselectBoardSQL->get_result();
                $prepareselectBoardSQL->close();
                // Delete Comment
               while( $dataBoardID = $boardresult->fetch_assoc()){
                $boardID = $dataBoardID['boardID'];
                $deleteCommentSQL = 'DELETE  FROM comment 
                WHERE userID = ? || boardID = ?';
                $preapredeleteCommentSQL = $GLOBALS['conn']->prepare($deleteCommentSQL);
                $preapredeleteCommentSQL->bind_param("ii",$_GET['userID'],$boardID);
                $preapredeleteCommentSQL->execute();
                $preapredeleteCommentSQL->close();
               }
               
                // Delete Board
                $deleteBoardSQL = 'DELETE  FROM board 
                WHERE userID = ?';
                $preapredeleteBoardSQL = $GLOBALS['conn']->prepare($deleteBoardSQL);
                $preapredeleteBoardSQL->bind_param("i",$_GET['userID']);
                $preapredeleteBoardSQL->execute();
                $preapredeleteBoardSQL->close();
                // Delete Users
                $deleteUserSQL = 'DELETE  FROM users 
                WHERE userID = ?';
                $preapredeleteUserSQL = $GLOBALS['conn']->prepare($deleteUserSQL);
                $preapredeleteUserSQL->bind_param("i",$_GET['userID']);
                $preapredeleteUserSQL->execute();
                $preapredeleteUserSQL->close();
                $_SESSION['delete'] = true;
                header('refresh:0;url=adminUser.php');
            }else{
                $userID = $_GET['userID'];
                if(isset($_POST['email'])){
                    $email = $_POST['email'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $password = md5($_POST['userPassword']);
                    $confirmPassword = $_POST['confirmuserPassword'];
                    // Check input empty
                    if($_POST['email']=='' || $_POST['firstName']=='' || $_POST['lastName']==''   ){
                        echo ' <script>
                        $(function() {
                            Swal.fire({
                                showCancelButton: true,
                                showConfirmButton: false,
                                cancelButtonText: "ปิด",
                                title: "ไม่สามารถแก้ไขข้อมูลได้",
                                text: "กรุณากรอกข้อมูลให้สมบูรณ์!",
                                icon: "error"
                            });
                        });
                        </script>';
                        // check Not update password
                    }else if($_POST['userPassword']=='' || $_POST['confirmuserPassword']=='' ){

                        $checkuserEmailSQL = 'SELECT userID,email FROM users WHERE email =  ?';
                        $preparecheckuserEmailSQL = $GLOBALS['conn']->prepare($checkuserEmailSQL);
                        $preparecheckuserEmailSQL->bind_param("s",$email);
                        $preparecheckuserEmailSQL->execute();
                        $checkresult = $preparecheckuserEmailSQL->get_result();
                        $chkUser = $checkresult->fetch_assoc();
                        $preparecheckuserEmailSQL->close();
                        // check email = $_POST['email] && userID != $_GET['userID']
                        if($chkUser['email'] == $email && $userID != $chkUser['userID']){
                            echo ' <script>
                            $(function() {
                                Swal.fire({
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: "ปิด",
                                    title: "ไม่สามารถแก้ไขข้อมูลได้",
                                    text: "มีผู้ใช้อีเมลนี้แล้ว!",
                                    icon: "error"
                                });
                            });
                            </script>';
                        }else{ // UPDATE User Data
                            $updateSQL = 'UPDATE users SET email = ? , firstName = ?, lastName = ? WHERE userID = ? ';
                            $prepareupdateSQL = $GLOBALS['conn']->prepare($updateSQL);
                            $prepareupdateSQL->bind_param("sssi",$email,$firstName,$lastName,$userID);
                            $prepareupdateSQL->execute();
                            $prepareupdateSQL->close();
                            echo ' <script>
                                        $(function() {
                                            Swal.fire({
                                                showCancelButton: true,
                                                showConfirmButton: false,
                                                cancelButtonText: "ปิด",
                                                title: "แก้ไขข้อมูลสำเร็จ",
                                                text: "กรุณารอสักครู่ !",
                                                icon: "success"
                                            });
                                        });
                                        </script>';
                            header('refresh:2; url=adminUser.php');
                        }
                    }else if($_POST['userPassword'] != $_POST['confirmuserPassword'] ) {
                        echo ' <script>
                        $(function() {
                            Swal.fire({
                                showCancelButton: true,
                                showConfirmButton: false,
                                cancelButtonText: "ปิด",
                                title: "เกิดข้อผิดพลาด",
                                text: "ไม่สามารถแก้ไขรหัสผ่านได้ !",
                                icon: "error"
                            });
                        });
                        </script>';
                    } else { // UPDATE User AND Password
                        $updateSQL = 'UPDATE users SET email = ? , firstName = ?, lastName = ? ,userPassword = ? WHERE userID = ? ';
                        $prepareupdateSQL = $GLOBALS['conn']->prepare($updateSQL);
                        $prepareupdateSQL->bind_param("ssssi",$email,$firstName,$lastName,$password,$userID);
                       // echo $password;
                        $prepareupdateSQL->execute();
                        $prepareupdateSQL->close();
                        echo ' <script>
                        $(function() {
                            Swal.fire({
                                showCancelButton: true,
                                showConfirmButton: false,
                                cancelButtonText: "ปิด",
                                title: "แก้ไขข้อมูลสำเร็จ",
                                text: "กรุณารอสักครู่!",
                                icon: "success"
                            });
                        });
                        </script>';
                        header('refresh:2; url=adminUser.php');
                        }
                    }
            }
              
             
    ?>
</head>
<body>
    <?php require 'req/navbar.php';  
    $userDataID = $_GET['userID'];
    $userSQL = 'SELECT * FROM users WHERE userID = ? ';
    $preapreuserSQL = $GLOBALS['conn']->prepare($userSQL);
    $preapreuserSQL->bind_param("i",$userDataID);
    $preapreuserSQL->execute();
    $result = $preapreuserSQL->get_result();
    $user = $result->fetch_assoc();
    $preapreuserSQL->close();
    //print_r($user);
     ?>
     <?php if (@$_GET['d'] != 1) { ?>
    <div class="container-fluid mt-5 mb-2">
    <form method="post">
        <div class="row mt-4">

            <h3 class="card-title text-center ">แก้ไขข้อมูลสมาชิก</h3>
            <p class="card-text form-inline">

            <div class="col-lg-4 "> 
            </div>
            <div class="col-lg-4">
                <div class="boxcard ">
                    <div class="card-body">

                            <div class="mb-3 row">
                            <label for="email" class="col-sm-3  col-form-label text-while">อีเมล</label>
                                <div class="col-sm-9 ">
                                <input type="email"  class="form-control " id="email" name="email" value="<?php echo $user['email']  ?>" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="firstName" class="col-sm-3 col-form-label text-while">ชื่อจริง</label>
                                <div class="col-sm-9">
                                <input type="text"  class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" value="<?php echo $user['firstName'] ?>" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="lastName" class="col-sm-3 col-form-label text-while">นามสกุล</label>
                                <div class="col-sm-9 ">
                                <input type="text"  class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" value="<?php echo $user['lastName'] ?>" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="userPassword" class="col-sm-3 col-form-label" >รหัสผ่าน</label>
                                <div class="col-sm-9">
                                <input type="password" class="form-control" id="userPassword" name="userPassword"  placeholder="Enter Password" >
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="confirmuserPassword" class="col-sm-3 col-form-label" >ยืนยันรหัสผ่าน</label>
                                <div class="col-sm-9">
                                <input type="password" class="form-control" id="confirmuserPassword" name="confirmuserPassword"  placeholder="Enter Confirm Password">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8"> <button type="submit" class="btn btn-warning text-dark w-100 mt-3 mb-3 rounded-pill" >ยืนยัน</button></div>
                                <div class="col-lg-2"></div>
                            </div>
                            
                        </p>
                    </div>
                </div>
            
            </div>

            <div class="col-lg-4"> </div>
            </form>
        </div>
    </div>
    <?php } ?>
    </body>
</html>