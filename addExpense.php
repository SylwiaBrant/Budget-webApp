<?php 
    session_start();

    if(!isset($_SESSION['logged_id'])) 
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
        if(isset($_POST['paymentMethod'])){
            $paymentMethod = $_POST['paymentMethod'];
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
                $user_id = $_SESSION['logged_id'];
                $sql_add_expense = $db->prepare(
                "INSERT INTO expenses VALUES ('', :user_id1, :money, :date, 
                (SELECT id FROM payment_methods WHERE name=:pm_name AND user_id=:user_id2), 
                (SELECT id FROM expense_categories WHERE name=:ec_name AND user_id=:user_id3), :comment, :invoice_id)");  
                $sql_add_expense->bindValue(':user_id1', $user_id, PDO::PARAM_INT);
                $sql_add_expense->bindValue(':money', $money);
                $sql_add_expense->bindValue(':date', $date, PDO::PARAM_STR);
                $sql_add_expense->bindValue(':pm_name', $paymentMethod, PDO::PARAM_STR); 
                $sql_add_expense->bindValue(':user_id2', $user_id, PDO::PARAM_INT);                
                $sql_add_expense->bindValue(':ec_name', $category);
                $sql_add_expense->bindValue(':user_id3', $user_id, PDO::PARAM_INT);
                $sql_add_expense->bindValue(':comment', $comment, PDO::PARAM_STR);
                $sql_add_expense->bindValue(':invoice_id', 'N', PDO::PARAM_STR);
                $sql_add_expense->execute();
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
        <div class="container-fluid mainPage align-items-stretch">
            <div class="row">
                <div class="nav col-lg-2 justify-content-center main-menu">
                    <nav class="">
                        <div>
                            <h1 class="text-center py-4">MENU</h1>
                        </div>
                        <ul class="nav flex-lg-column align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="addIncome.php">Dodaj przychód</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="addExpense.php">Dodaj wydatek</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showIncomes.php">Przeglądaj przychody</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showExpenses.php">Przeglądaj wydatki</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showBalance.php">Przeglądaj bilans</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="settings.php">Ustawienia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Wyloguj</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-8">
                    <div class="form-wrapper mx-auto mt-4">
                        <div class="">
                            <h4 class="text-center">Dodaj wydatek</h4>
                        </div>
                        <form action="addExpense.php" method="post">
                        <div class="form-group">
                            <label>Podaj wysokość wydatku:</label>
                            <input class="form-control" type="number" min='0'step='0.01' name='money'>
                        </div>
                        <div class="form-group">
                            <label>Podaj datę uzyskania przychodu:</label>
                            <input class="form-control" type="date" name='date'>
                        </div>
                        <div class="form-group">
                            <label >Wybierz sposób płatności:</label>
                            <select class="form-control" name='paymentMethod'>
                                <?php 
                                    require_once "config.inc.php";
                                    mysqli_report(MYSQLI_REPORT_STRICT);
                                    try{
                                        $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
                                        if($db_connection->connect_errno!=0)
                                        {
                                            throw new Exception(mysqli_connect_errno());
                                        }
                                        else{
                                            $user_id = $_SESSION['loggedInUserId'];
                                            $sql_select_payment_methods = sprintf(
                                                "SELECT name FROM payment_methods WHERE user_id='%s'",
                                                    $db_connection->real_escape_string($user_id)); 
                                            if($result = $db_connection->query($sql_select_payment_methods)){                                     
                                                while($paymentMethods = $result->fetch_array())
                                                {
                                                    printf(
                                                        '<option value="'.'%s'.'">%s</option>',
                                                        htmlspecialchars($paymentMethodss['name']),
                                                        htmlspecialchars($paymentMethods['name']));
                                                }
                                            }  
                                        }
                                        $db_connection->close();
                                    }
                                    catch(Exception $e){
                                        echo "Błąd serwera. Przepraszamy za niedogodności.";
                                        echo "Informacja developerska: ".$e;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategoria:</label>
                            <select class="form-control" id="expenseCategory" name='category'>
                                <?php 
                                    require_once "config.inc.php";
                                    mysqli_report(MYSQLI_REPORT_STRICT);
                                    try{
                                        $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
                                        if($db_connection->connect_errno!=0)
                                        {
                                            throw new Exception(mysqli_connect_errno());
                                        }
                                        else{
                                            $user_id = $_SESSION['loggedInUserId'];
                                            $sql_select_categories = sprintf(
                                                "SELECT name FROM expense_categories WHERE user_id='%s'",
                                                    $db_connection->real_escape_string($user_id)); 
                                            if($result = $db_connection->query($sql_select_categories)){                                     
                                                while($expenseCategories = $result->fetch_array())
                                                {
                                                    printf(
                                                        '<option value="'.'%s'.'">%s</option>',
                                                        htmlspecialchars($expenseCategories['name']),
                                                        htmlspecialchars($expenseCategories['name']));
                                                }
                                            }  
                                        }
                                        $db_connection->close();
                                    }
                                    catch(Exception $e){
                                        echo "Błąd serwera. Przepraszamy za niedogodności.";
                                        echo "Informacja developerska: ".$e;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <label>Dodaj komentarz (opcjonalnie):</label>
                        <textarea class="form-control" rows="3" id="expenseComment" name='comment'></textarea>
                        </div>
                        <input type="submit" name="submit">
                </div>
                <div class="footer justify-content-around px-4">
                    <button type="submit" class="btn btn-secondary btnSpecified" name="submit">Dodaj</button>
                    <button type="button" class="btn btn-secondary btnSpecified" data-dismiss="modal">Anuluj</button>
                </div>
                </form>
                    </div>
                </div>  
                <footer>
                    <div class="row justify-content-center">
                        <p>&copy; Sylwia Brant, 2019</p>
                        <div>Icons made by<a href="https://www.flaticon.com/authors/srip" title="srip">srip</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                        </div>
                    </div>
                </footer>     
            </div>
        </div>  
        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="script.js"></script>

    </body>
</html>

