<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 7/21/15
 * Time: 5:50 PM
 */

namespace Importer\interfaces;


interface Source extends \SeekableIterator{

    public function setOffset($offset);

    public function nextOne();

}
