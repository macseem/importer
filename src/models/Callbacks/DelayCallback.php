<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 10/7/15
 * Time: 9:49 PM
 */

namespace MIM\models\Callbacks;

/**
 * Class DelayCallback
 * @package MIM\models\Callbacks
 */
class DelayCallback extends AbstractCallback{

    private $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }
    /**
     * @return void
     */
    public function call()
    {
        if(!$this->seconds)
            return;
        sleep($this->seconds);
    }
}