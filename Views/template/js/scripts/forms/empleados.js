// OBTENIENDO LOS ELEMENTOS COMO CONSTANTES
const btnSubmit = document.getElementById('btnSubmit');
const cedulaInput = document.getElementById('cedula');
const mensajeValidacion = document.getElementById('mensajeCedulaValidacion');

//AJAX COMPROBAR NUMERO DE BIEN
cedulaInput.addEventListener('input', function() {
    console.log('si entra a la funcion');
    const newValue = this.value;
    const url = URL + 'ajax/comprobarCedula';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const data = `cedula=${newValue}`;
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Exitoso el ajax');
            const response = JSON.parse(xhr.responseText);

            if (response === 0) {

                cedulaInput.classList.remove('is-valid');
                cedulaInput.classList.add('is-invalid');
                btnSubmit.disabled = true;
                mensajeValidacion.textContent = 'Esta cedula ya esta registrada.';
                //document.getElementById('mensajeCedulaValidacion').textContent = 'Esta cedula ya esta registrada.';
            } else {
                cedulaInput.classList.remove('is-invalid');
                cedulaInput.classList.add('is-valid');
                btnSubmit.disabled = false;
                mensajeValidacion.textContent = 'La cedula es valida.';
                //document.getElementById('mensajeBienValidacion').textContent = 'La cedula es valida.';
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