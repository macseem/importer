<?php

namespace MIM\interfaces;

use MIM\interfaces\base\GetErrors;
use MIM\interfaces\base\IsImported;
use MIM\interfaces\base\Init;

interface Import extends GetErrors, IsImported, Init {

    /**
     * @param callable $callable
     * @param int $count
     * @return bool
     */
    public function import( $count = 1, $callable = null);

}
