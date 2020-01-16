<?php 
    session_start();
    if((isset($_SESSION['userLoggedIn'])) && ($_SESSION['userLoggedIn'] == true)){
        header('Location: mainpage.php');
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
                                <div class="d-flex flex-row justify-content-between">
                                    <h1>Zaloguj się</h1>
                                    <div>
                                        <p>Nie masz konta?</p>
                                        <a class="link" href="register.php">Zarejestruj się</a>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <form action="login.php" method="post">
                                        <div class="form-group">
                                            <div class="py-2">
                                                <label>Podaj login</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img src="img/114-user.png"></span>
                                                    </div>
                                                    <input class="form-control inputSlot" name="login" type="text" placeholder="Login" <?= isset($_SESSION['givenLogin']) ? 'value="'.$_SESSION['givenLogin'].'"' : '' ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pb-4">
                                            <label>Podaj hasło:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img src="img/144-lock.png"></span>
                                                </div>
                                                <input class="form-control inputSlot" name="password" type="password" placeholder="Hasło">
                                            </div>
                                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                                        </div> 
                                        <div class="d-flex justify-content-center mt-3">
                                            <input class="mainBtn" type="submit" name="submit" value="Zaloguj sie">
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