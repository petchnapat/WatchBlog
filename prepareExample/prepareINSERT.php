<?php
  // สร้างตัวแปลเก็บค่าจาก ฟอร์ม
  $email = $_POST['email'];
  $userPassword = md5($_POST['userPassword']);
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  
    // สร้าง SQL เพื่อเพิ่มข้อมูล โดน VALUES จะเป็น ? เพื่อป้องกันการโดน SQL INJECTION
  $addUserSql = 'INSERT INTO Users (email,userPassword,firstName,lastName,userDate,userTime) 
                VALUES (?, ?, ?, ?, CURRENT_DATE, CURRENT_TIME) ';

    // Prepare Statement เป็นการเตรียมคำสั่ง SQL ก่อนจะถูกนำไปทำงานกับ Database (execute)
    // ชื่อตัวแปล = ตัวแปลที่เชื่อมต่อ Database -> prepare(SQL) 
  $prepareRegister = $GLOBALS['conn']->prepare($addUserSql);

    /*  Bind param คือการกำหนดค่า ? ของ SQL โดยที่ "ssss" หมายถึงชนิดตัวแปล (s = String , i = integer ที่ใช้บ่อยๆ)
        ตามด้วยตัวแปลที่เก็บค่าที่ต้องการเพิ่มไปใน SQL ซึ่งจะปลอดภัยจากการโดน SQL INJECTION
    */ 
  $prepareRegister->bind_param("ssss",$email,$userPassword,$firstName,$lastName);

  // execute คือการนำ Prepare Statement ( เข้าใจง่ายๆ เอาคำสั่ง SQL ไป query ) ที่ Blind param แล้วไปทำงานกับ Database
  if($prepareRegister->execute()){
    echo "Register Success";
  }else {
    echo "Something Wrong !! Cann't Register";
  }
  // ปิดการทำงานของ Prepare Statement
  $prepareRegister->close();
?>