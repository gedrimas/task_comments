<?php
Class Db
{   
    protected static $_instance; 
    public static $linkCon = null;

    public static function getInstance($host, $user, $pass, $dbname)
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self($host, $user, $pass, $dbname);
        }
        return self::$_instance;
    }
    
    private function __construct($host, $user, $pass, $dbname) 
    {
        try 
        {
           self::$linkCon = mysql_connect($host, $user, $pass);
           mysql_select_db($dbname);
        } 
        catch (Exception $e)
        {
            echo $e->getMessage();
        }     
    }
    
    private function __clone(){}
    private function __wakeup(){} 
    
    public function query($sql)
    {
        $res = array();
        $query = mysql_query($sql, self::$linkCon);
        while ($r = mysql_fetch_array($query)) 
        {
           $res[] = $r;
        }
        return $res;
    }
    
    public function insert($sql)
    {
        $res = mysql_query($sql, self::$linkCon);
        return $res;
    }
    
     public function remove($sql)
    {
        $rem = mysql_query($sql, self::$linkCon);
        return $rem;
    }
    
}
?>

