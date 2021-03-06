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

// $today = date("d/m/Y");
$today = "23/01/2022";

if(isset($_GET['matapporto']))
{
  //MAT APPORTO 16 ARGOMENTI da 0 a 15

  //headers dell colonne che vengono visualizzate nella tabella
  $_SESSION['clm_header'] = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
  "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Note", "Data di carico", "Data di aggiornamento", "A magazzino");

  //campi del database ==> bisogna fare (id, nome ... data_inserimento, data_aggiornamento, Attiva)
  $_SESSION['clm_array'] = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",   "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "Note", "data_carico", "data_aggiornamento", "Attiva");

  //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['input_type'] = array("number", "text", "number", "text", "text", "number step='0.1'", "text", "text", "text", "text", "text", "text", "textarea", "date", "date", "checkbox");

  //Titolo
  $_SESSION['name'] = "Materiali apporto";

  //Nome della tabella
  $_SESSION['table'] = "materiali_apporto";

  //array(x, n1, n2, ecc...)  --> il primo indice va impostato come 0 (per il futuro), i successivi servono per indicare la ricerca secondaria in modo che si possano visualizzare tutti i record che hanno il valore in colonna n1 uguale a quello del record che ha come id il valore x. Questo serve principalmente per vedere tutte le revisioni di un record.
  //Es.: l'oggetto con id = x, ha sulla colonna n1 il valore y --> cerco tutti i record che nella colonna n1 hanno il valore y e li mostro nella pagina modify.php.
  //$_SESSION['clm_data_array_dataindex'] = array(0,6,10);
  $_SESSION['clm_data_array_dataindex'] = array(0,6); //deve essere delle stesse dimensioni di $_SESSION['clm_data_array']

  //definisce i blocchi di visualizzazione dall'alto verso il basso su modify.php
  $_SESSION['clm_data_array'] = array(array (1,2,3,4,5), array (6,7,8,9,10,11,12,13,14));

  //(nome pulsante, directory, colonna da cui prende il nome, estensione);
  $_SESSION['attachment'] =
  array(
    array("Certificato", $_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/certificati/matapporto/', 6, ".pdf"),
    array("Ordine", $_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/certificati/ordini/', 11, ".pdf"),
    array("DirProva",$_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/certificati/matapporto/')
  ); //si può cambiare e fare un multi array per includere il filepath

  //campo e quantità minima con cui parte l'alert -- DA IMPLEMENTARE
  $_SESSION['scortaminima'] = array(array(8,50));
}

if(isset($_GET['strumenti']))//
{
  //STRUMENTI 18 ARGOMENTI da 0 a 17
  $_SESSION['clm_header'] = array("id", "Descrizione", "Campo di misura", "Codice strumento", "Modello", "S/N", "Costruttore", "Tipo", "n° Taratura / Verifica", "Dotazione", "Intervallo di verifica (Mesi)", "Data messa in servizio","Data ultima verifica","Data prossima verifica", "Note", "Accettabilità","Stato", "Attiva?");    //headers delle colonne che vengono visualizzate nella tabella
  $_SESSION['clm_array'] = array("id", "Descrizione", "campo_misura", "Codice_strumento", "Modello", "SN", "Costruttore", "Tipo", "Taratura", "Dotazione", "Intervallo_verifica", "Data_messa_servizio","Data_ultima_verifica","Data_prossima_verifica", "Note", "Accettabilita", "Stato", "Attiva");   //campi del database
  $_SESSION['input_type'] = array("number", "text", "text", "text", "text", "text", "text", "select___Primario___Secondario___Operativo", "text", "text", "number", "date", "date", "date", "textarea", "text", "text", "text");    //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['name'] = "Strumenti di misura";   //Titolo
  $_SESSION['table'] = "strumenti";    //Nome della tabella
  $_SESSION['clm_data_array_dataindex'] = array(0,3);    //Questo serve principalmente per vedere tutte le revisioni di un record. (vedi sopra)
  $_SESSION['clm_data_array'] = array(array (1,2,3,4,5,6,7,9,11), array (8,12,13,14,15,16));    //definisce i blocchi di visualizzazione dall'alto verso il basso
  $_SESSION['attachment'] =
  array(
    array("Scheda strumento", $_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/certificati/strumenti/', 3, ".pdf"),
    array("Taratura / Verifica", $_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/certificati/strumenti/', 8, ".pdf")
  );
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
  $_SESSION['clm_data_array'] = array(array(), array());    //definisce i blocchi di visualizzazione dall'alto verso il basso
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
  $_SESSION['clm_data_array'] = array(array(), array());    //definisce i blocchi di visualizzazione dall'alto verso il basso
}

if(isset($_GET['ncrecl']))
{
  //RISCHIOPP xx ARGOMENTI da 0 a yy
  $_SESSION['clm_header'] = array();    //headers dell colonne che vengono visualizzate nella tabella
  $_SESSION['clm_array'] = array();   //campi del database
  $_SESSION['input_type'] = array();    //tipo di campo che compare nel form di inserimento dati sulla pagina new.php
  $_SESSION['name'] = "Non conformità e Reclami";   //Titolo
  $_SESSION['table'] = "";    //Nome della tabella
  $_SESSION['clm_data_array_dataindex'] = array();    //Questo serve principalmente per vedere tutte le revisioni di un record. (vedi sopra)
  $_SESSION['clm_data_array'] = array(array(), array());    //definisce i blocchi di visualizzazione dall'alto verso il basso
}

//non posso inserire la stessa funzione all'interno dei vari isset perché su new.php la condizione non si verifica => così non posso valutare che funzione definire a seconda del pulsante premuto
function create_optional_button($name)
{
  switch ($name)
  {
    case "Materiali apporto":
    //funzione
    echo "<a href=reports/reportmatapporto.php>Click Me!</a>";
    break;

    case "strumenti":
    //funzione
    ;
    break;

    case "fornitori":
      //funzione
      ;
      break;

      case "rischiopp":
      //funzione
      ;
      break;

      default:
      echo "Error: no function input selected";
    }
  }

  ?>
