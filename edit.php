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
    $mysql = new mysqli('localhost', 'root', 'abschluss.osp', 'asterisk');
    if ($mysql->connect_errno) {
        printf("Connect failed: %s\n", $mysql->connect_error);
        exit();
    }
    if(isset($_GET['id']) && isset($_POST['password'])) {
        $stmt = $mysql->prepare("UPDATE ps_auths SET password=? WHERE id=?");
        $stmt->bind_param("ss", $_POST['password'], $_GET['id']);
        $stmt->execute();
        $stmt->close();
    }
    if ($stmt = $mysql->prepare("SELECT ps_auths.id, password, exten FROM ps_auths INNER JOIN extensions ON CONCAT('PJSIP/',ps_auths.id,',20')=extensions.appdata WHERE ps_auths.id=? AND extensions.priority = 1 AND extensions.context = 'default'")) {
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($id, $password, $exten);
        $stmt->fetch();
        $stmt->close();
    }
    $mysql->close();
    ?>
    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label>Benutzername:</label>
        <input class="form-control" type="text" name="id" disabled value="<?php echo $id; ?>">

        <br>
        <label>Rufnummer:</label>
        <input class="form-control" type="text" name="password" disabled value="<?php echo $exten; ?>">

        <br>
        <label>Passwort:</label>
        <input class="form-control" type="text" name="password" value="<?php echo $password; ?>">

        <br>
        <input type="submit" class="btn btn-success" value="Passwort aktualisieren">
    </form>
</div>
</body>
</html>