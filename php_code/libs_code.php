<?php

//Per il corretto funzionamento:
//  - la posizione [0] dell'array DEVE essere la chiave primaria
//  - la posizione [1] dell'array DEVE essere il nome o la descrizione dell'oggetto
//  - la posizione [count($this->get_clm_array()-1)], ossia l'ultima, dell'array DEVE
//    essere quella che dice se un oggetto è ATTIVO e effettivamente presente (valore == 1)
//    oppure INATTIVO o ESAURITO (valore == 0)


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
      function create_table($begin, $end)                         //crea la Tabella

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
  function select_rows_by_array_where_is(array $array, $clm, $where)
  {
    $array_imploded = implode(" ,", $array);
    $this->sql = "SELECT $array_imploded FROM " . $this->table . " WHERE " . $clm . " = " . $where;
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table(0, count($array)-1);
  }

  function select_rows_by_array_where_like(array $array, $clm, $where)
  {
    $array_imploded = implode(" ,", $array);
    $this->sql = "SELECT $array_imploded FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table(0, count($array)-1);
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
    echo $this->sql;
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
    $this->sql .= $this->clm_array[count($array_values) - 1] . " = " . $array_values[count($array_values) - 1];
    $this->sql .= " WHERE " . $this->clm_array[0] . " = " . $id;
    $this->result = $this->conn->query($this->sql);
  }

  //crea la Tabella
  function create_table($begin, $end)
  {
    //header della tabella
    $this->output_table = "<div class='tablediv'><table><tr>";
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
          $color_if_non_attiva = 'style="background-color:#cecece"';
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
        //echo "ultima riga: ".$row[$this->clm_array[0]]."  ";
      }

    }
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table></div>";
    echo $this->output_table;
  }
}
 ?>
