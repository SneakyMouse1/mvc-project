<?php require("layout/header.php"); ?>

<!-- Invoice create/edit form: client selection and invoice fields -->
<h1>FACTURAS</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>

<!-- Invoice data form -->
<!-- Action changes based on mode: INSERTAR or MODIFICAR -->
<form action="<?php echo 'index.php?c=facturas&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $factura->id : 'insertar'); ?>" method="POST">

    <!-- Select Client -->
    <label for="cliente_id" class="form-label">Cliente</label>
    <select class="form-control" name="cliente_id" id="cliente_id" required>
        <?php // Fill select with client list, marking selected one when editing 
        ?>
        <?php if ($clientes && $clientes->filas): ?>
            <?php foreach ($clientes->filas as $c): ?>
                <option value="<?php echo $c->id; ?>" <?php echo ($opcion == 'EDITAR' && isset($factura) && $factura->cliente_id == $c->id ? 'selected' : ''); ?>>
                    <?php echo $c->id . ' - ' . $c->nombre . ' ' . $c->apellidos . ' (' . $c->email . ')'; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <br />

    <!-- Invoice Number -->
    <label for="numero" class="form-label">Numero</label>
    <input type="text" class="form-control"
        name="numero" id="numero"
        value="<?php echo ($opcion == 'EDITAR' ? $factura->numero : ''); ?>" required />
    <br />

    <!-- Invoice Date -->
    <label for="fecha" class="form-label">Fecha</label>
    <input type="datetime-local" class="form-control" name="fecha" id="fecha"
        value="<?php echo ($opcion == 'EDITAR' ? $factura->fecha : ''); ?>" />
    <br />

    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=facturas'; ?>">
        <button type="button" class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>

</form>

<?php require("layout/footer.php"); ?>