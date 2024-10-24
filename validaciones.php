<?php

class Validaciones {
    public static function validar($data) {
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

        if (empty($data['ultimaActualizacionDGII'])) {
            $errores['ultimaActualizacionDGII'] = 'La última actualización en DGII no se puede quedar vacío';
        } 


        /*----------------------
         Validaciones formato
        ----------------------*/


        if (!filter_var($data['correoEmpresa'], FILTER_VALIDATE_EMAIL)) {
            $errores['correoEmpresa'] = 'El correo electrónico no es válido.';
        }

        //  Validar que el campo teléfono no se haya quedado vacío y validar que el número telefónico sea válido.
        elseif (!preg_match('/^\+?[0-9]{1,3}\s?\(?[0-9]{3}\)?\s?[0-9]{3}-?[0-9]{4}$/', $data['numeroEmpresa'])) {
            $errores['numeroEmpresa'] = 'El número telefónico no es válido.';
        }

        /*----------------------
         Validaciones caracteres
        ----------------------*/

        if (strlen($data['rncEmpresa']) !== 9){
            $errores['rncEmpresa'] = 'Su RNC debe contener 9 caracteres';
        }

        /*----------------------
         Validaciones de fechas
        ----------------------*/

        if (!empty($data['vencimientoRegistroMercantil']) && $data['vencimientoRegistroMercantil'] <= date('Y-m-d')){
            $errores['vencimientoRegistroMercantil'] = 'La fecha de vencimiento no puede ser menor a la fecha actual';
        };

        if (!empty($data['vencimientoNombreComercial']) && $data['vencimientoNombreComercial'] <= date('Y-m-d')){
            $errores['vencimientoNombreComercial'] = 'La fecha de vencimiento no puede ser menor a la fecha actual';
        };


        return $errores;
    }
}
