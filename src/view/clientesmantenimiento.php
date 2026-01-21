<?php require("layout/header.php"); ?>
<!-- Client create/edit form: fields and actions -->
<h1>CLIENTES</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>

<!-- Client data input form -->
<!-- Action changes based on mode: INSERTAR or MODIFICAR -->
<form action="<?php echo 'index.php?c=clientes&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $cliente->id : 'insertar'); ?>" method="POST">

    <!-- Nombre-->
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control"
        name="nombre" id="nombre"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->nombre : ''); ?>" required />
    <br />

    <!-- Apellidos -->
    <label for="apellidos" class="form-label">Apellidos</label>
    <input type="text" class="form-control"
        name="apellidos" id="apellidos"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->apellidos : ''); ?>" required />
    <br />

    <!-- Email-->
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email" id="email"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->email : ''); ?>" required />
    <br />

    <!-- Contraseña-->
    <label for="contrasenya" class="form-label">Contrasenya</label>
    <input type="password" class="form-control" name="contrasenya" id="contrasenya"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->contrasenya : ''); ?>" required />
    <br />

    <!-- Dirección-->
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" class="form-control" name="direccion" id="direccion"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->direccion : ''); ?>" required />
    <br />

    <!-- CP-->
    <label for="cp" class="form-label">CP</label>
    <input type="text" class="form-control" name="cp" id="cp"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->cp : ''); ?>" required />
    <br />

    <!-- Población-->
    <label for="poblacion" class="form-label">Población</label>
    <input type="text" class="form-control" name="poblacion" id="poblacion"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->poblacion : ''); ?>" required />
    <br />

    <!-- Provincia-->
    <label for="provincia" class="form-label">Provincia</label>
    <input type="text" class="form-control" name="provincia" id="provincia"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->provincia : ''); ?>" required />
    <br />

    <!-- Fecha Nacimiento-->
    <label for="fecha_nac" class="form-label">Fecha Nacimiento</label>
    <input type="date" class="form-control" name="fecha_nac" id="fecha_nac"
        value="<?php echo ($opcion == 'EDITAR' ? $cliente->fecha_nac : ''); ?>" required />
    <br />


    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=clientes'; ?>">
        <button type="button" class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>
</form>
<?php require("layout/footer.php"); ?>