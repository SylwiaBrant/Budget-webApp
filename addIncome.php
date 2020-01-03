<?php 
    session_start();

    if(!isset($_SESSION['userLoggedIn'])) 
    {
        header('Location: index.php');
        exit();
    }
    $money = '';
    $date = '';
    $category = '';
    $comment = '';
    if(isset($_POST['submit'])){
        $ok = true;
        if(!isset($_POST['money']) || $_POST['money'] === ''){
            $ok = false;
        }
        else if(!is_numeric($_POST['money'])) {
            $ok = false;
            $_SESSION['e_money'] = "W tym polu można wpisać jedynie wartości numeryczne, np. 100, 100.50";
        }
        else{
            $money = $_POST['money'];
        }
        if(!isset($_POST['date']) || $_POST['date'] === ''){
            $ok = false;
        }
        else{
            $date = $_POST['date'];
        }
        if(isset($_POST['category'])){
            $category = $_POST['category'];
        }
        if(strlen($_POST['comment'])>400){
            $ok = false;
            $_SESSION['e_comment'] = "Pole może zawierać maksymalnie 400 znaków.";
        }
        else{
            $comment = $_POST['comment'];
        }
        //send db request
        require_once "config.inc.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            if($db_connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }
            else{
                if($ok){    
                    $user_id = $_SESSION['loggedInUserId'];

                    $sql_add_income = sprintf(
                        "INSERT INTO incomes VALUES ('', $user_id, $money, '$date', 
                        (SELECT id FROM income_types WHERE name='$category' AND user_id=$user_id), '%s')",  
                            $db_connection->real_escape_string($category),
                            $db_connection->real_escape_string($comment));
                    if($db_connection->query($sql_add_income)){
                        echo "<h1>Wpis dodany pomyślnie.</h1>";
                        header('Location: mainpage.php');
                    }
                    else{
                        throw new Exception($db_connection->error);
                    }
                }
                $db_connection->close();
            }
        }
        catch(Exception $e){
            echo "<h1>Błąd serwera. Przepraszamy za niedogodności.</h1>";
            echo "Informacja developerska: ".$e;
        }
    }

?>

