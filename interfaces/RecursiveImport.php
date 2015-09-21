<?php

namespace importer\interfaces;

use importer\interfaces\base\GetErrors;
use importer\interfaces\base\IsImported;

interface RecursiveImport extends GetErrors, IsImported {

    /**
     * @return bool
     */
    public function recursiveImport();

}
