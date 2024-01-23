<?php
echo'<h2> sesiones y cookies</h2>';
//setcookie("politica","true");
echo var_dump($_COOKIE);
if($_COOKIE['politica']=='true'){
    echo'has aceptado la privacidad';
}
else{
    echo'no hay cookies';
}
session_start();
$_SESSION['busqueda']='camisa';