<!-- In questo file vengono creati gli elementi per la definizione dell'oggetto dbEntry.
Col controllo isset($_GET[]) si associa il click del pulsante con gli elementi corrispondenti -->

<?php

require_once('libs_code.php');

if(isset($_GET['matapporto']))
{
  //MAT APPORTO 16 ARGOMENTI da 0 a 15
  $_SESSION['clm_header'] = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
  "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");
  $_SESSION['clm_array'] = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",   "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");
  $_SESSION['input_type'] = array("text", "text", "number", "text", "text", "number step='0.1'", "text", "text", "text", "text", "text",   "text", "date", "date", "textarea", "text");
  $_SESSION['name'] = "Materiali apporto";
  $_SESSION['table'] = "materiali_apporto";
}

?>
