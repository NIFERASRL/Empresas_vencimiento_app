<?php

class Validaciones {
    public static function validar($data) {
        $errores = [];

        // Validar que el nombre de la empresa no esté vacío
        if (empty($data['nombreEmpresa'])) {
            $errores['nombreEmpresa'] = 'El nombre de la empresa es obligatorio.';
        }

        if (empty($data['rncEmpresa'])) {
            $errores['rncEmpresa'] = 'El RNC de la empresa es obligatorio.';
        }

        // Validar que el tipo de empresa haya sido seleccionado
        if (empty($data['tipoEmpresa'])) {
            $errores['tipoEmpresa'] = 'Debe seleccionar un tipo de empresa.';
        }

        // Validar que el campo correo no se haya quedado vacío y Validar el correo electrónico escrito correctamente.
        if (empty($data['correoEmpresa'])) {
            $errores['correoEmpresa'] = 'Favor insertar una dirección de correo electrónico';
        } elseif (!filter_var($data['correoEmpresa'], FILTER_VALIDATE_EMAIL)) {
            $errores['correoEmpresa'] = 'El correo electrónico no es válido.';
        }

        //  Validar que el campo teléfono no se haya quedado vacío y validar que el número telefónico sea válido.
        if (empty($data['numeroEmpresa'])) {
            $errores['numeroEmpresa'] = 'Favor insertar un número telefónico';
        } elseif (!preg_match('/^\+?[0-9]{1,3}\s?\(?[0-9]{3}\)?\s?[0-9]{3}-?[0-9]{4}$/', $data['numeroEmpresa'])) {
            $errores['numeroEmpresa'] = 'El número telefónico no es válido.';
        }

        // Puedes agregar más validaciones según sea necesario (fechas, actividades, etc.)

        return $errores;
    }
}
