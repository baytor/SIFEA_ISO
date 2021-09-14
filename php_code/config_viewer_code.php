<!-- In questo file vengono creati gli elementi per la definizione dell'oggetto dbEntry.
Col controllo isset($_GET[]) si associa il click del pulsante con gli elementi corrispondenti

esempio:

//headers dell colonne che vengono visualizzate nella tabella
$_SESSION['clm_header'] = array("", "", ...);

//campi del database
$_SESSION['clm_array'] = array("", "", ...);

//tipo di campo che compare nel form di inserimento dati sulla pagina new.php
$_SESSION['input_type'] = array("text", "text", "number", "text", "text", "number step='0.1'", "text", "text", "text", "text", "text",   "text", "date", "date", "textarea", "text");

//Titolo
$_SESSION['name'] = "Materiali apporto";

//Nome della tabella
$_SESSION['table'] = "materiali_apporto";

//array(x, n1, n2, ecc...)  ==> il primo indice va impostato come 0 (per il futuro), i successivi servono per indicare la ricerca secondaria in modo che si possano visualizzare tutti i record che hanno il valore in colonna n1 uguale a quello del record che ha come id il valore x. Questo serve principalmente per vedere tutte le revisioni di un record.
//Es.: l'oggetto con id = x, ha sulla colonna n1 il valore y ==> cerco tutti i record che nella colonna n1 hanno il valore y e li mostro nella pagina modify.php.
$_SESSION['clm_data_array_dataindex'] = array(0,6);

//definisce i blocchi di visualizzazione dall'alto verso il basso
$_SESSION['clm_data_array'] = array(array (1,2,3,4,5,6,7), array (8,9,10,11,12,13,14));-->

<?php

require_once('libs_code.php');

if(isset($_GET['matapporto']))
{
  //MAT APPORTO 16 ARGOMENTI da 0 a 15

  //headers dell colonne che vengono visualizzate nella tabella
  $_SESSION['clm_header'] = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
  "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");

  //campi del database
  $_SESSION['clm_array'] = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",   "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");

  //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['input_type'] = array("text", "text", "number", "text", "text", "number step='0.1'", "text", "text", "text", "text", "text",   "text", "date", "date", "textarea", "text");

  //Titolo
  $_SESSION['name'] = "Materiali apporto";

  //Nome della tabella
  $_SESSION['table'] = "materiali_apporto";

  //array(x, n1, n2, ecc...)  --> il primo indice va impostato come 0 (per il futuro), i successivi servono per indicare la ricerca secondaria in modo che si possano visualizzare tutti i record che hanno il valore in colonna n1 uguale a quello del record che ha come id il valore x. Questo serve principalmente per vedere tutte le revisioni di un record.
  //Es.: l'oggetto con id = x, ha sulla colonna n1 il valore y --> cerco tutti i record che nella colonna n1 hanno il valore y e li mostro nella pagina modify.php.
  $_SESSION['clm_data_array_dataindex'] = array(0,6);

  //definisce i blocchi di visualizzazione dall'alto verso il basso
  $_SESSION['clm_data_array'] = array(array (1,2,3,4,5,6,7), array (8,9,10,11,12,13,14));

  //provvisorio
  $_SESSION['attachment'] = array(6 => "Certificato", 11 => "Ordine"); //si può cambiare e fare un multi array per includere il filepath
  $_SESSION['file_path'] = ""; //se faccio un array 3d questo lo posso eliminare

}

if(isset($_GET['fornitori']))
{
  //FORNITORI xx ARGOMENTI da 0 a yy
  $_SESSION['clm_header'] = array();  //headers dell colonne che vengono visualizzate nella tabella
  $_SESSION['clm_array'] = array();   //campi del database
  $_SESSION['input_type'] = array();    //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['name'] = "Fornitori qualificati";      //Titolo
  $_SESSION['table'] = "";    //Nome della tabella
  $_SESSION['clm_data_array_dataindex'] = array();    //Questo serve principalmente per vedere tutte le revisioni di un record. (vedi sopra)
  $_SESSION['clm_data_array'] = array(array (), array ());    //definisce i blocchi di visualizzazione dall'alto verso il basso
}

if(isset($_GET['rischiopp']))
{
  //RISCHIOPP xx ARGOMENTI da 0 a yy
  $_SESSION['clm_header'] = array();    //headers dell colonne che vengono visualizzate nella tabella
  $_SESSION['clm_array'] = array();   //campi del database
  $_SESSION['input_type'] = array();    //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['name'] = "Rischi e Opportunità";   //Titolo
  $_SESSION['table'] = "";    //Nome della tabella
  $_SESSION['clm_data_array_dataindex'] = array();    //Questo serve principalmente per vedere tutte le revisioni di un record. (vedi sopra)
  $_SESSION['clm_data_array'] = array(array (), array ());    //definisce i blocchi di visualizzazione dall'alto verso il basso
}

//non posso inserire la stessa funzione all'interno dei vari isset perché su new.php la condizione non si verifica => così non posso valutare che funzione definire a seconda del pulsante premuto
function aaa1($name)
{
  echo $name;
}


?>
