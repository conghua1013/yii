<?php
/**
 * Created by PhpStorm.
 * User: mwq
 * Date: 15/10/11
 * Time: 17:04
 */
class SelfFunction
{

    public function createPath($dir, $mode = 0755){
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!$this->createPath(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }

}