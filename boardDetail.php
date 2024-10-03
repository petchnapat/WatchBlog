<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Webboard</title>
    <?php 
            require 'db/db_connect.php';
            connect();
            if(@$_SESSION['delete']==1) {
                echo ' <script>
                        $(function() {
                             Swal.fire({
                                showCancelButton: true,
                                 showConfirmButton: false,
                                cancelButtonText: "ปิด",
                                title: "ลบคอมเม้นสำเร็จ !",
                              text: "",
                              icon: "success"
                             });
                        });
                    </script>'; 
                unset($_SESSION['delete']);
            }
            
            $boardID = $_GET['boardID'];
            $boardSql = 'SELECT board.boardHeader, board.boardBody,board.userID AS userBoardID, board.categoryID,board.boardImage,board.boardDate,board.boardTime ,
                    users.firstName AS userBoardFirstName , users.lastName AS userBoardLastName , users.userImage ,
                    category.categoryName 
                    FROM board INNER JOIN users ON users.userID = board.userID AND board.boardID = ? 
                    INNER JOIN category  ON category.categoryID = board.categoryID  WHERE board.boardID = ? ' ;
            $prepareboard = $GLOBALS['conn']->prepare($boardSql);
            $prepareboard->bind_param("ii",$boardID,$boardID);
            $prepareboard->execute();
            $result =$prepareboard->get_result();
            if($result->num_rows == 0) {
                header('refresh:0 ; url=index.php');
            }
             $board =  $result->fetch_assoc();
             $comment = countRow('comment','boardID',$_GET['boardID']);
            // User Comment 
            if(isset($_POST['commentDetail'])) {

                if($_POST['commentDetail']=='') {
                    echo ' <script>
                            $(function() {
                                Swal.fire({
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: "ปิด",
                                    title: "ไม่สามารถแสดงความคิดเห็นได้",
                                    text: "ข้อความเป็นค่าว่าง กรุณากรอกข้อคิดเห็น !",
                                    icon: "error"
                                });
                            });
                            </script>';
                }else{
                    // INSERT Comment userID FROM $_SESSSINO['userID'] boardID FROM $_GET['boardID']
                    $commnetSQL = 'INSERT INTO comment (userID,boardID,commentDetail,commentDate,commentTime) VALUES 
                    ( '.$_SESSION['userID'].', '.$_GET['boardID'].',"'.$_POST['commentDetail'].'" , CURRENT_DATE  , CURRENT_TIME ) ';
                   // echo $commnetSQL;
                    $result = mysqli_query($GLOBALS['conn'],$commnetSQL);
                    echo ' <script>
                            $(function() {
                                Swal.fire({
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: "ปิด",
                                    title: "แสดงความคิดเห็นสำเร็จ !",
                                    text: "",
                                    icon: "success"
                                });
                            });
                            </script>';
                            $comment = countRow('comment','boardID',$_GET['boardID']);
                }
            }
            // SELECT ALL comment ORDER BY DATE AND TIME
            $commentDate = "commentDate";
            $commentTime = "commentTime";
            $getcommentSQL = 'SELECT * FROM comment WHERE boardID = ? ORDER BY  commentDate DESC , commentTime  DESC ';
            $prepareComment = $GLOBALS['conn']->prepare($getcommentSQL);
            $prepareComment->bind_param("i",$boardID);
            $prepareComment->execute();
            $resultComment = $prepareComment->get_result();
            $prepareComment->close(); 
           $prepareboard->close();
           // Edit Comment
           if(isset($_POST['editCommnet'])) {
            echo' 123';
           }
    ?>
