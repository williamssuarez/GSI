// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
/*var ctx = document.getElementById("myPieChart");
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
});*/
document.addEventListener("DOMContentLoaded", function() {
  var URL = "http://localhost/GSI/";
  $.ajax({
    //url: "path/to/piechart.php",
    url: URL + 'ajax/pieChart',
    method: "GET",
    contentType: "application/json",
    dataType: "json",
    success: function(response) {
      console.log('exito el ajax del pieChart');
      // Parse the JSON response data
      var labels = response.labels;
      var data = response.data[0]
      console.log(data);
      var data1 = data[0];
      var data2 = data[1];
      var data3 = data[2];
      var data4 = data[3];


      // Create a pie chart using Chart.js
      var ctx = document.getElementById("piechart-container").getContext("2d");
      var myChart = new Chart(ctx, {
        //type: "pie",
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: [data1.totalIngreso, data2.totalEntrega, data3.totalAprobacion, data4.rechazos],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ff0000'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#bd0040'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#000000",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: true,
            fontcolor: "#000000",
            fontsize: 18
          },
          cutoutPercentage: 80,
        },
      });
      myChart.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      myChart.defaultFontColor = '#858796';
    },
    error: function(xhr, status, error) {
      // Handle any errors that occur during the Ajax request
      console.log(error);
    }
  });
});

document.addEventListener("DOMContentLoaded", function() {
  $.ajax({
    //url: "path/to/piechart.php",
    url: URL + 'ajax/pieChartAdmin',
    method: "GET",
    contentType: "application/json",
    dataType: "json",
    success: function(response) {
      console.log('exito el ajax del pieChart');
      // Parse the JSON response data
      var labels = response.labels;
      var data = response.data[0]
      console.log(data);
      var data1 = data[0];
      var data2 = data[1];
      var data3 = data[2];
      var data4 = data[3];


      // Create a pie chart using Chart.js
      var ctx = document.getElementById("piechart-container").getContext("2d");
      var myChart = new Chart(ctx, {
        //type: "pie",
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: [data1.totalIngreso, data2.totalEntrega, data3.totalAprobacion, data4.rechazos],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ff0000'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#bd0040'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#000000",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: true,
            fontcolor: "#000000",
            fontsize: 18
          },
          cutoutPercentage: 80,
        },
      });
      myChart.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      myChart.defaultFontColor = '#858796';
    },
    error: function(xhr, status, error) {
      // Handle any errors that occur during the Ajax request
      console.log(error);
    }
  });
});