<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration</title>
</head>

<body>
<form method="POST">
<p>Enter Username</p>
<input type="text" name="login">
<p>Enter Password</p>
<input type="password" name="password"><br><br>
<button name="Reg">Registration</button>
</form>
        <?php
        session_start();
        //проверка на ввод данных в форму
        if(isset($_POST['login']) && isset($_POST['password'])) {
        require_once 'connection.php';
        //подключаем БД
        $link = mysqli_connect($host,$user,$password,$database)
        or die("Error with connection to DB".mysqli_error($link));
        $login = $_POST['login'];
        $password = $_POST['password'];
        //проверка на то,что поля ввода не пустые
        if($login != '' && $password != ''){
        //SQL команды
        $select = "SELECT username from users";
        $query = "INSERT INTO users values(NULL,'$login','$password')"
        or die("Registration error!".mysqli_error($link));
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
        $result = mysqli_query($link,$query);
                if($result) {
            echo "Registration successful!";
        }
         }
        //закрываем подключение
        mysqli_close($link);
    }
    else echo "Enter data for registation!";
}
    ?>
    </body>