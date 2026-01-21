<?php

/**
 * Clients Controller.
 *
 * Handles CRUD operations on clients.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("model/clientes.php");
require_once("model/facturas.php");
require_once("model/articulos.php");
require("crypt.php");
require_once("lib/JSON.php");

class ClientesControlador
{
    /**
     * Display list of clients.
     *
     * Retrieves all clients from the model, decrypts passwords for display,
     * and renders the client list view.
     *
     * @return void
     */
    static function index()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        // --- DECRYPTION FOR DISPLAY IN TABLE ---
        // Iterate through $clientes->filas (where the model stores the list)
        if (isset($clientes->filas) && is_array($clientes->filas)) {
            foreach ($clientes->filas as $fila) {
                // Decrypt password for display (if needed) or other encrypted fields
                // In this case, we decrypt 'contrasenya' (password), although usually passwords are not decrypted for display
                $fila->contrasenya = Crypt::Desencriptar($fila->contrasenya);
            }
        }
        // --- END DECRYPTION ---

        require_once("view/clientes.php");
    }

    /**
     * Show form to create a new client.
     *
     * Sets the maintenance mode to 'NUEVO' and loads the maintenance view.
     *
     * @return void
     */
    function Nuevo()
    {
        $opcion = 'NUEVO'; // Option to create a new client
        require_once("view/clientesmantenimiento.php");
    }

    /**
     * Save a new client.
     *
     * Reads POST data, encrypts the password, and inserts the client into the DB.
     * Redirects to the index on success or shows an error.
     *
     * @return void
     */
    function Insertar()
    {
        $cliente = new ClientesModelo();
        $cliente->nombre = $_POST['nombre'];
        $cliente->apellidos = $_POST['apellidos'];
        $cliente->email = $_POST['email'];

        $cliente->contrasenya = Crypt::Encriptar($_POST['contrasenya']);
        $cliente->direccion = $_POST['direccion'];

        $cliente->cp = $_POST['cp'];
        $cliente->poblacion = $_POST['poblacion'];
        $cliente->provincia = $_POST['provincia'];
        $cliente->fecha_nac = $_POST['fecha_nac'];

        if ($cliente->Insertar() == 1) {
            header("location:" . URLSITE . '?c=clientes');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Show form to edit an existing client.
     *
     * Loads the client record by ID (from GET) and sets the maintenance mode to 'EDITAR'.
     *
     * @return void
     */
    function Editar()
    {
        $cliente = new ClientesModelo();
        $cliente->id = $_GET['id'];
        $opcion = 'EDITAR'; // Option to edit client

        if ($cliente->seleccionar()) {
            require_once("view/clientesmantenimiento.php");
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Apply changes to a client.
     *
     * Updates an existing client record with data from POST, including password encryption.
     * Redirects to the index on success or displays an error.
     *
     * @return void
     */
    function Modificar()
    {
        $cliente = new ClientesModelo();
        $cliente->id = $_GET['id'];
        $cliente->nombre = $_POST['nombre'];
        $cliente->apellidos = $_POST['apellidos'];
        $cliente->email = $_POST['email'];
        $cliente->contrasenya = Crypt::Encriptar($_POST['contrasenya']);
        $cliente->direccion = $_POST['direccion'];
        $cliente->cp = $_POST['cp'];
        $cliente->poblacion = $_POST['poblacion'];
        $cliente->provincia = $_POST['provincia'];
        $cliente->fecha_nac = $_POST['fecha_nac'];

        // If data didn't change, Modificar method might return 0.
        // So we also check for absence of errors.
        if (($cliente->Modificar() == 1) || ($cliente->GetError() == '')) {
            header("location:" . URLSITE . '?c=clientes');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Delete a client.
     *
     * Removes the client specified by ID (from GET) from the database.
     * Redirects to the index on success.
     *
     * @return void
     */
    function Borrar()
    {
        $cliente = new ClientesModelo();
        $cliente->id = $_GET['id'];

        if ($cliente->Borrar() == 1) {
            header("location:" . URLSITE . '?c=clientes');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Display invoices for a specific client.
     *
     * Retrieves invoices filtered by 'cliente_id' (from GET) and prepares the view.
     *
     * @return void
     */
    public function facturas()
    {
        $facturas = new FacturasModelo();
        if (isset($_GET['cliente_id'])) {
            $facturas->cliente_id = $_GET['cliente_id'];
        }
        $facturas->Seleccionar();

        // Prepare client map for name display
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();
        $clientesMap = [];

        if ($clientes && $clientes->filas) {
            foreach ($clientes->filas as $cli) {
                $clientesMap[$cli->id] = '(' . $cli->id . ' - ' . $cli->nombre . ' ' . $cli->apellidos . ' (' . $cli->email . '))';
            }
        }

        require_once("view/facturas.php");
    }

    public function articulos()
    {
        $articulos = new ArticulosModelo();
        $articulos->Seleccionar();

        require_once("view/articulos.php");
    }

    /**
     * Export clients to CSV.
     *
     * Generates a 'clientes.csv' file on the server containing all client data
     * and initiates a download for the user.
     *
     * @return void
     */
    static function Exportar()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        try {
            $fichero = fopen("clientes.csv", "w");

            foreach ($clientes->filas as $fila) {
                $cadena = "$fila->id;$fila->nombre;$fila->apellidos;$fila->email;$fila->direccion;$fila->cp;$fila->poblacion;$fila->provincia\n";
                fputs($fichero, $cadena);
            }
        } finally {
            fclose($fichero);
        }

        $rutaFichero = "clientes.csv";
        $fichero = basename($rutaFichero);

        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=\"$fichero\"");

        readfile($rutaFichero);
    }

    /**
     * Export clients to JSON.
     *
     * Encodes the client list to JSON format, saves it to 'clientes.json',
     * and initiates a download for the user.
     *
     * @return void
     */
    static function ExportarJSON()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        // Convert data to JSON
        $json = json_encode($clientes->filas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Save to file
        $ruta = "clientes.json";
        file_put_contents($ruta, $json);

        // Send file to user
        header("Content-Type: application/json");
        header("Content-Disposition: attachment; filename=\"clientes.json\"");
        header("Content-Length: " . filesize($ruta));

        readfile($ruta);
    }

    /**
     * Generate PDF list of clients.
     *
     * Uses the FPDF library (via ClientesPDF) to generate a printable
     * PDF document listing all clients.
     *
     * @return void
     */
    static function Imprimir()
    {
        require_once("./pdfs/clientes.php");

        // Create clients model
        $clientes = new ClientesModelo();

        // Select all clients
        $clientes->Seleccionar();

        // Create PDF object
        $pdf = new ClientesPDF();

        // Add page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', '', 14);

        // Set column widths
        $pdf->SetWidths(array(75, 75, 40));

        // Pass data
        $pdf->filas = $clientes->filas;

        // Print
        $pdf->Imprimir();

        // Output to browser
        $pdf->Output();
    }
}
