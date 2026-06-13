<?php
require_once '../models/clientes.php';

class ClientesController {
    public function ejecutar($accion, $datos) {
        $modelo = new ClientesModel();

        switch ($accion) {
            case 'listar':
                return json_encode(['success' => true, 'data' => $modelo->listar()]);
            case 'crear':
                $ok = $modelo->crear($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Creado exitosamente' : 'Error al crear']);
            case 'editar':
                $ok = $modelo->editar($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Actualizado exitosamente' : 'Error al actualizar']);
            case 'eliminar':
                $ok = $modelo->eliminar($datos['id']);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Eliminado exitosamente' : 'Error al eliminar']);
            default:
                return json_encode(['success' => false, 'message' => 'Acción no reconocida']);
        }
    }
}

if (isset($_POST['action'])) {
    $controller = new ClientesController();
    echo $controller->ejecutar($_POST['action'], $_POST);
}
?>