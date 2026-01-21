<?php require("layout/header.php"); ?>

<!-- Invoice view: list table and actions -->
<h1>FACTURAS</h1>
<br />
<table class="table table-striped table-hover" id="tabla">
    <thead>
        <!-- Invoice table header -->
        <tr class="text-center">
            <th>Id</th>
            <th>Cliente</th>
            <th>Numero</th>
            <th>Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php // Check if there are rows to display, and iterate through them 
        ?>
        <?php if ($facturas->filas): ?>
            <?php foreach ($facturas->filas as $fila): ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td>
                        <?php // Client Column: (ID - Nombre Apellido (email)); if client not in map, show id 
                        ?>
                        <?php
                        if (isset($clientesMap[$fila->cliente_id])) {
                            echo $clientesMap[$fila->cliente_id];
                        } else {
                            echo $fila->cliente_id;
                        }
                        ?>
                    </td>
                    <td><?php echo $fila->numero; ?></td>
                    <td><?php echo $fila->fecha; ?></td>
                    <td style="text-align: right; width: 50%;">
                        <!-- Invoice actions: edit, delete, view lines -->
                        <a href="index.php?c=facturas&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button>
                        </a>
                        <a href="index.php?c=facturas&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar" onclick="return confirm('¿Estás seguro de borrar el registro <?php echo $fila->id; ?>?');">Borrar</button>
                        </a>
                        <a href="index.php?c=lineas_facturas&factura_id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-info">Lineas</button>
                        </a>
                        <a href="index.php?c=lineas_facturas&m=exportarlineas&factura_id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-warning">Exportar(CSV)</button>
                        </a>
                        <a href="index.php?c=lineas_facturas&m=ImprimirLineas&factura_id=<?php echo $fila->id; ?>" target="_blank">
                            <button type="button" class="btn btn-primary">Imprimir</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <!-- Add new invoice -->
                <a href="index.php?c=facturas&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <a href="index.php?c=facturas&m=exportar">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
                <a href="index.php?c=facturas&m=exportarJSON">
                    <button type="button" class="btn btn-success">Exportar(JSON)</button>
                </a>
                <a href="index.php?c=facturas&m=imprimir" target="_blank">
                    <button type="button" class="btn btn-primary">Imprimir</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<?php require("layout/footer.php"); ?>