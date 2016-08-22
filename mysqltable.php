<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'login.php';

function record_in_db($name, &$arr)
{
    $table = new SQLTable($name);
    //foreach ($arr as $url)
    //{
        //$table->add_page($url);
    //}
    $table->add_array($arr);
    $table->close();
}

class SQLTable
{
    public function __construct($name)
    {
        global $db_database, $db_hostname, $db_username, $db_password;
        $this->connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        if ($this->connection->connect_error)
        {
            die($this->connection->connect_error);
        }
        $this->name = mysql_entities_fix_string($this->connection, $name);
        $this->connection->query("DROP TABLE $this->name");
        $query = "CREATE TABLE $this->name(
                  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  page VARCHAR(255))";
        $result = $this->connection->query($query);
        if (!$result)
        {
            echo('Table creaion fail:'.$query.': '.$this->connection->error).'<br>';
        }
    }
    
    public function add_page($url)
    {
        //$url = mysql_entities_fix_string(*/$this->connection, $url);
        $query = "INSERT INTO $this->name VALUES(NULL, '$url')";
        return $this->connection->query($query);
    }
    
    public function add_array(&$arr)
    {
        for ($i = 0, $count = count($arr), $length = 100; $i < $count; $i += $length)
        {
            $slice = array_slice($arr, $i, $length);
            foreach ($slice as &$node)
            {
                $node = "(NULL, '$node')";
            }
            $slice = implode($slice, ',');
            $query = "INSERT INTO $this->name VALUES".$slice;
            $this->connection->query($query);
        }
    }
    
    public function set_result()
    {
        $query = "SELECT * FROM $this->name";
        $this->result = $this->connection->query($query);
        if (!$this->result)
        {
            echo('Get data fail:'.$query.': '.$this->connection->error).'<br>';
        }
    }
    
    public function get_row($id)
    {
        if ($this->result->data_seek($id))
        {
            return $this->result->fetch_array(MYSQLI_NUM);
        }
        else
        {//$d = array("url" => 1, 1 => 2, 3 => 3); isset($d[$url]);
            return FALSE;
        }
    }
    
    public function close()
    {
        $this->connection->close();
    }
    
    private $name;
    private $connection;
    private $result;
    private $error;
}

function mysql_entities_fix_string($connection, $string)
{
    return htmlentities(mysql_fix_string($connection, $string));
}

function mysql_fix_string($connection, $string)
{
    if (get_magic_quotes_gpc())
    {
        $string = stripslashes($string);
    }
    return $connection->real_escape_string($string);
}

?>