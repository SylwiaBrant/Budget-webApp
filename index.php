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
                    <div>
                        <button class="btn btn-secondary btnSpecified" type="button" onclick="showModal('#loginModal')">Zaloguj się</button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-secondary dropdown-toggle btnSpecified" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Moje konto</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="icon-cog"></i>Ustawienia</button>
                                <button class="dropdown-item" type="button"><i class="icon-export"></i>Wyloguj się</button>
                            </div>
                        </div>
                    </div>    
                </nav>
            </div>
        </header>
            <div class="container mainPage">
                <!-- Cards -->
                <div class="d-flex flex-row justify-content-around text-center mx-2 flex-wrap">
                    <div class="col transactionsBtn p-3 m-2" onclick="showModal('#incomeModal')">
                        <img src="img/profits.png" class="d-block mx-auto mb-3 icon" alt="profits icon">
                        <h2>DODAJ PRZYCHÓD</h2>
                    </div>
                    <div class="col transactionsBtn p-3 m-2"
                    onclick="showModal('#expenseModal')">
                        <img src="img/pay.png" class="d-block mx-auto mb-3 icon" alt="two hands paying">
                        <h2>DODAJ WYDATEK</h2>
                    </div>
                    <div class="col transactionsBtn p-3 m-2">
                        <a href="balance.html">
                        <img src="img/analysis.png" class="d-block mx-auto mb-3 icon" alt="magnifying glass on charts">
                        <h2>PRZEGLĄDAJ BILANS</h2></a>
                    </div>
                </div>
                <div class="quote">
                    <p>„Skoro pracujesz na swoje pieniądze co najmniej czterdzieści godzin tygodniowo, to skrajną nieodpowiedzialnością jest niepoświęcanie im uwagi.”</p><p class="quoteAuthor">~Suze Orman</p>
                </div>
            </div>   
            <footer>
                <div class="row justify-content-center">
                    <p>&copy; Sylwia Brant, 2019</p>
                    <div>Icons made by<a href="https://www.flaticon.com/authors/srip" title="srip">srip</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                    </div>
                </div>
            </footer>

    <!-- Log In Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header d-flex flex-row justify-content-around align-items-center ml-2">
                <h4 class="modal-title">Zaloguj się</h4>
                <div>
                    <p>Nie masz konta?</p>
                    <button class="btn btn-secondary btnSpecified" data-dismiss="modal" onclick="showModal('#registerModal')">Zarejestruj się</button>
                </div>
                <button type="button" class="close ml-1" data-dismiss="modal">&times;</button>
              </div>
                <!-- Modal body -->
                <div class="modal-body mx-2">
               <form class="needs-validation">
                    <div class="form-group">
                        <div class="py-4">
                            <input class="form-control inputSlot" id="userInputEmail" type="email" placeholder="Wpisz email">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                    </div>
                    <div class="pb-4">
                        <input class="form-control inputSlot" id="userInputPassword" type="password" placeholder="Wpisz hasło">
                        <div class="invalid-feedback">To pole musi być wypełnione.</div>
                    </div>  
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer justify-content-center py-4">
                    <button class="btn btn-secondary btnSpecified" type="submit" value="Zaloguj się" name="login" onclick="getRegisterData()">Zaloguj</button>
                </div>
            </div>
        </div>
    </div>     
    <!-- Register Modal -->
    <div class="modal" id="registerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header d-flex flex-row justify-content-around align-items-center ml-2">
                <h4 class="modal-title">Zarejestruj się</h4>
                <button type="button" class="close ml-1" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body mx-2">
                    <form class="needs-validation" action="" method="">
                        <div class="form-group">
                            <label>Podaj imię:</label>
                            <input class="form-control inputSlot" id="firstname" type="text" name="name" value="<?php 
                                echo htmlspecialchars($name, ENT_QUOTES);
                            ?>">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="form-group">
                            <label>Podaj nazwisko:</label>
                            <input class="form-control inputSlot" id= "lastname" type="text" name="surname" value="<?php
                                echo htmlspecialchars($surname, ENT_QUOTES);
                            ?>"                            >
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="form-group">
                            <label>Podaj email:</label>
                            <input class="form-control inputSlot" id="userEmail" type="email" name="email" value="<?php
                                echo htmlspecialchars($email, ENT_QUOTES);
                            ?>">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                        <div class="form-group">
                            <label>Podaj hasło:</label>
                            <input class="form-control inputSlot" id="password" type="password" name="pasword">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center py-4">
                    <button class="btn btn-secondary btnSpecified" type="submit" value="Zaloguj się" name="register" onclick="getRegisterData()">Zaloguj</button>
                </div>
            </div>
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
                <form>
                    <div class="form-group">
                        <label>Podaj wysokość przychodu:</label>
                        <input class="form-control" type="number" id="incomeAmount">
                    </div>
                    <div class="form-group">
                        <label>Podaj datę uzyskania przychodu:</label>
                        <input class="form-control" id= "incomeDate" type="date">
                    </div>
                    <div class="form-group">
                        <label>Wybierz z listy rodzaj przychodu:</label>
                        <select class="form-control" id="incomeCategory">
                            <option>Wynagrodzenie</option>    
                            <option>Odsetki bankowe</option>    
                            <option>Sprzedaż</option>    
                            <option>Inne</option>    
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dodaj komentarz (opcjonalnie):</label>
                        <textarea class="form-control" rows="4" id="incomeComment"></textarea>
                    </div>
                </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center py-4">
                    <button type="submit" class="btn btn-secondary btnSpecified mr-3" onclick="getIncomeData()">Dodaj</button>
                    <button type="button" class="btn btn-secondary btnSpecified ml-3" data-dismiss="modal">Anuluj</button>
                </div>
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
                    <form>
                        <div class="form-group">
                            <label>Podaj wysokość wydatku:</label>
                            <input class="form-control" id="expenseAMount" type="number">
                        </div>
                        <div class="form-group">
                            <label>Podaj datę uzyskania przychodu:</label>
                            <input class="form-control" id= "expenseDate" type="date">
                        </div>
                        <div class="form-group">
                            <label >Wybierz sposób płatności:</label>
                            <select class="form-control" id="pay-method">
                                <option>Gotówka</option>    
                                <option>Karta debetowa</option>    
                                <option>Karta kredytowa</option>       
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategoria:</label>
                            <select class="form-control" id="expenseCategory">
                                <option>Jedzenie</option>
                                <option>Mieszkanie</option>
                                <option>Transport</option>
                                <option>Telekomunikacja</option>
                                <option>Opieka zdrowotna</option>
                                <option>Ubranie</option>
                                <option>Higiena</option>
                                <option>Dzieci</option>
                                <option>Rozrywka</option>
                                <option>Wycieczka</option>
                                <option>Szkolenia</option>
                                <option>Książki</option>
                                <option>Oszczędności</option>
                                <option>Emerytura</option>
                                <option>Spłata długów</option>
                                <option>Darowizna</option>
                                <option>Inne wydatki</option>    
                            </select>
                        </div>
                        <div class="form-group">
                        <label>Dodaj komentarz (opcjonalnie):</label>
                        <textarea class="form-control" rows="3" id="expenseComment"></textarea>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-around px-4">
                    <button type="submit" class="btn btn-secondary btnSpecified" onclick="getTransactionData()">Dodaj</button>
                    <button type="button" class="btn btn-secondary btnSpecified" data-dismiss="modal">Anuluj</button>
                </div>
            </div>
        </div>
    </div>    
    <!-- Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

    <?php

    $name = '';
    $surname = '';
    $email = '';
    $password = '';
        if (isset($_POST['submit'])) {
            $ok = true;
            if(!isset($_POST['name']) || $_POST['name'] === '') {
                $ok = false;
            }
            else {
                $name = $_POST['name'];
            }
            if(!isset($_POST['surname']) || $_POST['surname'] === '') {
                $ok = false;
            }
            else {
                $surname = $_POST['surname'];
            }
            if(!isset($_POST['email']) || $_POST['email'] === '') {
                $ok = false;
            }
            else {
                $email = $_POST['email'];
            }
            if(!isset($_POST['password']) || $_POST['password'] === '') {
                $ok = false;
            }
            else {
                $password = $_POST['password'];
            }
        }

    ?>
    </body>
</html>