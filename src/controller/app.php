<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("model/clientes.php");
require_once("model/facturas.php");

/**
 * Main Application Controller
 */
class AppControlador
{
    /**
     * Default method (entry point).
     *
     * Loads lists of clients and invoices for the dashboard and prepares
     * the client map for display.
     *
     * @return void
     */
    public static function index()
    {
        // Load lists of clients and invoices for the dashboard
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        $facturas = new FacturasModelo();
        // $facturas->Seleccionar();

        // Create a map of clients by ID for easy name lookup in the invoice list
        $clientesMap = [];
        if ($clientes && $clientes->filas) {
            foreach ($clientes->filas as $cli) {
                $clientesMap[$cli->id] = $cli->nombre . ' ' . $cli->apellidos;
            }
        }

        require_once("view/app.php");
    }
}
