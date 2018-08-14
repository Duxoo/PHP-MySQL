<!DOCTYPE html>
<html>
<head>
	<title>Change login</title>
</head>
<body>
<form method="POST">
<p>Input your current password</p>
<input type="password" name="oldpassword"><br><br>
<p>Input your new password</p>
<input type="password" name="newpassword1">
<p>Repeat your new password</p>
<input type="password" name="newpassword2">
<button>Sumbit</button>
</form>
<?php
    session_start();
    if(isset($_POST['oldpassword']) && isset($_POST['newpassword1']) && isset($_POST['newpassword2'])) {
    	require_once 'connection.php';
        //подключение БД
    	 $link = mysqli_connect($host,$user,$password,$database)
         or die("Error with connection to DB".mysqli_error($link));
         //записываем данные из формы в переменную
         $oldpassword = $_POST['oldpassword'];
         $newpassword1 = $_POST['newpassword1'];
         $newpassword2 = $_POST['newpassword2'];
         //если поля ввода не пустые
         if($oldpassword != '' && $newpassword1 != '' && $newpassword2 != '') {
            //обновить пароль
            $query = "UPDATE users SET password = '$newpassword1' WHERE username = '{$_SESSION['username']}'" 
            or die("Update error!".mysqli_error($link));
            //если старый пароль совпадает с паролем пользователя
            if ($oldpassword == $_SESSION['password']) {
                //если новый пароль введен 2 раза верно
                if($newpassword1 == $newpassword2) {  
                    //меняем пароль  
                    $result = mysqli_query($link,$query)
                    or die("Error".mysqli_error($link));
                    if($result) {
                        echo "password changed";
                    }
                }
                //иначе выводим, что пароли не совпадают
                else {
                    echo "You have entered different passwords";
                }
            }
            //если старый пароль не совпадает с паролем пользователя
            else {
                echo "Your current password is wrong";
            }
            //закрываем подключение
            mysqli_close($link);
         }
    }
?>
</body>
</html>