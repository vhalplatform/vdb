<?php

include_once 'database.php';

include 'functions.php';

session_start();

$Token = htmlspecialchars(strip_tags($_POST['token']));

$TokenCheck = $db->query("SELECT * FROM users WHERE k_key = '$Token'");
$TokenCount = $TokenCheck->rowCount();

while ($TokenData = $TokenCheck->fetch()) {
    $Expire_Date = $TokenData['k_time'];
    $CookieValue = $TokenData['k_cookie'];
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$IPAddr = getRealIpAddr();

date_default_timezone_set('Europe/Istanbul');

$DateTimeNow = date('d.m.y H:i:s');

$GenerateCookie = base64_encode(md5(sha1(rand(1111111, 9999999))));

$GetCookie = base64_decode($_COOKIE['cf_rtdsid']);

// Kullanıcının IP adresini al

$user_ip = getRealIpAddr();

// Veritabanından IP adreslerini sorgula

$allowed_ips = array();

$result = $db->query("SELECT * FROM users WHERE k_key = '$Token'");
if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        if (substr($row['k_ip'], 0, 4) == substr($user_ip, 0, 4)) {
            $allowed_ips[] = $row['k_ip'];
        }
    }
}

// IP Class engelleme için

// else if (!in_array($user_ip, $allowed_ips)) {
//     header('location: ../login/multi');
//     exit();
// } 

if (isset($_POST['loginForm'])) {
    // CSRF token doğrulama
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Tokenlar eşleşti, işlem yapılabilir
        if ($Token == "" || $Token == '' || $Token == null || empty($Token)) {
            header('location: ../login/error');
            exit();
        } else if ($TokenCount != "1") {
            header('location: ../login/error');
            exit();
        } else if ($Expire_Date != "") {

            function kontrol($kayit, $bitis)
            {
                $ilk = strtotime($kayit);
                $son = strtotime($bitis);
                if ($ilk - $son > 0) {
                    return 1;
                } else {
                    return 0;
                }
            }

            $bugun_tarih = date('Y-m-d');

            $bitis_tarihi = $Expire_Date;

            if (kontrol($bugun_tarih, $bitis_tarihi)) {
                header('location: ../login/timeout');
                exit();
            } else {
                if ($TokenCount == "1") {
                    if ($CookieValue != "") {
                        if ($CookieValue != $GetCookie) {
                            header('location: ../login/multi');
                            exit();
                        }
                    }
                    $Browser = getrealbrowser();
                    $System = getrealsystem();

                    $update = $db->exec("UPDATE users SET 
                    k_browser = '$Browser', 
                    k_os = '$System',
                    k_lastlogin = '$DateTimeNow', 
                    k_ip = '$IPAddr' WHERE k_key = '$Token'");
                    $_SESSION['GET_USER_SSID'] = $Token;
                    session_write_close();
                    if ($CookieValue == "") {
                        $update2 = $db->exec("UPDATE users SET k_cookie = '$GenerateCookie' WHERE k_key = '$Token'");
                        setcookie("cf_rtdsid", base64_encode($GenerateCookie), time() + (31556926  * 30), "/");
                    }

                    // Retrieve the k_rol value from the session
                    $query = $db->prepare("SELECT k_rol FROM users WHERE k_key = :token");
                $query->bindParam(':token', $Token, PDO::PARAM_STR);
                $query->execute();
                $user = $query->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $k_rol = $user['k_rol'];

                    // Check the k_rol value and redirect accordingly
                    if ($k_rol == 0) {
                        header('location: https://ouo.io/TXhu7e');
                    } elseif ($k_rol == 1 || $k_rol == 2) {
                        header('location: ../panel');
                    } else {
                        header('location: ../login/error'); // Redirect to an appropriate error page if needed.
                    }

                    exit();
                } else {
                    // User not found, handle the error appropriately
                    header('location: ../login/error');
                    exit();
                }
            }
        }
    } else {
        // Tokenlar eşleşmedi, işlem reddedildi
        die("Invalid CSRF token");
        exit();
    }
}
}