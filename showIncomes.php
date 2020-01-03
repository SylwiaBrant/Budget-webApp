<?php
    session_start();

    if(!isset($_SESSION['userLoggedIn'])){
        header('Location: index.php');
        exit();
    }
    require_once "config.inc.php";
    $db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    if($db_connection->connect_errno != 0){
        echo "Error: ".$db_connection->connect_errno;
    }
    else{
        $sql_show_incomes = sprintf("SELECT i.date, i.money, it.name, i.comment FROM incomes AS i INNER JOIN income_types AS it WHERE i.user_id='14' AND i.user_id = it.user_id",
            $db_connection->real_escape_string($_SESSION['loggedInUserId'])); 
            if($result =$db_connection->query($sql_show_incomes)){
        }
        $db_connection->close();
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
<div class="row justify-content-center">
    <div class="incomesTable col-6">
    <table class="table  bg-light table-striped">
    <thead class="thead-dark">
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
    while($row = mysqli_fetch_array($result))
    {

    echo "<tr>";
    echo "<th scope='row'>$recordNumber</th>";
    echo "<td>" . $row['money'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['comment'] . "</td>";
    echo "</tr>";
    $recordNumber++;
    }
    ?>
    </tbody>
    </table>
    </div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    </body>
    </html>