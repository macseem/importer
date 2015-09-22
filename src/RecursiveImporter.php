<?php

namespace Importer;

use Importer\interfaces\Import;
use Importer\interfaces\RecursiveImport;

class RecursiveImporter implements RecursiveImport
{

    private $importer;
    private $callable;
    private $count;
    private $delay;
    private $errors;

    public function __construct( Import $importer,
                                 $callable = null,
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
        $this->errors = [];
    }
    /**
     * {@inheritdoc}
     */
    public function recursiveImport()
    {
        while($this->importer->import(-1, $this->count, $this->callable)){
            $this->errors += $this->importer->getErrors();

            if($this->delay)
                sleep($this->delay);
        }

    }

    /**
     * @return \Exception[]
     */
    public function getErrors()
    {
        // TODO: Implement getErrors() method.
    }

    /**
     * @return bool
     */
    public function isImported()
    {
        // TODO: Implement isImported() method.
    }
}
