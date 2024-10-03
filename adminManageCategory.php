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
        if(empty($_GET)){
            header('refresh:0 ;url=adminCategory.php');
            // echo 123;
        }
        if(@$_GET['d']==1){
                   
                    $categoryID = $_GET['categoryID'];
                    $checkCategorySQL = 'SELECT * FROM board WHERE categoryID = ?';
                    $preparecheckCategorySQL = $GLOBALS['conn']->prepare($checkCategorySQL);
                    $preparecheckCategorySQL->bind_param("i", $categoryID);
                    $preparecheckCategorySQL->execute();
                    $Checkresult = $preparecheckCategorySQL->get_result();
                    $preparecheckCategorySQL->close();
                    if($Checkresult->num_rows > 0){
                        $_SESSION['delete'] = 2;
                        header('refresh:0; url=adminCategory.php');
                    }else{
                        $_SESSION['delete'] = true;
                        $deleteSQL = 'DELETE FROM category WHERE categoryID = ?';
                        $preparedeleteSQL = $GLOBALS['conn']->prepare($deleteSQL);
                        $preparedeleteSQL->bind_param("i",$categoryID);
                        $preparedeleteSQL->execute();
                         $preparedeleteSQL->close();
                        header('refresh:0; url=adminCategory.php');
                    }
                   
        }else{
        $categoryID = $_GET['categoryID'];
        $categorySQL = 'SELECT * FROM category WHERE categoryID = ? ';
        $preparecatgorySQL = $GLOBALS['conn']->prepare($categorySQL);
        $preparecatgorySQL->bind_param("i",$categoryID);
        $preparecatgorySQL->execute();
        $result = $preparecatgorySQL->get_result();
        $category = $result->fetch_assoc();
        $preparecatgorySQL->close();
        if(isset($_POST['categoryName'])) {
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
            }else{
                $categoryName = $_POST['categoryName'];
                $updateCategorySQL = ' UPDATE category SET categoryName = ? WHERE categoryID = ?';
                $prepareupdateCategorySQL = $GLOBALS['conn']->prepare($updateCategorySQL);
                $prepareupdateCategorySQL->bind_param("si",$categoryName,$categoryID);
                $prepareupdateCategorySQL->execute();
                $prepareupdateCategorySQL->close();
                echo ' <script>
                                    $(function() {
                                        Swal.fire({
                                            showCancelButton: true,
                                            showConfirmButton: false,
                                            cancelButtonText: "ปิด",
                                            title: "แก้ไขข้อมูลสำเร็จ !",
                                            text: "กรุณารอสักครู่ !",
                                            icon: "success"
                                        });
                                    });
                                </script>';
                            header("refresh:2; url=adminCategory.php");
            }
        }
        }
      ?>
</head>
<body>
  
    <?php require 'req/navbar.php' ?>
    <?php if(@$_GET['d'] != 1 ) {  ?>
    <div class="container-fluid  mt-3 mb-2">
    <div class="row">
        <div class="col-sm-4"> </div>
        <div class="col-sm-4">
        <h3 class="card-title text-center">แก้ไขหมวดหมู่</h3>  
            <form  method="post">
            <div class="boxcard mt-3">
                <div class="card-body">
                    <p class="card-text">
                        <label for="categoryName" class="mb-2 col-form-label">ชื่อหมวดหมู่</label>
                        <input type="text" name="categoryName" id="categoryName" class="form-control" value="<?php echo $category['categoryName'] ?>"  >
                        <button type="submit" class="btn btn-warning text-dark w-100 mt-3 mb-3 rounded-pill">แก้ไข</button>
                    </p>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <?php } ?>
</body> 
</html>