<?php

namespace MIM\interfaces;

use MIM\interfaces\base\GetErrors;
use MIM\interfaces\base\IsImported;
use MIM\interfaces\base\Init;
use MIM\interfaces\models\Callback;

interface Import extends GetErrors, IsImported, Init {

    /**
     * @param int $count
     * @param $callable
     * @return bool
     */
    public function import( $count = 1, Callback $callable = null);

}
