<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <title>Amministratore</title>

    <?php
    function MostraLinee($urbano){
      echo "<form method='post'>
              <table class='table'>
                <td>
                  <select class='form-select' name='Tipo_Linea'>
                    <option>Tutto</option>
                    <option>Urbano</option>
                    <option>Extraurbano</option>
                  </select>
                </td>

                <td> <input class='btn btn-success' type='submit' name='cercaLinea' value='Cerca'> </td>
            </form>";
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        if($urbano!=null && $urbano!="Tutto")
          $sqlLinee = "SELECT * FROM Linee WHERE Tipo = '$urbano'";
        else {
          $sqlLinee = "SELECT * FROM Linee";
        }
        $res = $con->query($sqlLinee);
        echo "<h3> Tabella delle linee:</h3>
              <table class = 'table table table-striped'>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Tipo di linea</th>
                  <th></th>
                </tr>";
        while ($riga = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td>".$riga["ID"]."</td>
                    <td>".$riga["Nome"]."</td>
                    <td>".$riga["Tipo"]."</td>
                    <td><input type='submit' name='EliminaLinea' value='Elimina'></td>
                    <input type='hidden' value='".$riga["ID"]."' name='EliminaID'>
                  </form>
                </tr>";
        }
        echo "  <tr>
                  <form method='post'>
                    <td><input type='number' name='ID' placeholder='id'></td>
                    <td><input type='text' name='Nome' placeholder='Nome Linea'></td>
                    <td>
                      <select class='form-select' name='Tipo'>
                        <option> Urbano </option>
                        <option> Extraurbano </option>
                      </select>
                    </td>
                    <td><input type='submit' name='AggiungiLinea' value='Aggiungi'></td>
                  </form>
                </tr>
             </table>";
      }
    }

    function EliminaLinea($id){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlElimina = "DELETE FROM Linee WHERE ID=".$id;
        if ($con->query($sqlElimina)) {
          ?> <script type='text/javascript'> alert('Linea eliminata con successo'); </script> <?php
          MostraLinee();
        } else {
          ?> <script type='text/javascript'> alert('Errore nella eliminazione del record'); </script> <?php
        }
      }
    }

    function AggiungiLinea($id, $nome, $tipo){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlInsert = "INSERT INTO Linee (ID, Nome, Tipo)
                      VALUES ({$id}, '{$nome}', '{$tipo}')";
        if ($con->query($sqlInsert)) {
          MostraLinee();
        }
        else {
          ?> <script type='text/javascript'> alert('Errore, non è stato possibile aggiungere il record'); </script> <?php
        }
      }
    }

    function MostraFermate(){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlLinee = "SELECT * FROM Fermata";
        $res = $con->query($sqlLinee);
        echo "<h3> Tabella delle Fermate:</h3>
              <table class = 'table table table-striped'>
                <tr>
                  <th>ID</th>
                  <th>Via</th>
                  <th>Città</th>
                  <th>Note</th>
                  <th></th>
                </tr>";
        while ($riga = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td>".$riga["ID_Fermata"]."</td>
                    <td>".$riga["Via"]."</td>
                    <td>".$riga["Città"]."</td>
                    <td>".$riga["Note"]."</td>
                    <td><input type='submit' name='EliminaFermata' value='Elimina'></td>
                    <input type='hidden' value='".$riga["ID_Fermata"]."' name='EliminaID_Fermata'>
                  </form>
                </tr>";
        }
        echo "  <tr>
                  <form method='post'>
                    <td>ID_Fermata automatico</td>
                    <td><input type='text' name='Via' placeholder='Via'></td>
                    <td><input type='text' name='Città' placeholder='Città'></td>
                    <td><input type='text' name='Note' placeholder='Note'></td>
                    <td><input type='submit' name='AggiungiFermata' value='Aggiungi'></td>
                  </form>
                </tr>
             </table>";
      }
    }

    function EliminaFermata($id){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlElimina = "DELETE FROM Fermata WHERE ID_Fermata=".$id;
        if ($con->query($sqlElimina)) {
          ?> <script type='text/javascript'> alert('Fermata eliminata con successo'); </script> <?php
          MostraFermate();
        } else {
          ?> <script type='text/javascript'> alert('Errore nella eliminazione del record'); </script> <?php
        }
      }
    }

    function AggiungiFermata($via, $citta, $note){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlInsert = "INSERT INTO Fermata (Via, Città, Note)
                      VALUES ('{$via}', '{$citta}', '{$note}')";
        if ($con->query($sqlInsert)) {
          MostraFermate();
        }
        else {
          ?> <script type='text/javascript'> alert('Errore, non è stato possibile aggiungere il record'); </script> <?php
        }
      }
    }


    function MostraAutobus(){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlLinee = "SELECT * FROM Linee";
        $resLinee = $con->query($sqlLinee);

        $sqlLinee = "SELECT * FROM Autobus";
        $res = $con->query($sqlLinee);
        echo "<h3> Tabella degli Autobus:</h3>
              <table class = 'table table table-striped'>
                <tr>
                  <th>Targa</th>
                  <th>Posti Totali</th>
                  <th>Posti Disponibili</th>
                  <th>Tipo</th>
                  <th>Linea</th>
                  <th></th>
                </tr>";
        while ($riga = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td>".$riga["Targa"]."</td>
                    <td>".$riga["Posti_Totali"]."</td>
                    <td>".$riga["Posti_Disponibili"]."</td>
                    <td>".$riga["Tipo"]."</td>
                    <td>".$riga["Linea"]."</td>
                    <td><input type='submit' name='EliminaAutobus' value='Elimina'></td>
                    <input type='hidden' value='".$riga["Targa"]."' name='EliminaTarga'>
                  </form>
                </tr>";
        }
        echo "  <tr>
                  <form method='post'>
                    <td><input type='text' name='Targa' placeholder='Targa'></td>
                    <td><input type='number' name='Posti_Totali' placeholder='Totali'></td>
                    <td><input type='number' name='Posti_Disponibili' placeholder='Disponibili'></td>
                    <td><input type='text' name='Tipo' placeholder='Tipo'></td>
                    <td>";
        echo "        <select class='form-select' name='LineaSelect'>";
        MostraFermateSelect($resLinee);
        echo "        </select>
                    </td>
                    <td><input type='submit' name='AggiungiAutobus' value='Aggiungi'></td>
                  </form>
                </tr>
             </table>";
      }
    }

    function MostraFermateSelect($res){
      while ($riga = $res->fetch_assoc())
        echo "<option>".$riga["ID"]."</option>";
    }

    function EliminaAutobus($targa){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlElimina = "DELETE FROM Autobus WHERE Targa='".$targa."'";
        if ($con->query($sqlElimina)) {
          ?> <script type='text/javascript'> alert('Fermata eliminata con successo'); </script> <?php
          MostraAutobus();
        } else {
          ?> <script type='text/javascript'> alert('Errore nella eliminazione del record'); </script> <?php
        }
      }
    }

    function AggiungiAutobus($targa, $postiTot, $postiDisp, $tipo, $linea){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlInsert = "INSERT INTO Autobus(Targa, Posti_Totali, Posti_Disponibili, Tipo, Linea)
                      VALUES ('{$targa}', {$postiTot}, {$postiDisp}, '{$tipo}', {$linea})";
        if ($con->query($sqlInsert)) {
          MostraAutobus();
        }
        else {
          ?> <script type='text/javascript'> alert('Errore, non è stato possibile aggiungere il record'); </script> <?php
        }
      }
    }


    function MostraPassaggi(){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlFermate = "SELECT * FROM Fermata";
        $resFermate= $con->query($sqlFermate);

        $sqlAutobus = "SELECT * FROM Autobus";
        $resAutobus= $con->query($sqlAutobus);

        $sqlPeriodo = "SELECT * FROM Periodo";
        $resPeriodo= $con->query($sqlPeriodo);

        $sqlLinee = "SELECT * FROM Passaggi ORDER BY Ora ASC";
        $res = $con->query($sqlLinee);
        echo "<h3> Tabella dei Passaggi:</h3>
              <table class = 'table table table-striped'>
                <tr>
                  <th>Fermata</th>
                  <th>Autobus</th>
                  <th>Ora</th>
                  <th>Feriale/Festivo</th>
                  <th>Periodo</th>
                  <th>Num Passaggio</th>
                  <th></th>
                </tr>";
        while ($riga = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td>".PrendiFermataDaID($con, $riga["ID_Fermata"])."</td>
                    <td>".$riga["ID_Autobus"]."</td>
                    <td>".$riga["Ora"]."</td>
                    <td>".FerialeFestivo($con, $riga["Feriale"])."</td>
                    <td>".$riga["Periodo"]."</td>
                    <td>".$riga["Numero_Passaggio"]."</td>
                    <td><input type='submit' name='EliminaPassaggio' value='Elimina'></td>
                    <input type='hidden' value='".$riga["ID_Fermata"]."' name='EliminaID_Fermata'>
                    <input type='hidden' value='".$riga["ID_Autobus"]."' name='EliminaID_Autobus'>
                    <input type='hidden' value='".$riga["Ora"]."' name='EliminaOra'>
                  </form>
                </tr>";
        }
        echo "  <tr>
                  <form method='post'>
                    <td>";
                 echo "<select class='form-select' name='FermateSelect'>";
                         SelectFermata($resFermate);
                 echo "</select>
                    </td>
                    <td>
                      <select class='form-select' name='AutobusSelect'>";
                         SelectAutobus($resAutobus);
                 echo "</select>
                    </td>
                    <td><input type='time' name='Ora' step='1' value='06:00:00'></td>
                    <td>
                      <select class='form-select' name='FerialeSelect'>
                        <option>Feriale</option>
                        <option>Festivo</option>
                      </select>
                    </td>
                    <td>
                      <select class='form-select' name='PeriodoSelect'>";
                         SelectPeriodo($resPeriodo);
                 echo "</select>
                    </td>
                    <td><input type='number' name='NumeroPassaggio' value='1'></td>
                    <td><input type='submit' name='AggiungiPassaggio' value='Aggiungi'></td>
                  </form>
                </tr>
             </table>";
      }
    }

    function PrendiIDFermata($via){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sql = "SELECT ID_Fermata FROM Fermata WHERE Via='".$via."'";
        $res = $con->query($sql);
        while ($riga = $res->fetch_assoc()){
          return $riga["ID_Fermata"];
        }
      }
    }

    function PrendiFermataDaID($con, $id){
      $sql = "SELECT * FROM Fermata WHERE ID_Fermata=$id";
      $res = $con->query($sql);
      $stringa="";
      while ($riga = $res->fetch_assoc()){
        $stringa=$riga["Via"];
      }
      return $stringa;
    }

    function FerialeFestivo($con, $feriale){
      if ($feriale)
        return "Feriale";
      return "Festivo";
    }

    function SelectFermata($res){
      while ($riga = $res->fetch_assoc())
        echo "<option>".$riga["Via"]."</option>";
    }

    function SelectAutobus($res){
      while ($riga = $res->fetch_assoc())
        echo "<option>".$riga["Targa"]."</option>";
    }

    function SelectPeriodo($res){
      while ($riga = $res->fetch_assoc())
        echo "<option>".$riga["Tipo"]."</option>";
    }


    function EliminaPassaggio($idFermata, $idAutobus, $ora){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlElimina = "DELETE FROM Passaggi WHERE ID_Fermata=".$idFermata." AND ID_Autobus='".$idAutobus."' AND Ora='".$ora."'";
        if ($con->query($sqlElimina)) {
          ?> <script type='text/javascript'> alert('Passaggio eliminata con successo'); </script> <?php
          MostraPassaggi();
        } else {
          ?> <script type='text/javascript'> alert('Errore nella eliminazione del record'); </script> <?php
        }
      }
    }

    function AggiungiPassaggio($fermata, $autobus, $ora, $feriale, $periodo, $numPassaggio){
      $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
      if(!$con){
        ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
      }
      else{
        $sqlInsert = "INSERT INTO Passaggi (ID_Fermata, ID_Autobus, Ora, Feriale, Periodo, Numero_Passaggio)
                      VALUES ({$fermata}, '{$autobus}', '{$ora}', {$feriale}, '{$periodo}', {$numPassaggio})";
        if ($con->query($sqlInsert)) {
          MostraPassaggi();
        }
        else {
          ?> <script type='text/javascript'> alert('Errore, non è stato possibile aggiungere il record'); </script> <?php
        }
      }
    }
     ?>
  </head>
  <body>

    <div class="container pb-3" style="text-align: center;">
      <div class="pt-3">
        <div class="titolo pt-3 pb-3" style="background-color:lightblue;">
          <h3>Zona dedicata all'aministrazione della base di dati PN TRASPORTI</h3>
        </div>
      </div>


      <div class="form pt-4">
        <form method="post">
          <input class="btn btn-warning" type="submit" name="Linea" value="Visualizza le Linee">
          <input class="btn btn-warning" type="submit" name="Fermata" value="Visualizza le Fermate">
          <input class="btn btn-warning" type="submit" name="Autobus" value="Visualizza gli Autobus">
          <input class="btn btn-warning" type="submit" name="Passaggio" value="Visualizza i Passaggi">
          <br><br>
          <input class="btn btn-danger" type="submit" name="Emergenza" value="Modifica percentuale di posti">
        </form>
      </div>

      <div class="tabella pt-3">
        <?php

          echo "<hr>";
          if(isset($_POST["Linea"])){
            MostraLinee(null);
          }
          if (isset($_POST["Tipo_Linea"])) {
            MostraLinee($_POST["Tipo_Linea"]);
          }
          if(isset($_POST["EliminaLinea"]) && isset($_POST["EliminaID"])){
            EliminaLinea($_POST["EliminaID"]);
          }
          if(isset($_POST["AggiungiLinea"]) && isset($_POST["ID"]) && isset($_POST["Tipo"]) && isset($_POST["Nome"])){
            $id = filter_var($_POST["ID"], FILTER_VALIDATE_INT);
            $nome = filter_var($_POST["Nome"], FILTER_SANITIZE_STRING);
            $tipo = filter_var($_POST["Tipo"], FILTER_SANITIZE_STRING);
            if(filter_var($_POST["ID"],  FILTER_VALIDATE_INT) && filter_var($_POST["Nome"], FILTER_SANITIZE_STRING) && filter_var($_POST["Tipo"], FILTER_SANITIZE_STRING)){
              AggiungiLinea($_POST["ID"], $_POST["Nome"], $_POST["Tipo"]);
            }
            else {
              ?> <script type='text/javascript'> alert('Valori immessi non sono validi, riprovi'); </script> <?php
            }
          }

          if(isset($_POST["Fermata"])){
            MostraFermate();
          }
          if(isset($_POST["EliminaFermata"]) && isset($_POST["EliminaID_Fermata"])){
            EliminaFermata($_POST["EliminaID_Fermata"]);
          }
          if(isset($_POST["AggiungiFermata"]) && isset($_POST["Via"]) && isset($_POST["Città"]) && isset($_POST["Note"])){
            $via = filter_var($_POST["Via"], FILTER_SANITIZE_STRING);
            $citta = filter_var($_POST["Città"], FILTER_SANITIZE_STRING);
            $note = filter_var($_POST["Note"], FILTER_SANITIZE_STRING);
            AggiungiFermata($via, $citta, $note);
          }


          if(isset($_POST["Autobus"])){
            MostraAutobus();
          }
          if(isset($_POST["EliminaAutobus"]) && isset($_POST["EliminaTarga"])){
            EliminaAutobus($_POST["EliminaTarga"]);
          }
          if(isset($_POST["AggiungiAutobus"]) && isset($_POST["Targa"]) && isset($_POST["Posti_Totali"]) && isset($_POST["Posti_Disponibili"]) && isset($_POST["Tipo"]) && isset($_POST["LineaSelect"])){
            $targa = filter_var($_POST["Targa"], FILTER_SANITIZE_STRING);
            $postiTot = filter_var($_POST["Posti_Disponibili"], FILTER_VALIDATE_INT);
            $postiDisp = filter_var($_POST["Posti_Disponibili"], FILTER_VALIDATE_INT);
            $tipo = filter_var($_POST["Tipo"], FILTER_SANITIZE_STRING);
            $linea = filter_var($_POST["LineaSelect"], FILTER_VALIDATE_INT);
            AggiungiAutobus($targa, $postiTot, $postiDisp, $tipo, $linea);
          }

          if(isset($_POST["Passaggio"])){
            MostraPassaggi();
          }
          if(isset($_POST["EliminaPassaggio"]) && isset($_POST["EliminaID_Fermata"]) && isset($_POST["EliminaID_Autobus"]) && isset($_POST["EliminaOra"])){
            EliminaPassaggio($_POST["EliminaID_Fermata"], $_POST["EliminaID_Autobus"], $_POST["EliminaOra"]);
          }
          if(isset($_POST["AggiungiPassaggio"]) && isset($_POST["FermateSelect"]) && isset($_POST["AutobusSelect"]) && isset($_POST["FerialeSelect"]) && isset($_POST["PeriodoSelect"]) && isset($_POST["Ora"]) && isset($_POST["NumeroPassaggio"])) {
            $ora = date('h:i:s', strtotime($_POST["Ora"]));

            if ($_POST["FerialeSelect"] == "Feriale") {
              AggiungiPassaggio(PrendiIDFermata($_POST["FermateSelect"]), $_POST["AutobusSelect"], $ora, true, $_POST["PeriodoSelect"], $_POST["NumeroPassaggio"]);
            }
            else {
              AggiungiPassaggio(PrendiIDFermata($_POST["FermateSelect"]), $_POST["AutobusSelect"], $ora, false, $_POST["PeriodoSelect"], $_POST["NumeroPassaggio"]);
            }
          }

          if(isset($_POST["Emergenza"])){
            echo "<h3> Imposti la percentuale di posti disponibili sull'autobus </h3>
                  <form method='post'>
                    <input type='number' name='Percentuale' placeholder='Percentuale posti %'>
                    <input class='btn btn-warning' type='submit' name='Conferma' value='Conferma riduzione posti'>
                    <input class='btn btn-success' type='submit' name='Ripristina' value='Ripristina numero di posti'>
                  </form>";
          }
          if(isset($_POST["Conferma"]) && isset($_POST["Percentuale"])){
            $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
            if(!$con){
              ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
            }
            else{
              $percentuale = $_POST["Percentuale"]/100;
              $sqlModificaPosti = "UPDATE Autobus
                                   SET Posti_Disponibili = Posti_Totali*$percentuale";
              if ($con->query($sqlModificaPosti)) {
                ?> <script type='text/javascript'> alert('La capienza massima nei mezzi è stata ridotta'); </script> <?php
              }
              else {
                ?> <script type='text/javascript'> alert('Errore'); </script> <?php
              }
            }
          }
          if (isset($_POST["Ripristina"])) {
            $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
            if(!$con){
              ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
            }
            else{
              $sqlModificaPosti = "UPDATE Autobus
                                   SET Posti_Disponibili = Posti_Totali";
              if ($con->query($sqlModificaPosti)) {
                ?> <script type='text/javascript'> alert('La capienza massima è stata ripristinata'); </script> <?php
              }
              else {
                ?> <script type='text/javascript'> alert('Errore'); </script> <?php
              }
            }
          }

         ?>
      </div>
    </div>
  </body>
</html>
