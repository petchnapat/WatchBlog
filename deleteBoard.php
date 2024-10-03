<?php 
            require 'db/db_connect.php';
            connect();
            $userID = $_GET['userID'];
            $boardID = $_GET['boardID'];   
            
            if(!isset($_SESSION['userID'])){
               header( "refresh:0; url=index.php" );
            }else if($_SESSION['userID'] != $_GET['userID'] && $_SESSION['userRole'] != 1 ){
               header( "refresh:0; url=boardDetail.php?boardID= $boardID" );
            }else if(@$_GET['myboard']==1) {
                $decommnetSQL = 'DELETE comment FROM comment JOIN board ON comment.boardID = board.boardID WHERE board.boardID = ?  ';
                $preparedecommnetSQL = $GLOBALS['conn']->prepare($decommnetSQL);
                $preparedecommnetSQL->bind_param("i",$boardID);
                $preparedecommnetSQL->execute();
                $preparedecommnetSQL->close();
                $deBoardSQL = 'DELETE FROM board WHERE boardID = ? ; ';
                $preparedeBoardSQL = $GLOBALS['conn']->prepare($deBoardSQL);
                $preparedeBoardSQL->bind_param("i",$boardID);
                $preparedeBoardSQL->execute();
                $preparedeBoardSQL->close();
                header("refresh:0; url=myboard.php");
            }else if(@$_GET['admin']==1){
               $_SESSION['delete'] = true;
               $decommnetSQL = 'DELETE comment FROM comment JOIN board ON comment.boardID = board.boardID WHERE board.boardID = ?  ';
               $preparedecommnetSQL = $GLOBALS['conn']->prepare($decommnetSQL);
               $preparedecommnetSQL->bind_param("i",$boardID);
               $preparedecommnetSQL->execute();
               $preparedecommnetSQL->close();
               $deBoardSQL = 'DELETE FROM board WHERE boardID = ? ; ';
               $preparedeBoardSQL = $GLOBALS['conn']->prepare($deBoardSQL);
               $preparedeBoardSQL->bind_param("i",$boardID);
               $preparedeBoardSQL->execute();
               $preparedeBoardSQL->close();
               header("refresh:0; url=adminBoard.php");
            } else {
                $_SESSION['delete'] = true;
                $decommnetSQL = 'DELETE comment FROM comment JOIN board ON comment.boardID = board.boardID WHERE board.boardID = ?  ';
                $preparedecommnetSQL = $GLOBALS['conn']->prepare($decommnetSQL);
                $preparedecommnetSQL->bind_param("i",$boardID);
                $preparedecommnetSQL->execute();
                $preparedecommnetSQL->close();
                $deBoardSQL = 'DELETE FROM board WHERE boardID = ? ; ';
                $preparedeBoardSQL = $GLOBALS['conn']->prepare($deBoardSQL);
                $preparedeBoardSQL->bind_param("i",$boardID);
                $preparedeBoardSQL->execute();
                $preparedeBoardSQL->close();
                 header("refresh:0; url=index.php");
            }
    ?>