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
            <a class="nav-link active" href="/">Hauptseite</a>
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
    if ($result = $mysql->query("SELECT ps_auths.id, password, exten FROM ps_auths INNER JOIN extensions ON CONCAT('PJSIP/',ps_auths.id,',20')=extensions.appdata WHERE extensions.priority = 1 AND extensions.context = 'default'")) {
        printf("Es gibt %d Benutzer.\n", $result->num_rows);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
    }
    $mysql->close();
    ?>
    <table class="table table-light">
        <thead>
        <tr>
            <th scope="col">Rufnummer</th>
            <th scope="col">Benutzername</th>
            <th scope="col">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $entry) {
            ?>
            <tr>
                <td><?php echo $entry['exten']; ?></td>
                <td><?php echo $entry['id']; ?></td>
                <td>
                    <a type="button" class="btn btn-warning" href="edit.php?id=<?php echo $entry['id']; ?>">Passwort ändern</a>
                    <a type="button" class="btn btn-danger" href="delete.php?id=<?php echo $entry['id']; ?>">Löschen</a>
                    <a type="button" class="btn btn-success" href="qr.php?id=<?php echo $entry['id']; ?>">QR-Code anzeigen</a>
                <a type="button" class="btn btn-success" href="qr.php?url&id=<?php echo $entry['id']; ?>">Abruf-URL anzeigen</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <a type="button" class="btn btn-success" href="create.php">Benutzer erstellen</a>
</div>
</body>
</html>