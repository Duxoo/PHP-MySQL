<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
    <?php
    //проверка на ввод данных в форму
    session_start();
    require_once 'connection.php';   
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "Login: " . $_SESSION['username']. "<a href='loginchange.php'> Изменить</a><br><br>";
        $link = mysqli_connect($host,$user,$password,$database)
            or die("Error with connection to DB".mysqli_error($link));
        $mail = "SELECT mail from users WHERE username = '{$_SESSION['username']}'";
        $result = mysqli_query($link,$mail);
        echo "<a href='changepassword.php'>Change password</a><br><br>";
        echo "<a href='emailchange.php'>Изменить e-mail</a><br><br>";
    } 
    else {
        echo "Please log in first to see this page.";
    }
    ?>
    <form method="POST">
        <button name="delete">Delete your account</button>
        <br>
        <button name="logout">Выйти из аккаунта</button>
    </form>
    <?php
    if(isset($_POST['delete'])) {
        $link = mysqli_connect($host,$user,$password,$database)
        or die("Error with connection to DB".mysqli_error($link));
        $delete = "DELETE from users WHERE username = '{$_SESSION['username']}'" or die("Error".mysqli_error($link));
        $result = mysqli_query($link,$delete);
        mysqli_close($link);
    }
    ?>
    <?php
        if(isset($_POST['logout'])) {
            $_SESSION = [];
            unset($_COOKIE[session_name()]);
            session_destroy();
            header("Location: index.php");
        }
    ?>
    </body>