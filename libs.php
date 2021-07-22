<!--PHP
creare la classe database con form dinamico
-->


<?php

class dbEntry {
  // Properties
  public $name;       //nome dell'oggetto
  public $ncolumn;    //numero di colonne
  public $table;      //nome della tabella
  public $clm_header; //array con i nomi delle colonne visualizzati
  public $clm_array;  //array con i nomi delle colonne del DB
  public $sql;
  public $conn;
  public $servername;
  public $username;
  public $password;
  public $dbname;
  public $output_table;

  public function __construct($name, $clm_header, $clm_array, $servername, $username, $password, $dbname, $table)
  {
    $this->name = $name;
    $this->clm_header = $clm_header;
    $this->clm_array = $clm_array;
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
  function get_servername() {return $this->servername;}
  function get_username() {return $this->username;}
  function get_password() {return $this->password;}
  function get_dbname() {return $this->dbname;}

  function set_name($name) {$this->name = $name;}
  function set_ncolumn($ncolumn) {$this->ncolumn = $ncolumn;}
  function set_dbtable($table) {$this->table = $table;}
  function set_clm_header($clm_header) {$this->clm_header = $clm_header;}
  function set_clm_array($clm_array) {$this->clm_array = $clm_array;}
  function set_servername($servername) {$this->servername = $servername;}
  function set_password($password) {$this->password = $password;}
  function set_dbname($dbname) {$this->dbname = $dbname;}

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

  function select_rows_by_pos_where_is($begin, $end, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->create_table($begin, $end);
  }
  //inserisce una riga nella tabella - da definire gli argomenti
  function insert_row()
  {
    // da completare, anche con l'argomento
    // $sql = "INSERT INTO " . $table . "VALUES ";
  }

  //cancella una riga nella tabella - da definire gli argomenti
  function remove_row()
  {

  }

  //aggiorna una riga nella tabella - da definire gli argomenti
  function update_row()
  {

  }

  //crea la Tabella
  function create_table($begin, $end)
  {
    $this->output_table = "<table><tr>";
    for($i = $begin; $i <= $end; $i++)
    {
      $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($this->result->num_rows > 0)
    {
      // output data of each row
      while($row = $this->result->fetch_assoc())
      {
        $this->output_table .= "<tr>";
        $this->output_table .=  "<td><a href=viewer.php?search=" . $row[$this->clm_array[0]] . ">" . $row[$this->clm_array[$begin]] . "</a></td>";
        for ($i = $begin+1; $i <= $end; $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
        //echo "ultima riga: ".$row[$this->clm_array[0]]."  ";
      }

    }
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }
}
 ?>
