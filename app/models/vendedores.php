<?php
require_once '../../config/conex.php';

class VendedoresModel extends Conexion {
    public function listar() {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM usuario ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO usuario (cedula, nombre, apellido, password, status, cod_rol) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['cedula'], $data['nombre'], $data['apellido'], $data['password'], $data['status'], $data['cod_rol']]);
    }

    public function editar($data) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE usuario SET cedula=?, nombre=?, apellido=?, password=?, status=?, cod_rol=? WHERE id=?");
        return $stmt->execute([$data['cedula'], $data['nombre'], $data['apellido'], $data['password'], $data['status'], $data['cod_rol'], $data['id']]);
    }

    public function eliminar($id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>