<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 10/6/15
 * Time: 10:56 PM
 */

namespace MIM\interfaces\models;


use MIM\interfaces\base\GetErrors;

interface Callback extends GetErrors{

    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @param mixed $result
     * @return self
     */
    public function setResult($result);

    /**
     * @return void
     */
    public function call();
}