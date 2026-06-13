<link rel="stylesheet" href="public/css/home.css">
<section class="content">
    <div class="container-fluid">
        <div class="bloque-encabezado">
            <h2>Gestión de Clientes</h2>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <button class="btn btn-primary" onclick="abrirModalCrear()">
                            <i class="material-icons">add</i> Nuevo Cliente
                        </button>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Sexo</th>
                                    <th>Teléfono</th>
                                    <th>Ciudad</th>
                                    <th>Fechas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaClientes">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModal">Formulario de Cliente</h4>
            </div>
            <div class="modal-body">
                <form id="formCliente">
                    <input type="hidden" id="cliente_id" name="id">
                    
                    <label for="nombre">Nombre</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
                        </div>
                    </div>
                    
                    <label for="apellido">Apellido</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingrese el apellido" required>
                        </div>
                    </div>

                    <label>Sexo</label>
                    <div class="form-group">
                        <select class="form-control show-tick" name="sexo" id="sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <label for="telefono">Teléfono</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Ej: 0414-1234567" required>
                        </div>
                    </div>
                    
                    <label for="ciudad">Ciudad</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ingrese la ciudad" required>
                        </div>
                    </div>
                    
                    <label for="direccion">Dirección</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control no-resize" name="direccion" id="direccion" placeholder="Dirección detallada..." required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" onclick="guardarCliente()">GUARDAR</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

<script>
let accionActual = 'crear'; // Para saber si el botón guardar hará un insert o un update

$(document).ready(function() {
    listarClientes();
});

// Función para listar
function listarClientes() {
    $.post('app/controllers/ClienteController.php', { action: 'listar' }, function(response) {
        let html = '';
        response.data.forEach(c => {
            let fechas = `<small>C: ${c.fecha_creacion}</small><br>`;
            if(c.fecha_modificacion) fechas += `<small>M: ${c.fecha_modificacion}</small>`;
            
            html += `<tr>
                <td>${c.nombre}</td>
                <td>${c.apellido}</td>
                <td>${c.sexo}</td>
                <td>${c.telefono}</td>
                <td>${c.ciudad}</td>
                <td>${fechas}</td>
                <td>
                    <button class="btn btn-xs btn-warning" onclick='abrirModalEditar(${JSON.stringify(c)})' title="Modificar"><i class="material-icons">edit</i></button>
                    <button class="btn btn-xs btn-danger" onclick="eliminarCliente(${c.id}, '${c.nombre} ${c.apellido}')" title="Eliminar"><i class="material-icons">delete</i></button>
                </td>
            </tr>`;
        });
        $('#tablaClientes').html(html);
    }, 'json');
}

// Ventana Flotante para Crear
function abrirModalCrear() {
    accionActual = 'crear';
    $('#tituloModal').text('Registrar Nuevo Cliente');
    $('#formCliente')[0].reset();
    $('#cliente_id').val('');
    $('#modalCliente').modal('show');
}

// Ventana Flotante para Modificar (Rellena los datos)
function abrirModalEditar(cliente) {
    accionActual = 'editar';
    $('#tituloModal').text('Personalizar Cliente');
    
    $('#cliente_id').val(cliente.id);
    $('#nombre').val(cliente.nombre);
    $('#apellido').val(cliente.apellido);
    $('#sexo').val(cliente.sexo);
    $('#telefono').val(cliente.telefono);
    $('#ciudad').val(cliente.ciudad);
    $('#direccion').val(cliente.direccion);
    
    $('#modalCliente').modal('show');
}

// Guardar (Detecta si es crear o editar)
function guardarCliente() {
    let datos = $('#formCliente').serialize() + '&action=' + accionActual;
    
    $.post('app/controllers/ClienteController.php', datos, function(res) {
        if(res.success) {
            $('#modalCliente').modal('hide');
            listarClientes(); // Recargar la tabla
        } else {
            alert("Error al procesar la solicitud.");
        }
    }, 'json');
}

// Sistema de Doble Advertencia para Eliminar
function eliminarCliente(id, nombreCompleto) {
    // Primera advertencia
    if(confirm("Advertencia 1: ¿Estás completamente seguro de que deseas eliminar a " + nombreCompleto + "?")) {
        // Segunda advertencia
        if(confirm("Advertencia 2: Esta acción es irreversible y los datos se perderán para siempre. ¿Confirmar eliminación?")) {
            
            // Si acepta ambas, se elimina
            $.post('app/controllers/ClienteController.php', { action: 'eliminar', id: id }, function(res) {
                if(res.success) {
                    listarClientes(); // Recargar la tabla para que desaparezca
                } else {
                    alert("No se pudo eliminar.");
                }
            }, 'json');
            
        }
    }
}
</script>