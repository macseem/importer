<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/22/15
 * Time: 11:37 PM
 */

namespace MIM;


use MIM\exceptions\ReinitException;
use MIM\interfaces\Import;
use MIM\interfaces\models\Callback;
use MIM\interfaces\models\Destination;
use MIM\interfaces\models\OffsetProvider;
use MIM\interfaces\models\Source;
use MIM\traits\ErrorsTrait;

class Importer implements Import{

    use ErrorsTrait;

    private $source;
    private $destination;
    private $offsetModel;
    private $imported;

    private $needToReinit;

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
        $this->needToReinit = false;
    }

    public function init()
    {
        $this->imported = false;
        $this->deleteAllErrors();
        $this->getSource()->seek($this->getOffsetProvider()->get());
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

        if($this->needToReinit)
            throw new ReinitException("I have old data. I need to reinit", 550);

        for($i = 0; $i < $count; $i++){
            try{
                $this->getSource()->next();
                $result = $this->getDestination()->create(
                    $this->getSource()->current());
                if(!$callable)
                    continue;
                $callable->setResult($result)->call();
            } catch(\Exception $e) {
                $this->addError($e);
            }
        }
        $this->getOffsetProvider()->set($this->getSource()->key());
        $errors =$this->getErrors();
        $this->imported = empty($errors);
        $this->needToReinit = true;
    }

    public function isImported()
    {
        return $this->imported;
    }
}
