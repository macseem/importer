<?php

namespace MIM\interfaces;

use MIM\interfaces\base\GetErrors;
use MIM\interfaces\base\IsImported;

interface RecursiveImport extends GetErrors, IsImported {

    /**
     * @return bool
     */
    public function recursiveImport();

}
