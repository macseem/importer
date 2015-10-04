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
use MIM\interfaces\base\GetErrors;
use MIM\interfaces\Destination;
use MIM\interfaces\OffsetProvider;
use MIM\interfaces\Source;

class Importer implements Import, GetErrors{

    private $source;
    private $destination;
    private $offsetModel;
    private $errors;
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
        $this->errors = [];
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

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function import($count = 1, $callable = null)
    {

        if($this->needToReinit)
            throw new ReinitException("I have old data. I need to reinit", 550);

        for($i = 0; $i < $count; $i++){
            try{
                $this->getSource()->next();
                $result = $this->getDestination()->create(
                    $this->getSource()->current());
                if(!$callable || !is_callable($callable))
                    continue;
                call_user_func($callable,$result);
            } catch(\Exception $e) {
                $this->errors[] = $e;
            }
        }
        $this->getOffsetProvider()->set($this->getSource()->key());
        $this->imported = empty($this->errors);
        $this->needToReinit = true;
    }

    public function isImported()
    {
        return $this->imported;
    }
}
