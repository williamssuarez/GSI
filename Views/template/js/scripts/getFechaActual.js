  // Obtener la fecha actual en manualmente (yyyy-MM-ddTHH:mm)
  var fechaHoraActual = new Date();
  var año = fechaHoraActual.getFullYear();
  var mes = (fechaHoraActual.getMonth() + 1).toString().padStart(2, '0');
  var dia = fechaHoraActual.getDate().toString().padStart(2, '0');
  var horas = fechaHoraActual.getHours().toString().padStart(2, '0');
  var minutos = fechaHoraActual.getMinutes().toString().padStart(2, '0');
  var fechaActual = `${año}-${mes}-${dia}T${horas}:${minutos}`;
              
// Establecer la fecha actual como el valor máximo en el campo de entrada
document.getElementById("fecha_recibido").max = fechaActual;
document.getElementById("fecha_recibido").value = fechaActual;
