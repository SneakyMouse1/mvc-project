<?php require("layout/header.php"); ?>
<h1>ARTICULOS</h1>
<br />
<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Referencia</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Tipo IVA</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($articulos->filas): ?>
            <?php foreach ($articulos->filas as $fila): ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->referencia; ?></td>
                    <td><?php echo $fila->descripcion; ?></td>
                    <td><?php echo $fila->precio; ?></td>
                    <td><?php echo $fila->tipo_iva; ?></td>
                    <td style="text-align: right; width: 30%;">
                        <!-- Edit button -->
                        <a href="index.php?c=articulos&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button>
                        </a>
                        <!-- Delete button with confirmation -->
                        <a href="index.php?c=articulos&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar" onclick="return confirm('¿Estás seguro de borrar el registro <?php echo $fila->id; ?>?');">Borrar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <!-- Create new item button -->
                <a href="index.php?c=articulos&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <!-- Export to CSV button -->
                <a href="index.php?c=articulos&m=exportar">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
                <!-- Export to JSON button -->
                <a href="index.php?c=articulos&m=exportarJSON">
                    <button type="button" class="btn btn-success">Exportar(JSON)</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<?php require("layout/footer.php"); ?>