<?php 
    session_start();

    if(!isset($_POST['login']) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }
    $login='';
    $password='';
    require_once "config.inc.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
        $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);   
        if($db_connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        }
        else{
            $login = $_POST['login'];
            $password = $_POST['password'];        

            $sql = sprintf(
                "SELECT * FROM users WHERE login='%s'",
                    $db_connection->real_escape_string($login));

            if($result = $db_connection->query($sql)){
                $usersNumber = $result->num_rows;
                if($usersNumber>0){
                    $row = $result->fetch_assoc();
                    if(password_verify($password, $row['password'])){
                        $_SESSION['userLoggedIn'] = true;
                        $_SESSION['loggedInUserId'] = $row['user_id'];

                        unset($_SESSION['credentialsError']);
                        $result->free_result();
                        header('Location: mainpage.php');
                    }
                    else{
                        $_SESSION['credentialsError'] = 'Nieprawidłowe hasło.';
                        header('Location: index.php');
                    }
                }
                else{
                    $_SESSION['credentialsError'] = 'Nieprawidłowy login.';
                    header('Location: index.php');
                }
            }
            else{
                throw new Exception($db_connection->error);
            }
            $db_connection->close();
        }
    }
    catch(Exception $e){
        echo "Błąd serwera. Przepraszamy za niedogodności.";
        echo "Informacja deweloperska: ".$e;
    }
?>