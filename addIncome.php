<?php  
    session_start();  
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
        require_once "database.php";
        if($ok){  
            try{  
                $user_ID = $_SESSION['logged_id'];
                $sql_add_income = $db->prepare(
                "INSERT INTO incomes VALUES ('', :user_Id, :money, :date,
                (SELECT id FROM income_categories WHERE name=:category AND user_id=:user_ID), :comment, :invoice_id)");  
                $sql_add_income->bindValue(':user_Id', $user_ID, PDO::PARAM_INT);
                echo $user_ID;
                $sql_add_income->bindValue(':money', $money);
                $sql_add_income->bindValue(':date', $date, PDO::PARAM_STR); 
                echo $date;               
                $sql_add_income->bindValue(':category', $category);
                echo $category;
                $sql_add_income->bindValue(':user_ID', $user_ID, PDO::PARAM_INT);
                $sql_add_income->bindValue(':comment', $comment, PDO::PARAM_STR);
                $sql_add_income->bindValue(':invoice_id', 'N', PDO::PARAM_STR);
                $sql_add_income->execute();
                $lastInsertId = $db->lastInsertId();

                if($lastInsertId > 0){
                    echo "<h1>Wpis dodany pomyślnie.</h1>";
                    header('Location: mainpage.php');
                }
                else{
                    throw new Exception($db->error);
                }
                $db->close();
            }
            catch(Exception $e){
                echo "<h1>Błąd serwera. Przepraszamy za niedogodności.</h1>";
                echo "Informacja developerska: ".$e;
            }
        }  
    } 
?>