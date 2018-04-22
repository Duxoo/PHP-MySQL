<!DOCTYPE html>
<html>
<head>
	<title>Change login</title>
</head>
<body>
<form method="POST">
<p>Input your new nickname</p>
<input type="text" name="login"><br><br>
<button>Sumbit</button>
</form>
<?php
session_start();
if(isset($_POST['login'])) {
	require_once 'connection.php';
	 $link = mysqli_connect($host,$user,$password,$database)
     or die("Error with connection to DB".mysqli_error($link));
     $login = $_POST['login'];
     $select = "SELECT ID from users";
     if($login != '') {
     	$select = "SELECT username from users";
        $query = "UPDATE users SET username = '$login' WHERE username = '{$_SESSION['username']}'"
        or die("Update error!".mysqli_error($link));
                //записать все логины,для проверки одинаковых данных
        $check = mysqli_query($link,$select);
        //количество записей в запросе на выбор
        $rows = mysqli_num_rows($check);
        $bool = true;
        for($i = 0; $i < $rows; $i++) {
            //извлекаем отдельную строку
            $row = mysqli_fetch_row($check);
            //перебор по ячейкам текущей строки
            for($j = 0; $j < 1; $j++) {
            //если такой пользователь уже есть,то выводим ошибку и завершаем цикл
            if($login == $row[$j]) {
                echo "Username is already exist";
                $bool = false;
                break;
            }
        }
        }
        //если такого пользователя нет,то заносим запись в БД
        if($bool) {
        $result = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link));
                if($result) {
            echo "login changed";
        }
         }
        //закрываем подключение
        mysqli_close($link);
     }
}
?>
</body>
</html>