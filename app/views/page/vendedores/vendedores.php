<link rel="stylesheet" href="public/css/home.css">
<section class="content">
    <div class="container-fluid">
        <div class="bloque-encabezado">
            <h2>Gestión de Vendedores / Usuarios</h2>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <button class="btn btn-primary" onclick="abrirModalCrear()">
                            <i class="material-icons">add</i> Nuevo Vendedor
                        </button>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre Completo</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaVendedores">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalVendedor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModal">Formulario</h4>
            </div>
            <div class="modal-body">
                <form id="formVendedor">
                    <input type="hidden" id="vendedor_id" name="id">
                    
                    <label for="cedula">Cédula</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control" name="cedula" id="cedula" placeholder="Ingrese la cédula" required>
                        </div>
                    </div>

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

                    <label for="password">Contraseña</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="password" id="password" placeholder="Ingrese la contraseña" required>
                        </div>
                    </div>
                    
                    <label>Rol del Sistema</label>
                    <div class="form-group">
                        <select class="form-control show-tick" name="cod_rol" id="cod_rol" required>
                            <option value="">Seleccione un rol...</option>
                            <option value="1">Administrador (Acceso Total)</option>
                            <option value="2">Vendedor (Acceso Limitado)</option>
                        </select>
                    </div>

                    <label>Estado de la Cuenta</label>
                    <div class="form-group">
                        <select class="form-control show-tick" name="status" id="status" required>
                            <option value="1">Activo (Permitir ingreso)</option>
                            <option value="0">Inactivo / Bloqueado</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" onclick="guardarVendedor()">GUARDAR</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

<script>
let accionActual = 'crear'; 

$(document).ready(function() {
    listarVendedores();
});

function listarVendedores() {
    $.post('app/controllers/VendedorController.php', { action: 'listar' }, function(response) {
        let html = '';
        response.data.forEach(v => {
            let nombreRol = (v.cod_rol == 1) ? '<span class="label bg-red">Administrador</span>' : '<span class="label bg-blue">Vendedor</span>';
            let statusBadge = (v.status == 1) ? '<span class="label bg-green">Activo</span>' : '<span class="label bg-grey">Inactivo</span>';
            
            html += `<tr>
                <td>${v.cedula}</td>
                <td>${v.nombre} ${v.apellido}</td>
                <td>${nombreRol}</td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-xs btn-warning" onclick='abrirModalEditar(${JSON.stringify(v)})' title="Modificar"><i class="material-icons">edit</i></button>
                    <button class="btn btn-xs btn-danger" onclick="eliminarVendedor(${v.id}, '${v.nombre}')" title="Eliminar"><i class="material-icons">delete</i></button>
                </td>
            </tr>`;
        });
        $('#tablaVendedores').html(html);
    }, 'json');
}

function abrirModalCrear() {
    accionActual = 'crear';
    $('#tituloModal').text('Registrar Nuevo Vendedor');
    $('#formVendedor')[0].reset();
    $('#vendedor_id').val('');
    $('#modalVendedor').modal('show');
}

function abrirModalEditar(vendedor) {
    accionActual = 'editar';
    $('#tituloModal').text('Personalizar Datos');
    
    $('#vendedor_id').val(vendedor.id);
    $('#cedula').val(vendedor.cedula);
    $('#nombre').val(vendedor.nombre);
    $('#apellido').val(vendedor.apellido);
    $('#password').val(vendedor.password);
    $('#cod_rol').val(vendedor.cod_rol);
    $('#status').val(vendedor.status);
    
    $('#modalVendedor').modal('show');
}

function guardarVendedor() {
    let datos = $('#formVendedor').serialize() + '&action=' + accionActual;
    
    $.post('app/controllers/VendedorController.php', datos, function(res) {
        if(res.success) {
            $('#modalVendedor').modal('hide');
            listarVendedores(); 
        } else {
            alert("Error al procesar la solicitud.");
        }
    }, 'json');
}

function eliminarVendedor(id, nombre) {
    if(confirm("Advertencia 1: ¿Estás seguro de que deseas eliminar al usuario " + nombre + "?")) {
        if(confirm("Advertencia 2: Esta acción eliminará su acceso al sistema por completo. ¿Confirmar?")) {
            $.post('app/controllers/VendedorController.php', { action: 'eliminar', id: id }, function(res) {
                if(res.success) {
                    listarVendedores(); 
                } else {
                    alert("No se pudo eliminar.");
                }
            }, 'json');
        }
    }
}
</script>