<?php
require '../server/database.php';

$customCSS = array('<link href="../assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">');

$customJAVA = array(
  '<script src="../assets/plugins/apexcharts/apexcharts.min.js"></script>',
  '<script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>',
  '<script src="../assets/js/pages/dashboard.js"></script>'
);

$page_title = 'VHAL Database Center';

include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

$TotalAccountQry = $db->query("SELECT * FROM users");
$TotalAccountCount = $TotalAccountQry->rowCount();

$vip = $db->query("SELECT * FROM users WHERE k_rol = 1");
$vips = $vip->rowCount();

$admin = $db->query("SELECT * FROM users WHERE k_rol = 2");
$admins = $admin->rowCount();

$says = $db->query("SELECT değer FROM sayaç WHERE id = 1")->fetchColumn();

$free = $db->query("SELECT * FROM users WHERE k_rol = 0");
$frees = $free->rowCount();

$k_ad = $db->query("SELECT * FROM users WHERE k_adi");
$adi = $k_ad->rowCount();

$OnlineTimezone = date('d.m.y H:i');
$OnlineAccountQry = $db->query("SELECT * FROM users WHERE k_updatesync = '$OnlineTimezone'");
$OnlineCount = $OnlineAccountQry->rowCount();

$admine = date('d.m.y H:i');
$adminn = $db->query("SELECT * FROM users WHERE k_updatesync = '$admine' AND k_rol = 2");
$admini = $adminn->rowCount();

$MembershipSSID = $_SESSION['GET_USER_SSID'];
$MemberhsipQuery = $db->query("SELECT * FROM users WHERE k_key = '$MembershipSSID'");

while ($MembershipData = $MemberhsipQuery->fetch()) {
  $Level = $MembershipData['k_rol'];
  $getNick = $MembershipData['k_adi'];
  $short = substr($MembershipData['k_time'], 0, 11);
  $short2 = str_replace("-", ".", $short);
  $endtime = $short2;
}
if ($Level == "2") {
  $membership = "Admin";
} elseif ($Level == "1") {
  $membership = "V!P";
} else {
  $membership = "Normal Üye";
}

// k_rol değerine göre renk sınıflarını belirleyin
$isim_rengi = '';
if ($Level == 1) {
    $isim_rengi = 'red'; // Kırmızı isim rengi
} elseif ($Level == 2) {
    $isim_rengi = '#ff00ff'; // Pembe isim rengi
} elseif ($Level == 0) {
    $isim_rengi = 'yellow'; // Sarı isim rengi
} else {
    $isim_rengi = 'black'; // Varsayılan olarak siyah isim rengi
}


?>
<style>
  .card-body {
    border: 1px solid #30363d;
    border-radius: 6px;
    border-color: #2d2d3f !important;
  }

  h9 {
    font-size: 16px !important;
  }

</style>

