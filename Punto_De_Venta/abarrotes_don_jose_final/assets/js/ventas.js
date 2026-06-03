let carrito = [];
let codeReader = null;

function agregarProducto(producto){
    if(parseInt(producto.stock) <= 0){
        alert("Producto sin stock");
        return;
    }

    let item = carrito.find(p => p.id_producto == producto.id_producto);

    if(item){
        if(item.cantidad < parseInt(producto.stock)){
            item.cantidad++;
        } else {
            alert("No hay más stock disponible");
        }
    } else {
        producto.cantidad = 1;
        producto.precio = parseFloat(producto.precio);
        carrito.push(producto);
    }

    mostrarCarrito();
}

function buscarProducto(){
    let codigo = document.getElementById("codigo").value.trim();

    if(codigo === ""){
        alert("Escribe o escanea un código");
        return;
    }

    fetch("buscar_producto.php?codigo=" + encodeURIComponent(codigo))
    .then(r => r.json())
    .then(p => {
        if(p){
            agregarProducto(p);
            document.getElementById("codigo").value = "";
        } else {
            alert("Producto no encontrado o sin stock");
        }
    });
}

document.getElementById("codigo").addEventListener("keydown", e => {
    if(e.key === "Enter") buscarProducto();
});

function mostrarCarrito(){
    let div = document.getElementById("carrito");
    div.innerHTML = "";
    let total = 0;

    if(carrito.length === 0){
        div.innerHTML = "<p class='gris'>No hay productos agregados</p>";
    }

    carrito.forEach((item,i) => {
        let sub = item.precio * item.cantidad;
        total += sub;

        div.innerHTML += `
        <div class="item-ticket">
            <div>
                <strong>${item.nombre}</strong><br>
                <small>${item.cantidad} x $${item.precio.toFixed(2)}</small>
            </div>
            <strong>$${sub.toFixed(2)}</strong>
            <button onclick="eliminarItem(${i})">X</button>
        </div>`;
    });

    document.getElementById("subtotal").textContent = "$" + total.toFixed(2);
    document.getElementById("total").textContent = "$" + total.toFixed(2);
    calcularCambio();
}

function eliminarItem(i){
    carrito.splice(i,1);
    mostrarCarrito();
}

function limpiarCarrito(){
    carrito = [];
    document.getElementById("pago").value = "";
    mostrarCarrito();
}

function obtenerTotal(){
    return carrito.reduce((s,i) => s + i.precio * i.cantidad, 0);
}

function calcularCambio(){
    let pago = parseFloat(document.getElementById("pago").value || 0);
    let cambio = pago - obtenerTotal();
    document.getElementById("cambio").textContent = "$" + Math.max(cambio,0).toFixed(2);
}

function finalizarVenta(){
    if(carrito.length === 0){
        alert("No hay productos");
        return;
    }

    let total = obtenerTotal();
    let pago = parseFloat(document.getElementById("pago").value || 0);

    if(pago < total){
        alert("El pago es menor al total");
        return;
    }

    let id_cliente = document.getElementById("id_cliente").value;

    fetch("guardar_venta.php", {
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body: JSON.stringify({
            productos: carrito,
            total: total,
            pago: pago,
            cambio: pago - total,
            id_cliente: id_cliente
        })
    })
    .then(r => r.json())
    .then(res => {
        if(res.ok){
            window.location.href = "ticket.php?id=" + res.id_venta;
        } else {
            alert("Error: " + res.mensaje);
        }
    });
}

async function abrirEscanerZXing(){
    document.getElementById("scanner").classList.remove("oculto");
    document.getElementById("estadoScanner").textContent = "Iniciando cámara...";

    try{
        codeReader = new ZXing.BrowserMultiFormatReader();
        const dispositivos = await codeReader.listVideoInputDevices();

        let deviceId = null;

        if(dispositivos.length > 0){
            const trasera = dispositivos.find(d => d.label.toLowerCase().includes("back") || d.label.toLowerCase().includes("rear") || d.label.toLowerCase().includes("environment"));
            deviceId = trasera ? trasera.deviceId : dispositivos[0].deviceId;
        }

        codeReader.decodeFromVideoDevice(deviceId, "video", (result, err) => {
            if(result){
                document.getElementById("codigo").value = result.text;
                document.getElementById("estadoScanner").textContent = "Código detectado: " + result.text;
                cerrarEscanerZXing();
                buscarProducto();
            }
        });

        document.getElementById("estadoScanner").textContent = "Apunta al código de barras del producto";
    }catch(e){
        alert("No se pudo abrir el escáner. Usa Chrome, localhost o un sitio con HTTPS.");
        console.error(e);
    }
}

function cerrarEscanerZXing(){
    document.getElementById("scanner").classList.add("oculto");

    if(codeReader){
        codeReader.reset();
        codeReader = null;
    }
}

mostrarCarrito();
