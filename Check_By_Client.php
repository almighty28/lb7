<?php
    include_once 'ImportDB.php';
    $selected = $_GET['select1'];
    $sql = "SELECT start, stop, in_trafic, out_trafic FROM seanse WHERE FID_Client = :client";
    $sth = $dbh->prepare($sql);
    $sth->execute(array(':client'=>$selected));
    $res = $sth->fetchAll();
    if($selected!=null){
    echo "<table border = 1 align = 'center'> <tr> <th>Начало сеанса</th> <th>Конец сеанса</th> <th>Входящий трафик</th> <th>Исходящий трафик</th> </tr>";
    foreach ($res as $row) 
    {
        echo "<tr> <th>$row[start]</th> <th>$row[stop]</th> <th>$row[in_trafic]</th> <th>$row[out_trafic]</th> </tr>";
    }
    echo "</table>";}
    else echo "Оберіть клієнта!";
?>