</head>
<body>
    <?php require 'req/navbar.php' ?>
    <div class="container-fluid mb-2 ">
    <form method="post" enctype="multipart/form-data">
        <div class="row mt-4 mb-4 ">
            <div class="col-lg-3 "> 
            </div>
            <!-- Board -->
            <div class="col-lg-6">
                <div class="boxcard">
                    <div class="card-body">
                        <p class="card-text form-inline">
                            <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label text-while">ห้วข้อบอร์ด</label>
                                <h5 class="text-start"><?php echo $board['boardHeader'] ?></h5>
                            </div>
                            <?php if($board['boardImage']!=null) { ?>
                            <div class="mb-3 row">
                                <div class="col-sm-1"><label for="img" class="col-sm-3 col-form-label text-while"></label></div>
                                <div class="col-sm-10">

                                    <img src="img/boardImg/<?php echo $board['boardImage']  ?>" class="img-fluid mt-2 mb-2" alt="...">
                                          
                                </div>
                                <div class="col-sm-1"></div>
                           
                            </div>
                            <?php } ?>
                            <div class="mb-3 row">
                                <label for="userPassword" class="col-sm-3 col-form-label" >เนื้อหาบอร์ด</label>
                                <div class="col-sm-12">
                                <span disabled class="form-control" name="boardBody" id="boardBody" diabled  
                                placeholder="Enter Board Body"><?php echo nl2br(htmlspecialchars($board['boardBody'])); ?></span>
                                </div>
                            </div>
                            <div class=" mb-3 ">
                            <label for="email" class="col-sm-3 col-form-label text-while">หมวดหมู่</label><br>
                                <span    class="btn btn-sm btn-outline-warning text-dark  mt-2 ml-2"> <?php echo $board['categoryName'] ?></span>
                            </div>
                            <div class="mb-3 row">
                                <label for="userPassword" class="col-sm-3 col-form-label" >
                                </label>
                                <div class="col-sm-12">
                                <span >สมาชิกหมายเลข <?php echo $board['userBoardID'] ?> :  
                                <a href="profile.php?profile=<?php echo $board['userBoardID'] ?>" class="text-decoration-none text-dark">
                                <?php if($board['userImage']!=null) { ?>
                                <img src="img/userImg/<?php echo $board['userImage'] ?>" width="30px" class="rounded-circle" height="30px" alt="">
                                <?php } else { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg>
                                <?php } ?>
                                <?php echo $board['userBoardFirstName'].' '. $board['userBoardLastName'] ?>
                                </a> </span> <br>
                                <span classs="card-text" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg> 
                                    <?php $date=date_create($board['boardDate']);
                                     echo date_format($date,"d/m/Y").' 
                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                    </svg> '.$board['boardTime']; ?> </span> 
                            </div>
                            </div>
                        </p>
                    </div>
                </div>
                <?php  if(isset($_SESSION['userID'])) { ?> 
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="boxcard">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Title</h5> -->
                                <p class="card-text">แสดงความคิดเห็น  </p>             
                                <textarea  class="form-control" name="commentDetail" id="commentDetail" aria-label="With textarea" 
                                placeholder="แสดงความคิดเห็น"></textarea>
                                <button type="submit" class="btn btn btn-warning w-100 mt-2"> แสดงความคิดเห็น </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <?php } ?>  
                <!-- Comment -->
                <div class="row mt-3">
                <div class="border"></div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 mt-2 mb-2 text-center">
                        <?php if($comment > 0 ) { ?>
                    <span class> ความคิดเห็นทั้งหมด <?php echo $comment; ?></span>
                        <?php }else { ?>
                    <span class> ไม่มีความคิดเห็น</span>           
                        <?php } ?>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="border "></div>
                </div>
               <?php if($resultComment->num_rows > 0) { ?>
                <div class="boxcard mt-3">
                    <div class="card-body mb-2">
                        <h5 class="card-title "> </h5>
                                <?php $i=0; while($data = mysqli_fetch_assoc($resultComment)) { 
                                    $i++; 
                                    $userID = $data['userID'];
                                    $userCommentSQL = 'SELECT firstName,lastName,userImage FROM users WHERE userID = ?  ';
                                    $prepareUserComment = $GLOBALS['conn']->prepare($userCommentSQL);
                                    $prepareUserComment->bind_param("i",$userID);
                                    $prepareUserComment->execute();
                                    $resultUser = $prepareUserComment->get_result();
                                    $userData = $resultUser->fetch_assoc();
                                    ?>
                                    <div class="col-sm-4">

                                    
                                    <label  class="col-form-label"> ความคิดเห็นที่  <?php echo $i;  ;if((@$_SESSION['userID'] == $data['userID'] ) || @$_SESSION['userRole'] == 1 ) { ?>
                                        <!-- Button trigger modal Comment -->
                                    <button   type="button" data-bs-toggle="modal" data-bs-target="#commnet<?php echo $data['commentID'] ?>" class="btn btn-sm btn-outline-success ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                                    </label>  
                                    <button   type="button" data-bs-toggle="modal" data-bs-target="#decommnet<?php echo $data['commentID'] ?>" class="btn btn-sm btn-outline-danger ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                    <?php } ?> 
                                    </div>
                                    <!-- Modal Comment Edit Comment -->
                                        <div class="modal fade" id="commnet<?php echo $data['commentID'] ?>" tabindex="-1" aria-labelledby="commnetLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="commnetLabel">คุณต้องการแก้ไขคอมเม้นหมายเลข <?php echo $data['commentID'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-sm-12">
                                                    <label for="editcomment" class="col-sm-3  col-form-label text-while"></label>
                                                        <input type="text" disabled  class="form-control " id="editcomment" name="editcomment" value="<?php echo $data['commentDetail'];  ?>">
                                                        </div> <br>
                                                        <p class="card-text mb-1"> หมายเลขสมาชิก :  <?php echo $data['userID']." คุณ ".$userData['firstName'].' '.$userData['lastName'];  ?>   </p>  
                                                        <span classs="card-text" ><?php echo $data['commentDate'].' '.$data['commentTime']; ?> </span>  <br> <br>
                                                        
                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <a href="editComment.php?commentID=<?php echo $data['commentID'] ?>&userID=<?php echo $data['userID'] ?>&boardID=<?php echo $boardID ?>"  class="btn btn-primary">แก้ไข</a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <!-- Modal Comment Delete Comment -->
                                        <div class="modal fade" id="decommnet<?php echo $data['commentID'] ?>" tabindex="-1" aria-labelledby="commnetLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="decommnetLabel">คุณต้องการลบคอมเม้น <?php echo $data['commentID'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-sm-12">
                                                    <label for="decomment" class="col-sm-3  col-form-label text-while"></label>
                                                        <input type="text" disabled  class="form-control " id="decomment" name="decomment" value="<?php echo $data['commentDetail'];  ?>">
                                                        </div> <br>
                                                        <p class="card-text mb-1"> หมายเลขสมาชิก :  <?php echo $data['userID']." คุณ ".$userData['firstName'].' '.$userData['lastName'];  ?>   </p>  
                                                        <span classs="card-text" ><?php echo $data['commentDate'].' '.$data['commentTime']; ?> </span>  <br> <br>
                                                        
                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <a href="deleteComment.php?commentID=<?php echo $data['commentID'] ?>&userID=<?php echo $data['userID'] ?>&boardID=<?php echo $boardID ?>"  class="btn btn-danger">ลบ</a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                <div class="col-sm-12">
                                <span  class="form-control" name="boardBody" id="boardBody" diabled  
                                placeholder="Enter Board Body"><?php echo $data['commentDetail']; ?></span>
                                </div> <br>
                                <p class="card-text mb-1"> หมายเลขสมาชิก : 
                                <?php if($userData['userImage']!=null) { ?>
                                <img src="img/userImg/<?php echo $userData['userImage'] ?>" width="30px" class="rounded-circle" height="30px" alt="">
                                <?php } else { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg>
                                <?php } ?>
                                <a href="profile.php?profile=<?php echo $userID ?>" class="text-decoration-none text-dark">
                                     <?php echo $data['userID']." คุณ ".$userData['firstName'].' '.$userData['lastName'];  ?>  </a> </p>  
                                <span classs="card-text" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg> 
                                    <?php $date=date_create($data['commentDate']);
                                     echo date_format($date,"d/m/Y").' 
                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                    </svg> '.$data['commentTime']; ?> </span>   <br> <br>
                                <p class="border"></p> 
                                <?php } ?> 
                                </div> 
                </div>
                <?php } ?>
            </div>
            <div class="col-lg-3"> </div>
           
            
        </div>
    </div>
    </body>
</html>