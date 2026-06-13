<?php
require_once '../../config/conex.php';

class ClientesModel extends Conexion {
    public function listar() {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM cliente ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO cliente (nombre, apellido, sexo, telefono, ciudad, direccion) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['nombre'], $data['apellido'], $data['sexo'], $data['telefono'], $data['ciudad'], $data['direccion']]);
    }

    public function editar($data) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE cliente SET nombre=?, apellido=?, sexo=?, telefono=?, ciudad=?, direccion=? WHERE id=?");
        return $stmt->execute([$data['nombre'], $data['apellido'], $data['sexo'], $data['telefono'], $data['ciudad'], $data['direccion'], $data['id']]);
    }

    public function eliminar($id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM cliente WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>