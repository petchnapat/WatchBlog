<?php
    // กำหนดค่าตัวแปล
    $loginUserID = $_SESSION['userID'];

    // SQL ดึงข้อมูล user จาก SESSION['userID] (ผู้ใช้ที่ Login)
    $DataUserLoginSql = 'SELECT * FROM users WHERE userID = ? ';

    /*  Prepare Statement เป็นการเตรียมคำสั่ง SQL ก่อนจะถูกนำไปทำงานกับ Database (execute)
        ชื่อตัวแปล = ตัวแปลที่เชื่อมต่อ Database -> prepare(SQL) */
    $prepareDataUserLogin = $GLOBALS['conn']->prepare($DataUserLoginSql); 

    /*  Bind param คือการกำหนดค่า ? ของ SQL โดยที่ "ss" หมายถึงชนิดตัวแปล (s = String , i = integer ที่ใช้บ่อยๆ)
        ตามด้วยตัวแปลที่เก็บค่าที่ต้องการเพิ่มไปใน SQL ซึ่งจะปลอดภัยจากการโดน SQL INJECTION */ 
    $prepareDataUserLogin->bind_param("i",$loginUserID);
    
    // execute คือการนำ Prepare Statement (เข้าใจง่ายๆ เอาคำสั่ง SQL ไป query) ที่ Blind param แล้วไปทำงานกับ Database
    $prepareDataUserLogin->execute();

      // get_result() คือการนำ ObJect ที่ได้จากการ execute มาแปลงเป็นลักษณะ Array  
    $result = $prepareDataUserLogin->get_result();

     /*   $result->num_rows คือ การนับแถวชุดข้อมูล  num_row คือ Method ที่ไว้นับแถวข้อมูล
        โดยที่เงื่อน > 0  หมายถึง เช็คว่า $result ที่เก็บค่าข้อมูลแบบลักษณะ Array ว่ามีข้อมูลหรือไม่ (ไม่มีข้อมูลจะนับได้ 0)
    */ 
    if($result->num_rows > 0 ){
        /*  fetch_assoc()  คือการดึงข้อมูลใน Array ในแต่ละแถว (ง่ายๆ คือการเข้าถึงข้อมูลแถวใน Array)  */
        $user = $result->fetch_assoc();

        /* fetch_asscoc ทำให้ตัวแปร $user สามารถระบุ Key filed  เพื่อระบุข้อมูลได้  */
        $olduserID = $user['userID'];
        $oldemail = $user['email'];
        $oldfirstName = $user['firstName'];
        $oldlastName = $user['lastName'];
        $loduserDate = $user['userDate'];
        $loduserTime = $user['userTime'];
    } else {
    echo 'Something went wrong';
    }

    /* isset เป็นการเช็คค่าจาก ฟอร์มว่า มีการกำหนดค่าหรือไม่ (ง่ายๆ คือกดปุ่มแล้ว ทำงาน) 
        โดยที่ใช้ $_POST['userID] เพราะเป็นค่าที่เปลี่ยนแปลงไม่ได้และแสดงโชว์ในฟอร์มไว้เฉยๆ (แปลว่ายังไงก็ทำงาน) */
    if(isset($_POST['userID'])) {

    // สร้าง Variable มาเก็บค่าจาก ฟอร์ม
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

        // เช็คว่า ฟอร์ม เป็นค่าว่าง
        if($email == '' || $firstName == '' || $lastName == '') {
            echo 'Error Please Ender Data';
        }else{
            /* สร้าง SQL เพื่ออัพเดต โดย ข้อมูล จะเป็น ? เพื่อป้องกันการโดน SQL INJECTION
                อัพเพต firstName lastName โดยอ้างอิง userID */
            // *** Update ต้องมี WHERE ทุกครั้งเพราะไม่งั้นจะเป็นการ UPDATE ทั้งตาราง  ****    
            $updateUserSQL = 'UPDATE user SET email = ? , firstName = ? , lastName = ? WHERE userID = ?'
            // Prepare Statement เป็นการเตรียมคำสั่ง SQL ก่อนจะถูกนำไปทำงานกับ Database (execute)
            // ชื่อตัวแปล = ตัวแปลที่เชื่อมต่อ Database -> prepare(SQL) 
            $prepareUpdateUser = $GLOBALS['conn']->prepare($updateUserSQL);
            /*  Bind param คือการกำหนดค่า ? ของ SQL โดยที่ "ss" หมายถึงชนิดตัวแปล (s = String , i = integer ที่ใช้บ่อยๆ)
                ตามด้วยตัวแปลที่เก็บค่าที่ต้องการเพิ่มไปใน SQL ซึ่งจะปลอดภัยจากการโดน SQL INJECTION */ 
            $prepareUpdateUser->bind_param("sssi",$email,$firstName,$lastName,$loginUserID);
            /* execute คือการนำ Prepare Statement (เข้าใจง่ายๆ เอาคำสั่ง SQL ไป query) ที่ Blind param แล้วไปทำงานกับ Database
               ทำการเช็คว่า execute ผ่านหรือไม่ */
           if( $result = $prepareUpdateUser->execute()) {
            echo ' Update user successfully';
           } else{
            echo 'Update user failed';
           }
            // ปิด prepareUpdateUser Statement
            $prepareUpdateUser->close();
        }
    }
    // ปิด prepareDataUserLogin Statement
    $prepareDataUserLogin->close();
?>