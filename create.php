<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <title>Admin-Webinterface Telefonanlage GSO</title>
</head>
<body>
<!-- A grey horizontal navbar that becomes vertical on small screens -->
<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <a class="navbar-brand" href="/"><img src="https://www.gso-koeln.de/images/logos/gso-bk-logo.jpg" alt="Logo"></a>
    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/">Hauptseite</a>
        </li>
    </ul>

</nav>
<br>
<div class="container">
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (isset($_POST['id']) && isset($_POST['password'])) {
        $mysql = new mysqli('localhost', 'root', 'abschluss.osp', 'asterisk');
        if ($mysql->connect_errno) {
            printf("Connect failed: %s\n", $mysql->connect_error);
            exit();
        }
        if ($stmt = $mysql->prepare("INSERT INTO ps_auths(id,auth_type,password,username) VALUES(?,'userpass',?,?)")) {
            $stmt->bind_param("sss", $_POST['id'], $_POST['password'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("INSERT INTO ps_aors(id,max_contacts,remove_existing,qualify_frequency) VALUES(?,5,1,15)")) {
            $stmt->bind_param("s", $_POST['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("INSERT INTO ps_endpoints(id,transport,aors,auth,context,disallow,allow) VALUES(?,'transport-tcp-tls',?,?,'default','all','g722,ulaw')")) {
            $stmt->bind_param("sss", $_POST['id'], $_POST['id'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("INSERT INTO extensions(id,context,exten,priority,app,appdata) VALUES(?,'default',?,1,'Dial',?)")) {
            $arg_appdata = "PJSIP/" . $_POST['id'] . ",20";
            $stmt->bind_param("sss", $_POST['id'], $_POST['exten'], $arg_appdata);
            $stmt->execute();
            $stmt->close();
        }
        $mysql->close();
    }
    ?>
    <form action="create.php" method="post">
        <label>Benutzername:</label>
        <input class="form-control" type="text" name="id">

        <label>Passwort: </label>
        <input class="form-control" type="text" name="password">

        <label>Rufnummer:</label>
        <input class="form-control" type="number" name="exten">

        <input type="submit" class="btn btn-success" value="Benutzer erstellen">
    </form>
</div>
</body>
</html>