<?php
const PREFIX_TO_RELATIVE_PATH = "/festiplan";
require $_SERVER[ 'DOCUMENT_ROOT' ] . PREFIX_TO_RELATIVE_PATH . '/lib/vendor/autoload.php';

use application\DefaultComponentFactory;
use yasmf\DataSource;
use yasmf\Router;

$dataSource = new DataSource(
    $host = 'SAE_S3_DevWeb-db',
    $port = '3306', 
    $db = 'sae_s3_devweb-1', 
    $user = 'sae_s3_devweb-1', 
    $pass = 'sae_s3_devweb-1', 
    $charset = 'utf8mb4'
);

$router = new Router(new DefaultComponentFactory(), $dataSource) ;
$router->route(PREFIX_TO_RELATIVE_PATH, $dataSource);
