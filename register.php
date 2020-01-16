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
        else {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if(empty($email)){
                $ok = false;
                $_SESSION['e_email'] = "Niepoprawny adres email.";
            }
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
        require_once 'database.php';
        try{
            $sql_check_login_existence = $db->prepare("SELECT user_id FROM users WHERE :login");
            $sql_check_login_existence->bindValue(':login', $login, PDO::PARAM_STR);  
            $sql_check_login_existence->execute();
            $number_of_logins = $sql_check_login_existence->fetchAll();
            if($number_of_logins){
                $ok = false;
                $_SESSION['e_login']="Wybrany login jest już zarejestrowany w serwisie.";
            }
            //check if email already exists
            $sql_check_email_existence = $db->prepare("SELECT user_id FROM users WHERE :email");
            $sql_check_email_existence->bindValue(':email', $email, PDO::PARAM_STR);  
            $sql_check_email_existence->execute();
            $number_of_emails = $sql_check_email_existence->fetchAll();
            if($number_of_emails){
                $ok = false;
                $_SESSION['e_email']="Mail jest już zarejestrowany w serwisie.";
            }
            if($ok){
                //add user to database
                $sql_add_user = $db->prepare("INSERT INTO users (login, email, password) VALUES (:login, :email, :password)");
                $sql_add_user->bindValue(':login', $login, PDO::PARAM_STR); 
                $sql_add_user->bindValue(':email', $email, PDO::PARAM_STR); 
                $sql_add_user->bindValue(':password', $hashedPassword, PDO::PARAM_STR);  
                $result = $sql_add_user->execute();
                if($result){
                    $sql_added_user_id = $db->prepare("SELECT * FROM users WHERE login = :login");
                    $sql_added_user_id->bindValue(':login', $login, PDO::PARAM_STR);
                    $result = $sql_added_user_id->execute();

                    if($result){
                        $row = $sql_added_user_id->fetch();
                        $userID = $row['user_id'];
                        $sql_populate_default_income_categories = $db->prepare("INSERT INTO income_categories (user_id, name) SELECT :userId, name FROM default_income_categories");
                        $sql_populate_default_income_categories->bindValue(':userId', $userID, PDO::PARAM_INT);
                        $result = $sql_populate_default_income_categories->execute();

                        if($result){
                            $sql_populate_default_expense_categories = $db->prepare(
                                "INSERT INTO expense_categories (user_id, name) SELECT :userId, name FROM default_expense_categories");
                            $sql_populate_default_expense_categories->bindValue(':userId', $userID, PDO::PARAM_INT);
                            $result = $sql_populate_default_expense_categories->execute();

                            if($result){
                                $sql_populate_default_payment_methods = $db->prepare(
                                    "INSERT INTO payment_methods (user_id, name) SELECT :userId, name FROM default_payment_methods");
                                $sql_populate_default_payment_methods->bindValue(':userId', $userID, PDO::PARAM_INT);
                                $result = $sql_populate_default_payment_methods->execute();

                                if($result){
                                    header('Location: index.php');
                                }
                            }
                        }  
                    }
                }
                else{
                    throw new Exception($db->error);
                }
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
    <div class="container-fluid entryPage">
                <div class="container entryPage align-items-center"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex flex-column banner-wrapper justify-content-center text-center">     
                                <img src="img/coiny.png" class="d-block mx-auto">
                                <h1>Oszczędzaj razem z Coiny</h1>
                                <div class="d-none d-md-block banner-text mt-4">
                                    <p>Skorzystaj z możliwości jakie daje Coiny.</p> 
                                    <p>Prowadź rejestr przychodów i wydatków.</p>
                                    <p>Przeglądaj analizę budżetu w wygodnej formie.</p>
                                    <p>Personalizuj kategorie.</p>
                                    <p>Oszczędzaj i spełniaj swoje marzenia!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrapper pt-5 mx-4 ml-md-0">
                                <div class="d-flex flex-row">
                                    <h1>Zarejestruj się</h1>
                                </div>
                                 <div class="mx-lg-2 mt-3">
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
                                        <div class="d-flex justify-content-center mt-5">
                                            <input class="mainBtn" type="submit" name="submit" value="Zarejestruj się">
                                        </div>
                                    </form>
                                </div>
                                <div class="justify-content-center">
                                    <?php
                                    if(isset($_SESSION['credentialsError'])) echo $_SESSION['credentialsError'];
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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