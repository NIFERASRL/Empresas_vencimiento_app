<?php
include 'connect.php';

class Validaciones
{
    public static function validar($data)
    {
        global $con;
        $errores = [];

        /*---------------------------
         Validaciones de campos vacíos
        ----------------------------*/

        if (empty($data['nombreEmpresa'])) {
            $errores['nombreEmpresa'] = 'El nombre de la empresa no se puede quedar vacío';
        }

        if (empty($data['rncEmpresa'])) {
            $errores['rncEmpresa'] = 'El RNC de la empresa no se puede quedar vacío.';
        }

        if (empty($data['tipoEmpresa'])) {
            $errores['tipoEmpresa'] = 'Debe seleccionar un tipo de empresa.';
        }

        if (empty($data['actividadEmpresa'])) {
            $errores['actividadEmpresa'] = 'La actividad de la empresa no se puede quedar vacío.';
        }

        if (empty($data['correoEmpresa'])) {
            $errores['correoEmpresa'] = 'La dirección de correo electrónico no se puede quedar vacío.';
        }

        if (empty($data['fechaConstitucion'])) {
            $errores['fechaConstitucion'] = 'La fecha de constitución no se puede quedar vacío';
        }

        if (empty($data['numeroEmpresa'])) {
            $errores['numeroEmpresa'] = 'El número de la empresa no se puede quedar vacío';
        }

        if (empty($data['vencimientoNombreComercial'])) {
            $errores['vencimientoNombreComercial'] = 'El vencimiento del nombre comercial no se puede quedar vacío';
        }

        if (empty($data['vencimientoRegistroMercantil'])) {
            $errores['vencimientoRegistroMercantil'] = 'El vencimiento del registro mercantil no se puede quedar vacío';
        }

        /*----------------------
         Validaciones formato
        ----------------------*/

        if (!filter_var($data['correoEmpresa'], FILTER_VALIDATE_EMAIL)) {
            $errores['correoEmpresa'] = 'El correo electrónico no es válido.';
        }

        /*----------------------
         Validaciones caracteres
        ----------------------*/

        if ($data['tipoEmpresa'] === 'PERSONA FÍSICA') {
            if (strlen($data['rncEmpresa']) !== 11) {
                $errores['rncEmpresa'] = 'El RNC para una Persona Física debe contener 11 caracteres';
            }
        } else {
            if (strlen($data['rncEmpresa']) !== 9) {
                $errores['rncEmpresa'] = 'El RNC para una empresa debe contener 9 caracteres';
            }
        }

        /*----------------------
         Validaciones de fechas
        ----------------------*/

        if (!empty($data['vencimientoRegistroMercantil']) && $data['vencimientoRegistroMercantil'] < date('Y-m-d')) {
            $errores['vencimientoRegistroMercantil'] = 'La fecha de vencimiento no puede ser menor a la fecha actual';
        }
        

        if (!empty($data['vencimientoNombreComercial']) && $data['vencimientoNombreComercial'] < date('Y-m-d')) {
            $errores['vencimientoNombreComercial'] = 'La fecha de vencimiento no puede ser menor a la fecha actual';
        }

        /*-------------------------
         Validaciones de duplicidad
        -------------------------*/

        if (isset($data['nombreEmpresa'])) {
            $id = isset($data['id']) ? (int) $data['id'] : 0; // ID de la empresa a editar, si existe
            $nombreEmpresa = mysqli_real_escape_string($con, $data['nombreEmpresa']);
    
            $sql = "SELECT * FROM `Empresas` WHERE nombre_empresa = '$nombreEmpresa' AND id != $id";
            $result = mysqli_query($con, $sql);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $errores['nombreEmpresa'] = 'El nombre de la empresa ya existe en otra empresa.';
            }
        }

        if (isset($data['rcnEmpresa'])) {
            $id = isset($data['id']) ? (int) $data['id'] : 0; // ID de la empresa a editar, si existe
            $rncEmpresa = mysqli_real_escape_string($con, $data['rcnEmpresa']);
    
            $sql = "SELECT * FROM `Empresas` WHERE rnc_empresa = '$rncEmpresa' AND id != $id";
            $result = mysqli_query($con, $sql);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $errores['rcnEmpresa'] = 'El RNC de la empresa ya existe en otra empresa.';
            }
        }


        return $errores;
    }
}
