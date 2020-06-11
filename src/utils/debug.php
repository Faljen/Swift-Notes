<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

//Funkcja debugująca
function dump($data)
{
    echo '<div style="; 
    position: relative;
    left: 50%;                   
    background-color: antiquewhite;
    display: inline-block;
    border: 2px solid black;
    padding: 6px">
    <pre>';
    print_r($data);
    echo '</pre>
</div>';
}
