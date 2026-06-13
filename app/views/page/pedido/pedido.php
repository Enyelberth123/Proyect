<link rel="stylesheet" href="public/css/home.css">
<style>
    .content .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    .bloque-encabezado {
        margin-bottom: 10px;
    }
    .card {
        margin-bottom: 15px;
    }
    .card .header {
        padding: 12px 15px;
    }
    .card .body {
        padding: 12px 15px;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="bloque-encabezado">
            <h2>Gestión de Pedidos</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <button class="btn btn-primary" onclick="abrirModalCrear()">
                            <i class="material-icons">add</i> Nuevo Pedido
                        </button>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaPedidos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModal">Formulario de Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="formPedido">
                    <input type="hidden" id="pedido_id" name="id">

                    <label for="id_cliente">Cliente</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control show-tick" name="id_cliente" id="id_cliente" required>
                                <option value="">Seleccione un cliente</option>
                            </select>
                        </div>
                    </div>

                    <label for="id_vendedor">Vendedor</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control show-tick" name="id_vendedor" id="id_vendedor" required>
                                <option value="">Seleccione un vendedor</option>
                            </select>
                        </div>
                    </div>

                    <label for="fecha">Fecha</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                    </div>

                    <label for="total">Total</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="total" id="total" placeholder="Monto total" required>
                        </div>
                    </div>

                    <label for="id_estatus">Estatus</label>
                    <div class="form-group">
                        <select class="form-control show-tick" name="id_estatus" id="id_estatus" required>
                            <option value="">Seleccione estatus</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" onclick="guardarPedido()">GUARDAR</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

<script>
let accionActual = 'crear';

$(document).ready(function() {
    cargarCombos();
    listarPedidos();
});

function cargarCombos() {
    $.post('app/controllers/PedidosController.php', { action: 'clientes' }, function(resp) {
        if (resp && resp.success) {
            let html = '<option value="">Seleccione un cliente</option>';
            resp.data.forEach(function(c) {
                html += '<option value="' + c.id + '">' + c.nombre + ' ' + c.apellido + '</option>';
            });
            $('#id_cliente').html(html);
        }
    }, 'json');

    $.post('app/controllers/PedidosController.php', { action: 'vendedores' }, function(resp) {
        if (resp && resp.success) {
            let html = '<option value="">Seleccione un vendedor</option>';
            resp.data.forEach(function(v) {
                html += '<option value="' + v.id + '">' + v.nombre + ' ' + v.apellido + '</option>';
            });
            $('#id_vendedor').html(html);
        }
    }, 'json');

    $.post('app/controllers/PedidosController.php', { action: 'estatus' }, function(resp) {
        if (resp && resp.success) {
            let html = '<option value="">Seleccione estatus</option>';
            resp.data.forEach(function(e) {
                html += '<option value="' + e.id + '">' + e.nombre + '</option>';
            });
            $('#id_estatus').html(html);
        }
    }, 'json');
}

function listarPedidos() {
    $.post('app/controllers/PedidosController.php', { action: 'listar' }, function(resp) {
        if (!resp || !resp.success) {
            $('#tablaPedidos').html('<tr><td colspan="7" style="text-align:center; color:#999">No se pudieron cargar los pedidos</td></tr>');
            return;
        }

        if (!resp.data || resp.data.length === 0) {
            $('#tablaPedidos').html('<tr><td colspan="7" style="text-align:center; color:#999">No hay pedidos cargados aún</td></tr>');
            return;
        }

        let html = '';
        resp.data.forEach(function(p) {
            html += '<tr>' +
                '<td>' + p.id + '</td>' +
                '<td>' + (p.cliente || '-') + '</td>' +
                '<td>' + (p.vendedor || '-') + '</td>' +
                '<td>' + p.fecha + '</td>' +
                '<td>$' + Number(p.total || 0).toFixed(2) + '</td>' +
                '<td>' + (p.estatus || '-') + '</td>' +
                '<td>' +
                    '<button class="btn btn-xs btn-warning" title="Editar" onclick="abrirModalEditar(' + p.id + ')"><i class="material-icons">edit</i></button> ' +
                    '<button class="btn btn-xs btn-danger" title="Eliminar" onclick="eliminarPedido(' + p.id + ')"><i class="material-icons">delete</i></button>' +
                '</td>' +
                '</tr>';
        });
        $('#tablaPedidos').html(html);
    }, 'json');
}

function abrirModalCrear() {
    accionActual = 'crear';
    $('#tituloModal').text('Registrar Nuevo Pedido');
    $('#formPedido')[0].reset();
    $('#pedido_id').val('');
    $('#modalPedido').modal('show');
}

function abrirModalEditar(id) {
    accionActual = 'editar';
    $('#tituloModal').text('Editar Pedido');
    $('#pedido_id').val(id);

    $.post('app/controllers/PedidosController.php', { action: 'listar' }, function(resp) {
        if (resp && resp.success && resp.data) {
            let pedido = resp.data.find(function(item) { return item.id == id; });
            if (pedido) {
                $('#id_cliente').val(pedido.id_cliente || '');
                $('#id_vendedor').val(pedido.id_vendedor || '');
                $('#fecha').val(pedido.fecha || '');
                $('#total').val(pedido.total || '');
                $('#id_estatus').val(pedido.id_estatus || '');
                $('#modalPedido').modal('show');
            }
        }
    }, 'json');
}

function eliminarPedido(id) {
    if (!confirm('¿Desea eliminar este pedido?')) {
        return;
    }

    $.post('app/controllers/PedidosController.php', { action: 'eliminar', id: id }, function(res) {
        if (res && res.success) {
            listarPedidos();
            alert(res.message || 'Pedido eliminado correctamente');
        } else {
            alert(res && res.message ? res.message : 'No se pudo eliminar el pedido');
        }
    }, 'json');
}

function guardarPedido() {
    let datos = $('#formPedido').serialize() + '&action=' + accionActual;

    $.post('app/controllers/PedidosController.php', datos, function(res) {
        if (res && res.success) {
            $('#modalPedido').modal('hide');
            $('#formPedido')[0].reset();
            listarPedidos();
            alert(res.message || 'Pedido guardado correctamente');
        } else {
            alert(res && res.message ? res.message : 'No se pudo guardar el pedido');
        }
    }, 'json');
}
</script>
