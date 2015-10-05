<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/22/15
 * Time: 11:38 PM
 */

namespace MIM\models\destinations;


use MIM\exceptions\validation\EscapeException;
use MIM\interfaces\base\DbConnection;
use MIM\interfaces\Destination;

class Db implements Destination{

    private $table;
    private $columnMap;
    private $connection;

    public function __construct(DbConnection $connection, $table, array $columnMap)
    {
        $this->table = $table;
        $this->columnMap = $columnMap;
        $this->connection = $connection;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $setStrings = [];
        foreach($data as $key => $value) {
            $value = $this->escapeValue($value);
            $column = $this->columnMap[$key];
            $setStrings[] = "$column=$value";
        }
        $setString = join(", ", $setStrings);
        $insertSql = "insert into {$this->table} set $setString";
        return $this->connection->execute($insertSql);
    }

    private function escapeValue($value)
    {
        if(is_int($value))
            return $value;
        if(is_double($value))
            return $value;
        if(is_float($value))
            return $value;
        if(is_string($value)){
            $value = str_replace("\\", "\\\\", $value);
            $value = str_replace("'", "\\'", $value);
            return "'" . $value . "'";
        }
        if(is_object($value) || is_array($value))
            throw new EscapeException("Not valid value. Can't escape", 550);
        return $value;
    }
}