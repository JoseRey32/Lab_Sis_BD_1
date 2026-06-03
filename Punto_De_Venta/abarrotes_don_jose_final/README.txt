PROYECTO FINAL - ABARROTES DON JOSÉ

Sistema Web de Punto de Venta con PHP y MySQL.

INSTALACIÓN EN XAMPP

1. Copia la carpeta abarrotes_don_jose_final en:
   C:\xampp\htdocs\

2. Abre XAMPP y activa:
   - Apache
   - MySQL

3. Abre phpMyAdmin:
   http://localhost/phpmyadmin

4. Importa el archivo:
   sql/base_datos.sql

5. Abre el sistema:
   http://localhost/abarrotes_don_jose_final/login.php

USUARIOS:
Administrador:
admin / admin123

Cajero:
cajero / 12345

FUNCIONES:
- Login con roles.
- Productos.
- Categorías.
- Proveedores.
- Clientes frecuentes.
- Compras.
- Ventas.
- Ticket imprimible.
- Reportes.
- Exportación CSV para Excel.
- Guardar reportes como PDF usando imprimir.
- Gráfica de ventas.
- Movimientos de inventario.
- Escaneo con cámara del celular usando ZXing.

NOTA DEL ESCÁNER:
Para que el escáner funcione en celular, el sistema debe estar en localhost o en un servidor HTTPS.
La librería del escáner se carga desde internet:
https://unpkg.com/@zxing/library@latest
