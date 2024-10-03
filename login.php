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
                        $password = md5($_POST['userPassword']);                       
                        $sql = 'SELECT * from users WHERE email = ? AND userPassword = ? ';
                        $prepareUser =  $GLOBALS['conn']->prepare($sql);
                        $prepareUser->bind_param("ss",$email,$password);
                        $prepareUser->execute();
                        $result = $prepareUser->get_result();
                        if($result->num_rows > 0) {
                           $row = $result->fetch_assoc();
                                if($row['userRole']==1){
                                    $_SESSION['userID'] = $row['userID'];  
                                    $_SESSION['userRole'] = $row['userRole'];   
                                }else{
                                    $_SESSION['userID'] = $row['userID'];
                                    
                                }
                                echo ' <script>
                                        $(function() {
                                            Swal.fire({
                                                showCancelButton: true,
                                                showConfirmButton: false,
                                                cancelButtonText: "ปิด",
                                                title: "เข้าสู่ระบบสำเร็จ !",
                                                text: "ยินดีต้อนรับสู่ Webboard!",
                                                icon: "success"
                                            });
                                        });
                                    </script>';
                                   header( "refresh:2; url=index.php" );
                            
                        } else {
                                     echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "ไม่สามารถเข้าสู่ระบบได้",
                                            text: "Email หรือ Password ผิดพลาด กรุณาลองใหม่อีกครั้ง !",
                                            icon: "error"
                                        });
                                    });
                                    </script>';
                        }
                    }                   
    ?>
</head>
<body>

    <?php require 'req/navbar.php' ?>
    <div class="container-fluid mb-2">
    <form method="post">
        <div class="row mt-4 ">
            <div class="col-lg-4 "> </div> 
            <div class="col-lg-4">
            <h1 class="Logo text-center mb-3">Login</h1>
                    <div class="card-body">
                        
                        <p class="card-text form-inline">
                            <div class="mb-3 row">

                            <label for="email" class="col-form-label text-while">Email</label>
                                <div class="ml-2">
                                <input type="email"  class="form-control" id="email" name="email" placeholder="Enter Email" value="" >
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="userPassword" class="col-sm-3 col-form-label" >Password</label>
                                <div class="ml-2">
                                <input type="password" class="form-control" id="userPassword" name="userPassword"  placeholder="Enter Password" >
                                </div>
                            </div>
                            <div class="btn-login">
                                <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8"><button type="submit" class="btn w-100 text-light" >Login</button></div>                   
                                <div class="col-lg-2"></div>
                                </div>
                            </div>
                            <div class="row-create mt-3 text-center">
                                <p>Don't have an account? <a class="createloing"  style=" color: #F0A04B " href="register.php">Create account</a></p>
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