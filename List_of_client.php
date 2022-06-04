<?php
    include_once 'ImportDB.php';
    $balance = $_GET['balance'];
    $sql = "SELECT ID_Client, name, IP, balance FROM client WHERE balance < ? ";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($balance));
    $res = $sth->fetchAll();
    header('Content-Type:application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $data;
    $i=0;
    foreach($res as $row){
        $data[$i][0]=$row['ID_Client'];
        $data[$i][1]=$row['name'];
        $data[$i][2]=$row['IP'];
        $data[$i][3]=$row['balance'];
        $i++;
    }
    
    echo json_encode($data);

?>