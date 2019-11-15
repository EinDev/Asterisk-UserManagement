<?php
    include 'lib/phpqrcode/qrlib.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $mysql = new mysqli('localhost', 'root', 'abschluss.osp', 'asterisk');
    if ($mysql->connect_errno) {
        printf("Connect failed: %s\n", $mysql->connect_error);
        exit();
    }
    $data='';
    if ($stmt = $mysql->prepare("SELECT ps_auths.id, password, exten FROM ps_auths INNER JOIN extensions ON CONCAT('PJSIP/',ps_auths.id,',20')=extensions.appdata WHERE ps_auths.id = ?")) {
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($id, $password,$exten);
        $data = $stmt->fetch();
        $stmt->close();
    }
    $pass=md5($id.':asterisk:'.$password);
    if(isset($_GET['url'])) {
        echo 'http://192.168.188.23/genconfig.php?username='.$id.'&pass='.$pass;
    } else {
        QRcode::png('http://192.168.188.23/genconfig.php?username='.$id.'&pass='.$pass);
        $mysql->close();
    }