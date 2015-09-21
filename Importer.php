<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/22/15
 * Time: 11:37 PM
 */

namespace importer;


use importer\exceptions\ReinitException;
use importer\interfaces\Import;
use importer\interfaces\base\GetErrors;
use importer\interfaces\Destination;
use importer\interfaces\Offset;
use importer\interfaces\Source;

class Importer implements Import, GetErrors{

    private $source;
    private $destination;
    private $offset;
    private $errors;
    private $imported;

    private $needToReinit;

    /**
     * @param Source $source
     * @param Destination $destination
     * @param Offset $offset
     */
    public function __construct(Source $source, Destination $destination, Offset $offset)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->offset = $offset;
        $this->init();
        $this->needToReinit = false;
    }

    public function init()
    {
        $this->imported = false;
        $this->errors = [];
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function import($offset = -1, $count = 1, $callable = null)
    {

        if($this->needToReinit)
            throw new ReinitException("I have old data. I need to reinit", 550);
        
        if($offset == -1){
            $offset = $this->getOffset()->get();
        } else
            $this->getSource()->setOffset($offset);
            
        for($i = 0; $i < $count; $i++){
            try{
                $data = $this->getSource()->nextOne();
                $result = $this->getDestination()->create($data);
                if(!$callable || !is_callable($callable))
                    continue;
                call_user_func($callable,$result);
            } catch(\Exception $e) {
                $this->errors[] = $e;
            }
        }
        $this->getOffset()->set($offset + $count);
        $this->imported = empty($this->errors);
        $this->needToReinit = true;
    }

    public function isImported()
    {
        return $this->imported;
    }
}
