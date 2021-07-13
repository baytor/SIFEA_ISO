<!--PHP
creare la classe database con form dinamico
-->
<?php

class dbEntry {
  // Properties
  protected $name;       //nome dell'oggetto
  protected $ncolumn;    //numero di colonne
  protected $table;      //nome della tabella
  protected $clm_header; //array con i nomi delle colonne visualizzati 
  protected $clm_array;  //array con i nomi delle colonne del DB
  protected $sql;
  protected $conn;
  protected $servername;
  protected $username;
  protected $password;
  protected $dbname;
  protected $output_table;

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
  }

  // Methods
  function get_name() {return $this->name;}
  function get_ncolumn() {return $this->ncolumn;}
  function get_dbtable() {return $this->table;}
  function get_clm_header() {return $this->clm_header;}
  function get_clm_array() {return $this->clm_array;}
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
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->output_table = "<table><tr>";
    for($i = 0; $i < count($this->clm_header); $i++)
    {
        $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        $this->output_table .= "<tr>";
        for ($i = 0; $i < count($this->clm_array); $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
      }
    }
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
    //var_dump($output_table);
  }

  //seleziona e visualizza le righe utlizzando una stringa
  function select_rows_by_string($a)
  {
    $this->sql = $a;
    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->output_table = "<table><tr>";
    for($i = 0; $i < count($this->clm_header); $i++)
    {
        $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        $this->output_table .= "<tr>";
        for ($i = 0; $i < count($this->clm_array); $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
      }
    }
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
    //var_dump($output_table);
  }

  function select_rows_by_pos($begin, $end)
  {
    $this->sql = "SELECT * FROM " . $this->table;
    //echo $this->sql . "<br>";

    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    //echo "<br> inizio creazione tabella";
    $this->output_table = "<table><tr>";
    for($i = $begin; $i <= $end; $i++)
    {
      $this->output_table .= "<th>" . $this->clm_array[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        $this->output_table .= "<tr>";
        for ($i = $begin; $i <= $end; $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
      }
    }
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
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

  //cerca una serie di righe
  function select_where($clm, $where)
  {
    //$this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->clm_array[$num] . " LIKE " . "'%$where%'";
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";
    echo $this->sql."<br>";

    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->output_table = "<table><tr>";
    for($i = 0; $i < count($this->clm_header); $i++)
    {
        $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        $this->output_table .= "<tr>";
        for ($i = 0; $i < count($this->clm_array); $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
      }
    }
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }
}
 ?>
