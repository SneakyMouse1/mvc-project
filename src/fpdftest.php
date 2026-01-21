<?php
// Test file for PDF generation using FPDF library and mc_table extension
// Used to demonstrate report generation capabilities

// Include mc_table.php
require_once("pdfs/mc_table.php");

class PDF_Clientes extends PDF_MC_Table
{
    // Custom HEADER (Page Header)
    function Header()
    {
        // Set header background color
        // rgb(30, 37, 43)
        $this->SetFillColor(30, 37, 43);

        // Set header text color
        // rgb(254, 212, 1)
        $this->SetTextColor(254, 212, 1);

        // Set font for header
        $this->SetFont('Courier', 'B', 18);

        // Draw header container cell
        // Width 0 = full page
        // Height 25mm
        // 'true' at the end = fill with background color (set in SetFillColor)
        $this->Cell(0, 25, 'Lista de Clientes', 0, 1, 'C', true);

        // RESET text color back to black for the rest of the document
        $this->SetTextColor(0, 0, 0);

        // Add margin after header
        $this->Ln(10);
    }

    // Custom FOOTER (Page Footer)
    function Footer()
    {
        // Position at 2 cm (20mm) from the bottom edge
        // (need more space for 3 lines)
        $this->SetY(-20);

        // Separator line
        $this->SetDrawColor(150, 150, 150); // Gray line
        $this->Line(10, $this->GetY(), 200, $this->GetY()); // Line from 10mm to 200mm
        $this->Ln(2); // Small margin

        // Set font for footer
        $this->SetFont('Courier', '', 8);
        $this->SetTextColor(50, 50, 50); // Dark gray text

        // Output fake data (3 lines)
        // (Width 95 = left half of page)
        $this->Cell(95, 4, 'Nombre: Falsa S.L', 0, 1, 'L');
        $this->Cell(95, 4, 'Telefono: 8-800-555-35-35', 0, 1, 'L');
        $this->Cell(95, 4, 'Email: falsa@domain.com', 0, 1, 'L');

        // Page number
        // Return to 15mm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8); // Italic
        $this->SetTextColor(100, 100, 100); // Light gray

        // 'Pagina X de Y' (X - current, Y - total)
        // {nb} - this is a placeholder that requires AliasNbPages()
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

// Create test data
$mock_data = [];

$fila1 = new stdClass();
$fila1->id = 1;
$fila1->nombre = "Juan";
$fila1->apellidos = "Govnov";
$fila1->email = "juan.govnov@example.com";
$fila1->direccion = "Calle Falsa, 123, 03001 Alicante";
$mock_data[] = $fila1;

$fila2 = new stdClass();
$fila2->id = 2;
$fila2->nombre = "Maria";
$fila2->apellidos = "Bezgovnova";
$fila2->email = "maria.bezgovnova@long-email-domain.com";
$fila2->direccion = "Avenida Principal, 45, Apartamento 6B, 03002";
$mock_data[] = $fila2;

$fila3 = new stdClass();
$fila3->id = 3;
$fila3->nombre = "Igor";
$fila3->apellidos = "Dolban";
$fila3->email = "dolban@example.com";
$fila3->direccion = "Una direccion muy larga que definitivamente necesita ser dividida en multiples lineas por la funcion MultiCell.";
$mock_data[] = $fila3;


// Create PDF document

// Create object
$pdf = new PDF_Clientes('P', 'mm', 'A4');

/*
 * !! IMPORTANT !!
 * Enable {nb} placeholder for counting total pages in footer.
 */
$pdf->AliasNbPages();

// Add page. FPDF AUTOMATICALLY calls our Header()
$pdf->AddPage();


// Create Table (Headers)
$pdf->SetWidths(array(10, 40, 40, 50, 50));
$pdf->SetFont('Arial', 'B', 10);
$pdf->Row(array(
    'ID',
    'Nombre',
    'Apellidos',
    'Email',
    'Direccion'
));


// Fill Table (Data)
$pdf->SetFont('Arial', '', 10);
foreach ($mock_data as $fila) {
    $pdf->Row(array(
        $fila->id,
        $fila->nombre,
        $fila->apellidos,
        $fila->email,
        $fila->direccion
    ));
}

// Output PDF
// FPDF automatically calls our Footer() before sending
$pdf->Output();
