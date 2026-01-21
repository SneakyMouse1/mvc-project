<?php

/**
 * Main application file.
 * Includes configuration and controllers.
 * Implements simple routing via GET parameters: 'c' (controller) and 'm' (method).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("config.php");
require_once("controller/app.php");
require_once("controller/clientes.php");
require_once("controller/facturas.php");
require_once("controller/lineas_facturas.php");
require_once("controller/articulos.php");

$controlador = '';

// Check if controller parameter is present in URL
if (isset($_GET['c'])):
    $controlador = $_GET['c'];
    $metodo = $_GET['m'] ?? '';

    switch ($controlador):
        case 'clientes': // Routing: Clients controller
            $ctrl = new ClientesControlador();
            if ($metodo && method_exists($ctrl, $metodo)):
                $ctrl->{$metodo}();
            else:
                $ctrl->index();
            endif;
            break;

        case 'facturas': // Routing: Invoices controller
            $ctrl = new FacturasControlador();
            if ($metodo && method_exists($ctrl, $metodo)):
                $ctrl->{$metodo}();
            else:
                $ctrl->index();
            endif;
            break;

        case 'lineas_facturas': // Routing: Invoice Lines controller
            $ctrl = new LineasFacturasControlador();
            if ($metodo && method_exists($ctrl, $metodo)):
                $ctrl->{$metodo}();
            else:
                $ctrl->index();
            endif;
            break;

        case 'articulos': // Routing: Articles/Items controller
            $ctrl = new ArticulosControlador();
            if ($metodo && method_exists($ctrl, $metodo)):
                $ctrl->{$metodo}();
            else:
                $ctrl->index();
            endif;
            break;

        default: // Default controller
            $ctrl = new AppControlador();
            $ctrl->index();
    endswitch;
else:
    // If no controller is specified, run the main controller
    $ctrl = new AppControlador();
    $ctrl->index();
endif;
