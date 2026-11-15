function Ruta(codigo, origen, destino, distancia) {
    this.codigo = codigo;
    this.origen = origen;
    this.destino = destino;
    this.distancia = distancia;

    this.descripcion = function () {
        return this.origen + " = " + this.destino;
    };
}