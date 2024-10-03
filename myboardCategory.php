<!DOCTYPE html>
<html lang="en">
<head>
<?php 
require 'db/db_connect.php';
connect();
$board['img']='';
if(empty($_GET)){
    header('refresh:0;url=myboard.php');
    }else if(empty($_GET['categoryID'] && @$_GET['userID'] != '' )){
    $userID = $_GET['userID'];
    header("refresh:0;url=myboard.php?userID=$userID.php");
    }else{
        $userID = $_GET['userID'];
        $categoryID = $_GET['categoryID'];
    }
    $sql = 'SELECT firstName,lastName FROM users WHERE userID = ?  ';
    $preparesql = $GLOBALS['conn']->prepare($sql);
    $preparesql->bind_param("i",$userID,);
    $preparesql->execute();
    $result= $preparesql->get_result();
    $data = $result->fetch_assoc();

    $boardSql = 'SELECT * FROM board WHERE userID = ? AND categoryID = ?'; 
    $prepareboardSQL = $GLOBALS['conn']->prepare($boardSql);
    $prepareboardSQL->bind_param("ii", $userID, $categoryID);
    $prepareboardSQL->execute();
    $boardResult=$prepareboardSQL->get_result();
    $countMyBoard = 0;
    while ($boardResult->num_rows > 0 && $countMyBoard < $boardResult->num_rows){
        $countMyBoard++;
    } 
    $prepareboardSQL->close();
    $categorySQL = 'SELECT * FROM category';
    $result1 = mysqli_query($GLOBALS['conn'],$categorySQL);
?>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link href="main.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Webboard</title>
</head>
<body>
    <?php require 'req/navbar.php' ?>
    <div class="container-fluid  mt-3 mb-2">
                <div class="row mt-2 mb-2">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4 text-center"><h5>บอร์ดทั้งหมดของคุณ <?php echo $data['firstName']; echo ' '; echo $data['lastName']; ?></h5></div>
                    <div class="col-sm-4 text-end"></div>
                </div>
                
                <div class="row mb-3 mt-3">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 row">
                    <?php while($cate = $result1->fetch_assoc()){ ?>
                    <div class="col-sm-3">
                    <a href="myboardCategory.php?userID=<?php if(@$_GET['userID'] != '') {
                    echo @$_GET['userID'];     } else{ echo $userID; }
                    ?>&categoryID=<?php echo $cate['categoryID'] ?>" class="btn text-light btn-lg w-100 rounded-pill bg-warning" name="category<?php echo $cate['categoryID'] ?>"  > 
                    <?php echo $cate['categoryName'] ?>
                    </a>
                    
                    </div>
                    <?php } ?> 
                    </div>
                    <div class="col-sm-2"></div>
                </div>

        <div class="row  mt-2 mb-2">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 ">
                <div class="row "> 
                    <?php  if($countMyBoard > 0) {  ?>
                    <?php $i=0; while ( $data = mysqli_fetch_assoc($boardResult) ) { 
                        $i++;
                        $categorySql = 'SELECT categoryName FROM category WHERE categoryID = '.$data['categoryID'].' ';
                        $category = getData($categorySql);
                        $commnet = countROW('comment','boardID',$data['boardID']);
                        ?>
                    <div class="boxcard">
                    <?php if($data['boardImage']!=null) { ?>
                        <div class="row">
                            <div class="col-sm-3">
                            <img src="img/boardImg/<?php echo $data['boardImage']  ?>" class="img-fluid mt-2 mb-2" alt="...">
                            </div>
                            <div class="col-sm-9">
                            <h5 class="text-start mt-2 mb-1"><?php echo $data['boardHeader'] ?> 
                                <?php if(@$_SESSION['userID'] == $userID ||  @$_SESSION['userRole'] == 1 ) { ?>
                                <a href="editBoard.php?boardID=<?php echo $data['boardID']; ?>" class="btn btn-sm btn-outline-primary ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                    <button   type="button" data-bs-toggle="modal" data-bs-target="#deboard<?php echo $data['boardID'] ?>" class="btn btn-sm btn-outline-danger ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                <?php } ?>
                                </h5>
                                <p class="text-start mb-1">Category : <?php echo $category['categoryName']; ?>
                            </p>
                                <div class="row">
                                    <div class="col-sm-5"><p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg> 

                                    <?php $date=date_create($data['boardDate']);
                                        echo date_format($date,"d/m/Y"); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                    </svg>
                                    <?php echo $data['boardTime']; ?>
                                </p>
                                </div>
                                <div class="col sm-2"></div>
                                    <div class="col-sm-5 text-end">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                </svg> Comment <?php echo $commnet; ?>
                                </p>
                                </div>
                                </div>
                                <a href="boardDetail.php?boardID=<?php echo $data['boardID']  ?>" class="btn btn-outline-warning mb-2 text-dark">ดูรายละเอียด</a>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="row">
                            <div class="col-sm-12">
                                <h5 class="text-start mt-2 mb-1"><?php echo $data['boardHeader'] ?> 
                                <a href="editBoard.php?boardID=<?php echo $data['boardID']; ?>" class="btn btn-sm btn-outline-success ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                </a>
                                <button   type="button" data-bs-toggle="modal" data-bs-target="#deboard<?php echo $data['boardID'] ?>" class="btn btn-sm btn-outline-danger ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </h5>
                                <p class="text-start mb-1">Category : <?php echo $category['categoryName']; ?>
                            </p>
                                
                                    
                                <div class="row">
                                    <div class="col-sm-5"><p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg> 
                                    <?php $date=date_create($data['boardDate']);
                                        echo date_format($date,"d/m/Y"); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                    </svg>
                                    <?php echo $data['boardTime']; ?>
                                </p>
                                
                                </div>
                                <div class="col sm-2"></div>
                                    <div class="col-sm-5 text-end">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                </svg> Comment <?php echo $commnet; ?>
                                </p>
                                </div>
                                </div>
                                <a href="boardDetail.php?boardID=<?php echo $data['boardID']  ?>" class="btn btn-outline-warning mb-2 text-dark">ดูรายละเอียด</a>
                            </div>
                        </div>
                            <?php }  ?>
                    </div>

                            <!-- Modal Board Delete Comment -->
                                        <div class="modal fade" id="deboard<?php echo $data['boardID'] ?>" tabindex="-1" aria-labelledby="commnetLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deboardLabel">คุณต้องการลบบอร์ด <?php echo $data['boardID'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                        <span classs="card-text " >คุณแน่ใจ </span> 
                                                        
                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <a href="deleteBoard.php?userID=<?php echo $data['userID'] ?>&boardID=<?php echo $data['boardID'] ?>&myboard=1"  class="btn btn-danger">ลบ</a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                    
                     <?php } }else { ?>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-12 text-center mt-4"><h5><strong>คุณไม่มีบอร์ด</strong></h5></div>
                    <div class="col-sm-4"></div>
                        <?php } ?>
                </div> 
            </div>
            
            <div class="col-lg-2"></div> 
           
        </div>
        <div class="row text-center">
            <div class="col-sm-4 "></div>
            <div class="col-sm-4">
                <!-- <a href="#" class=" text-decoration-none btn-sm btn-primary disable">แสดงบอร์ดทั้งหมด</a> -->
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <?php require 'req/footer.php' ?>
</body>
</html>