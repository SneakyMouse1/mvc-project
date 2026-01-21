<?php
require_once 'bd.php';

/**
 * Invoice Model.
 *
 * Represents the 'facturas' table in the database.
 * Handles CRUD operations for invoices.
 */
class FacturasModelo extends BD
{
    /**
     * @var int Invoice ID.
     */
    public $id;

    /**
     * @var int Client ID associated with the invoice.
     */
    public $cliente_id;

    /**
     * @var string Invoice Number.
     */
    public $numero;

    /**
     * @var string Invoice Date (YYYY-MM-DD format).
     */
    public $fecha;

    /**
     * @var array|null Array of selected records (objects).
     */
    public $filas = null;

    /**
     * Insert a new invoice.
     *
     * Inserts the current object properties into the database.
     *
     * @return int|false The number of affected rows (1 on success), or false on error.
     */
    public function Insertar()
    {
        $sql = "INSERT INTO facturas VALUES (default,
                '$this->cliente_id',
                '$this->numero',
                '$this->fecha')";

        return $this->_ejecutar($sql);
    }

    /**
     * Update an existing invoice.
     *
     * Updates the database record matching the current ID with new property values.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Modificar()
    {
        $sql = "UPDATE facturas SET
                cliente_id='$this->cliente_id',
                numero='$this->numero',
                fecha='$this->fecha'
                WHERE id=$this->id";

        return $this->_ejecutar($sql);
    }

    /**
     * Delete an invoice.
     *
     * Deletes the record matching the current ID from the database.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Borrar()
    {
        $sql = "DELETE FROM facturas WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Select invoices.
     *
     * Retrieves records from the database. Can filter by ID or Client ID.
     * If a specific ID is set, populates the object properties with the result.
     *
     * @return bool True if records were found, false otherwise.
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM facturas';

        // If ID is set, filter by it
        if ($this->id != 0) {
            $sql .= " WHERE id=$this->id";
        }
        // Otherwise, if cliente_id is set, filter by client
        else if ($this->cliente_id != 0) {
            $sql .= " WHERE cliente_id=$this->cliente_id";
        }

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null) {
            return false;
        }

        // If a single record was selected by ID, fill object properties
        if ($this->id != 0) {
            $this->cliente_id = $this->filas[0]->cliente_id;
            $this->numero = $this->filas[0]->numero;
            $this->fecha = $this->filas[0]->fecha;
        }

        return true;
    }
}
