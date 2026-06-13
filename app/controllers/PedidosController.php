<?php
require_once __DIR__ . '/../models/PedidosModel.php';

class PedidosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new PedidosModel();
    }

    public function ejecutar($accion, $datos = []) {
        switch ($accion) {
            case 'listar':
                return json_encode(['success' => true, 'data' => $this->modelo->listar()]);

            case 'crear':
                $ok = $this->modelo->crear($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Pedido creado correctamente' : 'Error al crear el pedido']);

            case 'editar':
                $ok = $this->modelo->editar($datos);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Pedido actualizado correctamente' : 'Error al actualizar el pedido']);

            case 'eliminar':
                $id = $datos['id'] ?? 0;
                $ok = $this->modelo->eliminar($id);
                return json_encode(['success' => $ok, 'message' => $ok ? 'Pedido eliminado correctamente' : 'Error al eliminar el pedido']);

            case 'clientes':
                return json_encode(['success' => true, 'data' => $this->modelo->listarClientes()]);

            case 'vendedores':
                return json_encode(['success' => true, 'data' => $this->modelo->listarVendedores()]);

            case 'productos':
                return json_encode(['success' => true, 'data' => $this->modelo->listarProductos()]);

            case 'estatus':
                return json_encode(['success' => true, 'data' => $this->modelo->listarEstatus()]);

            default:
                return json_encode(['success' => false, 'message' => 'Acción no reconocida']);
        }
    }
}

if (isset($_POST['action'])) {
    $controller = new PedidosController();
    echo $controller->ejecutar($_POST['action'], $_POST);
}
?>