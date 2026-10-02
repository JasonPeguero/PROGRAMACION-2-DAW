let Nombre = document.getElementById('Nombre');
let Email = document.getElementById('Email');
let Conductor = document.getElementById('Conductor');

    if(!sessionStorage.getItem(Bienvenida)){
            alert("Bienvenido a ALBOR LOGISTICS");
    };

    
            const BotonInfo = document.getElementById('BotonInfo');
            const textoExtra = document.getElementById('info');

            BotonInfo.addEventListener('click', function() {
                if (textoExtra.classList.contains('oculto')) {
                    textoExtra.classList.remove('oculto');
                    
                } else {
                    textoExtra.classList.add('oculto');
                    BotonInfo.textContent = "Ver más información";
                }
            });


    function validar(){
    if(Nombre.value.trim() == ""){
        alert("El nombre es obligatoria");
    }

    if(Email.value.trim() == ""){
        alert("El email es obligaotiro");
       
    } 

}