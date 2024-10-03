<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
  
    <title>Webboard</title>
    <?php 
      require 'db/db_connect.php';
      connect();
      if(@$_SESSION['userRole']!=1) {
        header('refresh:0;url=index.php');
      }
      if(@$_SESSION['delete']==1){
        echo ' <script>
        $(function() {
            Swal.fire({
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "ปิด",
                title: "ลบบอร์ดสำเร็จ",
                text: "!",
                icon: "success"
            });
        });
        </script>';
        unset($_SESSION['delete']);
      }
      ?>
</head>
<body>
  
    <?php require 'req/navbar.php' ?>
    <div class="container-fluid  mt-3 mb-2">
    <div class="row mt-2 mb-2">
          <div class="col-sm-4"></div>
          <div class="col-sm-6">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link  text-dark " aria-current="page" href="adminUser.php" >ข้อมูลสมาชิก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="adminboard.php">ข้อมูลบอร์ด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="adminComment.php">ข้อมูลคอมเม้น</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark " href="adminCategory.php" tabindex="-1" aria-disabled="true">ข้อมูลหมวดหมู่</a>
            </li>
          </ul>
          </div>
        </div>
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4 text-center"><h5>ข้อมูลบอร์ด </h5>
    </div>
        <div class="col-sm-4 text-end"></div>
    </div>
        <div class="row  mt-2 mb-2">
        <div class="col-sm-1"> </div>
           <div class="col-sm-10">
           <table id="boardTable" class="display responsive nowrap">
                    <thead>
                      <tr>
                        <th scope="col" >ไอดี</th>
                        <th scope="col" width="200px">หัวข้อ</th>
                        <th scope="col" >เนื้อหา</th>
                        <th scope="col">ไอดีสมาชิก</th>
                        <th scope="col">หมวดหมู่</th>
                        <th scope="col">วันที่โพสต์</th>
                        <th scope="col">เวลาที่โพสต์</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php  
                        $boardsql = 'SELECT * , category.categoryName FROM board JOIN category ON category.categoryID = board.categoryID ';
                        $result = mysqli_query($GLOBALS['conn'],$boardsql);
                        if($result->num_rows > 0) {
                         while($board = mysqli_fetch_assoc($result) ) {
                    ?>  
                      <tr>
                        <th scope="row"><?php echo $board['boardID']; ?></th>
                        <td><?php echo $board['boardHeader']; ?></td>
                        <td>
                        <textarea class="form-control" 
                        id="floatingTextarea2" disabled style="height: 25px"><?php echo $board['boardBody']; ?></textarea>
                            
                        </td>
                        <td><?php echo $board['userID']; ?></td>
                        <td><?php echo $board['categoryName']; ?></td>
                        <td><?php echo $board['boardTime']; ?></td>
                        <td>
                            <?php $date=date_create($board['boardDate']);
                                    echo date_format($date,"d/m/Y"); ?>
                        </td>
                        <td>
                          <a href="editBoard.php?boardID=<?php echo $board['boardID']; ?>&admin=1" class="btn btn-sm btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                          </a>
                          <button   type="button" data-bs-toggle="modal" data-bs-target="#deboard<?php echo $board['boardID'] ?>" class="btn btn-sm btn-danger ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                          </button>
                      </td>
                      </tr>
                      <!-- Modal Board Delete Comment -->
                      <div class="modal fade" id="deboard<?php echo $board['boardID'] ?>" tabindex="-1" aria-labelledby="commnetLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="deboardLabel">คุณต้องการลบบอร์ดหมายเลข <?php echo $board['boardID'] ?></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                    <span classs="card-text " >คุณแน่ใจ </span> 
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                  <a href="deleteBoard.php?userID=<?php echo $board['userID'] ?>&boardID=<?php echo $board['boardID'] ?>&admin=1"  class="btn btn-danger">ลบ</a>
                              </div>
                            </div>
                        </div>
                      </div>
                      <?php }} else { ?>
                        <tr><td>ไม่พบข้อมูล</td></tr>
                        <?php  } ?>
                    </tbody>
                    
                  </table>
           </div>
           <div class="col-sm-1"> </div>
        </div>
       
    </div>
    <script>
        $(document).ready( function () {
          $('#boardTable').DataTable({
            responsive: true
          }); // เปิดใช้งาน DataTables
        } );
    </script>
</body>
</html>