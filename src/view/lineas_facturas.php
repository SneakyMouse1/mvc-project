<?php require("layout/header.php"); ?>
<!-- Invoice lines view: items table and actions -->
<h1>LINEAS FACTURAS</h1>
<br />
<table class="table table-striped table-hover" id="tabla">
    <thead>
        <!-- Invoice line table header -->
        <tr class="text-center">
            <th>Id</th>
            <th>Factura</th>
            <th>Referencia</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>IVA</th>
            <th>Importe</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($lineas->filas): ?>
            <?php // foreach: iterate through all lines (lineas) of the specified invoice and display fields 
            ?>
            <?php foreach ($lineas->filas as $fila): ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->factura_id; ?></td>
                    <td><?php echo $fila->referencia; ?></td>
                    <td><?php echo $fila->descripcion; ?></td>
                    <td><?php echo $fila->cantidad; ?></td>
                    <td><?php echo $fila->precio; ?></td>
                    <td><?php echo $fila->iva; ?></td>
                    <td><?php echo $fila->importe; ?></td>
                    <td style="text-align: right; width: 50%;">
                        <!-- Invoice line actions: edit, delete -->
                        <a href="index.php?c=lineas_facturas&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button>
                        </a>
                        <a href="index.php?c=lineas_facturas&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar" onclick="return confirm('¿Estás seguro de borrar el registro <?php echo $fila->id; ?>?');">Borrar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <!-- Add new invoice line -->
                <a href="index.php?c=lineas_facturas&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <a href="index.php?c=lineas_facturas&m=exportarlineas">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
                <a href="index.php?c=lineas_facturas&m=imprimirlineas" target="_blank">
                    <button type="button" class="btn btn-primary">Imprimir</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<?php require("layout/footer.php"); ?>