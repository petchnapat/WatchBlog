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
      if(@$_SESSION['userRole']!=1) {
        header('refresh:0;url=index.php');
      }
       
        if(isset($_POST['categoryName'])) {
             $categoryName = $_POST['categoryName'];
             $categoryName;
            $categoryNameSQL = 'SELECT * FROM category WHERE categoryName = ? ';
            $preparecategoryNameSQL = $GLOBALS['conn']->prepare($categoryNameSQL);
            $preparecategoryNameSQL->bind_param("s", $categoryName);
            $preparecategoryNameSQL->execute();
            $result = $preparecategoryNameSQL->get_result();    
                if($_POST['categoryName']==''){
                echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "เกิดข้อผิดพลาด !",
                                            text: "กรุณากรอกข้อมูลให้สมบูรณ์ !",
                                            icon: "error"
                                        });
                                    });
                                </script>';
            }else if($row = $result->num_rows > 0){
                echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "เกิดข้อผิดพลาด !",
                                            text: "มีหมวดหมู่นี้แล้ว !",
                                            icon: "error"
                                        });
                                    });
                                </script>';
            }else{
                $addCategorySQL = 'INSERT INTO category (categoryName) VALUES (?) ';
                $prepareaddCategorySQL = $GLOBALS['conn']->prepare($addCategorySQL);
                $prepareaddCategorySQL->bind_param("s",$categoryName);
                $prepareaddCategorySQL->execute();
                echo ' <script>
                $(function() {
                    Swal.fire({
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: "ปิด",
                        title: "เพิ่มข้อมูลสำเร็จ !",
                        text: "กรุณารอสักครู่ !",
                        icon: "success"
                    });
                });
            </script>';
        header("refresh:2; url=adminCategory.php");
            }
        }
      ?>
</head>
<body>
  
    <?php require 'req/navbar.php' ?>
    <div class="container-fluid  mt-3 mb-2">
    <div class="row">
        <div class="col-sm-4"> </div>
        <div class="col-sm-4">
            <h3 class="card-title text-center">เพิ่มหมวดหมู่</h3>
            <form  method="post">
            <div class="boxcard">
                <div class="card-body"> 
                    <p class="card-text">
                        <label for="categoryName" class="mb-2 col-form-label">ชื่อหมวดหมู่</label>
                        <input type="text" name="categoryName" id="categoryName" class="form-control" placeholder="Enter Category Name"  >
                        <button type="submit" class="btn btn-warning text-dark w-100 mt-3 mb-3 rounded-pill">เพิ่ม</button>
                    </p>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
</body>
</html>