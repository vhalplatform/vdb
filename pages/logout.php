<?php

error_reporting(0);

session_start();

unset($_SESSION['GET_USER_SSID']);

session_destroy();

include '../server/database.php';

$ResetCookie = base64_decode($_COOKIE['cf_rtdsid']);

$update = $db->exec("UPDATE users SET k_cookie = '' WHERE k_cookie = '$ResetCookie'");

setcookie("cf_rtdsid", "", 1);

unset($_COOKIE['USER_SSO_SERVICE']);

header('Location: ../login.php');

?>
<script>
    // Sağ tıklama olayını yakalama
    window.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        alert("Köyüne Amına Kodum.");
    });
	
</script>
<script>
    // Klavyeden kısayol tuşlarını yakalama
    window.addEventListener('keydown', function(e) {
        // Klavyeden F12 tuşuna basılırsa
        if (e.keyCode == 123) {
            e.preventDefault(); // Tuşun varsayılan işlevini engelle
        }
    });
</script>
<script type="text/javascript">
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function(e) {
    if (e.keyCode == 123) {
        alert("Yasak Knks :D");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        alert("Yasak Knks :D");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        alert("Yasak Knks :D");
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        alert("Yasak Knks :D");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        alert("Yasak Knks :D");
        return false;
    }if (e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) {
        alert("Yasak Knks :D");
        return false;
    }
}
</script>