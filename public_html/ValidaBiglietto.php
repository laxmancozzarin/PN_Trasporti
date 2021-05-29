<?php
    if(isset($_GET["id"])){
        $con = new mysqli("localhost", "id16165052_root", "+)No~%0HKWm2^LN-", 'id16165052_pn_trasporti');
        if(!$con){
          ?> <script type='text/javascript'> alert('Errore di connessione al database'); </script> <?php
        }
        else{
            $update = "UPDATE Biglietti SET Non_Usato = false";
            $res=$con->query($update);
            
            echo "<h1> Grazie per aver scelto PN_TRASPORTI</h1>";
        }
    }
?>