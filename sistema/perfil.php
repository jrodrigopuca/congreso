<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php 
session_start();
?>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Tus datos </h1>
        </div>
    </div>
    <div class="entrar card">
        <form action="perfil-res.php" class="card-body" method="post" name="frm" role="form" data-toggle="validator" novalidate="true">
            <h4> Datos Personales </h4>
            <!--tipoInscripcion-->
            <div class="form-group required">
                <label for="tipo" class=" control-label">Tipo de Asistente*</label>
                <div class="">
                    <select name="tipo" class="form-control" required="">
                        <option value="Al" selected="">Alumno</option>
                        <option value="DI">Docente/Investigador</option>
                        <option value="PI">Profesional Independiente</option>
                        <option value="EX">Extranjero</option>
                </select>
                </div>
            </div>


            <!--nombre -->
            <div class="form-group required">
                <label for="nombre" class=" control-label">Nombre*</label>
                <input type="text" name="nombre" class="form-control" size="20" maxlength="20" required="" data-error="Es un dato importante que no puede faltar">
                <div class="help-block with-errors"></div>
            </div>

            <!--apellido -->
            <div class="form-group required">
                <label for="apellido" class=" control-label">Apellido*</label>
                <input type="text" name="apellido" class="form-control" size="20" maxlength="20" required="" data-error="Es un dato importante que no puede faltar">
                <div class="help-block with-errors"></div>
            </div>


            <!--FecNacimiento -->
            <div class="form-group">
                <label for="fecnac" class=" control-label">Fecha de Nacimiento</label>
                <input type="date" name="fecnac" class="form-control"data-error="Fecha incorrecta">
                <div class="help-block with-errors"></div>
            </div>

            <!--ocupacion-->
            <div class="form-group">
                <label for="ocup" class=" control-label">Ocupación</label>
                <input type="text" name="ocup" class="form-control" size="30">
            </div>

            <!--institucion-->
            <div class="form-group required">
                <label for="inst" class=" control-label">Institución*</label>
                <input type="text" name="inst" class="form-control" size="30" maxlength="30" required="" data-error="Especificar la organización a la que pertenece">
                <div class="help-block with-errors"></div>
            </div>
            <br>

            <div class="divisor">
            </div>
            <h4> Datos de Contacto </h4>

            <!--domResidencia-->
            <div class="form-group">
                <label for="domr" class=" control-label">Domicilio</label>
                <input type="text" name="domr" class="form-control" size="40" maxlength="40">
            </div>

            <!--locResidencia-->
            <div class="form-group">
                <label for="locr" class=" control-label">Localidad </label>
                <input type="text" name="locr" class="form-control" size="30" maxlength="30">
            </div>

            <!--Tel1-->
            <div class="form-group required">
                <label for="Tel1" class=" control-label">Teléfono 1*  </label>
                <input type="text" name="tel1" class="form-control" size="30" maxlength="30" required="" data-error="Se debe especificar un número de teléfono">
                <div class="help-block with-errors"></div>
            </div>

            <!--Tel2-->

            <div class="form-group">
                <label for="tel2" class=" control-label">Teléfono 2 </label>
                <input type="text" name="tel2" class="form-control" size="30">
            </div>

            <!--email1-->
            <div class="form-group required">
                <label for="email1" class=" control-label">email alternativo 1*</label>
                <input type="email" name="email1" class="form-control" size="30" required="" data-error="La dirección de mail no es válida">
                <div class="help-block with-errors"></div>
            </div>

            <!--email2-->

            <div class="form-group">
                <label for="email2" class=" control-label">email alternativo 2</label>
                <input type="email" name="email2" class="form-control" size="30">
            </div>

            <input type="submit" class="btn btn-primary disabled" value="Agregar datos">
            <input type="reset" class="btn" value="Borrar">
        </form>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
    </div>
</body>
</html>