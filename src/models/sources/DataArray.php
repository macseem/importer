<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/22/15
 * Time: 11:35 PM
 */

namespace MIM\models\sources;


use MIM\exceptions\validation\BadOffsetException;
use MIM\interfaces\Source;

class DataArray implements Source{

    private $baseArray;
    private $arrayIterator;

    public function __construct(array $array)
    {
        $this->baseArray = $array;
        $this->arrayIterator = new \ArrayIterator($array);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->arrayIterator->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->arrayIterator->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        $this->arrayIterator->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        $this->arrayIterator->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->arrayIterator->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset)
    {
        $newIterator = new \ArrayIterator($this->baseArray);
        while($newIterator->key() != $offset && $newIterator->valid()){
            $newIterator->next();
        }
        if(!$newIterator->valid())
            throw new BadOffsetException("OffsetProvider is not valid", 550);
        if($newIterator->key() != $offset)
            throw new \Exception("Something went wrong", 550);
        $this->arrayIterator = $newIterator;
    }

    public function nextOne()
    {
        $this->arrayIterator->next();
        return $this->arrayIterator->current();
    }

}