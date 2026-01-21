<?php
// pdfs/lineas_facturas.php

if (!isset($lineas)) {
    require_once("../model/lineas_facturas.php");
    $lineas = new LineasFacturasModelo();
    if (isset($_GET['factura_id']))
        $lineas->factura_id = $_GET['factura_id'];
    $lineas->Seleccionar();
}

require_once("mc_table.php");

$pdf = new PDF_MC_Table('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$id_factura_actual = isset($_GET['factura_id']) ? $_GET['factura_id'] : '';
$pdf->Cell(0, 10, 'Lista de Lineas de Factura: ' . $id_factura_actual, 0, 1, 'C');
$pdf->Ln(5);


// Column widths
// Total width 190
$pdf->SetWidths(array(10, 20, 30, 55, 15, 20, 20, 20));

// Headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Row(array(
    'ID',
    'ID Factura',
    'Referencia',
    'Descripcion',
    'Cant',
    'Precio',
    'IVA',
    'Importe'
));

// Output data 
$pdf->SetFont('Arial', '', 9);
foreach ($lineas->filas as $fila) {
    $pdf->Row(array(
        $fila->id,
        $fila->factura_id,
        $fila->referencia,
        $fila->descripcion,
        $fila->cantidad,
        $fila->precio,
        $fila->iva,
        $fila->importe
    ));
}

$pdf->Output();
