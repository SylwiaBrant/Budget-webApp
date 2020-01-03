<?php 
    session_start(); 
    if(!isset($_SESSION['userLoggedIn'])) 
    {
        header('Location: index.php');
        exit();
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
        <header>  
            <div class="container-fluid">
                <nav class="navbar bg-dark navbar-dark fixed-top">
                    <a class="navbar-brand logo" href="index.html">BudgetApp</a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle btnSpecified" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Moje konto</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button" onclick="location.href='settings.php'"><i class="icon-cog"></i>Ustawienia</button>
                            <button class="dropdown-item" type="button" onclick="location.href='logout.php'"><i class="icon-export"></i>Wyloguj się</button>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
            <div class="container-fluid mainPage">
                <!-- Cards -->
                <div class="d-flex flex-row justify-content-around text-center mx-2 flex-wrap">
                    <div class="col transactionsBtn p-3 m-2" onclick="showModal('#incomeModal')">
                        <img src="img/profits.png" class="d-block mx-auto mb-3 icon" alt="profits icon">
                        <h2>DODAJ PRZYCHÓD</h2>
                    </div>
                    <div class="col transactionsBtn p-3 m-2" onclick="showModal('#expenseModal')">
                        <img src="img/pay.png" class="d-block mx-auto mb-3 icon" alt="two hands paying icon">
                        <h2>DODAJ WYDATEK</h2>
                    </div>
                    <div class="col transactionsBtn p-3 m-2">
                        <a href="showIncomes.php">
                        <img src="img/analysis.png" class="d-block mx-auto mb-3 icon" alt="magnifying glass on charts icon">
                        <h2>PRZEGLĄDAJ BILANS</h2></a>
                    </div>
                </div>
                <div class="quote">
                    <p>„Skoro pracujesz na swoje pieniądze co najmniej czterdzieści godzin tygodniowo, 
                        to skrajną nieodpowiedzialnością jest niepoświęcanie im uwagi.”</p><p class="quoteAuthor">
                            ~Suze Orman</p>
                </div>
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
    <!-- Add Income Modal -->
    <div class="modal" id="incomeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header ml-2">
                <h4 class="modal-title">Dodaj przychód</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body mx-2">
                <form action="addIncome.php" method="post">
                    <div class="form-group">
                        <label>Podaj wysokość przychodu:</label>
                        <input class="form-control" type="number" name="money">
                        <?php
                                if (isset($_SESSION['e_money'])){
                                    echo '<div class="error">'.$_SESSION['e_money'].'</div>';
                                    unset($_SESSION['e_money']);
                                }
                            ?>  
                    </div>
                    <div class="form-group">
                        <label>Podaj datę uzyskania przychodu:</label>
                        <input class="form-control" id="incomeDate" type="date" name="date">
                        <?php
                            if (isset($_SESSION['e_date'])){
                                echo '<div class="error">'.$_SESSION['e_date'].'</div>';
                                unset($_SESSION['e_date']);
                            }
                        ?>  
                    </div>
                    <div class="form-group">
                        <label>Wybierz z listy rodzaj przychodu:</label>
                        <select class="form-control" id="incomeCategory" name="category">
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
                                        "SELECT name FROM income_categories WHERE user_id='%s'",
                                            $db_connection->real_escape_string($user_id)); 
                                    if($result = $db_connection->query($sql_select_categories)){                                     
                                        while($incomeCategories = $result->fetch_array())
                                        {
                                            printf(
                                                '<option value="'.'%s'.'">%s</option>',
                                                htmlspecialchars($incomeCategories['name']),
                                                htmlspecialchars($incomeCategories['name']));
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
                        <textarea class="form-control" rows="4" name="comment"></textarea>
                        <?php
                            if (isset($_SESSION['e_comment'])){
                                echo '<div class="error">'.$_SESSION['e_comment'].'</div>';
                                unset($_SESSION['e_comment']);
                            }
                        ?>  
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center py-4">

                    <input type="submit" class="btn btn-secondary btnSpecified ml-3" name="submit" value="Dodaj">
                    <button type="button" class="btn btn-secondary btnSpecified ml-3" data-dismiss="modal">Anuluj</button>
                </div>
                </form>
            </div>
        </div>
    </div> 
    <!-- Add Expense Modal --> 
    <div class="modal" id="expenseModal">    
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header ml-2">
                <h4 class="modal-title">Dodaj wydatek</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body mx-2">
                    <form action="addExpense.php" method="post">
                        <div class="form-group">
                            <label>Podaj wysokość wydatku:</label>
                            <input class="form-control" id="expenseAMount" type="number" name='money'>
                        </div>
                        <div class="form-group">
                            <label>Podaj datę uzyskania przychodu:</label>
                            <input class="form-control" id= "expenseDate" type="date" name='date'>
                        </div>
                        <div class="form-group">
                            <label >Wybierz sposób płatności:</label>
                            <select class="form-control" id="pay-method" name='paymentMethod'>
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
                <!-- Modal footer -->
                <div class="modal-footer justify-content-around px-4">
                    <button type="submit" class="btn btn-secondary btnSpecified" name="submit">Dodaj</button>
                    <button type="button" class="btn btn-secondary btnSpecified" data-dismiss="modal">Anuluj</button>
                </div>
                </form>
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