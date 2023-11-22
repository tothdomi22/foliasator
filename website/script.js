document.addEventListener("DOMContentLoaded", function () {
    // Get references to HTML elements
    const text_tempvalue = document.getElementById("tempvalue");
    const text_humvalue = document.getElementById("humvalue");
    const text_moistvalue = document.getElementById("moistvalue");
    const text_watervalue = document.getElementById("watervalue");
    const text_lightvalue = document.getElementById("lightvalue");
    const text_updatevalue = document.getElementById("updatevalue");

    // Fetch configuration data
    fetch('config.json')
        .then(response => response.json())
        .then(config => {
            // Use the 'URL' from the configuration
            const baseUrl = config.URL;

            // Construct the URL for the data fetch request
            const dataUrl = `${baseUrl}/get_folia_data.php`;

            // Fetch data from the constructed URL
            fetch(dataUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the response as JSON
                })
                .then(json_data => {
                    console.log('JSON Data:', json_data); // Log the received JSON data

                    if (Array.isArray(json_data) && json_data.length > 0) {
                        // Extract data arrays from JSON
                        const temperature_data = json_data.map(item => item.temperature);
                        const humidity_data = json_data.map(item => item.humidity);
                        const moisture_data = json_data.map(item => item.moisture);
                        const distance_data = json_data.map(item => item.distance);
                        const light_data = json_data.map(item => item.lightSensor);
                        const reading_data = json_data.map(item => item.reading_time);

                        // Update text values
                        text_tempvalue.innerHTML = `<p>${temperature_data[temperature_data.length - 1]}°C</p>`;
                        text_humvalue.innerHTML = `<p>${humidity_data[humidity_data.length - 1]}%</p>`;
                        text_moistvalue.innerHTML = `<p>${moisture_data[moisture_data.length - 1]}%</p>`;
                        text_watervalue.innerHTML = `<p>${distance_data[distance_data.length - 1]}cm</p>`;
                        text_lightvalue.innerHTML = `<p>${light_data[light_data.length - 1]}</p>`;
                        text_updatevalue.innerHTML = `<p>${reading_data[reading_data.length - 1]}</p>`;

                        // Create charts
                        createChart('temp_chart', 'Temperature', temperature_data, reading_data);
                        createChart('hum_chart', 'Humidity', humidity_data, reading_data);
                        createChart('moist_chart', 'Moisture', moisture_data, reading_data);
                        createChart('water_chart', 'Water level', distance_data, reading_data);
                        createChart('light_chart', 'Light value', light_data, reading_data);
                    } else {
                        console.log('Received data is not an array or empty:', json_data);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
});

// Function to create a line chart
function createChart(elementId, label, data, reading_data) {
    return new Chart(
        document.getElementById(elementId),
        {
            type: 'line',
            options: {
                animation: false,
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        grid: { color: "rgba(255,255,255,0.3)" },
                        ticks: {
                            maxTicksLimit: 4,
                            color: "rgba(255,255,255,1.3)"
                            }
                    },
                    y: {
                        grid: { color: "rgba(255,255,255,0.3)" },
                        ticks: { color: "rgba(255,255,255,1.3)" }
                    }
                },
                plugins: {
                    legend: { labels: { color: "rgba(255,255,255,1.3)" } }
                }
            },
            data: {
                labels: reading_data,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: 'rgb(255, 255, 55)',
                    fill: false,
                    tension: 0.2,
                    pointRadius: 3
                }]
            }
        }
    );
}




function resetdiv() {
    document.getElementById("temp").style.backgroundColor = "#2C87BF";
    document.getElementById("hum").style.backgroundColor = "#2C87BF";
    document.getElementById("moist").style.backgroundColor = "#2C87BF";
    document.getElementById("water").style.backgroundColor = "#2C87BF";
    document.getElementById("light").style.backgroundColor = "#2C87BF";
}

function hideallgraphs() {
    document.getElementById("temp_graph").style.display = "none";
    document.getElementById("hum_graph").style.display = "none";
    document.getElementById("moist_graph").style.display = "none";
    document.getElementById("water_graph").style.display = "none";
    document.getElementById("light_graph").style.display = "none";
}


function changecolor(element) {
    resetdiv();
    element.style.backgroundColor = "#67A7CE";
    hideallgraphs();
    if (temp === element) {
        document.getElementById("temp_graph").style.display = 'block';
    }
    if (hum === element) {
        document.getElementById("hum_graph").style.display = "block";
    }
    if (moist === element) {
        document.getElementById("moist_graph").style.display = "block";
    }
    if (water === element) {
        document.getElementById("water_graph").style.display = "block";
    }
    if (light === element) {
        document.getElementById("light_graph").style.display = "block";
    }
}

let moisture_slider = document.getElementById("moisture_slider");
let output_moisture = document.getElementById("moisture_value");
output_moisture.innerHTML = moisture_slider.value;

moisture_slider.oninput = function () {
    output_moisture.innerHTML = this.value;
};


let duration_slider = document.getElementById("duration_slider");
let output_slider = document.getElementById("duration_value");
output_slider.innerHTML = duration_slider.value;

duration_slider.oninput = function () {
    output_slider.innerHTML = this.value;
};


function changeColor_watering() {
    let lightButton = document.getElementById("light_button");
    lightButton.style.backgroundColor = "red";
    let light_duration = duration_slider.value;
    setTimeout(function () {
        lightButton.style.backgroundColor = "";
    }, light_duration * 1000);
}
