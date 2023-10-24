(async function() {
    const data = [
      { year: 2010, count: 23 },
      { year: 2011, count: 22 },
      { year: 2012, count: 21 },
      { year: 2013, count: 25 },
      { year: 2014, count: 26 },
      { year: 2015, count: 29 },
      { year: 2016, count: 21 },
      { year: 2016, count: 26 },
      { year: 2016, count: 24 },
      { year: 2016, count: 25 },
      { year: 2016, count: 26 },
      { year: 2016, count: 22 },
      { year: 2016, count: 22 },

    ];
  
    new Chart(
      document.getElementById('myChart'),
      {
        type: 'line',
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                x: {
                    grid: {
                        color: "rgba(255,255,255,0.3)"
                    },
                    ticks: {
                        color: "rgba(255,255,255,0)"
                    }
                },
                y: {
                    grid: {
                        color: "rgba(255,255,255,0.3)"
                    },
                    ticks: {
                        color: "rgba(255,255,255,1.3)"
                    }
                }
            },
            plugins: {
                legend: {
                    labels:{
                        color: "rgba(255,255,255,1.3)"
                    }
                }
            }
            
        },
        data: {
          labels: data.map(row => row.year),
          datasets: [{
              label: 'Temperature',
              data: data.map(row => row.count),
              borderColor: 'rgb(255, 255, 55)',
              fill:false,
              tension: 0.2,
              pointRadius: 3
            }]
        }
      }
    );
  })();




function resetdiv() {
    document.getElementById("temp").style.backgroundColor= "#2C87BF"
    document.getElementById("hum").style.backgroundColor= "#2C87BF"
    document.getElementById("moist").style.backgroundColor= "#2C87BF"
    document.getElementById("water").style.backgroundColor= "#2C87BF"
    document.getElementById("light").style.backgroundColor= "#2C87BF"
}


function changecolor(element) {
    resetdiv();
    element.style.backgroundColor = "#67A7CE"
}


document.addEventListener("DOMContentLoaded", function () {
    const text_tempvalue = document.getElementById("tempvalue");
    const text_humvalue = document.getElementById("humvalue");
    const text_moistvalue = document.getElementById("moistvalue");
    const text_watervalue = document.getElementById("watervalue");
    const text_lightvalue = document.getElementById("lightvalue");
    const text_updatevalue = document.getElementById("updatevalue");

    fetch('localhost:3307/get_folia_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Parse the response as JSON
        })
        .then(json_data => {
            if (Array.isArray(json_data)) {
                console.log(json_data);

                // Assuming you want to process the first item in the array
                if (json_data.length > 0) {
                    const currentItem = json_data[0];
                    const distance = currentItem.distance;
                    const moisture = currentItem.moisture;
                    const humidity = currentItem.humidity;
                    const temperature = currentItem.temperature;
                    const lightSensor = currentItem.lightSensor;
                    const reading = currentItem.reading_time;

                    // Display the data
                    text_tempvalue.innerHTML = `<p>${temperature}°C</p>`;
                    text_humvalue.innerHTML = `<p>${humidity}%</p>`;
                    text_moistvalue.innerHTML = `<p>${moisture}%</p>`;
                    text_watervalue.innerHTML = `<p>${distance}cm</p>`;
                    text_lightvalue.innerHTML = `<p>${lightSensor}</p>`;
                    text_updatevalue.innerHTML = `<p>${reading}</p>`;
                }
            } else {
                console.log('Received data is not an array:', json_data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
});








