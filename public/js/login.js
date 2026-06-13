$(document).ready(function () {


});
//__________________________________ Click Boton Login __________________________________________________________
$("#password").keyup(function (event) {

	if (event.keyCode == 13) {

		ingresar();
	}
});

$("#Ingresar").click(function (event) {

	ingresar();

});

$('#mostrar2').on('change', function (event) { //mostrar contraseña 
	// Si el checkbox esta "checkeado"
	if ($('#mostrar2').is(':checked')) {
		// Convertimos el input de contraseña a texto.
		$('#password').get(0).type = 'text';
		// En caso contrario..
	} else {
		// Lo convertimos a contraseña.
		$('#password').get(0).type = 'password';
	}
});
// Fin Function Ingresar ==========================================================================

//-----------------------------------funcion ingresar ------------------------------------------

function ingresar() {

	var action = 'IniciarSesion'
	var usuario = $('#usuario').val()
	var password = $('#password').val()

	if (usuario.length && password.length > 0) {

		var datos = new FormData();
		datos.append('action', action);
		datos.append("usuario", usuario);
		datos.append('password', password);

		url = 'app/controllers/login.php';
		$.ajax({
			// async:false,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			url: url,
			data: datos,
			dataType: "json",
			beforeSend: function () { },
			success: function (data) {

				if (data.success == true) {

					// console.log( data )
					// return false;

					// sessionStorage.setItem("Session", JSON.stringify(data.session));
					// sessionStorage.setItem("Modulos", JSON.stringify(data.modulos));

					alert('Bienvenido Al Sistema');

					url = data.url
					setTimeout(function () { $(location).attr('href', url); }, 1000);
				} else {

					alert('Datos Incorrectos');
				}
			},
			error: function(xhr, status, error) {
				console.error("Error del servidor:", xhr.responseText);
				alert('Ocurrió un error en el servidor. Revisa la consola.');
			}

		});
	} else {

		alert('Llene Los Campos');
	}
};
//-----------------------------------Fin funcion ingresar ------------------------------------------