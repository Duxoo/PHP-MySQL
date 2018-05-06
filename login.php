 <?php
        //проверка на ввод данных в форму
        session_start();
        if(isset($_POST['login']) && isset($_POST['password'])) {
            require_once 'index.html';
            require_once 'connection.php';
            //подключаем БД
            $link = mysqli_connect($host,$user,$password,$database)
            or die("Error with connection to DB".mysqli_error($link));
            //проверка на то,что поля ввода не пустые
            global $password;
            global $login;
            //записываем данные из формы в переменную
            $password = $_POST['password'];
            $login = $_POST['login'];
            //если поля ввода не пустые
            if($login != '' && $password != ''){
                //SQL команды
                $data = "SELECT * from users";
                //записать все логины,для проверки одинаковых данных
                $checkdata = mysqli_query($link,$data);
                //количество записей в запросе на выбор
                $rows = mysqli_num_rows($checkdata);
                $bool = true;
                for($i = 0; $i < $rows; $i++) {
                    //извлекаем отдельную строку
                    $row = mysqli_fetch_row($checkdata);
                    //перебор по ячейкам текущей строки
                    for($j = 0; $j < 2; $j++) {
                        if($row[$j] == $login && $row[$j + 1] == $password) {
                                $bool = false;
                                $_SESSION['loggedin'] = true;
                                $_SESSION['username'] = $login;
                                $_SESSION['password'] = $password;
                                setcookie("login",$login);
                                setcookie("password",$password, time()+3600);
                                header("Location: edit.php"); 

                                break;
                        }
                }
                }
                        if($bool) {
                    echo "Wrong password or there is no such username";
                }
                //закрываем подключение
                mysqli_close($link);
        }
        else echo "Enter data";
}
    ?>