
# Práctica 2. Panel de control de flota

## Descripción

Aplicación web para el departamento de operaciones de **ALBOR LOGISTICS** que permite comprobar rápidamente el estado de la flota de camiones.

El programa recorre los datos de 10 camiones con un bucle `for`, muestra la información de cada uno en la página y calcula un resumen con los totales de la flota.

## Archivos

| Archivo | Función |
|---|---|
| `flota.html` | Estructura de la página. Contiene dos secciones vacías donde JavaScript escribe los resultados. |
| `flota.js` | Lógica del programa: datos, bucle, cálculos y escritura de resultados en la página. |
| `README.md` | Esta explicación. |

## Cómo ejecutarlo

1. Guardar `flota.html` y el archivo de JavaScript en las rutas que indica la etiqueta `<script>` del HTML (`js/flota.js`).
2. Abrir `flota.html` en el navegador.

## Explicación de `flota.html`

- `<section id="flota">`: aquí se escribe el listado de camiones.
- `<section id="resumen">`: aquí se escribe el resumen de la flota.
- `<script src="js/flota.js">`: está al final del `body` para que JavaScript se cargue cuando las secciones ya existen y pueda encontrarlas con `getElementById`.

## Explicación de `flota.js`

### 1. Datos de los camiones

Los datos se guardan en cinco arrays. Cada posición es un camión, así que el camión número 0 es `matricula[0]`, `marca[0]`, `modelo[0]`, `kilometros[0]` y `estado[0]`.

```js
let matricula = ["1234ABC", "5678DEF", ...];
let marca = ["Volvo", "Scania", ...];
let modelo = ["FH", "R450", ...];
let kilometros = [235000, 182400, ...];
let estado = ["en_ruta", "disponible", ...];
```

Los estados posibles son `disponible`, `en_ruta` y `mantenimiento`.

Al estar los datos en arrays se pueden recorrer con un bucle, sin escribir ningún resultado a mano.

### 2. Variables acumuladoras

Empiezan en 0 y van aumentando dentro del bucle:

| Variable | Qué cuenta |
|---|---|
| `totalCamiones` | Número total de camiones. |
| `disponibles` | Camiones con estado `disponible`. |
| `enRuta` | Camiones con estado `en_ruta`. |
| `enMantenimiento` | Camiones con estado `mantenimiento`. |
| `kilometrosTotales` | Suma de los kilómetros de toda la flota. |
| `listaCamiones` | Texto HTML con la ficha de cada camión, que se va construyendo en cada vuelta. |

### 3. Bucle `for`

```js
for (let i = 0; i < 10; i++) { ... }
```

La variable `i` empieza en 0 y llega hasta 9, que son las 10 posiciones de los arrays. En cada vuelta se trabaja con un camión distinto.

Dentro del bucle ocurre lo siguiente:

1. Se suma 1 a `totalCamiones`.
2. Se suman los kilómetros del camión a `kilometrosTotales` (`kilometrosTotales += kilometros[i]`).
3. Se comprueba el estado con `if` / `else if`. Según el estado, se suma 1 al contador que corresponda (`disponibles`, `enRuta` o `enMantenimiento`) y se guarda en `textoEstado` el texto que se mostrará ("Disponible", "En ruta" o "En mantenimiento").
4. Se añade a `listaCamiones` la ficha del camión con su matrícula, modelo, kilómetros y estado.

Cada ficha tiene este formato:

```
Matrícula: 1234ABC
Modelo: Volvo FH
Kilómetros: 235000
Estado: En ruta
```

### 4. Kilometraje medio

Se calcula después del bucle, dividiendo los kilómetros totales entre el número de camiones:

```js
kilometrajeMedio = kilometrosTotales / totalCamiones;
```

Antes de dividir, un `if (totalCamiones > 0)` comprueba que hay camiones, para no dividir entre 0.

### 5. Mostrar los resultados en la página

Con `document.getElementById(...).innerHTML` se escribe el contenido dentro de las secciones del HTML:

- En `flota` se escribe la lista de fichas (`listaCamiones`).
- En `resumen` se escribe:
  - Número total de camiones.
  - Número de camiones disponibles.
  - Número de camiones en ruta.
  - Número de camiones en mantenimiento.
  - Kilómetros totales de la flota.
  - Kilometraje medio de la flota.

## Requisitos de la práctica

| Requisito | Dónde se cumple |
|---|---|
| Conjunto de 10 camiones con matrícula, marca, modelo, kilómetros y estado | Los cinco arrays del apartado 1. |
| Uso obligatorio de un bucle `for` | Apartado 3. |
| Variables acumuladoras | Apartado 2. |
| Uso de `if` para las comprobaciones | Comprobación del estado dentro del bucle y comprobación antes de calcular la media. |
| Resultados mostrados en la página | Apartado 5. |
| Sin introducir manualmente cada resultado | Todo se genera desde los arrays con el bucle. |