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
use MIM\traits\ProgressTrait;

class Importer implements Import{

    use ProgressTrait;

    private $source;
    private $destination;
    private $offsetModel;

    /**
     * @param Source $source
     * @param Destination $destination
     * @param OffsetProvider $offsetModel
     */
    public function __construct(Source $source, Destination $destination, OffsetProvider $offsetModel)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->offsetModel = $offsetModel;
        $this->init();
    }

    public function init()
    {
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
        $this->start();
        if($this->isCompleted())
            throw new ReinitException("I have old data. I need to reinit", 550);
        if( !is_integer($count)) {
            throw new InvalidParamException("Count is not integer", 550);
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
            } while($this->getSource()->valid() && $count < 0 || $i++<$count );
        } catch(\Exception $e) {
            $this->getOffsetProvider()->set($this->getSource()->key());
            $this->complete();
            throw $e;
        }

        $this->getOffsetProvider()->set($this->getSource()->key());
        $this->complete();

    }

    public function isImported()
    {
        return $this->isCompleted();
    }
}
