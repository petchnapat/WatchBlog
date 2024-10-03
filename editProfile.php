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
            $loginUserID = $_SESSION['userID'];
            $DataUserLoginSql = 'SELECT * FROM users WHERE userID = ? ';
            $prepareDataUserLogin = $GLOBALS['conn']->prepare($DataUserLoginSql); 
            $prepareDataUserLogin->bind_param("i",$loginUserID);
            $prepareDataUserLogin->execute();
            $result = $prepareDataUserLogin->get_result();
            if($result->num_rows > 0 ){
                $user = $result->fetch_assoc();
                $userID = $user['userID'];
                $email = $user['email'];
                $firstName = $user['firstName'];
                $lastName = $user['lastName'];
                $userDate = $user['userDate'];
                $userTime = $user['userTime'];
            }
            
            if(isset($_POST['firstName']) || isset($_POST['lastName']) || isset($_POST['email']) ){
                $newfirstName = $_POST['firstName'];
                $newlastName = $_POST['lastName'];
                $newImage = $_FILES['userImage']['name'];
                if($_POST['firstName']=='' || $_POST['lastName']==''){
                    echo ' <script>
                            $(function() {
                                Swal.fire({
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: "ปิด",
                                    title: "เกิดข้อผิดพลาด",
                                    text: "กรุณากรอกชื่อ นามสกุล ให้สมบูรณ์ !",
                                    icon: "error"
                                });
                            });
                            </script>';
                }else if($_FILES['userImage']["tmp_name"]!=''){
                         if(is_uploaded_file($_FILES['userImage']['tmp_name'])){
                                if(($_FILES['userImage']['type']=='image/jpeg') ||
                                   ($_FILES['userImage']['type']=='image/png')){
                               move_uploaded_file($_FILES['userImage']['tmp_name'],
                                       'img/userImg/'.$_FILES['userImage']['name']);
                                $updateImageSQL = 'UPDATE users SET firstName = ? , lastName = ? , userImage = ? WHERE userID = ? ';
                                $prepareuodateImageSQL = $GLOBALS['conn']->prepare($updateImageSQL);
                                $prepareuodateImageSQL->bind_param("sssi",$newfirstName,$newlastName,$newImage,$loginUserID);
                                $prepareuodateImageSQL->execute();
                                $prepareuodateImageSQL->close();
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
                            header('refresh:2 ; url=profile.php');
                                } else{
                                    echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "เกิดข้อผิดพลาด",
                                            text: "กรุณาใช้ไฟล์รูป jpeg หรือ png",
                                            icon: "error"
                                        });
                                    });
                                    </script>';
                                }
                            }
                }else{
                    $updateUserSQL = 'UPDATE users SET firstName = ? , lastName = ? WHERE userID = ?';
                    $prepareUpdateUser = $GLOBALS['conn']->prepare($updateUserSQL);
                    $prepareUpdateUser->bind_param("ssi",$newfirstName,$newlastName,$loginUserID);
                    $result = $prepareUpdateUser->execute();
                    $prepareUpdateUser->close();
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
                            header('refresh:2 ; url=profile.php');
                           
                }
            }
            
            $prepareDataUserLogin->close();
    ?>
</head>
<body>
    <?php require 'req/navbar.php' ?>

    <div class="container-fluid mt-5 mb-2">
    <form method="post" enctype="multipart/form-data">
        <div class="row mt-4">
            <div class="col-lg-4 "> 
            </div>

            <div class="col-lg-4">
                <h3 class="card-title text-center ">โปรไฟล์ของฉัน</h3>
                <div class="boxcard ">
                    <div class="card-body">
                        <p class="card-text form-inline">
                            <div class="mb-3 row">
                            <label for="email" class="col-sm-3  col-form-label text-while">user ID</label>
                                <div class="col-sm-9 ">
                                <span class="input-group-text"> 
                                    <?php  echo $userID; ?>
                                </span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                            <label for="email" class="col-sm-3  col-form-label text-while">อีเมล</label>
                                <div class="col-sm-9 ">
                                <input type="email"  class="form-control " id="email" name="email" value="<?php echo $email; ?>" disabled >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="firstName" class="col-sm-3 col-form-label text-while">ชื่อจริง</label>
                                <div class="col-sm-9">
                                <input type="text"  class="form-control " id="firstName" name="firstName" value="<?php echo $firstName; ?>"  >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="lastName" class="col-sm-3 col-form-label text-while">นามสกุล</label>
                                <div class="col-sm-9">
                                <input type="text"  class="form-control " id="lastName" name="lastName"  value="<?php echo $lastName; ?>"  >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">เลือกรูปภาพ *ไม่ใส่ก็ได้*</label>
                                <input class="form-control form-control-sm" id="userImage" name="userImage" type="file">
                            </div>

                            <div class="mb-3 row">
                            <label for="lastName" class="col-sm-3 col-form-label text-while">วัน / เวลา ที่สมัคร</label>
                                <div class="col-sm-9 ">
                                <span class="input-group-text"> <?php echo $userDate, ' ' , $userTime;  ?>1</span>
                                </div>
                            </div>

                            

                            <div class="row ">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8"> 
                                    <button type="submit" class="btn btn-outline-warning text-dark w-100" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                        แก้ไขข้อมูล
                                    </button>
                            </div>
                                   
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
    <?php require 'req/footer.php' ?>
    </body>
</html>