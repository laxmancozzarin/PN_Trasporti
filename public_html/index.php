<?php session_start();
      if(isset($_POST["Login_Registrazione"])){
        header("Location: Login_Registrazione.php");
        return;
      }

      if (isset($_POST["Prenota"]) && isset($_SESSION["Username"]) && isset($_SESSION["Logged"])) {
        header("Location: PrenotaBiglietto.php");
        return;
      }

      if(isset($_POST["Logout"])){
        session_destroy();
        //$_SESSION["Logged"] = false;
        header("Location: index.php");
        return;
      } 
?>
   


  
     
<!DOCTYPE html>
<html lang="en" dir="ltr">
    
  <head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <?php include 'ElementiPagina.php';?>
    <title>Home</title>
  </head>
  <body>

    <?php
      CreaNavBar();
    ?>

    <header class="bg-primary text-white text-center">
      <div class="container">
          <img class="pt-5" src="Logo.png" />
          <h1>PN_TRASPORTI</h1>
          <h2 class="mb-0">Viaggiare non è mai stato così facile</h2>
          <p class="font-weight-light mb-5">Sito realizzato come progetto scolastico</p>
      </div>
    </header>

    <div class="form" style="text-align: center;">
      <table width="100%">
        <tr>
          <td>
            <a href="PrenotaBiglietto.php"><input type="image" src="biglietto.png"></a>
          </td>

          <td>
            <a href="VisualizzaPrenotazioni.php"><input type="image" src="orologio.png"></a>
          </td>
        </tr>

        <tr>
          <td>
            <h3>Prenota biglietto</h3>
          </td>

          <td>
            <h3>Storico prenotazioni</h3>
          </td>
        </tr>
      </table>
    </div>



    
  </body>
</html>
