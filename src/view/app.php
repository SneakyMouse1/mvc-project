<?php require 'layout/header.php'; ?>
<?php // Main page: display 2 columns — clients and invoices 
?>

<div class="row">
    <div class="col-md-6">
        <h2>Cliente:</h2>
        <?php if (isset($clientes) && $clientes->filas): ?>
            <ul class="list-group">
                <?php foreach ($clientes->filas as $c): ?>
                    <li class="list-group-item">
                        <?php // Format: (ID) Nombre Apellido, email 
                        ?>
                        (<?php echo 'ID: ' . $c->id; ?>) <?php echo $c->nombre . ' ' . $c->apellidos; ?>, <?php echo $c->email; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No clients to display.</p>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h2>Facturas:</h2>
        <?php if (isset($facturas) && $facturas->filas): ?>
            <ul class="list-group">
                <?php foreach ($facturas->filas as $f): ?>
                    <li class="list-group-item">
                        <?php // Format: ID - Numero - Cliente - Fecha; Get Client from $clientesMap if available 
                        ?>
                        <?php
                        $clienteNombre = isset($clientesMap[$f->cliente_id]) ? $clientesMap[$f->cliente_id] : $f->cliente_id;
                        ?>
                        <?php echo $f->id; ?> - <?php echo $f->numero; ?> - <?php echo $clienteNombre; ?> - <?php echo $f->fecha; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No invoices to display.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'layout/footer.php'; ?>