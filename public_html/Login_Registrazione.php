<?php session_start();?>
<?php
  function Login($username, $password){
    $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
    if(!$con){
      ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
    }
    else {
      $select = "SELECT * FROM Utenti WHERE Email ='$username'";
      $resSelect = $con->query($select);
      while ($riga = $resSelect->fetch_assoc()) {
        if($riga["Email"] == $username && password_verify($password, $riga["Password"]) == true)
          return true;
        else {
          ?> <script type='text/javascript'> alert('Errore login'); </script> <?php
        }
      }
    }
    return false;
  }


  function Registrazione($nome, $cognome, $data_nascita, $password, $email){
    $passwordCriptato = password_hash($password, PASSWORD_BCRYPT);
    $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
    if(!$con){
      ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
    }
    else{
      $insertQuery = "INSERT INTO Utenti(Nome, Cognome, Data_Nascita, Password, Saldo, Email)
                      VALUES('$nome', '$cognome', '$data_nascita', '$passwordCriptato', 0, '$email')";
      if($con->query($insertQuery)){
        header("Location: Login_Registrazione.php");
      }
      else
        echo " <script type='text/javascript'> alert('Errore di registrazione'); </script>";
    }
  }

if(isset($_POST["Logout"])){                
    session_destroy();
    header("Location: https://laxmancozzarinprova.000webhostapp.com/");
    return;
}

if(isset($_POST["Login"]) && isset($_POST["Username"]) && isset($_POST["Password"])){
    $username = filter_var($_POST["Username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["Password"], FILTER_SANITIZE_STRING);
    if($username && $password && Login($username, $password)){
        $_SESSION["Username"] = $_POST["Username"];
        $_SESSION["Logged"] = true;
        header("Location: index.php");
        return;
    }
    else {
        ?> <script type='text/javascript'> alert('Login fallito'); </script> <?php
    }
}

if(isset($_POST["Registrazione"]) && isset($_POST["Nome"]) && isset($_POST["Cognome"]) && isset($_POST["Password"]) && isset($_POST["ConfirmPassword"]) && isset($_POST["Email"])){
        $nome = filter_var($_POST["Nome"], FILTER_SANITIZE_STRING);
        $cognome = filter_var($_POST["Cognome"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["Password"], FILTER_SANITIZE_STRING);
        $passwordControllo = filter_var($_POST["ConfirmPassword"], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["Email"], FILTER_SANITIZE_STRING);
        Registrazione($nome, $cognome, $_POST["DataNascita"], $password, $email);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="LoginStyle.css" >
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    
    <?php include 'ElementiPagina.php';?>
    

    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <?php CreaNavBar();?>
      <br><br>
      <div class="d-flex align-items-center justify-content-center">
        <form id="login-form" method="post">
          <h1> LOGIN </h1>
          <div class="form-group pt-2">
            <input type="email" name="Username" id="username" tabindex="1" class="form-control" placeholder="Username" required>
          </div>
          <div class="form-group pt-2">
            <input type="password" name="Password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
          </div>
          <div class="form-group text-center pt-2">
            <input type="checkbox" tabindex="3" class="" name="Remember" id="remember">
            <label for="remember"> Remember Me</label>
          </div>
          <div class="form-group pt-2 row">
            <input type="submit" name="Login" id="login" tabindex="4" class="form-control btn btn-login" value="Log In">
          </div>
        </form>
      </div>

      <br><br>
      <div class="d-flex align-items-center justify-content-center">

        <form id="register-form"  method="post" role="form">
          <h1> REGISTRATI </h1>
          <div class="form-group pt-2">
            <input type="text" name="Nome" id="Nome" tabindex="2" class="form-control" placeholder="Nome">
          </div>
          <div class="form-group pt-2">
            <input type="text" name="Cognome" id="Cognome" tabindex="2" class="form-control" placeholder="Cognome">
          </div>
          <div class="form-group pt-2">
            <input type="email" name="Email" id="Email" tabindex="2" class="form-control" placeholder="Email">
          </div>
          <div class="form-group pt-2">
            <input type="date" name="DataNascita" id="DataNascita" tabindex="2" class="form-control">
          </div>

          <div class="form-group pt-2">
            <input type="password" name="Password" id="Password" tabindex="3" class="form-control" placeholder="Password" required>
          </div>
          <div class="form-group pt-2">
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" tabindex="4" class="form-control" placeholder="Confirm Password" required>
          </div>
          <div class="form-group pt-2 pb-2 row">
            <input type="submit" name="Registrazione" id="Registrazione" tabindex="4" class="form-control btn btn-register" value="Register Now">
          </div>
        </form>
      </div>

  </body>
</html>
