# Congreso
Sistema de Gestión de Congreso 

# Forma de usar
- Usar el script en db/congreso-local.sql para generar la base de datos. Es una mysql con 3 tablas, es muy sencilla pero lo suficientemente útil para todo.
- Remplazar en admin.php y login.php por el correo que quieras como administrador
- Usar PHP>7 y ejecutar en localhost el registro.php para registrar el administrador. La contraseña se genera automáticamente (no olvidar guardarla)
- Ejecutar el login.php con el mail admin, te debería redirigir a admin.php (si todo esta bien).
- Cerrar sesión y crear otra cuenta para probar como un usuario común (solo se puede generar una cuenta administrador).
- Cuando inicies sesión con el segundo usuario te deberá redirigir a portal.php. Intenta subir un archivo.
- Si no te deja seguir o aparece el bye.php, cambia la fecha limite de los archivos (usualmente se encuentra en la parte superior de los archivos).