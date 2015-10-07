<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 10/7/15
 * Time: 10:53 PM
 */

namespace MIM\traits;


use MIM\exceptions\ProgressException;

trait ProgressTrait {

    private $startTime = null;
    private $completeTime = null;
    private $delta = null;
    protected function resetProgress()
    {
        $this->startTime = null;
        $this->completeTime = null;
        $this->delta = null;
    }

    protected function start()
    {
        $this->startTime = time();
    }

    protected function complete()
    {
        if(!$this->isStarted())
            throw new ProgressException("Can't complete. Start first", 550);
        $this->completeTime = time();
        $this->delta = $this->completeTime - $this->startTime;
    }

    public function isStarted()
    {
        return $this->startTime != null;
    }

    public function isCompleted()
    {
        return $this->completeTime != null;
    }

    protected function getDelta()
    {
        if(!$this->isCompleted())
            throw new ProgressException("Can't get delta. Complete first", 550);
        return $this->delta;
    }
}