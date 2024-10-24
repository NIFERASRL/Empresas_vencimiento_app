<?php
include 'connect.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Ejecutar la eliminación
    $sql = "DELETE FROM Empresas WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location:display.php');
    } else {
        echo "Error al eliminar la empresa.";
    }
}
?>
