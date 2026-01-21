<?php
require_once("config.php");

/**
 * Base Database Class.
 *
 * Provides a wrapper around PDO for database interactions.
 */
class BD
{
    /**
     * @var PDO|null Database connection instance.
     */
    private $con   = null;

    /**
     * @var string Error message, if any.
     */
    private $error = '';

    /**
     * Constructor.
     *
     * Establishes a new database connection using the defined constants.
     * Sets error mode to Exception and character set to UTF-8.
     */
    function __construct()
    {
        $this->error = '';

        try {
            // Create connection
            $this->con = new PDO(
                'mysql:host=' . SERVIDOR .
                    ';dbname=' . BASEDATOS .
                    ';charset=utf8',
                USUARIO,
                CONTRASENA
            );

            // If connection is successful
            if ($this->con) {
                // Set attributes for error handling via exceptions
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Set charset to utf-8
                $this->con->exec('SET CHARACTER SET utf8');
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Destructor.
     *
     * Closes the database connection.
     */
    function __destruct()
    {
        $this->con = null;
    }

    /**
     * Execute a SELECT query.
     *
     * Prepares and executes the SQL query. Fetches results as an array of objects.
     *
     * @param string $query The SQL SELECT query.
     * @return array|null An array of objects representing rows, or null if empty/error.
     */
    protected function _consultar($query)
    {
        $this->error = '';
        $filas = null;

        try {
            // Prepare query
            $stmt = $this->con->prepare($query);

            // Execute
            $stmt->execute();

            // If there are results
            if ($stmt->rowCount() > 0) {
                $filas = array();

                // Fill array with objects
                while ($registro = $stmt->fetchObject()) {
                    $filas[] = $registro;
                }
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        // Return obtained rows
        return $filas;
    }

    /**
     * Execute INSERT, UPDATE, or DELETE queries.
     *
     * Executes the SQL statement and returns the number of affected rows.
     *
     * @param string $query The SQL query to execute.
     * @return int|false The number of affected rows, or false on failure.
     */
    protected function _ejecutar($query)
    {
        $this->error = '';
        $filas = 0;

        try {
            // Execute query and get number of affected rows
            $filas = $this->con->exec($query);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        // Return number of affected rows
        return $filas;
    }

    /**
     * Get the ID of the last inserted record.
     *
     * @return string|false The last inserted ID, or false if not available.
     */
    protected function _ultimoId()
    {
        return $this->con->lastInsertId();
    }

    /**
     * Get the current error message.
     *
     * @return string The error message.
     */
    public function GetError()
    {
        return $this->error;
    }

    /**
     * Check if an error occurred.
     *
     * @return bool True if there is an error, false otherwise.
     */
    public function Error()
    {
        return ($this->error != '');
    }
}
