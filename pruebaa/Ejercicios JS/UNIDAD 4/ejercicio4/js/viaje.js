function Viaje(codigo, camion, conductor, ruta, estado) {
    this.codigo = codigo;
    this.camion = camion;         
    this.conductor = conductor;   
    this.ruta = ruta;             
    this.estado = estado;         

    this.estadoTexto = function () {
        let nombres = {
            pendiente: "Pendiente",
            asignado: "Asignado",
            en_ruta: "En ruta",
            entregado: "Entregado",
            incidencia: "Incidencia"
        };
        return nombres[this.estado];
    };

    this.mostrarInfo = function () {
        return this.codigo + "\n" +
               "Camión: " + this.camion.matricula + " (" + this.camion.nombreCompleto() + ")\n" +
               "Conductor: " + this.conductor.nombre + " (" + this.conductor.telefono + ")\n" +
               "Ruta: " + this.ruta.descripcion() + "\n" +
               "Distancia: " + this.ruta.distancia + " km\n" +
               "Estado: " + this.estadoTexto() + "\n";
    };
}