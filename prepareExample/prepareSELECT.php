<?php
    // login.php ไม่มีเชื่อมดาต้าเบสนะ เป็นแค่ตัวอย่าง Code
    // กำหนดค่า ตัวแปลจาก ฟอร์ม 
  $email = $_POST['email'];
    // md5() คือการเข้ารหัสแบบ md5
  $password = md5($_POST['userPassword']);
    // สร้าง SQL เพื่อดึงข้อมูล โดย VALUES จะเป็น ? เพื่อป้องกันการโดน SQL INJECTION
  $sql = 'SELECT * from users WHERE email = ? AND userPassword = ? ';

    // Prepare Statement เป็นการเตรียมคำสั่ง SQL ก่อนจะถูกนำไปทำงานกับ Database (execute)
    // ชื่อตัวแปล = ตัวแปลที่เชื่อมต่อ Database -> prepare(SQL) 
  $prepareUser =  $GLOBALS['conn']->prepare($sql);

   /*  Bind param คือการกำหนดค่า ? ของ SQL โดยที่ "ss" หมายถึงชนิดตัวแปล (s = String , i = integer ที่ใช้บ่อยๆ)
        ตามด้วยตัวแปลที่เก็บค่าที่ต้องการเพิ่มไปใน SQL ซึ่งจะปลอดภัยจากการโดน SQL INJECTION */ 
  $prepareUser->bind_param("ss",$email,$password);

  // execute คือการนำ Prepare Statement (เข้าใจง่ายๆ เอาคำสั่ง SQL ไป query) ที่ Blind param แล้วไปทำงานกับ Database
  $prepareUser->execute();

  // get_result() คือการนำ ObJect ที่ได้จากการ execute มาแปลงเป็นลักษณะ Array  
  $result = $prepareUser->get_result();

    /*   $result->num_rows คือ การนับแถวชุดข้อมูล  num_row คือ Method ที่ไว้นับแถวข้อมูล
        โดยที่เงื่อน > 0  หมายถึง เช็คว่า $result ที่เก็บค่าข้อมูลแบบลักษณะ Array ว่ามีข้อมูลหรือไม่ (ไม่มีข้อมูลจะนับได้ 0)
    */ 
  if($result->num_rows > 0) {

    /*  **  ตัวอย่าง ในกรณีนี้คือรู้ว่ามีชุดข้อมูลแค่ 1 แถว **
     fetch_assoc()  คือการดึงข้อมูลใน Array ในแต่ละแถว (ง่ายๆ คือการเข้าถึงข้อมูลแถวใน Array) 
    */
     $row = $result->fetch_assoc();

    /*   คือการเก็บค่าใน $_SESSION['userID'] และ  และสามารถนำไปใช้งานในการทำงานเกี่ยวกับ Login 
       จากการ fetch_asscoc ทำให้ตัวแปร $row สามารถระบุ Key filed  เพื่อระบุข้อมูลได้
    */
    $_SESSION['userID'] = $row['userID'];

    /* **  ตัวอย่างกรณีมีข้อมูลมากกว่า 1 แถว **
      การทำงานคือ เข้าถึงข้อมูลในแถวแรก จากนั้นไปแถวต่อไปเรื่อยๆ (แถว 1 ไป แถว 2 ไปแถว 3 ไป แถว ..... จนถึงแถว n) 
      เมื่อไม่มีข้อมูในแถวแล้ว  จะคืนค่า False (0) ทำให้ While หยุดการทำงาน **ใช้ foreach แทนได้ **
    */
    while ($row = $result->fetch_assoc()){
        // ทำให้สามารถค่อยๆ เข้าถึงข้อมูลในแถวได้ (Loop) โดยระบุ Key filed (Colums) ในแต่ละแถว
        echo $row['userID'];
    }

    echo ' Login successful';

  } else {
        echo ' Something went wrong please try again';
  }
  // ปิด Prepare Statement
  $prepareUser->close();
?>