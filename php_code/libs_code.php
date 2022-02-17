<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/fpdf183/fpdf.php');

//Per il corretto funzionamento:
//  - la posizione [0] dell'array DEVE essere la chiave primaria
//  - la posizione [1] dell'array DEVE essere il nome o la descrizione dell'oggetto
//  - la posizione [count($this->get_clm_array()-1)], ossia l'ultima, dell'array DEVE
//    essere quella che dice se un oggetto è ATTIVO e effettivamente presente (valore == 1)
//    oppure INATTIVO o ESAURITO (valore == 0)
//  - la posizione [count($this->get_clm_array()-2)], ossia penultima, dell'array DEVE
//    essere quella che da la data di aggiornamento
//  - la posizione [count($this->get_clm_array()-3)], ossia la terzultima ultima, dell'array DEVE
//    essere quella che essere quella che da la data di inserimento

class dbEntry {
  // Properties
  public $name;       //nome dell'oggetto
  public $ncolumn;    //numero di colonne
  public $table;      //nome della tabella
  public $clm_header; //array con i nomi delle colonne visualizzati
  public $clm_array;  //array con i nomi delle colonne del DB
  public $input_type; //array per definire il campo input all'interno del codice HTML
  public $sql;
  public $conn;
  public $servername;
  public $username;
  public $password;
  public $dbname;
  public $output_table;

  public function __construct($name, $clm_header, $clm_array, $input_type, $servername, $username, $password, $dbname, $table)
  {
    $this->name = $name;
    $this->clm_header = $clm_header;
    $this->clm_array = $clm_array;
    $this->input_type = $input_type;
    $this->table = $table;
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;
    $this->sql = "";
    $this->result = "";
  }

  // Methods
  function get_name() {return $this->name;}
  function get_ncolumn() {return $this->ncolumn;}
  function get_dbtable() {return $this->table;}
  function get_clm_header() {return $this->clm_header;}
  function get_clm_header_at($i) {return $this->clm_header[$i];}
  function get_clm_array() {return $this->clm_array;}
  function get_clm_array_at($i) {return $this->clm_array[$i];}
  function get_input_type() {return $this->input_type;}
  function get_input_type_at($i) {return $this->input_type[$i];}
  function get_servername() {return $this->servername;}
  function get_username() {return $this->username;}
  function get_password() {return $this->password;}
  function get_dbname() {return $this->dbname;}
  //dubito che serva
  //function get_entry_by_primary($primary_pos, $primary_value) {if($this->get_clm_array_at($primary_pos)==$primary_value) return $this;}

  function set_name($name) {$this->name = $name;}
  function set_ncolumn($ncolumn) {$this->ncolumn = $ncolumn;}
  function set_dbtable($table) {$this->table = $table;}
  function set_clm_header($clm_header) {$this->clm_header = $clm_header;}
  function set_clm_array($clm_array) {$this->clm_array = $clm_array;}
  function set_input_type($input_type) {$this->input_type = $input_type;}
  function set_servername($servername) {$this->servername = $servername;}
  function set_password($password) {$this->password = $password;}
  function set_dbname($dbname) {$this->dbname = $dbname;}

  /*  ALTRE FUNZIONI:
  function db_connection_on()                                 //ATTIVA LA CONNESSIONE AL DB
  function db_connection_off()                                //DISATTIVA LA CONNESSIONE AL DB
  function select_rows()                                      //seleziona e visualizza TUTTE le righe della Tabella
  function select_rows_by_string($a)                          //seleziona e visualizza le righe utlizzando una stringa messa dall'utente
  function select_rows_by_string_by_pos($a, $begin, $end)     //SELEZIONA TRAMITE STRINGA LE COLONNE DA BEGIN A END
  function select_rows_by_string_by_array($a, array $array_clm) //SELEZIONA TRAMITE STRINGA LE COLONNE usando gli indici delle colonne contenuti nell'array_clm
  function select_rows_by_pos($begin, $end)                   //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end
  function select_rows_where_like($clm, $where)               //seleziona tutte le voci WHERE clm LIKE %where%
  function select_rows_where_is($clm, $where)                 //seleziona tutte le voci WHERE clm IS where
  function select_rows_by_pos_where_like($begin, $end, $clm, $where)      //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end WHERE clm LIKE %where%
  function select_rows_by_pos_where_is($begin, $end, $clm, $where)        //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end WHERE clm IS where
  function select_rows_by_array_where_is(array $array, $clm, $where)    //seleziona le voci contenute in $array visualizzando le colonne di numero compreso tra begin e end WHERE clm IS where
  function select_rows_by_array_where_like(array $array, $clm, $where)  //seleziona le voci contenute in $array visualizzando le colonne di numero compreso tra begin e end WHERE clm LIKE %where%
  function insert_row(array $array_values)                    //inserisce una riga nella tabella - da definire gli argomenti
  function delete_row($id)                                    //cancella una riga nella tabella - da definire gli argomenti
  function update_row($id, array $array_values)               //aggiorna una riga nella tabella - da definire gli argomenti
  function copy_row($id)                                      //copia una riga assegnando un nuovo id
  function change_active($id, $status)                        //setta attivo o inattivo sull'ultima colonna (0 oppure 1)
  function create_table($begin, $end)                         //crea la Tabella usando un ciclo for da $begin fino a $end
  function create_table(array $array_clm)                     //crea la Tabella usando gli indici delle colonne contenuti nell'array_clm

  */

