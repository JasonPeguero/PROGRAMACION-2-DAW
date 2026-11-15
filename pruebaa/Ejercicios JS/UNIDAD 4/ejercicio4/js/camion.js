function Camion(matricula, marca, modelo, kilometros, estado) {
    this.matricula = matricula;
    this.marca = marca;
    this.modelo = modelo;
    this.kilometros = kilometros;
    this.estado = estado;

    this.nombreCompleto = function () {
        return this.marca + " " + this.modelo;
    };
}