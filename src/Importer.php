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
use MIM\traits\GetterTrait;
use MIM\traits\ProgressTrait;

/**
 * Class Importer
 * @package MIM
 * @property Source $source
 * @property Destination $destination
 * @property OffsetProvider $offsetProvider
 */
class Importer implements Import{

    use ProgressTrait;
    use GetterTrait;

    private $source;
    private $destination;
    private $offsetProvider;

    /**
     * @param Source $source
     * @param Destination $destination
     * @param OffsetProvider $offsetProvider
     */
    public function __construct(Source $source, Destination $destination, OffsetProvider $offsetProvider)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->offsetProvider = $offsetProvider;
        $this->init();
    }

    public function init()
    {
        $this->source->seek($this->offsetProvider->get());
        $this->resetProgress();
        if(!$this->source->valid()){
            throw new InvalidSourceException(
                "Your source iterator is invalid. Maybe you've already imported your data?", 550);
        }
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
                $result = $this->destination->create(
                    $this->source->current());
                $this->source->next();
                if(!$callable)
                    continue;
                $callable->setResult($result)->call();
            } while($this->source->valid() && $count < 0 || $i++<$count );
        } catch(\Exception $e) {
            $this->offsetProvider->set($this->source->key());
            $this->complete();
            throw $e;
        }

        $this->offsetProvider->set($this->source->key());
        $this->complete();

    }

    public function isImported()
    {
        return $this->isCompleted();
    }
}
