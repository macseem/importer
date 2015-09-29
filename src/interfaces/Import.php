<?php

namespace Importer\interfaces;

use Importer\interfaces\base\GetErrors;
use Importer\interfaces\base\IsImported;
use interfaces\base\Init;

interface Import extends GetErrors, IsImported, Init {

    /**
     * @param callable $callable
     * @param int $count
     * @return bool
     */
    public function import( $count = 1, $callable = null);

}
