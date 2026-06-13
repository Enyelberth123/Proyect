<?php 

	require_once '../../config/conex.php';
	// require_once 'logs.php';

	class loginModel extends Conexion{

		private $usuario;
		private $password;

		public function setloginuser($usuario){ $this->usuario = $usuario; }
		public function getloginuser(){ return $this->usuario; }
		public function setpassword($password){ $this->password = $password; }	
		public function getpassword(){ return $this->password; }

		public function IniciarSesion(){

			try {

				$conexion = new Conexion();
				$conex = $conexion->conectar();

				$sql = ("SELECT * FROM usuario a
							WHERE a.cedula = :cedula");

				$stmt = $conex->prepare($sql);
				$stmt->bindparam(":cedula", $this->usuario, PDO::PARAM_STR);

				$x = $stmt->execute();

				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$result = array('success' => true, 'datos' => $data );

			} catch ( Exception $e ) {
				
				var_dump($e->getMessage());
				exit();
				$result = array('success' => false, 'error' => 1 );
			}

			return $result;

			$conex = null;

		} #Fin Funcion IniciarSesion
	} #Fin clase loginModel
?>