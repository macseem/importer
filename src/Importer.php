<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/22/15
 * Time: 11:37 PM
 */

namespace MIM;


use MIM\exceptions\ReinitException;
use MIM\exceptions\validation\InvalidParamException;
use MIM\exceptions\validation\InvalidSourceException;
use MIM\interfaces\Import;
use MIM\interfaces\models\Callback;
use MIM\interfaces\models\Destination;
use MIM\interfaces\models\OffsetProvider;
use MIM\interfaces\models\Source;

class Importer implements Import{

    private $source;
    private $destination;
    private $offsetModel;
    private $imported;

    /**
     * @param Source $source
     * @param Destination $destination
     * @param OffsetProvider $offsetModel
     */
    public function __construct(Source $source, Destination $destination, OffsetProvider $offsetModel)
    {
        $this->imported = false;
        $this->source = $source;
        $this->destination = $destination;
        $this->offsetModel = $offsetModel;
        $this->init();
    }

    public function init()
    {
        $this->imported = false;
        $this->getSource()->seek($this->getOffsetProvider()->get());
        if(!$this->getSource()->valid()){
            throw new InvalidSourceException(
                "Your source iterator is invalid. Maybe you've already imported your data?", 550);
        }
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getOffsetProvider()
    {
        return $this->offsetModel;
    }

    /**
     * {@inheritdoc}
     */
    public function import($count = 1, Callback $callable = null)
    {
        if($this->imported)
            throw new ReinitException("I have old data. I need to reinit", 550);
        if($count <=0) {
            throw new InvalidParamException("Invalid count", 550);
        }
        $count--;
        $i=0;
        try{
            do{
                $result = $this->getDestination()->create(
                    $this->getSource()->current());
                $this->getSource()->next();
                if(!$callable)
                    continue;
                $callable->setResult($result)->call();
            } while($i++<$count && $this->getSource()->valid());
        } catch(\Exception $e) {
            $this->getOffsetProvider()->set($this->getSource()->key());
            throw $e;
        }

        $this->getOffsetProvider()->set($this->getSource()->key());
        $this->imported = true;
    }

    public function isImported()
    {
        return $this->imported;
    }
}
