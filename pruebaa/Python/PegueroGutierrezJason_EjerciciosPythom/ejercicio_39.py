ordenadores = 3
precioOrdenador = 650
monitores = 2
precioMonitor = 150
subtotal = ordenadores * precioOrdenador + monitores * precioMonitor
iva = subtotal * 0.21
total = subtotal + iva
articulos = ordenadores + monitores
costeMedio = total / articulos
print("Subtotal", subtotal, type(subtotal))
print("IVA", iva, type(iva))
print("Total", total, type(total))
print("Coste medio por articulo", costeMedio, type(costeMedio))
