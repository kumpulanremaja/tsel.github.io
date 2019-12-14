<?php
session_start(); #list: key, msisdn, otp, secret_token
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telkomsel Baru Murah</title>
    <link href='https://www.kumpulanremaja.com/favicon.ico' rel='icon' type='image/x-icon'/>
    
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/css/util.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/css/main.css">
</head>
<?php
    date_default_timezone_set('Asia/Jakarta');
    
    require_once('config.php');
    require('class.php');
    
    $err    = NULL;
    $ress   = NULL;
    
    if (isset($_POST) and isset($_POST['do'])){
        
        switch($_POST['do']){
            
            default: die(); exit(); break;

            case "CHANGE":{
                $key    = 'tppgaming';
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_SESSION['tipe'];
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            case "LOGOUT":{
                
                $key            = 'tppgaming';
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $otp            = $_SESSION['otp'];
                $secret_token   = $_SESSION['secret_token'];
                
                
                $tsel = new MyTsel();
                $tsel->logout($secret_token, $tipe);
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            
            case "GETOTP":{
                $key    = 'tppgaming';
                $msisdn = $_POST['msisdn'];
                
                
                if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                if ($tsel->get_otp($msisdn) == "SUKSES"){
                    
                    session_regenerate_id();
                    $_SESSION['key'] = $key;
                    $_SESSION['msisdn'] = $msisdn;                    
                    session_write_close();

                }
                else
                {
                    $err = "Error: msisdn salah";
                }
            }
            break;
            
            case "LOGIN":{
                $key    = 'tppgaming';
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_POST['tipe'];
                $otp    = $_POST['otp'];
                
                //if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                $login = $tsel->login($msisdn, $otp, $tipe);
                
                
                if (strlen($login) > 0){

                    $secret_token               = trim(preg_replace('/\s+/', ' ', $login));
                    $_SESSION['otp']            = $otp;
                    $_SESSION['secret_token']   = $secret_token;
                    $_SESSION['tipe']           = $tipe;
                    
                    
                } else {
                    //echo $login;
                    $err = $login;
                }

                
            }
            break;
            
            case "BUY_PKG":{
                $key            = 'tppgaming';
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $secret_token   = $_SESSION['secret_token'];
                $pkgid          = $_POST['pkgid'];
                $transactionid  = $_POST['transactionid'];
                
                switch($_POST['pkgid']){
                case '1':
                    $pkgidman = $_POST['pkgidman'];
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgidman."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgidman, $transactionid, $tipe);
                break;
                default:
                    $tsel = new MyTsel();
                    $ress = "Hay tayo <b></b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgid, $transactionid, $tipe);
                }
                
            }
            break;
            
        }
        
    }
?>

<!-- ################################ 1 ################################ -->
<?php if (!isset($_SESSION['key']) and !isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['secret_token']) ){ ?>
<body>

    <script type='text/javascript'>
//<![CDATA[

function redirectCU(e) {
  if (e.ctrlKey && e.which == 85) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.onkeydown = redirectCU;

//Script Redirect Klik Kanan
function redirectKK(e) {
  if (e.which == 3) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.oncontextmenu = redirectKK;
//]]>
</script>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
Anime Telkomsel Murah
</span>
<!--     <form method="POST">
    <pre> -->
<div class="wrap-input100 validate-input" data-validate="Please enter your msisdn">
<input class="input100" type="text" name="msisdn" placeholder="Nomer Hp 628x">
<span class="focus-input100"></span>
</div>

<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="do" value="GETOTP" type="submit">
    <span>
<i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Minta Kode OTP
</span></button>
</div>
<!-- <input type="submit" name="do" value="GETOTP"></input> -->
<?php if(!empty($err)) echo $err ?> 
<!--     </pre> -->
<br>
Gunakan format nomer 62
<br>
Developers Bye Wibu Anime Indonesia
</form>
</div>
</div>
</body>

<!-- ################################ 2 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['tipe']) and !isset($_SESSION['secret_token'])){ ?>
<body>
     
     <script type='text/javascript'>
//<![CDATA[

function redirectCU(e) {
  if (e.ctrlKey && e.which == 85) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.onkeydown = redirectCU;

//Script Redirect Klik Kanan
function redirectKK(e) {
  if (e.which == 3) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.oncontextmenu = redirectKK;
//]]>
</script>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
Telkomsel tembak Paket
</span>
    <center>
<label class="radio-container m-r-45">Telkom Murah
<input type="radio" checked="checked" name="tipe" value="vmp.telkomsel.com">
<span class="checkmark"></span>
</label>

        </center>
<!-- <input type="radio" name="tipe" value="vmp.telkomsel.com" checked> VMP&nbsp;&nbsp;<input type="radio" name="tipe" value="vmp-preprod.telkomsel.com"> VMP Prepod<br> -->
<div class="wrap-input100 validate-input" data-validate="Please enter your phone">
<input class="input100" type="text" value="<?= $_SESSION['msisdn']; ?>" name="phone" disabled>
<span class="focus-input100"></span>
</div>
<br>
Kode OTP
<br>
<br>
<div class="wrap-input100 validate-input" data-validate="Please enter your key">
<input class="input100" type="number" name="otp">
<span class="focus-input100"></span>
</div>
<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="do" value="CHANGE" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Ubah Nomer
<br>
</span></button>&nbsp;&nbsp;
    <button class="contact100-form-btn" name="do" value="LOGIN" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
Masuk
</span></button>
</div>
<!-- <input type="submit" name="do" value="LOGIN"></input> -->


<?php if(!empty($err)) echo $err ?>
<!--     </pre> -->
    </form>
    <br>
<center> Meminta kode OTP 
<br>
Cara 1 : Dial *323*10#
<br>
Cara 2 : Buka Aplikasi Maxstream lalu Daftar Dengan Nomer Hp Kamu
<br>

</center>
<br>

</div>
</div>
</body>


<!-- ################################ 3 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and isset($_SESSION['otp']) and isset($_SESSION['tipe']) and isset($_SESSION['secret_token'])){ ?>
<body>

     
<script type='text/javascript'>
//<![CDATA[

function redirectCU(e) {
  if (e.ctrlKey && e.which == 85) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.onkeydown = redirectCU;

//Script Redirect Klik Kanan
function redirectKK(e) {
  if (e.which == 3) {
    window.location.replace("https://telkomsel.com");
    return false;
  }
}
document.oncontextmenu = redirectKK;
//]]>
</script>
<form method="POST">
<fieldset>
    <center>
Nomer Hp :&nbsp;<?= $_SESSION['msisdn']."<br>" ?>
<input type="submit" name="do" value="LOGOUT"></input>
<hr>
<h3><u>Beli Paket internet Populer </u></h3>
PILIH&nbsp;PAKET:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pkgid" onchange="if (this.value=='1'){this.form['pkgidman'].style.visibility='visible'}else {this.form['pkgidman'].style.visibility='hidden'};" style="width: 50%;">
      <option value="#">Pilih Paket</option>

  <option value="00016038">OMG (VIU) 5GB Harga : Rp.10.000 / 30 Hari</option>
  <option value="00016036">OMG (KlikFilm) 5GB Harga : Rp.10.000 / 30 Hari</option>


  
  <option value="00009382">Maxstream 1GB harga :Rp 10 / 2 hari</option>
   <option value="00021308">Maxstream 1GB harga :Rp 10 / 30 hari </option>
  <option value="00010654">Maxstream 1GB Harga : Rp.10.000 / 2 Hari</option>
  <option value="00007221">Maxstream 1GB Harga : Rp.10.000 / 7 Hari</option>
      <option value="00016090">Makstream 5GB (Iflix) Harga : Rp.10.000 / 30 Hari </option>
  <option value="00016030">Maxstream 10GB Harga : Rp.10.000 / 30 Hari</option>
    <option value="00007333">Maxstream V1 30GB Harga : Rp.30.000 / 30 Hari</option>
    <option value="00016035">Maxstream V2 30GB Harga : Rp.30.000 / 30 Hari</option>

  <option value="00020943">Flash4G 50GB Harga : Rp.50.000 / 7 Hari</option>
  <option value="00016199">AddONMax 30GB Harga : Rp.30.000 / 30 Hari</option>
  <option value="00015185">Gigamax 6GB Harga : Rp.25.000 / 30 Hari</option>
 
     <option value="00009044">midnight 1GB Harga : Rp.2.000 / 2 Hari</option>
     <option value="00009033">Midnight 5GB Harga : Rp.5.000 / 30 Hari</option>
     
     <option value="00016150">DEMO OMG 10 GB Harga : Rp.10.000 / 30 Hari</optio>
     
     
  <option value="00017486">DATA 17GB COMBO (closed)</option>
  <option value="00013440">Paket Daily SMS Personal 12 Rp2.000</option>
  <option value="00013440">Paket Daily SMS Personal 2 Rp500</option>
     
     
</select><br>


TRANSACTIONID:<input type="text" name="transactionid" style="width: 50%;" value="A301180826192021277131740"></input><br>
<input type="submit" name="do" value="BUY_PKG"></input><br><br>
<?php  echo $err ?> 
<hr>
Maksimal Tembak paket : 5 kali / Bulan
<br>
Developers Bye Wibu Anime Indonesia

</center>


</fieldset>


</form>
</body>
<?php } ?>
