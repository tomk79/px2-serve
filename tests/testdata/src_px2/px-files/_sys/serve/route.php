<?php
chdir($_SERVER['DOCUMENT_ROOT']);
$path = $_SERVER['REQUEST_URI'];
$querystring = '';
if( strpos($path, '?') !== false ){
    list($path, $querystring) = preg_split('/\?/', $_SERVER['REQUEST_URI'], 2);
}
if( strrpos($path, '/') === strlen($path)-1 || preg_match('/\.(?:html?|css|js)$/', $path) ){
    $_SERVER['SCRIPT_FILENAME'] = realpath('./.px_execute.php');
    $_SERVER['SCRIPT_NAME'] = '/.px_execute.php';
    $_SERVER['PATH_INFO'] = $path;
    $_SERVER['PHP_SELF'] = '/.px_execute.php'.$path;
    include('./.px_execute.php');
    return;
}
return false;
