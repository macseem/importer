<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 9/22/15
 * Time: 11:34 PM
 */

namespace MIM\models\offsetProviders;


use MIM\exceptions\FileDoesNotExistException;
use MIM\interfaces\OffsetProvider;

/**
 * Class TmpFile
 * @package Importer\models\offsetProviders
 */
class TmpFile implements OffsetProvider{

    private $file;
    private $cache;

    public function __construct($file, $createIfNotExists = true)
    {
        if(!file_exists($file)){
            $exceptionMsg = "File $file does not exists or I create permission denied";
            if(!$createIfNotExists)
                throw new FileDoesNotExistException($exceptionMsg, 550);
        }
        $this->file = $file;
    }
    /**
     * {@inheritdoc}
     */
    public function get($default = 0)
    {
        if(!empty($this->cache))
            return $this->cache;
        $value = json_decode(file_get_contents($this->file), true);
        if(NULL == $value && $this->set($default)){
            return $default;
        }
        return $this->cache;
    }

    /**
     * {@inheritdoc}
     */
    public function set($offset)
    {
        $this->cache = false !== file_put_contents($this->file, json_encode($offset));
        return $this->cache;
    }
}