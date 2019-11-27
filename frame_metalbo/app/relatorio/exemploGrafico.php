<?php

/*
 * Implementa a classe exemplo de geração de gráficos
 * @authorprincipal Maxime Delorme
 * @url http://www.fpdf.org/en/script/script19.php
 * @author Cleverton Hoffmann
 * @since 18/09/2019
 */

require('../../biblioteca/graficos/Grafico.php');

$pdf = new PDF_Grafico();
$pdf->AddPage();

$data = array('Janeiro' => 100, 'Fevereiro' => 1610, 'Março' => 1510,
    'Abril' => 610, 'Maio' => 400,'Junho' => 510,
    'Julho' => 610, 'Agosto' => 140,'Setembro' => 151,
    'Outubro' => 161, 'Novembro' => 1200,'Dezembro' => 90);

//Pie chart
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '1 - Gráfico de Pizza', 0, 1);
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 10);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->Cell(30, 5, 'Janeiro:');
$pdf->Cell(15, 5, $data['Janeiro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Fevereiro:');
$pdf->Cell(15, 5, $data['Fevereiro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Março:');
$pdf->Cell(15, 5, $data['Março'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Abril:');
$pdf->Cell(15, 5, $data['Abril'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Maio:');
$pdf->Cell(15, 5, $data['Maio'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Junho:');
$pdf->Cell(15, 5, $data['Junho'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Julho:');
$pdf->Cell(15, 5, $data['Julho'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Agosto:');
$pdf->Cell(15, 5, $data['Agosto'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Setembro:');
$pdf->Cell(15, 5, $data['Setembro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Outubro:');
$pdf->Cell(15, 5, $data['Outubro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Novembro:');
$pdf->Cell(15, 5, $data['Novembro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(30, 5, 'Dezembro:');
$pdf->Cell(15, 5, $data['Dezembro'], 0, 0, 'R');
$pdf->Ln();
$pdf->Ln(8);

//Define corres conforme a quantidade de dados ou só definir null
$col1=array (0,0,0);
$col2=array (0,0,205);
$col3=array (255,20,100);
$col4=array (50,100,255);
$col5=array (0,128,0);
$col6=array (255,255,50);
$col7=array (100,200,255);
$col8=array (255,200,100);
$col9=array (139,69,19);
$col10=array (100,40,255);
$col11=array (255,69,0);
$col12=array (0,255,0);

/* 
 * Largura do gráfico
 * Altura do gráfico
 * Array de dados
 * %1 = texto
 * %v = valor
 * (%p) = porcentagem
 * Array de corres do Gráfico de Pizza
 */
$pdf->SetXY(90, $valY);
$pdf->PieChart(100, 100, $data, '%l (%p)', array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11,$col12));
$pdf->SetXY($valX, $valY + 100);

//Bar diagram
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '2 - Gráfico de Barras Horizontal', 0, 1);
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();

/* 
 * Largura do Campo do Gráfico
 * Altura do Campo Gráfico
 * Array de dados
 * %1 = texto
 * %v = valor
 * (%p) = porcentagem
 * Array de corres do Gráfico
 * Comprimento máximo das Barras de 1 á 3 e 0 como padrão
 * Quantidade de Divisões
 */
$pdf->BarDiagram(180, 100, $data, '%l : %v (%p)', array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11,$col12), 0, 10);
$pdf->SetXY($valX, $valY + 80);



$pdf->AddPage();

//Colunm diagram
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '2 - Gráfico de Colunas', 0, 1);
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();

/* 
 * Largura do Campo do Gráfico
 * Altura do Campo Gráfico
 * Array de dados
 * %1 = texto
 * %v = valor
 * (%p) = porcentagem
 * Array de corres do Gráfico
 * Comprimento máximo das Barras de 1 á 3 e 0 como padrão
 * Quantidade de Divisões
 */
$pdf->ColunmDiagram(100, 150, $data, '%l : %v (%p)', array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11,$col12), 0, 5);

$pdf->Output();
?>
