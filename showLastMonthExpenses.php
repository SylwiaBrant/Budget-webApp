<?php
    session_start();

    if(!isset($_SESSION['logged_id'])){
        header('Location: index.php');
        exit();
    }
        require_once 'database.php';
        $user_id = $_SESSION['logged_id'];
        $today = date('Y-m-d');
        $sql_show_expenses = $db->query("SELECT e.date, e.money, ec.name, ep.name, e.comment 
            FROM expenses AS e INNER JOIN expense_categories AS ec ON e.user_id = ec.user_id 
            AND e.expense_type_id=ec.id INNER JOIN payment_methods AS ep ON e.user_id = ep.user_id 
            AND e.pay_method_id = ep.id WHERE e.user_id=$user_id AND date BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(CURDATE()), 
            INTERVAL 1 DAY), INTERVAL - 2 MONTH) AND DATE_ADD(LAST_DAY(CURDATE()),INTERVAL - 1 MONTH)");
        $expenses=$sql_show_expenses->fetchAll();

        $sql_sum_expenses = $db->query("SELECT ROUND(SUM(money),2) as totalAmount FROM expenses 
            WHERE user_id=$user_id AND date BETWEEN DATE_ADD(DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY), 
            INTERVAL - 2 MONTH) AND DATE_ADD(LAST_DAY(CURDATE()),INTERVAL - 1 MONTH)");
        $row=$sql_sum_expenses->fetch();
        $sum = $row['totalAmount'];
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
        <div class="d-flex justify-content-center main-menu" id="sidebar">
            <nav>
                <div>
                    <img class="d-block mx-auto logo" src="img/coiny.png">
                </div>
                <div class="d-flex justify-content-center" id="navCollapse">
                    <h2>MENU</h2>
                    <div class="d-flex arrow"></div>
                </div>
                <ul class="nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="mainpage.php">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#incomeModal" data-target="#incomeModal"
                         data-toggle="modal">Dodaj przychód</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#expenseModal" data-target="#expenseModal"
                         data-toggle="modal">Dodaj wydatek</a>
                    </li>
                    <li class="nav-item currentPage">
                        <a href="#incomesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Przeglądaj przychody</a>
                        <ul class="collapse list-unstyled" id="incomesSubmenu">
                            <li class="nav-item">
                                <a class="nav-link" href="showThisWeekIncomes.php">Bieżący tydzień</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showThisMonthIncomes.php">Bieżący miesiąc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showLastMonthIncomes.php">Poprzedni miesiąc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showChosenPeriodIncomes.php">Wybrany okres</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#expensesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Przeglądaj wydatki</a>
                        <ul class="collapse list-unstyled" id="expensesSubmenu">
                            <li>
                                <a class="nav-link" href="showThisWeekExpenses.php">Bieżący tydzień</a>
                            </li>
                            <li>
                                <a class="nav-link" href="showThisMonthExpenses.php">Bieżący miesiąc</a>
                            </li>
                            <li>
                                <a class="nav-link" href="showLastMonthExpenses.php">Poprzedni miesiąc</a>
                            </li>
                            <li>
                                <a class="nav-link" href="showChosenPeriodExpenses.php">Wybrany okres</a>
                            </li>
                        </ul>
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
            <div class="info-board d-flex justify-content-between text-center mb-3 ml-3">
                <div class="totalIncomesBox">
                    <h3>SUMA WYDATKÓW</h3>
                    <p class="incomeBox">w poprzednim miesiącu</p>
                    <?php echo "<p class='incomeBoxInt'>$sum</p>" ?>
                </div>
            </div>
            <div class="info-board ml-3">
                <div class="d-flex justify-content-between">
                <button class="mainBtn showTransactionsBtn" type="button" onclick="location.href='showThisWeekExpenses.php'">Bieżący tydzień</button>
                    <button class="mainBtn showTransactionsBtn" type="button" onclick="location.href='showThisMonthExpenses.php'">Bieżący miesiąc</button>
                    <button class="mainBtn showTransactionsBtn" type="button" onclick="location.href='showLastMonthExpenses.php'">Poprzedni miesiąc</button>
                    <button class="mainBtn showTransactionsBtn" type="button" data-toggle="collapse" data-target="#collapseChoosePeriod" aria-expanded="false" aria-controls="collapseChoosePeriod">Wybierz okres</button>
                </div>
                <div class="collapse" id="collapseChoosePeriod">
                    <div class="card card-body mt-2">
                        <form action="showChosenPeriodIncomes.php" method="post">
                            <div class="form-group">
                                <label>Podaj datę początkową</label>
                                <input class="form-control" type="date" name="startingDate">
                                <?php
                                    if (isset($_SESSION['e_date'])){
                                        echo '<div class="error">'.$_SESSION['e_date'].'</div>';
                                        unset($_SESSION['e_date']);
                                    }
                                ?>  
                            </div>
                            <div class="form-group">
                                <label>Podaj datę końcową</label>
                                <input class="form-control" type="date" name="endingDate">
                                <?php
                                    if (isset($_SESSION['e_date'])){
                                        echo '<div class="error">'.$_SESSION['e_date'].'</div>';
                                        unset($_SESSION['e_date']);
                                    }
                                ?>  
                            </div>
                            <input class="mainBtn" type="submit" name="submit" value="Wybierz">
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex incomesTable my-5 mr-3">
                <table class="table bg-light table-striped ml-3">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Wysokość przychodu</th>
                        <th scope="col">Data</th>
                        <th scope="col">Rodzaj przychodu</th>
                        <th scope="col">Komentarz</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $recordNumber=1;
                            foreach ($expenses as $expense)
                            {
                                echo "<tr>";
                                echo "<th scope='row'>$recordNumber</th>";
                                echo "<td>" . $expense['money'] ."</td>";
                                echo "<td>" . $expense['date'] . "</td>";
                                echo "<td>" . $expense['name'] . "</td>";
                                echo "<td>" . $expense['name'] . "</td>";
                                echo "<td>" . $expense['comment'] . "</td>";
                                echo "</tr>";
                            $recordNumber++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal" id="incomeModal">
            <div class="modal-dialog">
                <div class="modal-content px-2 px-sm-4">
                    <!-- Modal Header -->
                    <div class="modal-header justify-content-center ml-2">
                        <h4 class="modal-title">Dodaj przychód</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body mx-2">
                        <form action="addIncome.php" method="post">
                            <div class="form-group">
                                <label>Podaj wysokość przychodu:</label>
                                <input class="form-control inputSlot" type="number" min="0" step="0.01" name="money">
                                <?php
                                    if (isset($_SESSION['e_money'])){
                                        echo '<div class="error">'.$_SESSION['e_money'].'</div>';
                                        unset($_SESSION['e_money']);
                                    }
                                ?>  
                            </div>
                            <div class="form-group">
                                <label>Podaj datę uzyskania przychodu:</label>
                                <input class="form-control inputSlot" id="incomeDate" type="date" name="date">
                                <?php
                                    if (isset($_SESSION['e_date'])){
                                        echo '<div class="error">'.$_SESSION['e_date'].'</div>';
                                        unset($_SESSION['e_date']);
                                    }
                                ?>  
                            </div>
                            <div class="form-group">
                                <label>Wybierz z listy rodzaj przychodu:</label>
                                <select class="form-control inputSlot" id="incomeCategory" name="category">
                                    <?php foreach ($income_options as $option): ?>
                                                <option value="<?=$option['name']?>"><?=$option['name']?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dodaj komentarz (opcjonalnie):</label>
                                <textarea class="form-control inputSlot" rows="4" name="comment">
                                    <?php
                                        if (isset($_SESSION['e_comment'])){
                                            echo '<div class="error">'.$_SESSION['e_comment'].'</div>';
                                            unset($_SESSION['e_comment']);
                                        }
                                    ?> 
                                </textarea> 
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer justify-content-between py-4">
                                <input type="submit" class="mainBtn" name="submit" value="Dodaj">
                                <button type="button" class="mainBtn" data-dismiss="modal">Anuluj</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Add Expense Modal --> 
        <div class="modal" id="expenseModal">
            <div class="modal-dialog">
                <div class="modal-content px-2 px-sm-4">
                    <!-- Modal Header -->
                    <div class="modal-header justify-content-center ml-2">
                        <h4 class="modal-title">Dodaj wydatek</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body mx-2">
                        <form action="addExpense.php" method="post">
                            <div class="form-group">
                                <label>Podaj wysokość wydatku:</label>
                                <input class="form-control" type="number" min='0'step='0.01' name='money'>
                                <?php
                                    if (isset($_SESSION['e_money'])){
                                        echo '<div class="error">'.$_SESSION['e_money'].'</div>';
                                        unset($_SESSION['e_money']);
                                    }
                                ?>  
                            </div>
                            <div class="form-group">
                                <label>Podaj datę uzyskania przychodu:</label>
                                <input class="form-control" type="date" name='date'>
                            </div>
                            <div class="form-group">
                                <label >Wybierz sposób płatności:</label>
                                <select class="form-control" name='paymentMethod'>
                                    <?php foreach ($payment_methods as $option): ?>
                                                <option value="<?=$option['name']?>"><?=$option['name']?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategoria:</label>
                                <select class="form-control" name='category'>
                                    <?php foreach ($expense_categories as $option): ?>
                                                <option value="<?=$option['name']?>"><?=$option['name']?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dodaj komentarz (opcjonalnie):</label>
                                <textarea class="form-control" rows="3" name='comment'></textarea>
                                <?php
                                    if (isset($_SESSION['e_comment'])){
                                        echo '<div class="error">'.$_SESSION['e_comment'].'</div>';
                                        unset($_SESSION['e_comment']);
                                    }
                                ?> 
                            </div>
                            <div class="form-group">
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer justify-content-between py-4">
                                <input type="submit" class="mainBtn" name="submit" value="Dodaj">
                                <button type="button" class="mainBtn" data-dismiss="modal">Anuluj</button>
                            </div>
                        </form>
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