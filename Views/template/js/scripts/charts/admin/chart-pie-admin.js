var chartsLmao = null;

document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
      //url: "path/to/piechart.php",
      url: URL + 'ajax/pieChartAdmin',
      method: "GET",
      contentType: "application/json",
      dataType: "json",
      success: function(response) {
        console.log('exito el ajax del pieChart');

        //DESTRUYENDO LA GRAFICA ACTUAL
        if (chartsLmao) {
          chartsLmao.destroy();
          console.log('destruido');
      }

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
        chartsLmao = myChart;
      },
      error: function(xhr, status, error) {
        // Handle any errors that occur during the Ajax request
        console.log(error);
      }
    });
  });

  function DropdownEvento1(button) {
    
    var username = button.id;
    $.ajax({
      url: URL + 'ajax/pieChartByOpr/' + username,
      method: "GET",
      contentType: "application/json",
      dataType: "json",
      success: function(response) {
        console.log('THIS WORKS');

        //DESTRUYENDO LA GRAFICA ACTUAL
        if (chartsLmao) {
            chartsLmao.destroy();
            console.log('destruido');
        }

        var labels = response.labels;
        var data = response.data[0]
        console.log(data);
        var data1 = data[0];
        var data2 = data[1];
        var data3 = data[2];
        var data4 = data[3];

        // Create a pie chart using Chart.js
        var ctx = document.getElementById("piechart-container").getContext("2d");
        var myCharts = new Chart(ctx, {
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
        myCharts.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        myCharts.defaultFontColor = '#858796';
        chartsLmao = myCharts;
    
      },
      error: function(xhr, status, error) {
        // Handle any errors that occur during the Ajax request
        console.log(error);
      }
    });
}

function resetChart(){
  $.ajax({
    //url: "path/to/piechart.php",
    url: URL + 'ajax/pieChartAdmin',
    method: "GET",
    contentType: "application/json",
    dataType: "json",
    success: function(response) {
      console.log('exito el ajax del pieChart');

      //DESTRUYENDO LA GRAFICA ACTUAL
      if (chartsLmao) {
        chartsLmao.destroy();
        console.log('destruido');
    }

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
      chartsLmao = myChart;
    },
    error: function(xhr, status, error) {
      // Handle any errors that occur during the Ajax request
      console.log(error);
    }
  });
}