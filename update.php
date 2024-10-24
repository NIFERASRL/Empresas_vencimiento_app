<?php


include 'connect.php';       //Conexión con base de datos
include 'validaciones.php';   // Instancia de archivo de validaciones
$id = $_GET[trim('updateid')];
$sql = "select * from `Empresas` where id=$id";  //Consulta a la base de datos basado en el Id de la empresa
$result = mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($result);

//Actualizando valores encontrados en la base de datos en variables

$nombreEmpresa_holder=$row['nombre_empresa'];
$rncEmpresa_holder = $row['rncEmpresa'];
$tipoEmpresa_holder= $row['tipo_empresa'];
$actividadEmpresa_holder= $row['actividad_empresa'];
$correoEmpresa_holder=$row['correo_empresa'];
$fechaConstitucion_holder=$row['fecha_constitucion'];
$numeroEmpresa_holder=$row['numero_telefono'];
$vencimientoNombreComercial_holder=$row['fecha_vencimiento_nombre_comercial'];
$vencimientoRegistroMercantil_holder=$row['fecha_vencimiento_registro_mercantil'];

//Fin de actualización de valores


if (isset($_POST['submit'])) {
  
    $data = [

        'nombreEmpresa' => htmlspecialchars($_POST['nombreEmpresa']),
        'rncEmpresa' => htmlspecialchars($_POST['rncEmpresa']),
        'tipoEmpresa' => htmlspecialchars($_POST['tipoEmpresa']),
        'actividadEmpresa' => htmlspecialchars($_POST['actividadEmpresa']),
        'correoEmpresa' => htmlspecialchars($_POST['correoEmpresa']),
        'fechaConstitucion' => htmlspecialchars($_POST['fechaConstitucion']),
        'numeroEmpresa' => htmlspecialchars($_POST['numeroEmpresa']),
        'vencimientoNombreComercial' => htmlspecialchars($_POST['vencimientoNombreComercial']),
        'vencimientoRegistroMercantil' => htmlspecialchars($_POST['vencimientoRegistroMercantil'])
    ];

    // Validar los datos
    $errores = Validaciones::validar($data);

    if (empty($errores)) {
    $sql = "UPDATE `Empresas` SET
    nombre_empresa='{$data['nombreEmpresa']}',
    tipo_empresa='{$data['tipoEmpresa']}',
    actividad_empresa='{$data['actividadEmpresa']}',
    correo_empresa='{$data['correoEmpresa']}',
    fecha_constitucion='{$data['fechaConstitucion']}',
    numero_telefono='{$data['numeroEmpresa']}',
    fecha_vencimiento_nombre_comercial='{$data['vencimientoNombreComercial']}',
    fecha_vencimiento_registro_mercantil='{$data['vencimientoRegistroMercantil']}'
    WHERE id=$id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            header('location:display.php');
        } else {
            die(mysqli_error($con));
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <title>Registro de clientes</title>
</head>

<body>
<div class="container my-5">
        <form method="POST">
            <div class="form-group">
                <div class="form-group">
                <label>Nombre de la empresa</label>
                <input type="text" name="nombreEmpresa" class="form-control" placeholder="NIFERA SRL"
                    autocomplete="off" value="<?= htmlspecialchars($nombreEmpresa_holder ?? '') ?>">
                    <span class="text-danger"><?= $errores['nombreEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Tipo de empresa</label>
                    <select  type="text" name="tipoEmpresa" class="form-control" 
                    value="<?= htmlspecialchars($tipoEmpresa_holder ?? '') ?>">
                        <option value="">Seleccionar una opción</option>
                        <option value="SRL">SRL</option>
                        <option value="SAS">SAS</option>
                        <option value="SA">SA</option>
                        <option value="EIRL">EIRL</option>
                        <option value="PERSONA FÍSICA">PERSONA FíSICA</option>
                    </select>
                    <span class="text-danger"><?= $errores['tipoEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Actividad de la empresa</label>
                    <input type="text" name="actividadEmpresa" class="form-control" placeholder="Desarrollo de software"
                        autocomplete="off" value="<?php echo $actividadEmpresa_holder;?>">
                </div>
                <div class="form-group">
                    <label>Correo electrónico empresarial</label>
                    <input type="mail" name="correoEmpresa" class="form-control"
                        placeholder="info@niferadev.com" autocomplete="off" 
                        value="<?= htmlspecialchars($correoEmpresa_holder ?? '') ?>">
                        <span class="text-danger"><?= $errores['correoEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Fecha de constitución</label>
                    <input type="date" name="fechaConstitucion" class="form-control" autocomplete="off" 
                    value="<?php echo $fechaConstitucion_holder;?>">
                </div>
                <div class="form-group">
                    <label>Número telefónico empresarial</label>
                    <input type="text" name="numeroEmpresa" class="form-control" placeholder="+1(829)995-5655"
                        autocomplete="off" value="<?= htmlspecialchars($numeroEmpresa_holder ?? '') ?>">
                        <span class="text-danger"><?= $errores['numeroEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Vencimiento del nombre comercial</label>
                    <input type="date" name="vencimientoNombreComercial" class="form-control" autocomplete="off"
                    value="<?php echo $vencimientoNombreComercial_holder;?>">
                </div>
                <div class="form-group">
                    <label>Vencimiento del registro comercial</label>
                    <input type="date" name="vencimientoRegistroMercantil" class="form-control" autocomplete="off"
                    value="<?php echo $vencimientoRegistroMercantil_holder;?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Actualizar empresa</button>
                <button type="button" onclick="window.location.href='display.php';" class="btn btn-danger">Volver</button>
            </div>
        </form>
    </div>
</body>

</html>