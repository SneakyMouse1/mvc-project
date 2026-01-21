<?php
require_once 'bd.php';

/**
 * Client Model.
 *
 * Represents the 'clientes' table in the database.
 * Handles CRUD operations for clients.
 */
class ClientesModelo extends BD
{
    /**
     * @var int Client ID.
     */
    public $id;

    /**
     * @var string Client Name.
     */
    public $nombre;

    /**
     * @var string Client Surname.
     */
    public $apellidos;

    /**
     * @var string Client Email.
     */
    public $email;

    /**
     * @var string Encrypted Password.
     */
    public $contrasenya;

    /**
     * @var string Client Address.
     */
    public $direccion;

    /**
     * @var string Postal Code.
     */
    public $cp;

    /**
     * @var string City/Town.
     */
    public $poblacion;

    /**
     * @var string Province/State.
     */
    public $provincia;

    /**
     * @var string Date of Birth (YYYY-MM-DD format).
     */
    public $fecha_nac;

    /**
     * @var array|null Array of selected records (objects).
     */
    public $filas = null;

    /**
     * Insert a new client.
     *
     * Inserts the current object properties into the database.
     *
     * @return int|false The number of affected rows (1 on success), or false on error.
     */
    public function Insertar()
    {
        $sql = "INSERT INTO clientes VALUES (default,
                '$this->nombre',
                '$this->apellidos',
                '$this->email',
                '$this->contrasenya',
                '$this->direccion',
                '$this->cp',
                '$this->poblacion',
                '$this->provincia',
                '$this->fecha_nac')";

        return $this->_ejecutar($sql);
    }

    /**
     * Update an existing client.
     *
     * Updates the database record matching the current ID with new property values.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Modificar()
    {
        $sql = "UPDATE clientes SET
                nombre='$this->nombre',
                apellidos='$this->apellidos',
                email='$this->email',
                contrasenya='$this->contrasenya',
                direccion='$this->direccion',
                cp='$this->cp',
                poblacion='$this->poblacion',
                provincia='$this->provincia',
                fecha_nac='$this->fecha_nac'
                WHERE id=$this->id";

        return $this->_ejecutar($sql);
    }

    /**
     * Delete a client.
     *
     * Deletes the record matching the current ID from the database.
     *
     * @return int|false The number of affected rows, or false on error.
     */
    public function Borrar()
    {
        $sql = "DELETE FROM clientes WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Select clients.
     *
     * Retrieves records from the database. Can filter by ID.
     * If a specific ID is set, populates the object properties with the result.
     *
     * @return bool True if records were found, false otherwise.
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM clientes';

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
            $this->nombre = $this->filas[0]->nombre;
            $this->apellidos = $this->filas[0]->apellidos;
            $this->email = $this->filas[0]->email;
            $this->contrasenya = $this->filas[0]->contrasenya;
            $this->direccion = $this->filas[0]->direccion;
            $this->cp = $this->filas[0]->cp;
            $this->poblacion = $this->filas[0]->poblacion;
            $this->provincia = $this->filas[0]->provincia;
            $this->fecha_nac = $this->filas[0]->fecha_nac;
        }

        return true;
    }
}
