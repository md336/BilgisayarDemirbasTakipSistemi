
<?php 
ob_start();
session_start();

require 'baglan.php';

if(isset($_POST['kayit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password_again= @$_POST['password_again'];

    if(!$username){
        echo "Lütfen Kullanıcı adınızı girin";
    }elseif(!$password || !$password_again){
        echo"lütfen şifrenizi girin";
    }elseif($password != $password_again){
        echo"Girdiğiniz şifreler birbiriyle aynı değil";
    }
     else{

     //veritabanı kayıt işlemi
     $sorgu=$db->prepare('INSERT INTO users SET user_name=?, user_password=?');
     $ekle=$sorgu->execute([
         $username,$password
     ]);
     if($ekle){
         echo "Kayıt başarıyla gerçekleşti,yönlendiriyorsnuz";
         header('Refresh:2;index.php');
     }else{

        echo "Bir hata oluştu,Tekrar kontrol edin";
     }
    }
            
}
if(isset($_POST['giris'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    if(!$username){
        echo"kullanici adınızı giriniz";
    }elseif(!$password){
        echo "Şifrenizi girin";
    }
     else{
        $kullanici_sor=$db->prepare('SELECT * FROM users WHERE user_name= ? && user_password=?');
         $kullanici_sor -> execute([
            $username, $password
         ]);
          $say=$kullanici_sor-> rowCount();
         if($say==1){
            $_SESSION['username']=$username;
            echo "Başarıyla giriş yaptınız, yönlendiriliyorsunuz";
            header('Refresh:2;index.php');
            header('Refresh:2;url=personel.php'); 
         }else{
            echo "Bir hata oluştu tekrar konrol edin";
         }
    }
}



?>