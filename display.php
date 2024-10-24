<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver empresas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <button type="button" onclick="window.location.href='registro_cliente.php';" class="btn btn-outline-success mb-3 mt-5">Registrar empresa</button>
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">RNC</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">tipo</th>
                    <th scope="col">Última actualización DGII</th>
                    <th scope="col">Vencimiento nombre comercial</th>
                    <th scope="col">Vencimiento registro mercantil</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <?php

                $sql = "Select * from `Empresas`";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $rnc_empresa = $row['rnc_empresa'];
                        $nombreEmpresa = $row['nombre_empresa'];
                        $tipoEmpresa = $row['tipo_empresa'];
                        $ultimaActualizacionDGII = $row['ultima_actualizacion_dgii'];
                        $vencimientoNombreComercial = $row['fecha_vencimiento_nombre_comercial'];
                        $vencimientoRegistroMercantil = $row['fecha_vencimiento_registro_mercantil'];
                        
                        echo '
                        <tr>
                            <th scope="row"> ' . $rnc_empresa . ' </th>
                            <td>' . $nombreEmpresa . '</td>
                            <td>' . $tipoEmpresa . '</td>
                            <td>' . $ultimaActualizacionDGII . '</td>
                            <td>' . $vencimientoNombreComercial . '</td>
                            <td>' . $vencimientoRegistroMercantil . '</td>
                            <td>
                            <button class="btn btn-primary"><a href="update.php?updateid='.$id.'"class="text-light">Editar</a>
                            </button>
                            <button class="btn btn-danger"><a href="delete.php?deleteid='.$id.'" class="text-light">Eliminar</a>
                            </button>
                            </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>