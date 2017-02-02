<?php
namespace LearnPSQL;

use LearnPSQL\OutputTable as OutputTable;

/**
 * PostgreSQL Demo
 */
class PostgresDemo {

	/**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * Increment var
     * @var integer
     */
    private $inc = 0;

    /**
     * Fetched rows
     * @var array
     */
    private $rows;
    
    /**
     * Columns names from fetched rows
     * @var array
     */
    private $columns;

    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function loadSql($filename){
        $sql = file_get_contents($filename);
        return $this->pdo->exec($sql);
    }


    private function whichQuery($sql){
        if (preg_match("/^SELECT /", ltrim($sql))) return 'query';
        elseif (preg_match("/^UPDATE /", ltrim($sql))) return 'execute';
        elseif (preg_match("/^INSERT /", ltrim($sql))) return 'execute';
        elseif (preg_match("/^WITH /", ltrim($sql))) return 'query';
        elseif (preg_match("/^FETCH /", ltrim($sql))) return 'query';
        else return 'execute';
    }

    public function go($title,$sql,$run=true) {
        
        $this->inc++;
        echo "<h3>{$this->inc}. {$title}</h3>";
        if (false === $run) { return; }
        $string = $this->whichQuery($sql);
        $res = $this->$string($sql);
        $table = new OutputTable(); 
        $table->setRows($this->rows);
        $table->setColumns($this->columns);
        if ($string == 'query') echo $table->outputData();
        else echo "<p>Execute. Affected rows: ".$res."</p>";
        echo "<code>".$sql."</code><hr>";

    }

   /**
     * Return affected rows after update
     * @param string $sql
     * @return int
     */
    private function execute($sql) {
 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
 
        // return the number of row affected
        return $stmt->rowCount();
    }
    
    /**
     * Return all rows from query
     * @param string $sql
     * @return array
     */
    private function query($sql) {
        
        $this->rows = $this->columns = [];
        
        $stmt = $this->pdo->query($sql);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if (empty($this->columns)) { 
                foreach($row as $key=>$value) {
                    $this->columns[] = $key;
                }
            }
            $this->rows[] = $row;
        }
    }

}        