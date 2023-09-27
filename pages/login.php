<style>
        

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 2px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            z-index: 2; /* Daha yüksek bir z-index değeri */
        }

        .popup img {
            width: 100%;
            height: auto;
        }

        .popup .close-button {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 5px;
            background-color: transparent;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
            color: white;
        }

        .popup .close-button:hover {
            background-color: #30304d;
        }
    </style>

<div class="background"></div>

<!--<div class="popup">
    <img src="/assets/img/reklam.jpg" alt="Reklam Resmi">
    <button class="close-button" onclick="closePopup()">KAPAT</button>
</div>

<script>
    function closePopup() {
        document.querySelector('.popup').style.display = 'none';
        document.querySelector('.background').style.display = 'none';
    }
</script>-->
<?php

include '../server/database.php';

error_reporting(0);

session_start();

if ($_SESSION['GET_USER_SSID'] != "") {
    header('Location: /panel');
    exit();
}

// CSRF token oluşturma
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page_title = 'Giriş Yap';

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title ?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="../assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="../assets/plugins/pace/pace.css" rel="stylesheet">
    <link rel="icon" href="../assets/img/vv.gif">
    <script src="https://google.com/recaptcha/api.js"></script>
    <link href="../assets/css/main.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }

        .overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: -100;
        }

        .card {
            box-shadow: 20px 20px 50px rgba(0, 0, 0, 0.5);
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.1);
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            padding: 10px;
        }

        .Logo {
            margin-right: 0;
            width: auto;
            height: 70px;
            margin: 5px auto;
            display: block;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        #key:focus {
            background-color: red;
        }

        .alert-danger {
            background: rgba(234, 84, 85, 0.12) !important;
            color: #ea5455 !important;
        }

        .alert {
            position: relative;
            padding: 0.99rem 1rem;
            margin-bottom: 1rem;
            border: 0 solid transparent;
            border-radius: 0.358rem;
        }

        input {
            background-color: transparent !important;
            display: table-cell;
            width: 100%;
            padding-top: 0;
            padding-bottom: 0;
            font-size: inherit;
            color: #c9d1d9;
            background: none;
            box-shadow: none;
            border: 1px solid #30363d !important;
        }

        input:focus {
            box-shadow: none !important;
        }

        img:hover {
            transition: 1s;
            filter: grayscale(100%);
        }

        button:hover {
            box-shadow: none !important;
            opacity: 0.8;
        }

        .animasyonlu-yazi {
            font-size: 17px;
            text-align: center;
            padding: 5px;
            color: red;
            white-space: nowrap;
            font-weight: bold;
            overflow: hidden;
            text-shadow: 0px 0px 30px red;
            animation: yazikaydir 3s steps(30, end) forwards;
        }

        @keyframes yazikaydir {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>
    <script>
        const yazi = document.getElementById("yazi");
        yazi.addEventListener("animationend", () => {
            yazi.style.animation = "none";
        });
    </script>
</head>

<body class="login-page">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div style="  backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    background-color: #010409;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.125);border: none;" class="card login-box-container">
                    <div class="card-body">
                        <div class="animasyonlu-yazi" id="yazi">Hoşgeldin!</div>
                        <img style="height: 135px;border-radius: 50%;" alt="image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cc/Milli_E%C4%9Fitim_Bakanl%C4%B1%C4%9F%C4%B1_Logo.svg/2048px-Milli_E%C4%9Fitim_Bakanl%C4%B1%C4%9F%C4%B1_Logo.svg.png" class="Logo">
                        <div style="padding: 3.5px;"></div>
                        <?php if (htmlspecialchars($_GET["alert"]) == 'error') { ?>
                            <div class="alert alert-danger" role="alert">
                                Kullanıcı bulunamadı!
                            </div>
                        <?php } else if (htmlspecialchars($_GET["alert"]) == 'timeout') { ?>
                            <div class="alert alert-danger" role="alert">
                                Bu kullanıcının süresi dolmuştur!
                            </div>
                        <?php } else if (htmlspecialchars($_GET["alert"]) == 'multi') { ?>
                            <div class="alert alert-danger" role="alert">
                                Hesabınızı başka bir şahıs ile paylaşamazsınız!
                            </div>
                        <?php } ?>
                        <form action="../server/authorization.php" method="POST">
                            <div class="mb-3">
                            <div class="form-floating">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input required style="background-color: transparent;width: 100%;" name="token" type="password" class="form-control" id="floatingPassword" placeholder="Anahtar">
    <label for="floatingPassword">Anahtar</label>
</div>

                            </div>
                            <div class="d-grid">
                                <button style="background-color: #ADA6F2; border: none;width: 340px;" name="loginForm" type="submit" class="btn btn-info m-b-xs">Giriş Yap</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php include('inc/footer_main.php'); ?>

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
