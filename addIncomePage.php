<?php 
    session_start();

    if(!isset($_SESSION['logged_id'])) 
    {
        header('Location: index.php');
        exit();
    }
    require_once 'database.php';
        $user_id = $_SESSION['logged_id'];
        $sql_select_categories = $db->prepare(
            "SELECT name FROM income_categories WHERE user_id= :user_id");
        $sql_select_categories->bindValue(':user_id', $user_id, PDO::PARAM_INT); 
        $sql_select_categories->execute();
        $options= $sql_select_categories->fetchAll(); 
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
        <div class="justify-content-center main-menu">
            <nav class="nav-wrapper">
                <div>
                    <img class="d-block mx-auto" src="img/coiny.png">
                </div>
                <div>
                    <h2 class="text-center py-4">MENU</h2>
                </div>
                <ul class="nav flex-lg-column align-items-center">
                        <li class="nav-item">
                        <a class="nav-link" href="mainpage.php">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addIncomePage.php">Dodaj przychód</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addExpense.php">Dodaj wydatek</a>
                    </li>
                    <li class="nav-item currentPage">
                        <a class="nav-link" href="showIncomes.php">Przeglądaj przychody</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="showExpenses.php">Przeglądaj wydatki</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="showBalance.php">Przeglądaj bilans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Przeglądaj faktury</a>
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
        <div class="container-fluid mainContent justify-content-center">
            <div class="d-flex row justify-content-center text-center mb-3">
                <div class="info-board">
                <form action="addIncome.php" method="post">
                    <div class="form-group">
                        <label>Podaj wysokość przychodu:</label>
                        <input class="form-control" type="number" min="0" step="0.01" name="money">
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
                            <?php foreach ($options as $option): ?>
                                        <option value="?=$option['name']"><?=$option['name']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dodaj komentarz (opcjonalnie):</label>
                        <textarea class="form-control" rows="4" name="comment">
                            <?php
                                if (isset($_SESSION['e_comment'])){
                                    echo '<div class="error">'.$_SESSION['e_comment'].'</div>';
                                    unset($_SESSION['e_comment']);
                                }
                            ?> 
                        </textarea> 
                    </div>
                    <div class="d-flex justify-content-around">
                        <input type="submit" class="agreementBtn ml-3" name="submit" value="Dodaj">
                        <button type="button" class="agreementBtn btnSpecified ml-3" onclick="location.href='mainpage.php'">Anuluj</button>
                    </div>
                </form>
                </div>
            </div>
            <div>
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
