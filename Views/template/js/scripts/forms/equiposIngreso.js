// OBTENIENDO LOS ELEMENTOS COMO CONSTANTES
const btnSubmit = document.getElementById('btnSubmit');
const numeroBienInput = document.getElementById('numero_bien');
const mensajeValidacion = document.getElementById('mensajeValidacion');

//AJAX COMPROBAR NUMERO DE BIEN
numeroBienInput.addEventListener('input', function() {
    console.log('si entra a la funcion');
    const newValue = this.value;
    const url = URL + 'ajax/comprobarBien';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const data = `numero_bien=${newValue}`;
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Exitoso el ajax');
            const response = JSON.parse(xhr.responseText);

            if (response === 1) {
                numeroBienInput.classList.remove('is-invalid');
                numeroBienInput.classList.add('is-valid');
                //document.getElementById('btnSubmit').disabled = false;
                btnSubmit.disabled = false;
                //mensajeValidacion.textContent = '';
                document.getElementById('mensajeBienValidacion').textContent = 'El equipo esta registrado.';
            } else {
                numeroBienInput.classList.remove('is-valid');
                numeroBienInput.classList.add('is-invalid');
                //document.getElementById('btnSubmit').disabled = true;
                btnSubmit.disabled = true;
                document.getElementById('mensajeBienValidacion').textContent = 'Este equipo no esta registrado, registrelo para poder ingresarlo.';
            }
        } else {
            console.error('Error en el ajax:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Error en la red');
    };

    xhr.send(data);
});