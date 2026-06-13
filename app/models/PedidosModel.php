<?php
require_once __DIR__ . '/../../config/conex.php';

class PedidosModel extends Conexion {
    private function obtenerConexion() {
        return Conexion::conectar();
    }

    public function listar() {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return [];
            }

            $stmt = $conexion->prepare(
                "SELECT p.id, p.fecha, p.total, p.id_cliente, p.id_vendedor, p.id_estatus,
                        COALESCE(c.nombre, '') AS cliente,
                        COALESCE(u.nombre, '') AS vendedor,
                        COALESCE(e.nombre, 'Pendiente') AS estatus
                 FROM pedido p
                 LEFT JOIN cliente c ON p.id_cliente = c.id
                 LEFT JOIN usuario u ON p.id_vendedor = u.id
                 LEFT JOIN estatus e ON p.id_estatus = e.id
                 ORDER BY p.id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function crear($data) {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return false;
            }

            $fecha = !empty($data['fecha']) ? $data['fecha'] : date('Y-m-d');

            $stmt = $conexion->prepare(
                "INSERT INTO pedido (id_cliente, id_vendedor, fecha, total, id_estatus)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $ok = $stmt->execute([
                $data['id_cliente'] ?? 0,
                $data['id_vendedor'] ?? 0,
                $fecha,
                $data['total'] ?? 0,
                $data['id_estatus'] ?? 1
            ]);

            if (!$ok) {
                return false;
            }

            $idPedido = $conexion->lastInsertId();

            if (!empty($data['id_producto']) && !empty($data['cantidad'])) {
                $detalle = $conexion->prepare(
                    "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
                     VALUES (?, ?, ?, ?)"
                );
                $detalle->execute([
                    $idPedido,
                    $data['id_producto'],
                    $data['cantidad'],
                    $data['total'] ?? 0
                ]);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function editar($data) {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return false;
            }

            $fecha = !empty($data['fecha']) ? $data['fecha'] : null;
            $params = [
                $data['id_cliente'] ?? 0,
                $data['id_vendedor'] ?? 0,
                $data['total'] ?? 0,
                $data['id_estatus'] ?? 1,
                $data['id'] ?? 0
            ];

            if ($fecha !== null) {
                $stmt = $conexion->prepare(
                    "UPDATE pedido SET id_cliente=?, id_vendedor=?, fecha=?, total=?, id_estatus=? WHERE id=?"
                );
                $params = [
                    $data['id_cliente'] ?? 0,
                    $data['id_vendedor'] ?? 0,
                    $fecha,
                    $data['total'] ?? 0,
                    $data['id_estatus'] ?? 1,
                    $data['id'] ?? 0
                ];
            } else {
                $stmt = $conexion->prepare(
                    "UPDATE pedido SET id_cliente=?, id_vendedor=?, total=?, id_estatus=? WHERE id=?"
                );
            }

            return $stmt->execute($params);
        } catch (Exception $e) {
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return false;
            }

            $conexion->prepare("DELETE FROM detalle_pedido WHERE id_pedido = ?")->execute([$id]);
            $stmt = $conexion->prepare("DELETE FROM pedido WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function listarClientes() {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return [];
            }
            $stmt = $conexion->prepare("SELECT id, nombre, apellido FROM cliente ORDER BY nombre ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function listarVendedores() {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return [];
            }
            $stmt = $conexion->prepare("SELECT id, nombre, apellido FROM usuario ORDER BY nombre ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function listarProductos() {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return [];
            }
            $stmt = $conexion->prepare("SELECT id, nombre FROM producto ORDER BY nombre ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function listarEstatus() {
        try {
            $conexion = $this->obtenerConexion();
            if (!$conexion) {
                return [];
            }
            $stmt = $conexion->prepare("SELECT id, nombre FROM estatus ORDER BY id ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>