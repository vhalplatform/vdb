<?php

ini_set("display_errors", 0);

error_reporting(0);

include "../server/database.php";

include '../server/rolecontrol.php';

$USERSSID = $_SESSION['GET_USER_SSID'];

$UserRoleQry = $db->query("SELECT * FROM users WHERE k_key = '$USERSSID'");

while ($UserData = $UserRoleQry->fetch()) {
    $k_rol = $UserData['k_rol'];
    $k_image = $UserData['k_image'];
}

function Image($k_image)
{
    if ($k_image != "") {
        $Output = $k_image;
    } else {
        $Output = "assets/img/userkls.jpeg";
    }
    return $Output;
}

?>
<script src="https://use.fontawesome.com/452826394c.js"></script>
<div class="page-container">
    <div class="page-sidebar">
        <img alt="image" src="https://i.hizliresim.com/g15jzqe.png" class="FR13NDS">
        <ul class="list-unstyled accordion-menu">
            <li>
                <a href="panel" style="color: white;"><i data-feather="home"></i>Ana Sayfa</a>
            </li>
            <li>
                <a href="baglantılar" style="color: white;"><i data-feather="database"></i>Bağlantılar</a>
            </li>

           


            <?php if ($k_rol == "2") { ?>
                <li>
                    <a href="#" style="color: white;"><i data-feather="lock"></i>Admin <i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul>
                        <li>
                            <a href="/users" class="active">Kullanıcılar</a>
                        </li>
                        <li>
                            <a href="/adduser" class="active">Kullanıcı Ekle</a>
                        </li>
                        <li>
                            <a href="/notice" class="active">Duyurular</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>

            <li>
                <a href="logout" style="color: white;"><i data-feather="power"></i>Çıkış Yap</a>
            </li>

        </ul>
    </div>
    <style>

.page-sidebar {
    /* Adjust the width of the sidebar */
    width: 250px;
}



    </style>