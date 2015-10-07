<?php

namespace MIM\interfaces;

use MIM\interfaces\base\IsImported;

interface RecursiveImport extends IsImported {

    /**
     * @return bool
     */
    public function recursiveImport();

}
