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
    if (isset($_GET['id']) && isset($_GET['confirmed'])) {
        $mysql = new mysqli('localhost', 'root', 'abschluss.osp', 'asterisk');
        if ($mysql->connect_errno) {
            printf("Connect failed: %s\n", $mysql->connect_error);
            exit();
        }
        if ($stmt = $mysql->prepare("DELETE FROM ps_endpoints WHERE id=?")) {
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("DELETE FROM ps_auths WHERE id=?")) {
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("DELETE FROM ps_aors WHERE id=?")) {
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $stmt->close();
        }
        if ($stmt = $mysql->prepare("DELETE FROM extensions WHERE appdata=CONCAT('PJSIP/',?,',20')")) {
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $stmt->close();
        }
        $mysql->close();
    }
    ?>
    <h1>Wollen Sie den Benutzer <span style="font-family: Courier"><?php echo $_GET['id']; ?></span> wirklich l&ouml;schen?</h1>
    <a href="delete.php?confirmed&id=<?php echo $_GET['id']; ?>" class="btn btn-danger btn-lg">Best&auml;tigen</a>
</div>
</body>
</html>