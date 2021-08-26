<?php
if(isset($_GET['matapporto']))
{
  $_SESSION['clm_header'] = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
       "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");
  $_SESSION['clm_array'] = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",
          "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");
  $_SESSION['name'] = "Materiali apporto";
  $_SESSION['table'] = "materiali_apporto";
}

?>
