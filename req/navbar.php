<?php 
  if(isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $sql = 'SELECT email,userRole,firstName,userImage FROM users WHERE userID = ? ';
    $prepareUser = $GLOBALS['conn']->prepare($sql);
    $prepareUser->bind_param("i",$userID);
    $prepareUser->execute();
    $result = $prepareUser->get_result();
    $user = $result->fetch_assoc();;

    //print_r($user);
}

?>
  <style>
    @media only screen and (max-width: 992px) {
    .collapse-fix {
      padding: 10px;
      background-color: #FAF7F0;
      border: 1px solid #000;
      border-radius: 20px;
    }
    .navbar-toggler{
      background-color: #FAF7F0;
      border: 0;
    }
  }
  </style>
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container-fluid"> 
      <div class="logobtn">
        <a href="index.php"><img src="img/blog2.png" alt=""></a>
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse collapse-fix" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <form action="search.php" method="POST" class="d-flex me-3 mt-.5">
            <input class="form-control me-2 rounded-pill border border-warning" type="search" id="search" name="search" placeholder="Search" aria-label="Search">
            <button button class="btn btn-success rounded-pill" type="submit">ค้นหา</button>
          </form>
      </li>
        <?php if(isset($_SESSION['userID'])) { ?>
        <li class="nav-item">
          <a class="nav-link active text-dark" aria-current="page" href="addboard.php">โพสต์บล็อค</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php if($user['userImage']==null) { ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            <?php }else { ?>
              <img src="img/userImg/<?php echo $user['userImage']; ?>" width="25px" height="25px" class="rounded-circle">
              <?php } ?>
            <?php if(isset($_SESSION['userID'])) { echo $user['firstName']; } else { echo 'Profile'; } ?>
          </a>
          
          <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php">ข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item" href="myboard.php">กระทู้ของฉัน</a></li>
            <?php if($user['userRole']==1) { ?>
            <div class="dropdown-divider"></div>
            <div class="li "><a href="adminUser.php"  class="dropdown-item ml-3"> ผู้ดูแลระบบ </a></div>
            <?php } ?>
            <div class="dropdown-divider"></div>
            <div class="li "><a href="logout.php"  class="dropdown-item  ml-3"> ออกจากระบบ </a></div>
          </ul>
        </li>
        <?php } ?>
        <li class="nav-item justify-content-end">
            <?php if(!isset($_SESSION['userID'])) { ?>
              <div class="log-1">
                <a href="Login.php" class="Login text-light">Login</a>
              </div>
            <?php } ?>
        </li> 
      </ul>
    </div>
  </div>
</nav>
