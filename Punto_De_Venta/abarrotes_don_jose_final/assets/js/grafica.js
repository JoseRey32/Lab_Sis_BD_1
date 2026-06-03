fetch("datos_grafica.php")
.then(res => res.json())
.then(datos => {
    const labels = datos.map(d => "Día " + d.dia);
    const valores = datos.map(d => d.total);

    new Chart(document.getElementById("graficaVentas"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Ventas en pesos",
                data: valores
            }]
        },
        options: {
            responsive: true
        }
    });
});
