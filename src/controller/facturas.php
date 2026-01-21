<?php

/**
 * Invoices Controller.
 *
 * Handles listing, adding, editing, and deleting invoices (facturas).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("model/facturas.php");
require_once("model/lineas_facturas.php");
require_once("model/clientes.php");

class FacturasControlador
{
    /**
     * Display list of invoices.
     *
     * Retrieves invoices from the model (filtering by 'cliente_id' if present in GET)
     * and prepares the client map for display in the view.
     *
     * @return void
     */
    static function index()
    {
        // Get invoice list; if cliente_id is present, filter by it
        $facturas = new FacturasModelo();
        if (isset($_GET['cliente_id'])) {
            $facturas->cliente_id = $_GET['cliente_id'];
        }
        $facturas->Seleccionar();

        // Prepare client map for convenient display in the invoice table
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();
        $clientesMap = [];

        if ($clientes && $clientes->filas) {
            // foreach: iterate through all clients and form the $clientesMap
            // Key is client ID, value is string like (ID - Nombre Apellido (email))
            foreach ($clientes->filas as $cli) {
                $clientesMap[$cli->id] = '(' . $cli->id . ' - ' . $cli->nombre . ' ' . $cli->apellidos . ' (' . $cli->email . '))';
            }
        }

        require_once("view/facturas.php");
    }

    /**
     * Show form to create a new invoice.
     *
     * Sets the maintenance mode to 'NUEVO' and loads the list of clients
     * for the selection dropdown in the view.
     *
     * @return void
     */
    function Nuevo()
    {
        $opcion = 'NUEVO'; // Show form to add invoice
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();
        require_once("view/facturasmantenimiento.php");
    }

    /**
     * Save a new invoice.
     *
     * Reads POST data, creates a new Invoice model instance, and attempts to
     * insert it into the database. Redirects to the index on success or shows an error.
     *
     * @return void
     */
    function Insertar()
    {
        $factura = new FacturasModelo();
        $factura->cliente_id = $_POST['cliente_id'];
        $factura->numero = $_POST['numero'];
        $factura->fecha = $_POST['fecha'];

        if ($factura->Insertar() == 1) {
            header("location:" . URLSITE . '?c=facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $factura->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Show form to edit an existing invoice.
     *
     * Loads the invoice record by ID (from GET) and the list of clients.
     * Sets the maintenance mode to 'EDITAR'.
     *
     * @return void
     */
    function Editar()
    {
        $factura = new FacturasModelo();
        $factura->id = $_GET['id'];
        $opcion = 'EDITAR'; // Show form to edit invoice

        if ($factura->Seleccionar()) {
            $clientes = new ClientesModelo();
            $clientes->Seleccionar();
            require_once("view/facturasmantenimiento.php");
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $factura->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Apply changes to an invoice.
     *
     * Updates an existing invoice record with data from POST.
     * Redirects to the index on success or displays an error message on failure.
     *
     * @return void
     */
    function Modificar()
    {
        // Save invoice changes
        $factura = new FacturasModelo();
        $factura->id = $_GET['id'];
        $factura->cliente_id = $_POST['cliente_id'];
        $factura->numero = $_POST['numero'];
        $factura->fecha = $_POST['fecha'];

        // Check for success or absence of errors
        if (($factura->Modificar() == 1) || ($factura->GetError() == '')) {
            header("location:" . URLSITE . '?c=facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $factura->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Delete an invoice.
     *
     * Removes the invoice specified by ID (from GET) from the database.
     * Redirects to the index on success.
     *
     * @return void
     */
    function Borrar()
    {
        // Delete invoice by ID
        $factura = new FacturasModelo();
        $factura->id = $_GET['id'];

        if ($factura->Borrar() == 1) {
            header("location:" . URLSITE . '?c=facturas');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $factura->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Export invoices to CSV.
     *
     * Generates a 'facturas.csv' file on the server containing all invoice data
     * and initiates a download for the user.
     *
     * @return void
     */
    static function Exportar()
    {
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        try {
            $fichero = fopen("facturas.csv", "w");

            foreach ($facturas->filas as $fila) {
                $cadena = "$fila->id;$fila->cliente_id;$fila->numero;$fila->fecha\n";
                fputs($fichero, $cadena);
            }
        } finally {
            fclose($fichero);
        }

        $rutaFichero = "facturas.csv";
        $fichero = basename($rutaFichero);

        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=\"$fichero\"");

        readfile($rutaFichero);
    }

    /**
     * Export invoices to JSON.
     *
     * Encodes the invoice list to JSON format, saves it to 'facturas.json',
     * and initiates a download for the user.
     *
     * @return void
     */
    static function ExportarJSON()
    {
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        // Convert data to JSON
        $json = json_encode($facturas->filas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Save to file
        $ruta = "facturas.json";
        file_put_contents($ruta, $json);

        // Send file to user
        header("Content-Type: application/json");
        header("Content-Disposition: attachment; filename=\"facturas.json\"");
        header("Content-Length: " . filesize($ruta));

        readfile($ruta);
    }

    /**
     * Generate PDF list of invoices.
     *
     * Uses the FPDF library (via FacturasPDF) to generate a printable
     * PDF document listing all invoices with client names.
     *
     * @return void
     */
    static function Imprimir()
    {
        require_once("pdfs/facturas.php");
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        $clientes = new ClientesModelo();
        $clientes->Seleccionar();
        $clientesMap = [];

        foreach ($clientes->filas as $cli) {
            $clientesMap[$cli->id] = '(' . $cli->id . ' - ' . $cli->nombre . ' ' . $cli->apellidos . ' (' . $cli->email . '))';
        }

        $pdf = new FacturasPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->filas = $facturas->filas;
        $pdf->clientesMap = $clientesMap;

        $pdf->Imprimir();
        $pdf->Output();
    }
}
