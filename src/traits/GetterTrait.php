<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 10/7/15
 * Time: 11:22 PM
 */

namespace MIM\traits;


use MIM\exceptions\MIMException;

trait GetterTrait {

    public function __get($name)
    {
        if(!empty($this->$name))
            return $this->$name;
        if(!empty($this->{'_'.$name}))
            return $this->{'_'.$name};
        $callable = [$this, 'get'.ucfirst($name)];
        if(is_callable($callable))
            return call_user_func($callable);
        throw new MIMException("Can't get $name", 550);
    }
}