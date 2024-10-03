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
                
            if(empty($_GET) || !isset($_SESSION['userID']) ){
                header( "refresh:0; url=index.php" );
            } else if($_SESSION['userID'] != $_GET['userID'] && $_SESSION['userRole'] != 1 ){
                header( "refresh:0; url=boardDetail.php?boardID= $boardID" );
             }else if (@$_GET['delete'] == 1) {
                    $deleteCommentSQL = 'DELETE FROM comment WHERE commentID = ?';
                    $commentID = $_GET['commentID'];
                    $preparedeleteCommentSQL = $GLOBALS['conn']->prepare($deleteCommentSQL);
                    $preparedeleteCommentSQL->bind_param("i",$commentID);
                    $preparedeleteCommentSQL->execute();
                    $preparedeleteCommentSQL->close();
                    $_SESSION['delete'] = true;
                    header('refresh:0 ; url= adminComment.php');
                   
             }else {
                $commentID = $_GET['commentID'];
                $userID = $_GET['userID'];
                $boardID = $_GET['boardID'];   
                    // Gete commentDetail Data
                    $commentSQL = 'SELECT comment.*,users.firstName,users.lastName  
                    FROM comment JOIN users ON comment.userID = users.userID
                    WHERE comment.commentID = ? AND users.userID = ? ' ;
                    $preparecommentSQL = $GLOBALS['conn']->prepare($commentSQL);
                    $preparecommentSQL->bind_param("ii",$commentID,$userID);
                    $preparecommentSQL->execute();
                    $result = $preparecommentSQL->get_result();
                    $data = $result->fetch_assoc();
                    $preparecommentSQL->close();

                    if(isset($_POST['editcommentDetail'])){
                    $commentDetail = $_POST['editcommentDetail'];
                    if($_POST['editcommentDetail']==''){
                    echo ' <script>
                    $(function() {
                    Swal.fire({
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: "ปิด",
                    title: "เกิดข้อผิดพลาด !",
                    text: "คอมเม้นไม่สามารถเป็นค่าว่างได้!",
                    icon: "error"
                    });
                    });
                    </script>';
                    }else{    
                    $editcommnetSQL = 'UPDATE comment SET commentDetail = ? WHERE commentID = ? ';
                    $prepareeditcommnetSQL = $GLOBALS['conn']->prepare($editcommnetSQL);
                    $prepareeditcommnetSQL->bind_param("si",$commentDetail,$commentID);
                    $prepareeditcommnetSQL->execute();
                    echo ' <script>
                    $(function() {
                    Swal.fire({
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: "ปิด",
                    title: "แก้ไขคอมเม้นสำเร็จ !",
                    text: "กรุณารอสักครู่!",
                    icon: "success"
                    });
                    });
                    </script>';
                    $prepareeditcommnetSQL->close();
                    if(@$_GET['admin']==1) {
                    header("refresh:2; url=adminComment.php");
                    }else{
                    header("refresh:2; url=boardDetail.php?boardID= $boardID");
                    }

                    }
                    
               }
               
             }

    ?>
</head>
<body>
    <?php require 'req/navbar.php' ?>
    <?php if(@$_GET['delete'] != 1 ) {  ?>
    <div class="container-fluid mt-5 mb-2 ">
    <form method="post">
        <div class="row mt-4 ">
            <h3 class="card-title text-center ">แก้ไขคอมเม้น</h3>
            <p class="card-text form-inline">
            <div class="col-lg-4 "> </div> 
            <div class="col-lg-4">
                <div class="boxcard ">
                    <div class="card-body">
                            <div class="mb-3 row">
                            <label for="editcommentDetail" class="col-sm-3  col-form-label text-while">คอมเม้นของคุณ</label>
                            <input type="text"  class="form-control" name="editcommentDetail" id="editcommentDetail"  
                            value="<?php echo $data['commentDetail']; ?>">
                            <button type="submit" class="btn btn-warning text-dark w-100 mt-3 mb-3 rounded-pill" >แก้ไข</button>
                            </div>                 
                        </p>
                    </div>
                </div>            
            </div>
            <div class="col-lg-4"> </div>
        </div>
    </form>
    </div>
    <?php } ?>
    </body>
</html>