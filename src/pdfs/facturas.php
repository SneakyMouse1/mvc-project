<?php

require_once('mc_table.php');


class FacturasPDF extends PDF_MC_Table
{

    public $filas;

    public $clientesMap;

    // Page Header
    function Header()
    {

        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'LISTADO DE FACTURAS', 1, 0, 'C');


        $this->SetXY(10, 20);
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);

        // Set column widths
        // 15 (ID) + 105 (Cliente) + 35 (Numero) + 35 (Fecha) = 190 (Total width)
        $this->SetWidths(array(15, 105, 35, 35));

        // Draw headers
        // Use 'Cliente' instead of 'Cliente ID'
        $this->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(105, 10, 'Cliente', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Numero', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Fecha', 1, 0, 'C', true);

        $this->Ln();
        // Reset colors
        $this->SetTextColor(0, 0, 0);
    }

    // Page Footer
    function Footer()
    {
        // Position: 1 cm from the bottom of the page
        $this->SetY(-10);
        $this->SetFont('Arial', '', 10);

        // Date and time
        $fechayhora = date('d/m/Y - H:i');
        $this->Cell(50, 10, $fechayhora, 0, 0, 'L');

        // Page number (Removed utf8_decode to avoid Deprecated warning)
        $this->Cell(
            0,
            10,
            'Página ' . $this->PageNo() . '/{nb}',
            0,
            0,
            'R'
        );
    }

    /**
     * Main method to print table rows
     */
    public function Imprimir()
    {
        $this->SetFont('Arial', '', 9); // Font for data

        if ($this->filas) {
            foreach ($this->filas as $fila) {

                $nombreClientes = $this->clientesMap[$fila->cliente_id];

                $this->Row(array(
                    $fila->id,
                    $nombreClientes,
                    $fila->numero,
                    $fila->fecha
                ));
            }
        }
    }
}
