


document.addEventListener("DOMContentLoaded", function () {
    const text_tempvalue = document.getElementById("tempvalue");
    const text_humvalue = document.getElementById("humvalue");
    const text_moistvalue = document.getElementById("moistvalue");
    const text_watervalue = document.getElementById("watervalue");
    const text_lightvalue = document.getElementById("lightvalue");
    const text_updatevalue = document.getElementById("updatevalue");

    fetch('https://foliasator.000webhostapp.com/getalldata.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(json_data => {
            if (Array.isArray(json_data)) {
                console.log(json_data);

                if (json_data.length > 0) {
                    var temperature_data = [];
                    var reading_data = [];
                    var moisture_data = [];
                    var water_data = [];
                    var light_data = [];
                    var distance_data = [];
                    var humidity_data = [];
                    for(var i in json_data) {
                        distance_data.push(json_data[i].distance);
                        moisture_data.push(json_data[i].moisture);
                        humidity_data.push(json_data[i].humidity);
                        temperature_data.push(json_data[i].temperature);
                        light_data.push(json_data[i].lightSensor);
                        reading_data.push(json_data[i].reading_time);
                    }

                    text_tempvalue.innerHTML = `<p>${temperature_data[json_data.length -1]}°C</p>`;
                    text_humvalue.innerHTML = `<p>${humidity_data[json_data.length -1]}%</p>`;
                    text_moistvalue.innerHTML = `<p>${moisture_data[json_data.length -1]}%</p>`;
                    text_watervalue.innerHTML = `<p>${distance_data[json_data.length -1]}cm</p>`;
                    text_lightvalue.innerHTML = `<p>${light_data[json_data.length -1]}</p>`;
                    text_updatevalue.innerHTML = `<p>${reading_data[json_data.length -1]}</p>`;

                        new Chart(
                            document.getElementById('temp_chart'),
                            {
                                type: 'line',
                                options: {
                                    animation:false,
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                        ticks: {display:false}
                                        },
                                        y: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                            ticks: {color: "rgba(255,255,255,1.3)"}
                                        }
                                    },
                                    plugins: {
                                        legend: {labels:{color: "rgba(255,255,255,1.3)"}}
                                    }
                                },
                                data: {
                                    labels: reading_data,
                                    datasets: [{
                                        label: 'Temperature',
                                        data: temperature_data,
                                        borderColor: 'rgb(255, 255, 55)',
                                        fill:false,
                                        tension: 0.2,
                                        pointRadius: 3
                                    }]
                                }
                            }
                        );
                        new Chart(
                            document.getElementById('hum_chart'),
                            {
                                type: 'line',
                                options: {
                                    animation:false,
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                        ticks: {display:false}
                                        },
                                        y: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                            ticks: {color: "rgba(255,255,255,1.3)"}
                                        }
                                    },
                                    plugins: {
                                        legend: {labels:{color: "rgba(255,255,255,1.3)"}}
                                    }
                                },
                                data: {
                                    labels: reading_data,
                                    datasets: [{
                                        label: 'Humidity',
                                        data: humidity_data,
                                        borderColor: 'rgb(255, 255, 55)',
                                        fill:false,
                                        tension: 0.2,
                                        pointRadius: 3
                                    }]
                                }
                            }
                        );

                        new Chart(
                            document.getElementById('moist_chart'),
                            {
                                type: 'line',
                                options: {
                                    animation:false,
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                        ticks: {display:false}
                                        },
                                        y: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                            ticks: {color: "rgba(255,255,255,1.3)"}
                                        }
                                    },
                                    plugins: {
                                        legend: {labels:{color: "rgba(255,255,255,1.3)"}}
                                    }
                                },
                                data: {
                                    labels: reading_data,
                                    datasets: [{
                                        label: 'Moisture',
                                        data: moisture_data,
                                        borderColor: 'rgb(255, 255, 55)',
                                        fill:false,
                                        tension: 0.2,
                                        pointRadius: 3
                                    }]
                                }
                            }
                        );

                        new Chart(
                            document.getElementById('water_chart'),
                            {
                                type: 'line',
                                options: {
                                    animation:false,
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                        ticks: {display:false}
                                        },
                                        y: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                            ticks: {color: "rgba(255,255,255,1.3)"}
                                        }
                                    },
                                    plugins: {
                                        legend: {labels:{color: "rgba(255,255,255,1.3)"}}
                                    }
                                },
                                data: {
                                    labels: reading_data,
                                    datasets: [{
                                        label: 'Water level',
                                        data: distance_data,
                                        borderColor: 'rgb(255, 255, 55)',
                                        fill:false,
                                        tension: 0.2,
                                        pointRadius: 3
                                    }]
                                }
                            }
                        );

                        new Chart(
                            document.getElementById('light_chart'),
                            {
                                type: 'line',
                                options: {
                                    animation:false,
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                        ticks: {display:false}
                                        },
                                        y: {
                                            grid: {color: "rgba(255,255,255,0.3)"},
                                            ticks: {color: "rgba(255,255,255,1.3)"}
                                        }
                                    },
                                    plugins: {
                                        legend: {labels:{color: "rgba(255,255,255,1.3)"}}
                                    }
                                },
                                data: {
                                    labels: reading_data,
                                    datasets: [{
                                        label: 'Light value',
                                        data: light_data,
                                        borderColor: 'rgb(255, 255, 55)',
                                        fill:false,
                                        tension: 0.2,
                                        pointRadius: 3
                                    }]
                                }
                            }
                        );


                }
            } else {
                console.log('Received data is not an array:', json_data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
});


function resetdiv() {
    document.getElementById("temp").style.backgroundColor= "#2C87BF"
    document.getElementById("hum").style.backgroundColor= "#2C87BF"
    document.getElementById("moist").style.backgroundColor= "#2C87BF"
    document.getElementById("water").style.backgroundColor= "#2C87BF"
    document.getElementById("light").style.backgroundColor= "#2C87BF"
}

function hideallgraphs() {
    document.getElementById("temp_graph").style.display="none";
    document.getElementById("hum_graph").style.display="none";
    document.getElementById("moist_graph").style.display="none";
    document.getElementById("water_graph").style.display="none";
    document.getElementById("light_graph").style.display="none";
}


function changecolor(element) {
    resetdiv();
    element.style.backgroundColor = "#67A7CE"
    hideallgraphs();
    if (temp === element) {
        document.getElementById("temp_graph").style.display='block';
    }
    else if (hum === element) {
        document.getElementById("hum_graph").style.display="block";
    }
    else if (moist === element) {
        document.getElementById("moist_graph").style.display="block";
    }
    else if (water === element) {
        document.getElementById("water_graph").style.display="block";
    }
    else if (light === element) {
        document.getElementById("light_graph").style.display="block";
    }
}

var moisture_slider = document.getElementById("moisture_slider");
var output_moisture = document.getElementById("moisture_value");
output_moisture.innerHTML = moisture_slider.value;

moisture_slider.oninput = function() {
    output_moisture.innerHTML = this.value;
}


var duration_slider = document.getElementById("duration_slider");
var output_slider = document.getElementById("duration_value");
output_slider.innerHTML = duration_slider.value;

duration_slider.oninput = function() {
    output_slider.innerHTML = this.value;
}


function changeColor_watering() {
    var lightButton = document.getElementById("light_button");
    lightButton.style.backgroundColor = "red";
    var light_duration = duration_slider.value;
    setTimeout(function() {
      lightButton.style.backgroundColor = "";
    }, light_duration*1000);
  }
