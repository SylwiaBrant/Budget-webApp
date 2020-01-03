<?php
    session_start();

    $login = '';
    $email = '';
    $password = '';
    $hashedPassword = '';
    $incomeCategory = '';

    if (isset($_POST['submit'])) {
        $ok = true;
        //CHECKING NAME
        if(!isset($_POST['login']) || $_POST['login'] === '') {
            $ok = false;
            $_SESSION['e_login'] = "To pole musi być wypełnione.";
        //    echo "Blad w imieniu";
        }
        else if(strlen($_POST['login'])>50) {
            $ok = false;
            $_SESSION['e_login'] = "Dozwolona ilość znaków: 50.";
        //    echo "Blad w imieniu";
        }
        else {
            $login = $_POST['login'];
        }
        //CHECKING EMAIL
        if((!isset($_POST['email'])) || ($_POST['email'] === '')) {
            $ok = false;
            $_SESSION['e_email'] = "To pole musi być wypełnione.";
        //    echo "Blad w emailu. Jest pusty";
        }
        else if((filter_var((filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)), FILTER_VALIDATE_EMAIL)==false) || ((filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) != $_POST['email'])){
            $ok = false;
            $_SESSION['e_email'] = "Adres email zawiera niedozwolone znaki." ;
        //    echo "Blad w emailu. Niedozwolone znaki";
        }
        else {
            $email = $_POST['email'];
        }
        //CHECKING PASSWORD
        if(!isset($_POST['password']) || $_POST['password'] === '') {
            $ok = false;
            $_SESSION['e_password'] = "To pole musi być wypełnione.";
        //    echo "Blad w hasle";
        }
        else if($_POST['password'] != $_POST['secondPassword']) {
            $ok = false;
            $_SESSION['e_password'] = "Podane hasła nie są identyczne.";
        //    echo "Blad w hasle";
        }
        else {
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        require_once "config.inc.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            if($db_connection->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else{
                //check if login already exists
                $sql_check_login_existence = sprintf("SELECT user_id FROM users WHERE login='%s'",
                    $db_connection->real_escape_string($login));
                $result = $db_connection->query($sql_check_login_existence);
                if(!$result) 
                    throw new Exception($db_connection->error);
                $number_of_logins = $result->num_rows;
                if($number_of_logins>0)
                {
                    $ok = false;
                    $_SESSION['e_login']="Wybrany login jest już zarejestrowany w serwisie.";
                }
                //check if email already exists
                $sql_check_email_existence = sprintf("SELECT user_id FROM users WHERE email='%s'",
                    $db_connection->real_escape_string($email));
                $result = $db_connection->query($sql_check_email_existence);
                if(!$result) 
                    throw new Exception($db_connection->error);
                $number_of_email = $result->num_rows;
                if($number_of_emails>0)
                {
                    $ok = false;
                    $_SESSION['e_email']="Mail jest już zarejestrowany w serwisie.";
                }
                if($ok){
                    //add user to database
                    $sql_add_user = sprintf(
                    "INSERT INTO users (login, email, password) VALUES ('%s', '%s', '%s')",
                        $db_connection->real_escape_string($login),
                        $db_connection->real_escape_string($email),
                        $db_connection->real_escape_string($hashedPassword)); 
                    if($db_connection->query($sql_add_user)){
                        
                        $sql_added_user_id = sprintf(
                            "SELECT * FROM users WHERE login = '%s'",
                            $db_connection->real_escape_string($login));
                            
                            if($result = $db_connection->query($sql_added_user_id)){
                                $row = $result->fetch_assoc();
                                $userID = $row['user_id'];
                            $sql_populate_default_income_categories = sprintf(
                                "INSERT INTO income_categories (user_id, name) SELECT $userID, name FROM default_income_categories"); 
                            if($db_connection->query($sql_populate_default_income_categories)){
                                $sql_populate_default_expense_categories = sprintf(
                                    "INSERT INTO expense_categories (user_id, name) SELECT $userID, name FROM default_expense_categories");
                                if($db_connection->query($sql_populate_default_expense_categories)){
                                    $sql_populate_default_payment_methods = sprintf(
                                        "INSERT INTO payment_methods (user_id, name) SELECT $userID, name FROM default_payment_methods");
                                    if($db_connection->query($sql_populate_default_payment_methods))
                                    {
                                        header('Location: index.php');
                                    }
                                }
                            }  
                        }
                    }
                    else{
                        throw new Exception($db_connection->error);
                    }
                }
                $db_connection->close();
            }
        }
        catch(Exception $e){
            echo "Błąd serwera. Przepraszamy za niedogodności.";
            echo "Informacja developerska: ".$e;
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta charset="UTF-8"/>
        <title>Spełnij swoje marzenia</title>
        <meta name="description" content="Zbuduj oszczędności życia z pomocą tej aplikacji."/>
        <meta name ="keywords" content="oszczędności, oszczędzanie, bilans przychodów i wydatków"/>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Oswald:500&display=swap&subset=latin-ext" rel="stylesheet">
        <link rel="stylesheet" href="fontello/css/menu.css">
        <!-- Bootstrap CSS -->
	   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style1.css">
    </head>
    <body>
        <div class="container align-items-center"> 
            <div class="card mx-auto">
                <!-- Card Header -->
                <div class="card-header d-flex flex-row justify-content-around align-items-center">
                <h4>Zarejestruj się</h4>
                </div>
                <!-- Card body -->   
                <div class="card-body mx-2">
                    <form class="needs-validation" method="post">
                        <div class="form-group">
                            <label>Podaj login:</label>
                            <input class="form-control inputSlot" type="text" name="login" value="<?php 
                                echo htmlspecialchars($login, ENT_QUOTES);
                            ?>">
                            <?php
                                if (isset($_SESSION['e_login'])){
                                    echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                                    unset($_SESSION['e_login']);
                                }
                            ?>
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>

                        </div>
                        <div class="form-group">
                            <label>Podaj email:</label>
                            <input class="form-control inputSlot" type="email" name="email" value="<?php
                                echo htmlspecialchars($email);
                            ?>">
                            <?php
                                if (isset($_SESSION['e_email'])){
                                    echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                    unset($_SESSION['e_email']);
                                }
                            ?>
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="form-group">
                            <label>Podaj hasło:</label>
                            <input class="form-control inputSlot" type="password" name="password">
                            <?php
                                if (isset($_SESSION['e_password'])){
                                    echo '<div class="error">'.$_SESSION['e_password'].'</div>';
                                    unset($_SESSION['e_password']);
                                }
                            ?>
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="form-group">
                            <label>Powtórz hasło:</label>
                            <input class="form-control inputSlot" type="password" name="secondPassword">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input class="btn btn-secondary btnSpecified" type="submit" name="submit" value="Zarejestruj się">
                        </div>
                    </form>
                </div>
                <!-- Card footer -->
                <div class="card-footer justify-content-center">
                    <!-- <button class="btn btn-secondary btnSpecified" type="submit" name="register" >Zarejestruj się</button>
                -->
                </div>
            </div>
        </div>   
    <!-- Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    </body>
</html>