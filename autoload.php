<?php
spl_autoload_register('afAfAutoloader');
function afAfAutoloader($fullClassName='')
{
    if (strpos($fullClassName, "OpenAffiliates\Migration")!==FALSE){
       $path = AF_PATH . 'classes/Migration/';
    } else if (strpos($fullClassName, "OpenAffiliates\Db")!==FALSE){
       $path = AF_PATH . 'classes/Db/';
    } else if (strpos($fullClassName, "OpenAffiliates\Services")!==FALSE){
       $path = AF_PATH . 'public/services/';
    } else if (strpos($fullClassName, "OpenAffiliates\Admin")!==FALSE){
       $path = AF_PATH . 'admin/';
    } else if (strpos($fullClassName, "OpenAffiliates")!==FALSE){
       $path = AF_PATH . 'classes/';
    }
    if (empty($path)){
       return;
    }

    $classNameParts = explode('\\', $fullClassName);
    if (!$classNameParts){
       return;
    }
    $lastElement = count($classNameParts) - 1;
    if (empty($classNameParts[$lastElement])){
       return;
    }
    $fullPath = $path . $classNameParts[$lastElement] . '.php';

    if (!file_exists($fullPath)){
       return;
    }
    include $fullPath;
}