  //connessione ON
  function db_connection_on() //inserire gli argomenti necessari o la stringa appropriata
  {
    // Create connection
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . $conn->connect_error);
  }

  //connessione OFF
  function db_connection_off()
  {
    $this->conn->close();
  }

  //seleziona e visualizza TUTTE le righe della Tabella
  function select_rows()
  {
    $this->sql = "SELECT * FROM " . $this->table;
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html -- $end-1 perchè
    //la funzione cilca da begin to end, compresi, per necessità
    $this->create_table(0, count($this->clm_array)-1);
  }

  //seleziona e visualizza le righe utlizzando una stringa messa dall'utente
  function select_rows_by_string($a)
  {
    $this->sql = $a;
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table(0, count($this->clm_array)-1);
  }

  function select_rows_by_string_by_pos($a, $begin, $end)
  {
    $this->sql = $a;
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table($begin, $end);
  }

  function select_rows_by_string_by_array($a, array $array_clm)
  {
    $this->sql = $a;
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table_by_array($array_clm);
  }

  //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end
  function select_rows_by_pos($begin, $end)
  {
    $this->sql = "SELECT * FROM " . $this->table;
    //echo $this->sql . "<br>";
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table($begin, $end);
  }

  //seleziona tutte le voci WHERE clm LIKE %where%
  function select_rows_where_like($clm, $where)
  {
    //$this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->clm_array[$num] . " LIKE " . "'%$where%'";
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";
    echo $this->sql."<br>";
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table(0, count($this->clm_array)-1);
  }

  function select_rows_where_is($clm, $where)
  {
    //$this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->clm_array[$num] . " LIKE " . "'%$where%'";
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;
    echo $this->sql."<br>";
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table(0, count($this->clm_array)-1);
  }

  //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end WHERE clm LIKE %where%
  function select_rows_by_pos_where_like($begin, $end, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";
    $this->result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table($begin, $end);
  }

  //Seleziona le colonne di array WHERE clm LIKE %where%
  function select_rows_by_pos_where_is($begin, $end, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table($begin, $end);
  }

  //Seleziona le colonne di array WHERE clm IS $where
  function select_rows_by_array_where_is(array $array_clm, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table_by_array($array_clm);
  }

  function select_rows_by_array_where_like(array $array_clm, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";
    $result = $this->conn->query($this->sql);

    //creazione della tabella html viene fatta non usando la funzione create_table ma una fatta apposta
    $this->create_table_by_array($array_clm);
  }

  //inserisce una riga nella tabella - da definire gli argomenti
  function insert_row(array $array_values)
  {
    // da completare, anche con l'argomento
    $this->sql = "INSERT INTO " . $this->table . " VALUES ('";
    //se ho un array con n valori, gli indici vanno da 0 a n-1
    //il ciclo for va dal primo al penultimo => da 0 a n-2
    for($i = 0; $i < count($array_values) - 1; $i++)
    {
      $this->sql .= $array_values[$i] . "', '";
    }

    $this->sql .= $array_values[count($array_values) - 1] . "')";
    //n-1 e chiudo parentesi
    echo "INSERT ROW: $this->sql<br>";
    $this->result = $this->conn->query($this->sql);
  }

  //cancella una riga nella tabella - da definire gli argomenti
  function delete_row($id)
  {
    //clm_array[0] deve essere la chiave primaria
    $this->sql = "DELETE FROM " . $this->table ." WHERE " . $this->get_clm_array_at(0) . " = '" . $id . "'";
    echo $this->sql;
    $this->result = $this->conn->query($this->sql);
  }

  //aggiorna una riga nella tabella - da definire gli argomenti
  function update_row($id, array $array_values)
  {
    $this->sql = "UPDATE $this->table SET ";
    for($i = 1; $i < count($array_values) - 1; $i++) //ID non si modifica
    {
      $this->sql .= $this->clm_array[$i] . " = '" . $array_values[$i] . "', ";//con ciclo for
    }
    $this->sql .= $this->clm_array[count($array_values) - 1] . " = '" . $array_values[count($array_values) - 1];
    $this->sql .= "' WHERE " . $this->clm_array[0] . " = " . $id;
    $this->result = $this->conn->query($this->sql);
    echo "$this->sql<br>";
  }

  function copy_row($id)
  {
    //recupera la riga con l'id in argomento
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->get_clm_array_at(0) . " = " . $id;

    //recupero la row
    $this->result = $this->conn->query($this->sql);
    $row = $this->result->fetch_assoc();

    $array_copy = array();
    array_push($array_copy,""); //per l'id che in realtà verrà assegnato dal DB in quanto primary, unique, AI;
    for($i = 1; $i < count($this->get_clm_array())-1; $i++)
    {
      array_push($array_copy,$row[$this->get_clm_array_at($i)]);
    }
    array_push($array_copy,1); //per l'ultima voce;

    $this->insert_row($array_copy);

  }

  function change_active($id, $status)
  {
    $this->sql = "UPDATE $this->table SET "
    . $this->clm_array[count($this->get_clm_array())-1] . " = $status WHERE "
    . $this->clm_array[0] . " = '$id'";
    $this->result = $this->conn->query($this->sql);

    echo "$this->sql<br>";
  }

  //crea la Tabella
  function create_table($begin, $end)
  {
    //header della tabella
    //se rinuncio al tablediv posso mettere, in css, th con position: sticky per vedere sempre la riga del header
    // $this->output_table = "<div class='tablediv'><table><tr>";
    $this->output_table = "<table><tr>";
    for($i = $begin; $i <= $end; $i++)
    {
      $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($this->result->num_rows > 0)
    {
      // dati della tabella -> sul valore at[1] (nome) c'è un href per selezionare la voce
      while($row = $this->result->fetch_assoc())
      { //se è esaurito colora la riga di grigio
        if($row[$this->clm_array[count($this->get_clm_array())-1]] == 0)
        {
          $color_if_non_attiva = "style='background-color:#cecece'";
        }
        else {
          $color_if_non_attiva = "";
        }
        $this->output_table .= "<tr $color_if_non_attiva>";
        $this->output_table .=  "<td><a href=modify.php?search=" . $row[$this->clm_array[0]] . ">" . $row[$this->clm_array[$begin]] . "</a></td>";
        for ($i = $begin+1; $i <= $end; $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
        //echo "ultima riga: " . $row[$this->clm_array[0]] . "  ";
      }

    }
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    // $this->output_table .= "</tr></table></div>";
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }

  function create_table_by_array(array $array_clm_value)
  {
    //header della tabella
    // $this->output_table = "<div class='tablediv'><table><tr>";
    $this->output_table = "<table><tr>";
    foreach($array_clm_value as $index)
    {
      $this->output_table .= "<th>" . $this->clm_header[$index] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($this->result->num_rows > 0)
    {
      // dati della tabella -> sul valore at[1] (nome) c'è un href per selezionare la voce
      while($row = $this->result->fetch_assoc())
      { //se è esaurito colora la riga di grigio
        if($row[$this->clm_array[count($this->get_clm_array())-1]] == 0)
        {
          $color_if_non_attiva = "style='background-color:#cecece'";
        }
        else
        {
          $color_if_non_attiva = "";
        }
        $this->output_table .= "<tr $color_if_non_attiva>";
        foreach($array_clm_value as $index)
        {
          if($index == $array_clm_value[0])
          {
            $this->output_table .=  "<td><a href=new.php?search=" . $row[$this->clm_array[0]] . ">"
            . $row[$this->clm_array[$array_clm_value[0]]] . "</a></td>";
          }
          else
          {
            $this->output_table .=  "<td>" . $row[$this->clm_array[$index]] . "</td>";
          }
        }
      }
    }
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    // $this->output_table .= "</tr></table></div>";
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }
}

//se la versione di php precede la 8 serve
if (!function_exists('str_contains')) {
  function str_contains (string $haystack, string $needle)
  {
    return empty($needle) || strpos($haystack, $needle) !== false;
  }
}

//classe per generare report PDF
class reportPDF extends FPDF
{

  // Page header
  function Header()
  {
    // Logo
    $this->Image($_SERVER['DOCUMENT_ROOT'].'\SIFEA_ISO\img\Logo SIFEA resize trasparenza.png',10,6,30);
    $this->SetFont('Arial','B',15);     // Arial bold 15
    //$this->Cell(80);                    // Move to the right
    $this->Cell(30,10,'Title',1,0,'C'); // Title
    $this->Cell(40,10,'Rombo',1,0,'C');
    $this->Ln(20);                      // Line break
  }

  // Page footer
  function Footer()
  {
    $this->SetY(-15);                                               // Position at 1.5 cm from bottom
    $this->SetFont('Arial','I',8);                                  // Arial italic 8
    $this->Cell(0,10,'Pagina '.$this->PageNo().' di {nb}',0,0,'R'); // Page number
  }

}

?>
