import React, {useRef, useEffect, useState} from 'react';

const CryptoPriceChart = (props) => {
    const canvasRef = useRef();
    const [chart, setChart] = useState(null);
    const [chartData, setChartData] = useState([]);

    function getConfig() {
        return {
            type: 'line',
            data: {
                datasets: [
                    _.merge(
                        {
                            label: `${props.from} price log in ${props.to}`,
                            data: [],
                            type: 'line',
                            pointRadius: 0,
                            fill: false,
                            lineTension: 0,
                            borderWidth: 2
                        },
                        props.dataset || {}
                    )
                ]
            },
            options: _.merge(
                {
                    animation: {
                        duration: 0
                    },
                    scales: {
                        xAxes: [{
                            type: 'time',
                            distribution: 'series',
                            ticks: {
                                major: {
                                    enabled: true,
                                    fontStyle: 'bold'
                                },
                                source: 'data',
                                autoSkip: true,
                                autoSkipPadding: 15
                            },
                        }]
                    },
                    tooltips: {
                        intersect: false,
                        mode: 'index',
                    }
                },
                props.options || {}
            )
        };
    }

    function fetchChartData() {
        axios.post('/api/stats', {
                from: props.from,
                to: props.to
            })
            .then(res => {
                console.log('Data fetched: ' + res);
                setChartData(res.data);
            })
            .catch(err => console.error('Failed to fetch data: ' + err));
    }

    // On data change
    useEffect(() => {
        if (!chart) {
            return;
        }

        // Limited to one dataset
        chart.data.datasets[0].data = chartData;
        chart.update();
    }, [chartData]);

    // On component mount
    useEffect(() => {
        setChart(new Chart(canvasRef.current.getContext('2d'), getConfig()));
        fetchChartData();
    }, []);

    return (
        <canvas ref={canvasRef}>Your browser does not support canvas</canvas>
    );
};

export default CryptoPriceChart;
