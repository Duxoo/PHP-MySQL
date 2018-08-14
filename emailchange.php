<!DOCTYPE html>
<html>
<head>
	<title>Change login</title>
</head>
<body>
<form method="POST">
<p>Input your new e-mail</p>
<input type="text" name="email" type="e-mail" placeholder="example@gmail.com"><br><br>
<button>Sumbit</button>
</form>
<?php
    session_start();
    if(isset($_POST['email'])) {
    	require_once 'connection.php';
        //подключение БД
    	 $link = mysqli_connect($host,$user,$password,$database)
         or die("Error with connection to DB".mysqli_error($link));
         //записываем в переменную для удобства
         $email = $_POST['email'];
         if($email != '') {
         	$select = "SELECT mail from users";
            $query = "UPDATE users SET mail = '$email' WHERE username = '{$_SESSION['username']}'"
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
                if($email == $row[$j]) {
                    echo "e-mail is already exist";
                    $bool = false;
                    break;
                }
            }
            }
            //если такого пользователя нет,то заносим запись в БД
            if($bool) {
            $result = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link));
                    if($result) {
                echo "e-mail changed";
                mail($email,"Смена адреса","Вы успешно сменили e-mail адрес!");
            }
             }
            //закрываем подключение
            mysqli_close($link);
         }
    }
?>
</body>
</html>