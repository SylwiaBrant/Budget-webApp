<?php 
    session_start();

        if(isset($_POST['submit']))
        {
            $login = filter_input(INPUT_POST, 'login');
            $password = filter_input(INPUT_POST, 'password');

            require_once 'database.php';

            $userQuery = $db->prepare('SELECT user_id, password FROM users WHERE login = :login');
            $userQuery->bindValue(':login', $login, PDO::PARAM_STR);
            $userQuery->execute();
            
            $user = $userQuery->fetch();
            if($user){
                if(password_verify($password, $user['password'])){
                    $_SESSION['logged_id'] = $user['user_id'];
                    unset($_SESSION['credentialsError']);
                    header('Location: mainpage.php');
                }else{
                    $_SESSION['credentialsError'] = 'Nieprawidłowe hasło.';
                    header('Location: index.php');
                }
            }else{
                $_SESSION['credentialsError'] = 'Nieprawidłowy login.';
                header('Location: index.php');
            }
        }  
?>