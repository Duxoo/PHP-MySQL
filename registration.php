        <?php
        session_start();
        //проверка на ввод данных в форму
        if(isset($_POST['loginreg']) && isset($_POST['passwordreg']) &&isset($_POST['e-mailreg'])) {
        require_once 'index.html';
        require_once 'connection.php';
        //подключаем БД
        $link = mysqli_connect($host,$user,$password,$database)
        or die("Error with connection to DB".mysqli_error($link));
        $login = $_POST['loginreg'];
        $password = $_POST['passwordreg'];
        $email = $_POST['e-mailreg'];
        //проверка на то,что поля ввода не пустые
        if($login != '' && $password != '' && $email!= ''){
        //хэширование пароля
        $hash = password_hash($password, PASSWORD_DEFAULT);
        //SQL команды
        $select = "SELECT username from users";
        $query = "INSERT INTO users values(NULL,'$login','$hash','$email')"
        or die("Registration error!".mysqli_error($link));
        $selectmail = "SELECT mail from users";
        $checkmail = mysqli_query($link,$selectmail);
        //записать все логины,для проверки одинаковых данных
        $check = mysqli_query($link,$select);
        //количество записей в запросе на выбор
        $rows = mysqli_num_rows($check);
        $bool = true;
        //проверка на одинаковый логин
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
        $rows = mysqli_num_rows($checkmail);
        //проверка на одинаковый мэил
                for($i = 0; $i < $rows; $i++) {
            //извлекаем отдельную строку
            $row = mysqli_fetch_row($checkmail);
            //перебор по ячейкам текущей строки
            for($j = 0; $j < 1; $j++) {
            //если такой пользователь уже есть,то выводим ошибку и завершаем цикл
            if($email == $row[$j]) {
                echo "this e-mail has been registred already";
                $bool = false;
                break;
            }
        }
        }
        //если такого пользователя нет,то заносим запись в БД
        if($bool) {
        $result = mysqli_query($link,$query);
                if($result) {
            mail($email,"Регистрация", "Вы успешно зарегистрированы на нашем сайте!\n\n Приятного время препровождения,наша команда!");
            echo "Registration successful!";
            $_SESSION['username'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['e-mail'] = $email;
        }
         }
        //закрываем подключение
        mysqli_close($link);
    }
    else echo "Enter data for registation!";
}
    ?>
