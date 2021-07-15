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
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
    //var_dump($output_table);
  }

  //seleziona e visualizza le righe utlizzando una stringa messa dall'utente
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
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }

  //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end
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
      $this->output_table .= "<th>" . $this->$this->clm_header[$i] . "</th>";
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
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
}

  //seleziona tutte le voci WHERE clm LIKE %where%
  function select_rows_where_like($clm, $where)
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
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }

  function select_rows_where_is($clm, $where)
  {
    //$this->sql = "SELECT * FROM " . $this->table . " WHERE " . $this->clm_array[$num] . " LIKE " . "'%$where%'";
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;
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
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }

  //seleziona tutte le voci visualizzando le colonne di numero compreso tra begin e end WHERE clm LIKE %where%
  function select_rows_by_pos_where_like($begin, $end, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " LIKE " . "'%$where%'";

    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    $this->output_table = "<table><tr>";
    for($i = $begin; $i <= $end; $i++)
    {
      //header
      $this->output_table .= "<th>" . $this->clm_header[$i] . "</th>";
    }
    $this->output_table .= "</tr>";
    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        //popolazione delle righe
        $this->output_table .= "<tr>";
        $this->output_table .=  "<td><a href=viewer.php?search=" . $row[$this->clm_array[0]] . ">" . $row[$this->clm_array[$begin]] . "</a></td>";
        for ($i = $begin+1; $i <= $end; $i++)
        {
          $this->output_table .=  "<td>" . $row[$this->clm_array[$i]] . "</td>";
        }
      }
    }
    else {echo "Error in ".$this->sql."<br>".$this->conn->error;}
    $this->output_table .= "</tr></table>";
    echo $this->output_table;
  }

  function select_rows_by_pos_where_is($begin, $end, $clm, $where)
  {
    $this->sql = "SELECT * FROM " . $this->table . " WHERE " . $clm . " = " . $where;

    $result = $this->conn->query($this->sql);

    //creazione della tabella html
    //echo "<br> inizio creazione tabella";
    $this->output_table = "<table><tr>";
    for($i = $begin; $i <= $end; $i++)
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
}
 ?>
