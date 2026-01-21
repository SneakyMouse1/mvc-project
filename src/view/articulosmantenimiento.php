<?php require("layout/header.php"); ?>
<h1>ARTICULOS</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>

<!-- Form for creating or editing an article -->
<!-- Action changes based on mode: INSERTAR or MODIFICAR -->
<form action="<?php echo 'index.php?c=articulos&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $articulo->id : 'insertar'); ?>" method="POST">

    <label for="referencia" class="form-label">Referencia</label>
    <input type="text" class="form-control" name="referencia" id="referencia"
        value="<?php echo ($opcion == 'EDITAR' ? $articulo->referencia : ''); ?>" required />
    <br />

    <label for="descripcion" class="form-label">Descripcion</label>
    <input type="text" class="form-control" name="descripcion" id="descripcion"
        value="<?php echo ($opcion == 'EDITAR' ? $articulo->descripcion : ''); ?>" required />
    <br />

    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01" class="form-control" name="precio" id="precio"
        value="<?php echo ($opcion == 'EDITAR' ? $articulo->precio : ''); ?>" required />
    <br />

    <label for="tipo_iva" class="form-label">Tipo IVA</label>
    <input type="number" step="0.01" class="form-control" name="tipo_iva" id="tipo_iva"
        value="<?php echo ($opcion == 'EDITAR' ? $articulo->tipo_iva : ''); ?>" required />
    <br />

    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=articulos'; ?>">
        <button type="button" class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>

</form>
<?php require("layout/footer.php"); ?>