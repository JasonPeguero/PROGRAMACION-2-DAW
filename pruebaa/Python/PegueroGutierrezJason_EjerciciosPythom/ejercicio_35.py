lectura = 1
escritura = 2
ejecucion = 4
permisos = lectura | escritura
print("Permisos", permisos)
tienelectura = (permisos & lectura) == lectura
print("lectura?", tienelectura)
