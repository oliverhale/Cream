<?php

$Router->addRoute('/hello/:pagenum/:pagelimit/','home','test');
$Router->addRoute('/','home','homepage');
$Router->addRoute('path2','controller','method');
$Router->addRoute('path3','controller','method');
$Router->addRoute('path4','controller','method');
$Router->calculateRoute();