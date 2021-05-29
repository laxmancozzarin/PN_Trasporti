<?php session_start();?>
<?php
if (!isset($_SESSION["Logged"])) {
  header("Location: Login_Registrazione.php");
  return;
}
if(isset($_POST["Logout"])){
    session_destroy();
    header("Location: index.php");
    return;
}
function GeneraQRCode($idBiglietto){
    $testo = "https://laxmancozzarinprova.000webhostapp.com/ValidaBiglietto.php?id=".$idBiglietto."&user=".$_SESSION["Username"];
    header("Location: https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$testo."&choe=UTF-8");
    return;
}

if(isset($_POST["QR"]) && isset($_POST["idBiglietto"])){
    GeneraQRCode($_POST["idBiglietto"]);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="form_popup_gestore.css">

    <?php 
    include 'ElementiPagina.php';
    ?>
    <meta charset="utf-8">
    <title>Storico Prenotazioni</title>
    
    <?php
    function PrendiFermataDaID($con, $id){
      $sql = "SELECT * FROM Fermata WHERE ID_Fermata=$id";
      $res = $con->query($sql);
      $stringa="";
      while ($riga = $res->fetch_assoc()){
        $stringa=$riga["Via"];
      }
      return $stringa;
    }
    
    
    
    function ControllaPrenotazioni($tipo="Tutti i Biglietti"){
    $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
    if(!$con){
      ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
    }
    else{
      $select = "SELECT COUNT(Utente) AS Numero FROM Biglietti WHERE Utente = '".$_SESSION["Username"]."'";
      
      $res=$con->query($select);
      $riga = $res->fetch_assoc();
      
      if($riga["Numero"] > 0){
        if($tipo == "Tutti i biglietti"){
            $select = "SELECT * FROM Biglietti WHERE Utente = '".$_SESSION["Username"]."'";
        }
        if($tipo == "Biglietti usati"){
          $select = "SELECT * FROM Biglietti WHERE Utente = '".$_SESSION["Username"]."' AND Non_Usato=0";
        }
        if($tipo == "Biglietti da usare"){
          $select = "SELECT * FROM Biglietti WHERE Utente = '".$_SESSION["Username"]."' AND Non_Usato=1";
        }
        
        $res=$con->query($select);
        while ($riga = $res->fetch_assoc()) {
             echo "<table class='table'>
                <h3>Biglietto ".$riga["Codice"].": </h3>
                <form method='POST'>
                   <tr>
                       <td> Data di prenotazione: </td>
                       <td> ".$riga["Data_Transito"]."</td>
                   </tr>
    
                   <tr>
                       <td> Fermata di partenza: </td>
                       <td> ".PrendiFermataDaID($con, $riga["Fermata_Inizio"])."</td>
                   </tr>
                   <tr>
                       <td> Orario partenza: </td>
                       <td> ".$riga["Ora_Inizio"]."</td>
                   </tr>
    
                   <tr>
                       <td> Fermata termine: </td>
                       <td> ".PrendiFermataDaID($con, $riga["Fermata_Fine"])."</td>
                   </tr>
                   <tr>
                       <td> Orario di termine: </td>
                       <td> ".$riga["Ora_Fine"]."</td>
                   </tr>
    
                   <tr>
                       <td> Linea: </td>
                       <td> ".$riga["Linea"]."</td>
                   </tr>
                 
                   <tr>
                       <td> Costo in euro: </td>
                       <td> ".$riga["Prezzo"]." </td>
                   </tr>
                  </table>
                  ";
                  if($riga["Non_Usato"] == true){
                      echo"
                      <table width='100%'>
                        <tr>
                            <td><input type='submit' class='btn btn-success' name='QR' value='Visualizza QRCode'></td>
                            <td> <input type='submit' class='btn btn-danger' name='Disdici' value='Disdici Prenotazione'></td>
                            
                            <input type='hidden' name='idBiglietto' value='".$riga["Codice"]."'>
                        <tr> 
                      </table>";
                  }
                 echo"<br>
                 <hr>
               </form>";
        }
      }
      else
        echo " <script type='text/javascript'> alert('Errore nell'esecuzione della query'); </script>";
    }
}
    ?>
    
  </head>
  <body>
    
    <div class='container'>
        <?php CreaNavBar();?>
        <div class="form">
            <h3> Storico dei biglietti </h3>
            <form method='post' >
                <table width=100%>
                    <tr>
                        <td> 
                            <select class='form-select' name="TipoBiglietto">
                                <option>Tutti i biglietti</option>
                                <option>Biglietti usati</option>
                                <option>Biglietti da usare</option>
                            </select>
                            
                        </td>
                        <td><input type="submit" name="Mostra" value="Mostra"></td>
                        
                    </tr>
                    
                </table>
                <hr>
                
            </form>
            
        </div>
        
        <div class="table">
            <?php 
            if(isset($_POST["Mostra"]) && isset($_POST["TipoBiglietto"])){
                ControllaPrenotazioni($_POST["TipoBiglietto"]); 
            }
      
            ?> 
        </div>
    </div>
  </body>
</html>
