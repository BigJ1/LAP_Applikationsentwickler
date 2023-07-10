<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>LAP_UEBUNG</title>
</head>
<body>
    <?php 

    //verbindung definieren
    $SERVER = "127.0.0.1";
    $user = "root";
    $pass ="";
    $db="lap_buecherei_ai";
    
    //Open DB Connection
    $mysqli= new mysqli($SERVER, $user, $pass, $db);
    echo $mysqli->host_info, "/n";

//======================FORMULARE===================

echo '<form action="index.php" method="POST">';
echo 'Kunde: <input type="text" value =""name="filter_kunde">';
echo 'Buch: <input type="text" value =""name="filter_buch">';


echo '<input type="submit" value="filtern">';
echo '</form> <br>';

//werte aus Formular abfragen
print_r($_POST); echo'<br><br>';

//====================== ENDE FORMULARE===================

    //db abfrage
    $sql = "SELECT `ENTLEHNUNGENdatumvon`, `ENTLEHNUNGENdatumbis`, kunde.KUNDEname, kunde.KUNDEvorname, buch.BUCHtitel FROM `entlehnungen` 
            Inner JOIN kunde on kunde.idKUNDE=entlehnungen.KUNDE_idKUNDE
            INNER JOIN buch on BUCH_idBUCH = entlehnungen.BUCH_idBUCH";
    

//werden daten gesendet
if(!empty($_POST['filter_kunde']))
{
    $sql .= ' WHERE KUNDE_idKUNDE='.$_POST['filter_kunde'];
}
if(!empty($_POST['filter_buch']))
{
    $sql .= ' '.(!empty($_POST['filter_kunde']) ? 'AND' : 'WHERE').' BUCH_idBUCH='.$_POST['filter_buch'];
}

    echo $sql,"<br><br>";
    $mysqli->real_query($sql);
    $result = $mysqli->use_result();

    echo '<table class="table">
    <tr>
        <th>Kunde</th>
        <th>Buch</th>
        <th>von</th>
        <th>bis</th>
    <tr>';

    foreach ($result as $row){
        echo "<tr>
        <td>",$row ['KUNDEname']," ",$row['KUNDEvorname'],"</td>
        <td>",$row ['BUCHtitel'],"</td>
        <td>",$row ['ENTLEHNUNGENdatumvon'],"</td>
        <td>",$row ['ENTLEHNUNGENdatumbis'],"</td>
        </tr>";
    }
    echo"</table>";
    $mysqli->close();
    ?>
    <div id="Head">
        <h1>LAP_UEBUNG</h1>
    </div>
    
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Kunde</th>
        <th scope="col">Buch</th>
        <th scope="col">Von</th>
        <th scope="col">Bis</th>
        </tr>
    </thead>
        <tbody>
            <tr>
            <th scope="row">1</th>
            <td>Mustermann Max</td>
                    <td>Aqua Alta</td>
                    <td>2023-07-04 09:00:00</td>
            </tr>
        </tbody>
    </table>
</body>
</html>