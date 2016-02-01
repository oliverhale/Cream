<?php
$Router->addRoute('/register','user','register');
$Router->addRoute('/hello/:pagenum/:pagelimit/','home','homepage');
$Router->addRoute('/','home','homepage');
$Router->addRoute('/register','user','register');
$Router->addRoute('/login','user','login');
$Router->addRoute('path4','controller','method');
$Router->calculateRoute();