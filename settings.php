<?php 
    session_start();
    if(!isset($_SESSION['userLoggedIn'])){
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
            <div class="container">
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
        <div class="container mainPage align-items-center"> 
        <div class="row mx-auto">                
            <h1>Ustawienia</h1>
        </div>
        <div class="row mx-auto"> 
            <div class="col-md-3">
                <h2>
                    <a class="" data-toggle="collapse" href="#collapseIncomesSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Kategorie przychodów &or;
                    </a>
                </h2>
                <div class="collapse-sm" id="collapseIncomesSettings">  
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
                                            '<div class="row py-2"><li class=" px-2">%s</li><button class="btn btnSpecified btn-sm">USUŃ</button></div>',
                                            htmlspecialchars($incomeCategories['name']), ENT_QUOTES);
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
                </div>
            </div>
            <div class="col-md-3">
                <h2>
                    <a class="" data-toggle="collapse" href="#collapseExpensesSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Kategorie wydatków  &or;
                    </a>
                </h2>
                <div class="collapse-sm" id="collapseExpensesSettings">
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
                                            '<div class="row py-2"><li class=" px-2">%s</li><button class="btn btnSpecified btn-sm">USUŃ</button></div>',
                                            htmlspecialchars($expenseCategories['name']), ENT_QUOTES);
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
                </div>
            </div>
            <div class="col-md-3"> 
                <h2>
                <a class="" data-toggle="collapse" href="#collapsePasswordSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Zmiana hasła  &or;
                </a>
                </h2>
                <div class="collapse-sm" id="collapsePasswordSettings">                     
                    <?php 

                
                
                    ?>
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