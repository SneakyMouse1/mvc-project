<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("model/articulos.php");

/**
 * Articles Controller.
 *
 * Handles CRUD operations on articles (products).
 */
class ArticulosControlador
{
    /**
     * Display list of articles.
     *
     * Retrieves all articles from the model and renders the article list view.
     *
     * @return void
     */
    static function index()
    {
        $articulos = new ArticulosModelo();
        $articulos->Seleccionar();
        require_once("view/articulos.php");
    }

    /**
     * Show form to create a new article.
     *
     * Sets the maintenance mode to 'NUEVO' and loads the maintenance view.
     *
     * @return void
     */
    function Nuevo()
    {
        $opcion = 'NUEVO';
        require_once("view/articulosmantenimiento.php");
    }

    /**
     * Save a new article.
     *
     * Reads POST data and inserts the article into the database.
     * Redirects to the index on success or shows an error.
     *
     * @return void
     */
    function Insertar()
    {
        $articulo = new ArticulosModelo();
        $articulo->referencia = $_POST['referencia'];
        $articulo->descripcion = $_POST['descripcion'];
        $articulo->precio = $_POST['precio'];
        $articulo->tipo_iva = $_POST['tipo_iva'];

        if ($articulo->Insertar() == 1) {
            header("location:" . URLSITE . '?c=articulos');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $articulo->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Show form to edit an existing article.
     *
     * Loads the article record by ID (from GET) and sets the maintenance mode to 'EDITAR'.
     *
     * @return void
     */
    function Editar()
    {
        $articulo = new ArticulosModelo();
        $articulo->id = $_GET['id'];
        $opcion = 'EDITAR';

        if ($articulo->Seleccionar()) {
            require_once("view/articulosmantenimiento.php");
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $articulo->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Apply changes to an article.
     *
     * Updates an existing article record with data from POST.
     * Redirects to the index on success or displays an error.
     *
     * @return void
     */
    function Modificar()
    {
        $articulo = new ArticulosModelo();
        $articulo->id = $_GET['id'];
        $articulo->referencia = $_POST['referencia'];
        $articulo->descripcion = $_POST['descripcion'];
        $articulo->precio = $_POST['precio'];
        $articulo->tipo_iva = $_POST['tipo_iva'];

        if (($articulo->Modificar() == 1) || ($articulo->GetError() == '')) {
            header("location:" . URLSITE . '?c=articulos');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $articulo->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Delete an article.
     *
     * Removes the article specified by ID (from GET) from the database.
     * Redirects to the index on success.
     *
     * @return void
     */
    function Borrar()
    {
        $articulo = new ArticulosModelo();
        $articulo->id = $_GET['id'];

        if ($articulo->Borrar() == 1) {
            header("location:" . URLSITE . '?c=articulos');
        } else {
            $_SESSION["CRUDMVC_ERROR"] = $articulo->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Export articles to CSV.
     *
     * Generates an 'articulos.csv' file on the server containing all article data
     * and initiates a download for the user.
     *
     * @return void
     */
    static function Exportar()
    {
        $articulos = new ArticulosModelo();
        $articulos->Seleccionar();

        try {
            $fichero = fopen("articulos.csv", "w");

            foreach ($articulos->filas as $fila) {
                $cadena = "$fila->id;$fila->referencia;$fila->descripcion;$fila->precio;$fila->tipo_iva\n";
                fputs($fichero, $cadena);
            }
        } finally {
            fclose($fichero);
        }

        $rutaFichero = "articulos.csv";
        $fichero = basename($rutaFichero);

        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=\"$fichero\"");

        readfile($rutaFichero);
    }

    /**
     * Export articles to JSON.
     *
     * Encodes the article list to JSON format, saves it to 'articulos.json',
     * and initiates a download for the user.
     *
     * @return void
     */
    static function ExportarJSON()
    {
        $articulos = new ArticulosModelo();
        $articulos->Seleccionar();
        $json = json_encode($articulos->filas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $ruta = "articulos.json";
        file_put_contents($ruta, $json);
        header("Content-Type: application/json");
        header("Content-Disposition: attachment; filename=\"articulos.json\"");
        header("Content-Length: " . filesize($ruta));
        readfile($ruta);
    }
}
