<?php 
            require 'db/db_connect.php';
            connect();
                
                 $commentID = $_GET['commentID'];
                 $userID = $_GET['userID'];
                 $boardID = $_GET['boardID'];   
                 if(!isset($_SESSION['userID'])){
                    header( "refresh:0; url=index.php" );
                 }else if($_SESSION['userID'] != $_GET['userID'] && $_SESSION['userRole'] != 1 ){
                    header( "refresh:0; url=boardDetail.php?boardID= $boardID" );
                 }else{
                     $decommnetSQL = 'DELETE FROM comment WHERE commentID = ? ';
                     $preparedecommnetSQL = $GLOBALS['conn']->prepare($decommnetSQL);
                     $preparedecommnetSQL->bind_param("i",$commentID);
                     $preparedecommnetSQL->execute();
                     $preparedecommnetSQL->close();
                     $_SESSION['delete'] = true;
                     header("refresh:0; url=boardDetail.php?boardID= $boardID");
                 }
    ?>