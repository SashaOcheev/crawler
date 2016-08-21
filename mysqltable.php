<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'login.php';

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
        $this->name = 'site';
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
    
    public function AddPage($url)
    {
        $url = mysql_entities_fix_string($this->connection, $url);
        $query = "INSERT INTO $this->name VALUES(NULL, '$url')";
        return $this->connection->query($query);
    }
    
    public function SetResult()
    {
        $query = "SELECT * FROM $this->name";
        $this->result = $this->connection->query($query);
        if (!$this->result)
        {
            echo('Get data fail:'.$query.': '.$this->connection->error).'<br>';
        }
    }
    
    public function GetRow($j)
    {
        if ($this->result->data_seek($j))
        {
            return $this->result->fetch_array(MYSQLI_NUM);
        }
        else
        {//$d = array("url" => 1, 1 => 2, 3 => 3); isset($d[$url]);
            return FALSE;
        }
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