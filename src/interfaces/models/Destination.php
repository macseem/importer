<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/23/15
 * Time: 12:01 AM
 */

namespace Importer\interfaces;


interface Destination {

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data);
}
