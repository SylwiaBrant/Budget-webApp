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
        <div class="container mainPage align-items-center"> 
            <div class="card mx-auto">
                <!-- Card Header -->
                <div class="card-header d-flex flex-row justify-content-around align-items-center">
                    <h4 class="card-title">Zaloguj się</h4>
                    <div>
                        <p>Nie masz konta?</p>
                        <button class="btn btn-secondary btnSpecified" data-dismiss="modal" onclick="location.href='register.php'">Zarejestruj się</button>
                    </div>
                </div>
                    <!-- Card body -->
                <div class="card-body mx-2">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <div class="py-2">
                                <label>Podaj login</label>
                                <input class="form-control inputSlot" name="login" type="text" placeholder="Login">
                            </div>
                        </div>
                        <div class="pb-4">
                            <label>Podaj hasło:</label>
                            <input class="form-control inputSlot" name="password" type="password" placeholder="Hasło">
                            <div class="invalid-feedback">To pole musi być wypełnione.</div>
                        </div> 
                        <div class="d-flex justify-content-center">
                            <input class="btn btn-secondary btnSpecified" type="submit" value="Zaloguj sie">
                        </div> 
                    </form>
                </div>
            <div class="justify-content-center">
                <?php
                if(isset($_SESSION['credentialsError'])) echo $_SESSION['credentialsError'];
                ?>
        </div>
    <footer>
        <div class="row justify-content-center">
            <p>&copy; Sylwia Brant, 2019</p>
            <div>Icons made by<a href="https://www.flaticon.com/authors/srip" title="srip">srip</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
            </div>
        </div>
    </footer>    
    <!-- Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    </body>
</html>