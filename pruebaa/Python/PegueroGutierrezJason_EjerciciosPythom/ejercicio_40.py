nombre = "Ordenador"
ram = 16
almacenamiento = 512
precio = 800.0
iva = 21
disponible = True
unidades = 12
print(nombre, type(nombre))
print(ram, type(ram))
print(almacenamiento, type(almacenamiento))
print(precio, type(precio))
print(iva, type(iva))
print(disponible, type(disponible))
print(unidades, type(unidades))
precioIva = precio + precio * iva / 100
costeCinco = precioIva * 5
ramMB = ram * 1024
almacenamientoMB = almacenamiento * 1024
hayUnidades = unidades > 0
print( precioIva)
print( costeCinco)
print(ramMB)
print(almacenamientoMB)
print(hayUnidades)
print(ram & unidades)
print(ram | unidades)
print(ram ^ unidades)
