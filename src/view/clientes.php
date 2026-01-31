<?php require("layout/header.php"); ?>
<!-- Client view: list table and actions -->
<h1>CLIENTES</h1>
<br />
<table class="table table-striped table-hover" id="tabla">
    <thead>
        <!-- Table header with client columns -->
        <tr class="text-center">
            <th class="bg-primary">Id</th>
            <th class="text-uppercase">Nombre</th>
            <th>Apellidos</th>
            <th class="border shadow-lg p-3 mb-5 bg-body-tertiary rounded">Email</th>
            <th>Contraseña</th>
            <th>Dirección</th>
            <th>CP</th>
            <th>Población</th>
            <th>Provincia</th>
            <th>Fecha Nacimiento</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($clientes->filas): ?>
            <?php foreach ($clientes->filas as $fila): ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->nombre; ?></td>
                    <td><?php echo $fila->apellidos; ?></td>
                    <td><?php echo $fila->email; ?></td>
                    <td><?php echo $fila->contrasenya; ?></td>
                    <td><?php echo $fila->direccion; ?></td>
                    <td><?php echo $fila->cp; ?></td>
                    <td><?php echo $fila->poblacion; ?></td>
                    <td><?php echo $fila->provincia; ?></td>
                    <td><?php echo $fila->fecha_nac; ?></td>
                    <td style="text-align: right; width: 20%;">
                        <!-- Actions: edit, delete, view invoices -->
                        <a href="index.php?c=clientes&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button>
                        </a>
                        <a href="index.php?c=clientes&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar" onclick="return confirm('¿Estás seguro de borrar el registro <?php echo $fila->id; ?>?');">Borrar</button>
                        </a>
                        <a href="index.php?c=clientes&m=facturas&cliente_id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-info">Facturas</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <!-- Add new client -->
                <a href="index.php?c=clientes&m=nuevo">
                    <button type="button" class="btn btn-success text-uppercase">Nuevo</button>
                </a>
                <a href="index.php?c=clientes&m=exportar">
                    <button type="button" class="btn btn-success">Exportar(CSV)</button>
                </a>
                <a href="index.php?c=clientes&m=exportarjson">
                    <button type="button" class="btn btn-success">Exportar(JSON)</button>
                </a>
                <a href="index.php?c=clientes&m=imprimir" target="_blank">
                    <button type="button" class="btn btn-primary">Imprimir</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>

<?php require("layout/footer.php"); ?>
