<?php
$palabra = "espantapajaros";
$array = str_split($palabra);
$letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
echo $palabra . "<br>";

//array_filter sirve para quitar los valores que no quiera, me quedo con los que necesto en este caso las vocales
$quitarlasconsonantes = array_filter($array, function($val) use ($letras) {
    return in_array($val, $letras);
});

print_r(array_count_values($quitarlasconsonantes));
?>