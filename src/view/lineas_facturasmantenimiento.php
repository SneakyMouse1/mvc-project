<?php require("layout/header.php"); ?>
<?php // Dynamic form for invoice lines: choose insertar or modificar based on $opcion 
?>

<!-- Invoice line add/edit form: invoice selection and item parameters -->
<h1>LINEAS FACTURAS</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>

<!-- Invoice line data form -->
<!-- Action changes based on mode: INSERTAR or MODIFICAR -->
<form action="<?php echo 'index.php?c=lineas_facturas&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $linea->id : 'insertar'); ?>" method="POST">

    <!-- Select Invoice (Factura) -->
    <label for="factura_id" class="form-label">Factura</label>
    <select class="form-control" name="factura_id" id="factura_id" required>
        <?php // Invoice list to select current (mark selected when editing) 
        ?>
        <?php if (isset($facturasList) && $facturasList->filas): ?>
            <?php foreach ($facturasList->filas as $f): ?>
                <option value="<?php echo $f->id; ?>" <?php echo ($opcion == 'EDITAR' && isset($linea) && $linea->factura_id == $f->id ? 'selected' : ''); ?>>
                    <?php echo $f->id . ' - ' . $f->numero; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <br />

    <!-- Referencia -->
    <label for="referencia" class="form-label">Referencia</label>
    <input type="text" class="form-control"
        name="referencia" id="referencia"
        value="<?php echo ($opcion == 'EDITAR' ? $linea->referencia : ''); ?>" required />
    <br />

    <!-- Descripcion -->
    <label for="descripcion" class="form-label">Descripcion</label>
    <input type="text" class="form-control" name="descripcion" id="descripcion"
        value="<?php echo ($opcion == 'EDITAR' ? $linea->descripcion : ''); ?>" />
    <br />

    <!-- Cantidad -->
    <label for="cantidad" class="form-label">Cantidad</label>
    <input type="number" step="0.01" class="form-control" name="cantidad" id="cantidad"
        value="<?php echo ($opcion == 'EDITAR' ? $linea->cantidad : ''); ?>" required />
    <br />

    <!-- Precio -->
    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01" class="form-control" name="precio" id="precio"
        value="<?php echo ($opcion == 'EDITAR' ? $linea->precio : ''); ?>" required />
    <br />

    <!-- IVA -->
    <label for="iva" class="form-label">IVA</label>
    <input type="number" step="0.01" class="form-control" name="iva" id="iva"
        value="<?php echo ($opcion == 'EDITAR' ? $linea->iva : ''); ?>" required />
    <br />

    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=lineas_facturas'; ?>">
        <button type="button" class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>
</form>

<?php require("layout/footer.php"); ?>