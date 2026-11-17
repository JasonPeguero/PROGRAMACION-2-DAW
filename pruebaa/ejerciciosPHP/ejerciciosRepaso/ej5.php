<?php
$palabra = "programacion";
$array = str_split($palabra);
$vocales = array('a', 'e', 'i', 'o', 'u');
echo $palabra . "<br>";

//array_filter sirve para quitar los valores que no quiera, me quedo con los que necesto en este caso las vocales
$quitarlasconsonantes = array_filter($array, function($val) use ($vocales) {
    return in_array($val, $vocales);
});

print_r(array_count_values($quitarlasconsonantes));
?>