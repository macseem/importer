<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/23/15
 * Time: 8:55 AM
 */

namespace MIM\interfaces;


interface OffsetProvider {

    /**
     * @param mixed $default
     * @return $offset
     **/
    public function get($default = 0);

    /**
     * @param $offset
     * @return bool
     */
    public function set($offset);

}
