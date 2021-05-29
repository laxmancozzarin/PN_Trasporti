<?php
  function CreaNavBar(){
    echo "<nav class='navbar navbar-expand-lg bg-white'>
            <div class='container'>
                <a class='navbar-brand' href='index.php'>Home</a>
                <div class='collapse navbar-collapse'>
                <ul class='navbar-nav'>
                    <li class='nav-item mx-0 mx-lg-1'><a class='nav-link py-3 px-0 px-lg-3 rounded' href='PrenotaBiglietto.php'>Prenota biglietto</a></li>
                    <li class='nav-item mx-0 mx-lg-1'><a class='nav-link py-3 px-0 px-lg-3 rounded' href='VisualizzaPrenotazioni.php'>Storico prenotazioni</a></li>
                </ul>
            </div>
            <div class='col-4 d-flex justify-content-end align-items-center'>
            <form method='post'>";
    if(isset($_SESSION["Logged"]))
      echo "<label>".$_SESSION['Username']."\t<label><input type='submit' class='btn btn-lg btn-primary' value='Logout' name='Logout'>";

    else
      echo "<lable>Ospite\t<label><a href='Login_Registrazione.php'><input type='button' class='btn btn-lg btn-primary' value='Login/Registrati'></a>";

    echo "  </form>
         </div>
      </div>
    </nav>";
  }
  
  function PrendiSaldoCliente(){
        $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');

  }

?>
