<?php
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

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

        if (isset($data['rncEmpresa'])) {
            $id = isset($data['id']) ? (int) $data['id'] : 0; // ID de la empresa a editar, si existe
            $rncEmpresa = mysqli_real_escape_string($con, $data['rncEmpresa']);

            $sql = "SELECT * FROM `Empresas` WHERE rnc_empresa = '$rncEmpresa' AND id != $id";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $errores['rncEmpresa'] = 'El RNC de la empresa ya existe en otra empresa.';
            }
        }

        /*------------------------------------
         Validaciones para enviar correo y SMS
        ------------------------------------*/

        self::enviarAlertasRegistroMercantil($data);

        return $errores;
    }

    public static function enviarAlertasRegistroMercantil($data)
    {
        // Validamos si hay un vencimiento en los próximos 30 días o si vence hoy
        $vencimiento = $data['vencimientoRegistroMercantil'];
        $hoy = date('Y-m-d');
        $alerta30Dias = date('Y-m-d', strtotime('+30 days'));

        // Comprobamos si el vencimiento es dentro de 30 días
        if ($vencimiento == $alerta30Dias) {
            $mensaje = "Aviso: Su registro mercantil de la empresa " . $data['nombreEmpresa'] . " vence en 30 días. Por favor, realice los trámites necesarios para la renovación.";
            self::enviarCorreo("analyticaccelerator@gmail.com", "Aviso de vencimiento de registro mercantil", $mensaje);
        }

        // Comprobamos si el vencimiento es hoy
        if ($vencimiento == $hoy) {
            $mensaje = "Urgente: Su registro mercantil de la empresa " . $data['nombreEmpresa'] . " vence hoy. Por favor, realice los trámites necesarios para la renovación.";
            self::enviarCorreo("analyticaccelerator@gmail.com", "Vencimiento de registro mercantil hoy", $mensaje);
        }
    }

    private static function enviarCorreo($destinatario, $asunto, $mensaje)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'reporteriadisenorepublica@gmail.com'; // Reemplaza con tu correo
            $mail->Password = 'zlyg lsvs mybq orwk'; // Reemplaza con tu contraseña
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('reporteriadisenorepublica@gmail.com', 'Fernando');
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje;

            // Enviar el correo
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }

    public static function revisarVencimientos()
{
    global $con;

    // Obtener la fecha actual y la fecha 30 días en el futuro
    $fechaHoy = date('Y-m-d');
    $fechaAviso = date('Y-m-d', strtotime('+30 days'));

    // Consulta para obtener empresas que vencen hoy o en 30 días
    $query = "SELECT nombreEmpresa, correoEmpresa, vencimientoRegistroMercantil FROM Empresas WHERE vencimientoRegistroMercantil = '$fechaHoy' OR vencimientoRegistroMercantil = '$fechaAviso'";
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($empresa = mysqli_fetch_assoc($result)) {
            // Preparar el mensaje del correo
            $mensaje = ($empresa['vencimientoRegistroMercantil'] == $fechaHoy) 
                ? "Su registro mercantil de la empresa {$empresa['nombreEmpresa']} vence hoy." 
                : "Su registro mercantil de la empresa {$empresa['nombreEmpresa']} vence en 30 días.";

            // Enviar correo con PHPMailer
            self::enviarCorreo("analyticaccelerator@gmail.com", "Alerta de Vencimiento de Registro Mercantil", $mensaje);
        }
    }
}

}
