<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/23/15
 * Time: 8:55 AM
 */

namespace Importer\interfaces;


interface Offset {

    /**
      * @return $offset
     **/
    public function get();

    public function set($offset);


}
