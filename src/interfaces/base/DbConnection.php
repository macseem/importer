<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/29/15
 * Time: 11:58 PM
 */

namespace Importer\interfaces\base;


interface DbConnection {

    public function execute($query);

}