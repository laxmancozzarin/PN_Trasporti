<?php session_start();?>
<?php 
if(!isset($_SESSION["Logged"])){
    header("Location: index.php");
    return;
}
      
if(isset($_POST["compra"])){
    Prenota($_GET["data"], $_GET["fermata_Inizio"], $_GET["id_fermata_Inizio"], $_GET["ora_Inizio"], $_GET["fermata_Fine"], $_GET["id_fermata_Fine"], $_GET["ora_Fine"], $_GET["autobus"], $_GET["linea"]);
}
      
if(isset($_POST["Logout"])){
    session_destroy();
    header("Location: index.php");
    exit();
}

function Prenota($data, $femata_Inizio, $id_Fermata_Inizo, $ora_Inzio, $fermata_Fine, $id_Fermata_Fine, $ora_Fine, $autobus, $linea){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
          echo $autobus;
        $linea = explode("-", $linea, 2);
        $idLinea = $linea[0];
        $costo = 5.50;
        $sqlInsert = "INSERT INTO Biglietti(Data_Transito, Fermata_Inizio, Fermata_Fine, Linea, Ora_Inizio, Ora_Fine, Utente, Prezzo, Non_Usato)
                      VALUES('$data', $id_Fermata_Inizo, $id_Fermata_Fine, $idLinea, '$ora_Inzio', '$ora_Fine', '".$_SESSION["Username"]."', $costo, '1')";
        $resInsert = $con->query($sqlInsert);
        if($resInsert){
          $sqlModificaPosti = "UPDATE Autobus SET Posti_Disponibili = Posti_Disponibili-1 WHERE Autobus='$autobus'";
          if($con->query($sqlModificaPosti)){
              header("Location: index.php");
              return;
          }
        }
        else
          echo " <script type='text/javascript'> alert('Errore'); </script>";
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <?php include 'ElementiPagina.php';?>
    <meta charset="utf-8">
    <title>Prenotazione Biglietto</title>
    <?php
    CreaNavBar();

    function MostraLineePeriodo(){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlLinee = "SELECT * FROM Linee";
        $sqlPeriodo = "SELECT * FROM Periodo";
        $res = $con->query($sqlLinee);
        echo "<h3> Scelga la linea:</h3>
              <select class='form-select' name='linee' id='linea'>";
        while ($riga = $res->fetch_assoc()) {
          echo "<option>".$riga["ID"]." - ".$riga["Nome"]." - ".$riga["Tipo"]."</option>";
        }
        echo "</select>";

        $res = $con->query($sqlPeriodo);
        echo "<h3>Scelga il periodo</h3><select class='form-select' name='Periodo' id='Periodo'>";
        while ($riga = $res->fetch_assoc()) {
          echo "<option>".$riga["Tipo"]."</option>";
        }
        echo "</select>";
      }
    }


    function MostraFermate($linea, $periodo, $passaggio, $ora){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $idLinea = preg_replace('/[^0-9]/', '',$linea);
        if($passaggio == 0){
          echo "<h3> Selezioni la fermata di partenza </h3>";
          $sql = "SELECT Passaggi.Numero_Passaggio, Passaggi.ID_Fermata, Fermata.Via, Fermata.Città, Passaggi.Ora, Autobus.Posti_Disponibili, Autobus.Targa
                    FROM Autobus
                    INNER JOIN Passaggi ON Autobus.Targa = Passaggi.ID_Autobus
                    INNER JOIN Fermata ON Passaggi.ID_Fermata = Fermata.ID_Fermata
                    WHERE Linea = $idLinea AND Posti_Disponibili >= 1 AND Periodo = '$periodo'
                  ORDER BY Ora ASC";
        }
        if($passaggio > 0){
          echo "<h3> Selezioni la fermata dove intende scendere </h3>";
          $sql = "SELECT Passaggi.Numero_Passaggio, Passaggi.ID_Fermata, Fermata.Via, Fermata.Città, Passaggi.Ora, Autobus.Posti_Disponibili, Autobus.Targa
                    FROM Autobus
                    INNER JOIN Passaggi ON Autobus.Targa = Passaggi.ID_Autobus
                    INNER JOIN Fermata ON Passaggi.ID_Fermata = Fermata.ID_Fermata
                    WHERE Linea = $idLinea AND Posti_Disponibili >= 1 AND Ora > '$ora' AND Periodo = '$periodo' AND Numero_Passaggio = $passaggio
                  ORDER BY Ora ASC";
        }

        $res = $con->query($sql);
        echo "<h1>Linea:  $linea </h1>
              <table class = 'table table table-striped'>
                <tr>
                  <th>Via</th>
                  <th>Città</th>
                  <th>Ora passaggio</th>
                  <th>Autobus</th>
                  <th>Posti Disponibili</th>
                  <th></th>
                </tr>";
        while ($riga = $res->fetch_assoc()){

          echo "<tr>
                  <td>".$riga["Via"]."</td>
                  <td>".$riga["Città"]."</td>
                  <td>".$riga["Ora"]."</td>
                  <td>".$riga["Targa"]."</td>
                  <td>".$riga["Posti_Disponibili"]."</td>";
          if($passaggio == 0){
            echo "  <td>
                      <form method='get'>
                        <input type='submit' class='editbtn' name='Fermata_Inizio' value='Prenota Inzio Corsa'>
                        <input type='hidden' name='id_fermata_Inizio' value='".$riga['ID_Fermata']."'>
                        <input type='hidden' name='fermata_Inizio' value='".$riga['Via']."'>
                        <input type='hidden' name='ora_Inizio' value='".$riga['Ora']."'>

                        <input type='hidden' name='data' value='".$_POST["data"]."'>
                        <input type='hidden' name='autobus' value='".$riga['Targa']."'>
                        <input type='hidden' name='linea' value='".$linea."'>
                        <input type='hidden' name='num_pas' value='".$riga['Numero_Passaggio']."'>
                        <input type='hidden' name='periodo' value='".$periodo."'>
                      </form> </td>
                  </tr>";
          }
          else {
            echo "  <td>
                      <form method='get'>
                        <input type='submit' class='editbtn' name='Fermata_Fine' value='Prenota Fine Corsa'>
                        <input type='hidden' name='fermata_Inizio' value='".$_GET["fermata_Inizio"]."'>
                        <input type='hidden' name='id_fermata_Inizio' value='".$_GET["id_fermata_Inizio"]."'>
                        <input type='hidden' name='ora_Inizio' value='".$_GET["ora_Inizio"]."'>

                        <input type='hidden' name='fermata_Fine' value='".$riga['Via']."'>
                        <input type='hidden' name='id_fermata_Fine' value='".$riga['ID_Fermata']."'>
                        <input type='hidden' name='ora_Fine' value='".$riga['Ora']."'>

                        <input type='hidden' name='data' value='".$_GET["data"]."'>
                        <input type='hidden' name='autobus' value='".$_GET["autobus"]."'>
                        <input type='hidden' name='linea' value='".$_GET["linea"]."'>
                      </form> </td>
                  </tr>";
          }

        }
        echo "</table>";
      }
    }

     ?>
  </head>
  <body>
    <?phpCreaNavBar();?>
    <div class="container">
      <form class="prenota" method="post">
        <?php MostraLineePeriodo(); ?>
        <br>
        Prenotazione per il giorno:<input type='date' name='data' required>
        <br>
        <input class="btn btn-lg btn-primary" type="submit" name="invia" value="Mostra">
      </form>
      <br>
      <?php
      if(isset($_POST["invia"]) && isset($_POST["linee"]) && isset($_POST["Periodo"])){
        if (!isset($_SESSION["Logged"])){
          ?> <script type='text/javascript'> alert('La preghiamo di autenticarsi prima di prenotare un biglietto'); </script> <?php
        }
        else
          MostraFermate($_POST["linee"], $_POST["Periodo"], 0, 0);
      }

      if(isset($_GET["Fermata_Inizio"])){
        MostraFermate($_GET["linea"], $_GET["periodo"], $_GET["num_pas"], $_GET["ora_Inizio"]);
      }
      if(isset($_GET["Fermata_Fine"])){
        echo "<h3>Dettagli corsa:</h3>
              <table class='table'>
                <tr>
                    <td> Data Di prenotazione: </td>
                    <td> ".$_GET["data"]."</td>
                </tr>
                
                <tr>
                    <td> Fermata di partenza: </td>
                    <td> ".$_GET["fermata_Inizio"]."</td>
                </tr>
                <tr>
                    <td> Orario partenza: </td>
                    <td> ".$_GET["ora_Inizio"]."</td>
                </tr>
                
                <tr>
                    <td> Fermata termine: </td>
                    <td> ".$_GET["fermata_Fine"]."</td>
                </tr>
                <tr>
                    <td> Orario di termine: </td>
                    <td> ".$_GET["ora_Fine"]."</td>
                </tr>
                
                <tr>
                    <td> Targa autobus: </td>
                    <td> ".$_GET["autobus"]."</td>
                </tr>
                <tr>
                    <td> Linea: </td>
                    <td> ".$_GET["linea"]."</td>
                </tr>
                
                <tr>
                    <td> Costo in euro: </td>
                    <td> 5,50 </td>
                </tr>
              </table>
              
              <form method='POST'>
                <input type='submit' name='compra' value='compra'>
              </form>";
      }
      
       ?>
    </div>

  </body>
</html>
