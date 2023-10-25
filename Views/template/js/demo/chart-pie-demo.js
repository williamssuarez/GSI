// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Ingresados", "Entregados", "En Revision", "Entregas Rechazadas"],
    datasets: [{
      data: [55, 30, 10, 5],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ff0000'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#bd0040'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

// En algún evento, por ejemplo, cuando la página se carga
document.addEventListener("DOMContentLoaded", function() {
  // Realiza una solicitud AJAX para obtener los datos del servidor
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "http://localhost/GSI/inicio/pieChart", true);
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          // Parsea los datos JSON obtenidos del servidor
          var data = JSON.parse(xhr.responseText);

          // Actualiza los datos del gráfico con los datos obtenidos del servidor
          myPieChart.data.datasets[0].data = data;
          // Actualiza el gráfico
          myPieChart.update();
      }
  };
  xhr.send();
});

