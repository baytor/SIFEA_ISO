<?php
  require_once('libs.php');
  session_start();

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>


 <!DOCTYPE html>
 <html>
 	<head>
 		<title>Home Page</title>
 	</head>
 <body>
	 <style>

	 		table {
				border-collapse: collapse;
				width: 100%;
			}

			th, td {
				padding: 15px;
  			text-align: center;
				border-bottom: 5px solid #ddd;
			}

			tr:hover {background-color:#f5f5f5;}

	 </style>

   <!-- inizio parte copiata per login -->
	 <div class="header">
	    <h2>Home Page</h2>
    </div>
    <div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success">
      	<h3>
          <?php
          	echo $_SESSION['success'];
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
  </div>
  <!-- fine parte copiata per login -->

   <?php
    //Qui l'Header è uguale al nome delle colonne del DB --> si possono settare dei nomi formattati meglio
      $clm_header = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
               "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");
      $clm_array = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",
                  "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");

      $_SESSION["entry1"] = new dbEntry("Materiali apporto", $clm_header, $clm_array, "localhost", "root", "", "test", "materiali_apporto");

   ?>

   <form method="post" action="index.php">
     <label for="where">Ricerca: </label>

     <select id="Ricerca" name="Ricerca">
       <?php
        for($i = 0; $i < count($clm_array); $i++)
        {
          echo "<option value=$clm_array[$i]>$clm_header[$i]</option>";
        }
        ?>
     </select>

     <input type="text" name="searchbar"><br><br>
     <input type="submit" value="Cerca" name="submit"><br><br><br><br>
  </form>

 </body>
 </html>

 <?php

    $entry1 = $_SESSION["entry1"];
    $entry1->db_connection_on();
	  if(isset($_POST['submit']))
      {
        $entry1->select_rows_by_pos_where_like(1, 14, $_POST['Ricerca'],$_POST['searchbar']);
        //$entry1->select_where($_POST['Ricerca'],$_POST['searchbar']);
      }

    $entry1->db_connection_off();

  ?>
