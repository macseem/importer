<?php

namespace MIM;

use MIM\interfaces\Import;
use MIM\interfaces\models\Callback;
use MIM\interfaces\RecursiveImport;

class RecursiveImporter implements RecursiveImport
{

    private $importer;
    private $callable;
    private $count;
    private $delay;

    public function __construct( Import $importer,
                                 Callback $callable = null,
                                 $delay = null,
                                 $count = 1
    ) {
        $this->importer = $importer;
        $this->callable = $callable;
        $this->delay = $delay;
        $this->count = $count;
        $this->init();
    }

    public function init()
    {
    }
    /**
     * {@inheritdoc}
     */
    public function recursiveImport()
    {
        while($this->importer->import($this->count, $this->callable)){
            if($this->delay)
                sleep($this->delay);
        }
    }

    /**
     * @return bool
     */
    public function isImported()
    {
        // TODO: Implement isImported() method.
    }
}
