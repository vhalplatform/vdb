<?php

error_reporting(0);

session_start();

include "../../server/database.php";

include "../../server/rolecontrol.php";

if (isset($_POST)) {

  $message = htmlspecialchars(strip_tags($_POST['message']));

  if ($message != "" && strlen($message) < 75) {

    $messagessid = $_SESSION['GET_USER_SSID'];

    $messagequery = $db->query("SELECT * FROM `users` WHERE k_key = '$messagessid'");

    while ($messagedata = $messagequery->fetch()) {
      $getusername = $messagedata['k_adi'];
      $getpremium = $messagedata['k_premium'];
      $getadmin = $messagedata['k_rol'];
      $getimage = $messagedata['k_image'];
    }

    function Image($getimage)
    {
      if ($getimage != "") {
        $Output = $getimage;
      } else {
        $Output = "assets/img/userkls.jpeg";
      }
      return $Output;
    }

    $username = $getusername; // kullanıcı adı

    $time = date('Y-m-d H:i:s'); // gönderim zamanı


    session_start();
    $limit = 60; // saniye cinsinden limit (1 dakika)
    $max_messages = 7; // 1 dakikada en fazla gönderilebilecek mesaj sayısı
    if (isset($_SESSION['message_count']) && isset($_SESSION['last_message_time']) && time() - $_SESSION['last_message_time'] < $limit) {
      // hız limiti aşıldı
      if ($_SESSION['message_count'] >= $max_messages) {
        exit('limit');
        die();
      } else {
        $_SESSION['message_count']++;
      }
    } else {
      $_SESSION['message_count'] = 1;
      $_SESSION['last_message_time'] = time();
    }

    if (is_numeric($message)) {
      exit("numeric");
      die();
    }

    if (preg_match('/http(s)?:\/\/[^\s]+/', $_POST['message'])) {
      exit("special");
      die();
    }


    $sql = "INSERT INTO messages (username, message, time, image, admin, premium) VALUES (:username, :message, :time, :image, :admin, :premium)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':admin', $getadmin);
    $stmt->bindParam(':premium', $getpremium);
    $stmt->bindParam(':image', Image($getimage));
    $stmt->execute();
    $_SESSION['last_message_time'] = time();
    session_write_close();
  }
}
