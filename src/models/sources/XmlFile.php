<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/22/15
 * Time: 11:13 PM
 */

namespace MIM\models\sources;


use MIM\interfaces\models\Source;

class XmlFile implements Source{

    /** @var  \ArrayIterator */
    private $iterator;
    private $file;
    private $keyToIterate;
    private $keyDepth;

    public function __construct($file, $keyToIterate, $keyDepth)
    {
        $this->file = $file;
        $this->keyToIterate = $keyToIterate;
        $this->keyDepth = $keyDepth;
        $this->init();
    }

    protected function init()
    {
        $contents = file_get_contents($this->file);
        $simpleXmlObject = new \SimpleXMLElement($contents);
        for($i = 0; $i<$this->keyDepth; $i++){
            $simpleXmlObject = $simpleXmlObject->children();
        }
        /** @var \SimpleXMLElement $simpleXmlObject */
        $simpleXmlObject = $simpleXmlObject->$contents;
        $this->iterator = new \SimpleXMLIterator($simpleXmlObject);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->iterator->key();
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
        return $this->iterator->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Seeks to a position
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @param int $position <p>
     * The position to seek to.
     * </p>
     * @return void
     */
    public function seek($position)
    {
        $this->iterator->seek($position);
    }
}