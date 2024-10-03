<?php
    // รับค่าจาก ตัวแปรจาก GET
    $userID = $_GET['userID'];
    // SQL DELETE จาก ID  ** DELETE ต้องมี WHERE ไม่งั้นมันจะลบข้อมูลทั้งตาราง **
    $deleteUserSQL = 'DELETE FROM users WHERE userID = ? ';

     // Prepare Statement เป็นการเตรียมคำสั่ง SQL ก่อนจะถูกนำไปทำงานกับ Database (execute)
    // ชื่อตัวแปล = ตัวแปลที่เชื่อมต่อ Database -> prepare(SQL) 
    $prepareDeleteUser = $GLOBALS['conn']->prepare($deleteUserSQL);

    /*  Bind param คือการกำหนดค่า ? ของ SQL โดยที่ "i" หมายถึงชนิดตัวแปล (s = String , i = integer ที่ใช้บ่อยๆ)
        ตามด้วยตัวแปลที่เก็บค่าที่ต้องการเพิ่มไปใน SQL ซึ่งจะปลอดภัยจากการโดน SQL INJECTION */ 
    $prepareDeleteUser->bind_param("i", $userID);

    // execute คือการนำ Prepare Statement ( เข้าใจง่ายๆ เอาคำสั่ง SQL ไป query ) ที่ Blind param แล้วไปทำงานกับ Database
    // มีการเช็คเงื่อนไขในกรณี excute ไม่ผ่าน
    if($prepareDeleteUser->execute()) {
        echo   'Delete user Success';
    }else{
        echo  'Delete user Failure';
    }
    $prepareDeleteUser->close();
?>