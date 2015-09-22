<?php

namespace Importer\interfaces;

use Importer\interfaces\base\GetErrors;
use Importer\interfaces\base\IsImported;

interface RecursiveImport extends GetErrors, IsImported {

    /**
     * @return bool
     */
    public function recursiveImport();

}
