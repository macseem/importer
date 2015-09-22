<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/22/15
 * Time: 11:38 PM
 */

namespace Importer\models\destinations;


use Importer\interfaces\Destination;

class Db implements Destination{

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }
}