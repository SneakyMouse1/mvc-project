<?php
require_once('mc_table.php');

class ClientesPDF extends PDF_MC_Table
{
    public $filas;

    // Page Header
    function Header()
    {
        // Set page title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'LISTADO DE CLIENTES', 1, 0, 'C');

        // Set cell headers
        $this->SetXY(10, 20);
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(75, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(75, 10, 'Email', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Direccion', 1, 0, 'C', true);

        $this->Ln();
    }

    // Page Footer
    function Footer()
    {
        // Position: 1 cm from the bottom of the page
        $this->SetY(-10);

        // Arial 10
        $this->SetFont('Arial', '', 10);

        // Date and time
        $fechayhora = date('d/m/Y - H:i');
        $this->Cell(50, 10, $fechayhora, 0, 0, 'L');

        // Page number
        $this->Cell(
            227,
            10,
            ('Página ' . $this->PageNo() . '/{nb}'),
            0,
            0,
            'R'
        );
    }

    public function Imprimir()
    {
        if ($this->filas) {
            foreach ($this->filas as $fila) {
                $this->Row(array(
                    $fila->nombre,
                    $fila->email,
                    $fila->direccion
                ));
            }
        }
    }
}
