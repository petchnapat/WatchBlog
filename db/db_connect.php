<?php 
session_start();
$GLOBALS['conn'] = '';

function connect() {
    $servername = "localhost";
    $user = 'root';
    $pass = '';
    $database = 'webboard';
    $GLOBALS['conn']  = new mysqli($servername,$user,$pass,$database);
    if($GLOBALS['conn']->connect_error){
        die("Error connecting to Database: " . $GLOBALS['conn']->connect_error);
    }else{
        mysqli_set_charset($GLOBALS['conn'], 'utf8');
    }
}
function countRow($table, $column,$value) {
    $sql = 'SELECT * FROM '.$table.' WHERE '.$column.' = ? ';
    $preparesql = $GLOBALS['conn']->prepare($sql);
    $preparesql->bind_param("s",$value);
    $preparesql->execute();
    $result = $preparesql->get_result();
    return $result->num_rows;
}

function getData($sql) {
    $result =  mysqli_query($GLOBALS['conn'],$sql);
    $data = mysqli_fetch_assoc($result);
    return $data;
}

?>