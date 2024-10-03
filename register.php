<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="log.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Webboard</title>
    <?php 
            require 'db/db_connect.php';
            connect();
                    if(isset($_POST['email'])){  
                        $email = $_POST['email']; 
                        $userPassword = md5($_POST['userPassword']);
                        $checkEmailSql = 'SELECT email FROM users WHERE email = ? ';
                        $prepareCheckEmail = $GLOBALS['conn']->prepare($checkEmailSql);
                        $prepareCheckEmail->bind_param("s", $email);
                        $prepareCheckEmail->execute();
                        $checkEamilResult = $prepareCheckEmail->get_result();

                        if(($_POST['email']=='' || $_POST['userPassword']=='' || $_POST['confirmuserPassword']==''
                        || $_POST['firstName']=='' || $_POST['lastName']=='' ) ) {
                            echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "ข้อมูลไม่สมบูรณ์ !",
                                            text: "กรุณากรอกข้อมูลให้ครบ !",
                                            icon: "error"
                                        });
                                    });
                                    </script>';
                        } else if($checkEamilResult->num_rows > 0) {
                            echo ' <script>
                                $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "อีเมลนี้ถูกใช้งานแล้ว !",
                                            text: "กรุณาใช้อีเมลอื่น !",
                                            icon: "error"
                                        });
                                    });
                                </script>';
                            
                        }else if( $_POST['confirmuserPassword'] != $_POST['userPassword'] ){
                            echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "รหัสผ่านไม่ถูกต้อง !",
                                            text: "กรุณากรอกรหัสผ่านใหม่อีกครั้ง !",
                                            icon: "error"
                                        });
                                    });
                                </script>';
                        } else {
                            $email = $_POST['email'];
                            $userPassword = md5($_POST['userPassword']);
                            $firstName = $_POST['firstName'];
                            $lastName = $_POST['lastName'];
                            $addUserSql = 'INSERT INTO Users (email,userPassword,firstName,lastName,userDate,userTime) 
                                           VALUES (?, ?, ?, ?, CURRENT_DATE, CURRENT_TIME) ';
                            $prepareRegister = $GLOBALS['conn']->prepare($addUserSql);
                            $prepareRegister->bind_param("ssss",$email,$userPassword,$firstName,$lastName);
                            if($prepareRegister->execute()){
                                echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "สมัครสมาชิกสำเร็จ !",
                                            text: "ยินดีต้อนรับสู่การเป็นสมาชิก !",
                                            icon: "success"
                                        });
                                    });
                                </script>';
                            header( "refresh:2; url=login.php" );
                            }
                            $prepareRegister->close();
                            }
                    }
    ?>
</head>
<body>
    <?php require 'req/navbar.php' ?>
    <div class="container-fluid mt-5 mb-2">
    <form method="post">
        <div class="row mt-4">
            <div class="col-lg-4 "> 
            </div>
            <div class="col-lg-4">
            <h1 class="Logo text-center mb-3">Create Account</h1>

                    <div class="card-body">
                        <p class="card-text form-inline">
                            <div class="mb-3 row">
                            <label for="email" class="col-sm-3  col-form-label text-while">Email</label>
                                <div class="col-sm-9 ">
                                <input type="email"  class="form-control " id="email" name="email" placeholder="Enter Email" value="" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="firstName" class="col-sm-3 col-form-label text-while">First Name</label>
                                <div class="col-sm-9">
                                <input type="text"  class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" value="" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                            <label for="lastName" class="col-sm-3 col-form-label text-while">Last Name</label>
                                <div class="col-sm-9 ">
                                <input type="text"  class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" value="" >
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="userPassword" class="col-sm-3 col-form-label" >Password</label>
                                <div class="col-sm-9">
                                <input type="password" class="form-control" id="userPassword" name="userPassword"  placeholder="Enter Password" >
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="confirmuserPassword" class="col-sm-3 col-form-label" >Confirm Password</label>
                                <div class="col-sm-9">
                                <input type="password" class="form-control" id="confirmuserPassword" name="confirmuserPassword"  placeholder="Enter Confirm Password">
                                </div>
                            </div>

                            <div class="btn-login">
                                <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8"><button type="submit" class="btn w-100 text-light" >Create</button></div>                   
                                <div class="col-lg-2"></div>
                                </div>
                            </div>
                            
                        </p>
                    </div>
                
            
            </div>

            <div class="col-lg-4"> </div>
            </form>
        </div>
    </div>

    <?php require 'req/footer.php' ?>
    
    </body>
</html>