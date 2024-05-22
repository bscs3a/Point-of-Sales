async function recordChartAsAnImage(typeFile, fromDate, toDate){
    // Create the chart
    var ctx = document.getElementById('emptyCanvas').getContext('2d');
    let chartValue = {};
    if (typeFile == 'Income'){
        chartValue = await generateIncomeChart(fromDate, toDate);
    }
    else if (typeFile == 'OwnerEquity'){
        chartValue = await generateEquityChart(fromDate, toDate);
    }
    else if (typeFile == 'TrialBalance'){
        chartValue = await generateBalanceChart(fromDate, toDate);
    }
    else if (typeFile == 'CashFlow'){
        chartValue = await generateCashFlowChart(fromDate, toDate);
    }
    var myChart = new Chart(ctx, chartValue);
    myChart.options.animation.onComplete = function() {
        // Convert the chart to a data URL
        var url = myChart.toBase64Image();
        // Send the image data to the server
        fetch('http://localhost/Finance/chartGenerator', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },  
            body: JSON.stringify({
                imageData: url,
            }),
        });
    };
}

function generateIncomeChart(){

}

function generateBalanceChart(fromDate, toDate){
    let dataToSend = {
        fromDate : fromDate,
        toDate : toDate,
    };
    // Return the fetch Promise
    return fetch('http://localhost/Finance/chartGeneration/getBalanceReport', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Return the chart configuration object
            return {
                type: 'pie',
                data: {
                    labels: ['Assets', 'Liabilities'],
                    datasets: [{
                        data: [data.asset, data.liability],
                        backgroundColor: ['rgb(255, 165, 0)', 'rgb(255, 205, 86)']
                    }]
                },
                options: {
                    responsive: true,
            
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 0,
                            bottom: 0
                        }
                    }
                }
            };
        })
        .catch((error) => {
            console.error('Error:', error);
        });
};

function generateEquityChart(fromDate, toDate){
    let dataToSend = {
        fromDate : fromDate,
        toDate : toDate,
    };
    return fetch('http://localhost/Finance/chartGeneration/getEquityReport', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Initialize labels and data arrays
            let labels = [];
            let datasetData = [];
            let colors = [];
            
            // Populate labels and data arrays with data from the server
            for (let key in data.owners) {
                console.log(data.owners[key]);
                labels.push(data.owners[key].name);
                datasetData.push(data.owners[key].dividedShare);
                colors.push(generateRandomColor());
            }
            // Return the chart configuration object
            return {
                type: 'pie',
                data: {
                    labels: labels, // Use the labels array
                    datasets: [{
                        data: datasetData, // Use the datasetData array
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
            
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 0,
                            bottom: 0
                        }
                    }
                }
            };
        })
        .catch((error) => {
            console.error('Error:', error);
        });
};

function generateCashFlowChart(){

}
