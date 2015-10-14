<?php

//网站做的基础类 可以做一些公共的操作
class BaseController extends CController 
{
   public function createPath($dir, $mode = 0755){
       if (is_dir($dir) || @mkdir($dir,$mode)) return true;
       if (!$this->createPath(dirname($dir),$mode)) return false;
       return @mkdir($dir,$mode);
   }

}





