<?php
require_once '../models/vendedores.php';

class VendedorController {
    public function ejecutar($accion, $datos) {
        $modelo = new VendedoresModel();

        switch ($accion) {
            case 'listar':
                return json_encode(['success' => true, 'data' => $modelo->listar()]);
            case 'crear':
                $ok = $modelo->crear($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Creado exitosamente' : 'Error']);
            case 'editar':
                $ok = $modelo->editar($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Actualizado exitosamente' : 'Error']);
            case 'eliminar':
                $ok = $modelo->eliminar($datos['id']);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Eliminado exitosamente' : 'Error']);
            default:
                return json_encode(['success' => false, 'message' => 'Acción no reconocida']);
        }
    }
}

if (isset($_POST['action'])) {
    $controller = new VendedorController();
    echo $controller->ejecutar($_POST['action'], $_POST);
}
?>