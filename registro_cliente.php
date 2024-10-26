<?php

include 'connect.php';
include 'validaciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST' && isset($_POST['submit'])) {
    // Capturar datos y sanitizarlos
    $data = [
        
        'nombreEmpresa' => htmlspecialchars($_POST['nombreEmpresa']),
        'rncEmpresa' => htmlspecialchars($_POST['rncEmpresa']),
        'tipoEmpresa' => htmlspecialchars($_POST['tipoEmpresa']),
        'actividadEmpresa' => htmlspecialchars($_POST['actividadEmpresa']),
        'correoEmpresa' => htmlspecialchars($_POST['correoEmpresa']),
        'fechaConstitucion' => htmlspecialchars($_POST['fechaConstitucion']),
        'numeroEmpresa' => htmlspecialchars($_POST['numeroEmpresa']),
        'vencimientoNombreComercial' => htmlspecialchars($_POST['vencimientoNombreComercial']),
        'vencimientoRegistroMercantil' => htmlspecialchars($_POST['vencimientoRegistroMercantil']),
        'ultimaActualizacionDGII' => htmlspecialchars($_POST['ultimaActualizacionDGII'])

    ];

    // Validar los datos
    $errores = Validaciones::validar(data: $data);

    if (empty($errores)) {

        $sql = "insert into `Empresas` (
    nombre_empresa,
    rnc_empresa,
    tipo_empresa, 
    actividad_empresa, 
    correo_empresa, 
    fecha_constitucion, 
    numero_telefono,
    fecha_vencimiento_nombre_comercial, 
    fecha_vencimiento_registro_mercantil,
    ultima_actualizacion_dgii
    ) values('{$data['nombreEmpresa']}','{$data['rncEmpresa']}','{$data['tipoEmpresa']}','{$data['actividadEmpresa']}',
    '{$data['correoEmpresa']}','{$data['fechaConstitucion']}', '{$data['numeroEmpresa']}', 
    '{$data['vencimientoNombreComercial']}', '{$data['vencimientoRegistroMercantil']}','{$data['ultimaActualizacionDGII']}')";

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
                    <input type="text" name="nombreEmpresa" class="form-control" placeholder="Insertar nombre de empresa"
                        autocomplete="off" value="<?= htmlspecialchars($data['nombreEmpresa'] ?? '') ?>">
                    <span class="text-danger"><?= $errores['nombreEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>RNC de la empresa</label>
                    <input type="number" name="rncEmpresa" class="form-control" placeholder="Insertar RNC de la empresa"
                        autocomplete="off" value="<?= htmlspecialchars($data['rncEmpresa'] ?? '') ?>">
                    <span class="text-danger"><?= $errores['rncEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Tipo de empresa</label>
                    <select type="text" name="tipoEmpresa" class="form-control">
                        <option value="">Seleccionar un tipo de empresa</option>
                        <option value="SRL" <?= isset($data['tipoEmpresa']) && $data['tipoEmpresa'] == 'SRL' ? 'selected' : '' ?>>SRL</option>
                        <option value="SAS" <?= isset($data['tipoEmpresa']) && $data['tipoEmpresa'] == 'SAS' ? 'selected' : '' ?>>SAS</option>
                        <option value="SA" <?= isset($data['tipoEmpresa']) && $data['tipoEmpresa'] == 'SA' ? 'selected' : '' ?>>SA</option>
                        <option value="EIRL" <?= isset($data['tipoEmpresa']) && $data['tipoEmpresa'] == 'EIRL' ? 'selected' : '' ?>>EIRL</option>
                        <option value="PERSONA FÍSICA" <?= isset($data['tipoEmpresa']) && $data['tipoEmpresa'] == 'PERSONA FÍSICA' ? 'selected' : '' ?>>PERSONA FíSICA</option>
                    </select>
                    <span class="text-danger"><?= $errores['tipoEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Actividad de la empresa</label>
                    <input type="text" name="actividadEmpresa" class="form-control" placeholder="Insertar actividad de empresa"
                        autocomplete="off"
                    value="<?= htmlspecialchars($data['actividadEmpresa'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['actividadEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Correo electrónico empresarial</label>
                    <input type="mail" name="correoEmpresa" class="form-control" placeholder="Añadir correo de la empresa"
                        autocomplete="off" value="<?= htmlspecialchars($data['correoEmpresa'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['correoEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Fecha de constitución</label>
                    <input type="date" name="fechaConstitucion" class="form-control"
                        autocomplete="off" value="<?= htmlspecialchars($data['fechaConstitucion'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['fechaConstitucion'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Número telefónico empresarial</label>
                    <input type="text" name="numeroEmpresa" class="form-control" placeholder="Ejemplo: +1(829)995-5655"
                        autocomplete="off" value="<?= htmlspecialchars($data['numeroEmpresa'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['numeroEmpresa'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Vencimiento del nombre comercial</label>
                    <input type="date" name="vencimientoNombreComercial" class="form-control" autocomplete="off" 
                    value="<?= htmlspecialchars($data['vencimientoNombreComercial'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['vencimientoNombreComercial'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Vencimiento del registro comercial</label>
                    <input type="date" name="vencimientoRegistroMercantil" class="form-control" autocomplete="off" 
                    value="<?= htmlspecialchars($data['vencimientoRegistroMercantil'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['vencimientoRegistroMercantil'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label>Última actualización DGII</label>
                    <input type="date" name="ultimaActualizacionDGII" class="form-control" autocomplete="off" 
                    value="<?= htmlspecialchars($data['ultimaActualizacionDGII'] ?? '') ?>">
                        <span class="text-danger"><?= $errores['ultimaActualizacionDGII'] ?? '' ?></span>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Registrar empresa</button>
                <button type="button" onclick="window.location.href='display.php';" class="btn btn-danger">Volver</button>
            </div>
        </form>
    </div>

</body>

</html>