<div class="main-wrapper">
  <div class="row">
    <div class="col-md-3">
      <div class="card stats-card">
        <div class="card-body">
          <div class="stats-info">
            <h9 class="card-title">Toplam Kullanıcılar<span class="stats-change stats-change-info"></span></h9>
            <h4 class="stats-text"><span style="color: white;"><?php echo $TotalAccountCount; ?></span></h4>
          </div>
          <div class="stats-icon change-danger" style="background-color: transparent !important;box-shadow: none;border: none;">
            <i class="material-icons">groups</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card stats-card">
        <div class="card-body">
          <div class="stats-info">
            <h9 class="card-title">Aktif Kullanıcılar<span class="stats-change stats-change-success"></span></h9>
            <p class="stats-text"><span style="color: white;"><?php echo $OnlineCount; ?></span></p>
          </div>
          <div class="stats-icon change-success" style="background-color: transparent !important;box-shadow: none;border: none;">
            <i class="material-icons">rocket_launch</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card stats-card">
        <div class="card-body">
          <div class="stats-info">
            <h9 class="card-title">Mevcut Üyeliğiniz<span class="stats-change stats-change-success"></span></h9>
            <p class="stats-text"><span style="color: white;"><?= $membership; ?></span></p>
          </div>
          <div class="stats-icon change-success" style="background-color: transparent !important;box-shadow: none;border: none;">
            <i class="material-icons">card_membership</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="card">
      <div class="card-body" style="border-radius: 4px !important;">
        <h5 style="font-size: 19px" class="card-title">Genel Sohbet</h5>
        <div id="chat-container">

        </div>
        <hr>
        <form id="chat-form">
          <input type="text" class="form-control" id="chat-message" autocomplete="off" maxlength="75" minlength="1" name="message" placeholder="Mesaj..." required>
          <div style="padding: 5px;"></div>
          <button type="submit" class="btn btn-primary">Gönder</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
          $(function() {
            var chatContainer = $('#chat-container');
            var chatForm = $('#chat-form');
            var chatMessage = $('#chat-message');

            function fetchMessages() {
              $.ajax({
                url: 'pages/api/get_messages.php',
                type: 'GET',
                success: function(data) {
                  chatContainer.html(data);
                  chatContainer.scrollTop(chatContainer.prop('scrollHeight'));
                },
                error: function() {
                  console.log('error');
                }
              });
            }


            fetchMessages();
            setInterval(fetchMessages, 2000);

            chatForm.on('submit', function(event) {
              event.preventDefault();
              var message = chatMessage.val();
              $.ajax({
                url: 'pages/api/send_message.php',
                type: 'POST',
                data: {
                  message: message
                },
                success: function(response) {
                  if (response == "swear") {
                    toastr.error('Küfür etmek yasaktır.');
                  } else if (response == "limit") {
                    toastr.error("Hız limiti aşıldı, lütfen bir süre bekleyin.");
                  } else if (response == "numeric") {
                    toastr.error("Sohbetimizde sayısal veri kullanımına izin vermiyoruz.");
                  } else if (response == "special") {
                    toastr.error("Özel karakterler kullanılamaz.");
                  }
                  chatMessage.val('');
                },
                error: function() {
                  console.log('error');
                }
              });
            });
          });
        </script>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body" style="padding-bottom: 9vh;">
          <h5 style="font-size: 19px" class="card-title">Hesap Bilgileriniz</h5>
          <table id="01000001" class="display" style="width:100%;">
            <thead>
              <tr>
                <th>Kullanıcı Adı</th>
                <th>Kalan Zaman</th>
                <th>İşletim Sistemi</th>
                <th>Tarayıcı</th>
                <th>Son Giriş Tarihi</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $query = $db->query("SELECT * FROM `users` WHERE `k_key` = '$MembershipSSID'");

              while ($getvar = $query->fetch()) {

                $uyetarih = $getvar['k_time'];

                if ($uyetarih != "") {
                  $nowDate = date("Y-m-d");
                  $d1 = new DateTime($nowDate);
                  $d2 = new DateTime($uyetarih);
                  $gun = $d1->diff($d2)->days;
                }

              ?>
                <tr>
                  <td><span style="color: <?php echo $isim_rengi; ?>"><?php echo $getNick; ?></p></span></td>
                  <td><?php echo $gun; ?> Gün</td>
                  <td>
                    <div class="platform_icon"><?php getos($getvar['k_os']) ?></div>
                  </td>
                  <td><?php echo $getvar['k_browser']; ?></td>
                  <td><?php echo $getvar['k_lastlogin']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <!-- Card for announcement panel -->
        <div class="card-body">
          <h5 class="card-title">Duyurular</h5>
          <div class="table-responsive">
            <table id="01000001" class="table table-hover" style="width:100%;">
              <!-- Table header -->
              <thead>
                <tr>
                  <th style="padding: 15px;">İçerik</th>
                </tr>
              </thead>
              <!-- Table body -->
              <tbody>
                <?php
                $query = $db->query("SELECT * FROM `news` LIMIT 3");
                while ($getvar = $query->fetch()) {
                  echo '<tr><td style="padding: 15px;">' . $getvar['d_icerik'] . '</td></tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content py-3" style="position: static !important;">
  <div class="row fs-sm" style="position: static !important;">
    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
      <i class='fa fa fa-quote-left'></i> Aman Aman Nerelere Geldik <i class='fa fa fa-quote-right'></i></a>
    </div>
    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
    VHAL Database Center © <span data-toggle="year-copy" class="js-year-copy-enabled"><?= date('Y'); ?></span>
    </div>
  </div>
</div>

<?php
include('inc/footer_main.php');
?>
<script>
    // Sağ tıklama olayını yakalama
    window.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        alert("🛑 Yasak!");
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
        alert("🛑 Yasak!");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        alert("🛑 Yasak!");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        alert("🛑 Yasak!");
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        alert("🛑 Yasak!");
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        alert("🛑 Yasak!");
        return false;
    }if (e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) {
        alert("🛑 Yasak!");
        return false;
    }
}
</script>