function Camion(matricula, marca, modelo, anio, kilometros, estado) {
    this.matricula = matricula;
    this.marca = marca;
    this.modelo = modelo;
    this.anio = anio;
    this.kilometros = kilometros;
    this.estado = estado;

    this.mostrarInfo = function () {
        let nombres = {
            disponible: "Disponible",
            en_ruta: "En ruta",
            mantenimiento: "Mantenimiento"
        };
        return this.matricula + " | " + this.marca + " " + this.modelo + " | " +
               this.kilometros.toLocaleString("es-ES") + " | " + nombres[this.estado];
    };

    this.cambiarEstado = function (nuevoEstado) {
        this.estado = nuevoEstado;
    };

    this.aniadirKilometros = function (km) {
        this.kilometros += km;
    };

    this.necesitaMantenimiento = function () {
        return this.kilometros >= 300000 || this.estado === "mantenimiento";
    };
}