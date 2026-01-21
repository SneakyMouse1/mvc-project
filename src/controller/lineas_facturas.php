<?php

/**
 * Invoice Lines Controller.
 *
 * Handles CRUD operations on invoice lines (items within an invoice).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("model/lineas_facturas.php");
require_once("model/facturas.php");

class LineasFacturasControlador
{
    /**
     * Display list of invoice lines.
     *
     * Retrieves all invoice lines from the model, optionally filtered by 'factura_id' (GET),
     * and renders the list view.
     *
     * @return void
     */
    static function index()
    {
        $lineas = new LineasFacturasModelo();
        if (isset($_GET['factura_id'])) {
            $lineas->factura_id = $_GET['factura_id'];
        }
        $lineas->Seleccionar();

        require_once("view/lineas_facturas.php");
    }

    /**
     * Show form to create a new invoice line.
     *
     * Sets the maintenance mode to 'NUEVO', loads the list of invoices for selection,
     * and displays the maintenance view.
     *
     * @return void
     */
    function Nuevo()
    {
        $opcion = 'NUEVO'; // Option to create a new line
        $facturasList = new FacturasModelo();
        $facturasList->Seleccionar();
        require_once("view/lineas_facturasmantenimiento.php");
    }

    /**
     * Save a new invoice line.
     *
     * Reads POST data and inserts the new line into the database.
     * Redirects to the index on success or shows an error.
     *
     * @return void
     */
    function Insertar()
    {
        $linea = new LineasFacturasModelo();
        $linea->factura_id = $_POST['factura_id'];
        $linea->referencia = $_POST['referencia'];
        $linea->descripcion = $_POST['descripcion'];
        $linea->cantidad = $_POST['cantidad'];
        $linea->precio = $_POST['precio'];
        $linea->iva = $_POST['iva'];

        if ($linea->Insertar() == 1) {
            header("location:" . URLSITE . '?c=lineas_facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $linea->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Show form to edit an existing invoice line.
     *
     * Loads the line record by ID (from GET) and the list of invoices.
     * Sets the maintenance mode to 'EDITAR'.
     *
     * @return void
     */
    function Editar()
    {
        $linea = new LineasFacturasModelo();
        $linea->id = $_GET['id'];
        $opcion = 'EDITAR'; // Option to edit line

        if ($linea->Seleccionar()) {
            $facturasList = new FacturasModelo();
            $facturasList->Seleccionar();
            require_once("view/lineas_facturasmantenimiento.php");
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $linea->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Apply changes to an invoice line.
     *
     * Updates an existing invoice line record with data from POST.
     * Redirects to the index on success or displays an error.
     *
     * @return void
     */
    function Modificar()
    {
        $linea = new LineasFacturasModelo();
        $linea->id = $_GET['id'];
        $linea->factura_id = $_POST['factura_id'];
        $linea->referencia = $_POST['referencia'];
        $linea->descripcion = $_POST['descripcion'];
        $linea->cantidad = $_POST['cantidad'];
        $linea->precio = $_POST['precio'];
        $linea->iva = $_POST['iva'];

        if (($linea->Modificar() == 1) || ($linea->GetError() == '')) {
            header("location:" . URLSITE . '?c=lineas_facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $linea->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Delete an invoice line.
     *
     * Removes the invoice line specified by ID (from GET) from the database.
     * Redirects to the index on success.
     *
     * @return void
     */
    function Borrar()
    {
        $linea = new LineasFacturasModelo();
        $linea->id = $_GET['id'];

        if ($linea->Borrar() == 1) {
            header("location:" . URLSITE . '?c=lineas_facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $linea->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Export lines of a specific invoice to CSV.
     *
     * Generates a CSV file containing the lines of the invoice specified by 'factura_id'
     * and initiates a download.
     *
     * @return void
     */
    static function exportarlineas()
    {
        $lineas = new LineasFacturasModelo();
        $lineas->Seleccionar();

        $factura_id_actual = $_GET['factura_id'];
        $nombreArchivo = "datos_factura_" . $factura_id_actual . ".csv";

        try {
            $fichero = fopen($nombreArchivo, "w");

            foreach ($lineas->filas as $fila) {
                $cadena = "$fila->id;$fila->factura_id;$fila->referencia;$fila->descripcion;$fila->cantidad;$fila->precio;$fila->iva;$fila->importe\n";
                fputs($fichero, $cadena);
            }
        } finally {
            fclose($fichero);
        }

        $rutaFichero = $nombreArchivo;
        $fichero = basename($rutaFichero);

        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=\"$fichero\"");

        readfile($rutaFichero);
    }

    static function ImprimirLineas()
    {
        // Stub for printing lines
    }
}
