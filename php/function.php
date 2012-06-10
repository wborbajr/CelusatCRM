<?php

$geturl = explode('/', $_SERVER['REQUEST_URI']);
if ($geturl[1] == 'noticia') { 
    $id = $geturl[2];
    include noticia.php;
}

?>