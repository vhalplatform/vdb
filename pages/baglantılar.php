<?php
include_once "../server/rolecontrol.php";

$customCSS = array();
$customJAVA = array();

$page_title = 'Üyelik Paketleri';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');
?>
<center>
<h1 style="color: white; animation: blink 5s infinite;">VHAL Database Center</h1>
  <div class="plans-container">
    <div class="plan">
      <h2>Başlık</h2>
      <br>
      <p>Açıklama 1</p>
      <p>Açıklama 2</p>
      <p>Açıklama 3</p>
      <button onclick="satinal('plan1')">Link</button>
    </div>



</center>



<style>
    /* Stil düzenlemeleri */
    body {
      font-family: Arial, sans-serif;
    }

    /* Üyelik planı kutularını yan yana göstermek için flex kullanalım */
    .plans-container {
      display: flex;
      justify-content: space-between;
    }

    /* Her bir üyelik planı kutusu */
    .plan {
      border: none; /* Kenarlıkları kaldırdık */
      padding: 20px;
      width: 23%;
    }

    /* Buton stil düzenlemesi */
    .plan button {
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
    }

    /* Yazı renklerini beyaz yap */
    h2, p {
      color: white;
    }

    @keyframes blink {
            0% { color: red; }
            20% { color: orange; }
            40% { color: yellow; }
            60% { color: green; }
            80% { color: blue; }
            100% { color: purple; }
        }
  </style>

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