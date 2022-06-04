<?php
    include_once 'ImportDB.php';
    $date_in = $_GET['date_in'];
    $date_out = $_GET['date_out'];
    $sql = "SELECT start, stop, in_trafic, out_trafic, FID_Client FROM seanse WHERE start BETWEEN ? AND ?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($date_in,$date_out));
    $res = $sth->fetchAll();
    header('Content-Type:text/xml');
    header("Cache-Control: no-cache, must-revalidate");
    echo "<?xml version='1.0' encoding='utf8' ?>";
    echo "<root>";
    foreach ($res as $row)
    {
        $start=$row[start];$stop=$row[stop];$in_trafic=$row[in_trafic];$out_trafic=$row[out_trafic];$FID_Client=$row[FID_Client];
        echo "<row><start>$start</start><stop>$stop</stop><in_trafic>$in_trafic</in_trafic><out_trafic>$out_trafic</out_trafic><FID_Client>$FID_Client</FID_Client></row>";
    }
    echo "</root>";



    /*echo "<table border = 1 align = 'center'> <tr> <th>Начало сеанса</th> <th>Конец сеанса</th> <th>Входящий трафик</th> <th>Исходящий трафик</th> <th>Номер Клиента</th></tr>";
    foreach ($res as $row)
    {
        echo "<tr> <th>$row[start]</th> <th>$row[stop]</th> <th>$row[in_trafic]</th> <th>$row[out_trafic]</th> <th>$row[FID_Client]</th></tr>";
    }
    echo "</table>";*/

?>