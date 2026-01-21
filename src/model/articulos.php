<?php
require_once 'bd.php';

/**
 * Article Model.
 *
 * Represents the 'articulos' table in the database.
 * Handles CRUD operations for articles (items/products).
 */
class ArticulosModelo extends BD
{
    /**
     * @var int Article ID.
     */
    public $id;

    /**
     * @var string Article Reference/Code.
     */
    public $referencia;

    /**
     * @var string Article Description.
     */
    public $descripcion;

    /**
     * @var float Article Price.
     */
    public $precio;

    /**
     * @var float VAT Rate.
     */
    public $tipo_iva;

    /**
     * @var array|null Array of selected records (objects).
     */
    public $filas = null;

    /**
     * Insert a new article.
     *
     * Inserts the current object properties into the database.
     *
     * @return int|false The number of affected rows (1 on success), or false on error.
     */
    public function Insertar()
    {
        $sql = "INSERT INTO articulos VALUES (default,
                '$this->referencia',
                '$this->descripcion',
                '$this->precio',
                '$this->tipo_iva')";

        return $this->_ejecutar($sql);
    }

    /**
     * Update an existing article.
     *
     * Updates the database record matching the current ID with new property values.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Modificar()
    {
        $sql = "UPDATE articulos SET
                referencia='$this->referencia',
                descripcion='$this->descripcion',
                precio='$this->precio',
                tipo_iva='$this->tipo_iva'
                WHERE id=$this->id";

        return $this->_ejecutar($sql);
    }

    /**
     * Delete an article.
     *
     * Deletes the record matching the current ID from the database.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Borrar()
    {
        $sql = "DELETE FROM articulos WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Select articles.
     *
     * Retrieves records from the database. Can filter by ID.
     * If a specific ID is set, populates the object properties with the result.
     *
     * @return bool True if records were found, false otherwise.
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM articulos';

        // If ID is set, filter by it
        if ($this->id != 0) {
            $sql .= " WHERE id=$this->id";
        }

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null) {
            return false;
        }

        // If a single record was selected, fill object properties
        if ($this->id != 0) {
            $this->referencia = $this->filas[0]->referencia;
            $this->descripcion = $this->filas[0]->descripcion;
            $this->precio = $this->filas[0]->precio;
            $this->tipo_iva = $this->filas[0]->tipo_iva;
        }

        return true;
    }
}
