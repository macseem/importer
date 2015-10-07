<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 10/6/15
 * Time: 11:05 PM
 */

namespace MIM\models\Callbacks;


use MIM\interfaces\models\Callback;

abstract class AbstractCallback implements Callback{

    private $result;

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

}