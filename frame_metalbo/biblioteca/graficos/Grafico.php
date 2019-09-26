<?php

/*
 * Implementa a classe principal de geração de gráficos
 * @authorprincipal Maxime Delorme
 * @url http://www.fpdf.org/en/script/script19.php
 * @author Cleverton Hoffmann
 * @since 18/09/2019
 */


require('Functions.php');

class PDF_Grafico extends PDF_Functions {

    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;

    /**
     * Responsável por criar um gráfico de Pizza
     * @param type $w Largura do gráfico
     * @param type $h Altura do gráfico
     * @param type $data Array de dados
     * @param type $format $format %1 = texto, %v = valor, (%p) = porcentagem
     * @param type $colors Array de corres do Gráfico
     */
    function PieChart($w, $h, $data, $format, $colors = null) {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 5;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
        if ($colors == null) {
            for ($i = 0; $i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $colors[$i] = array($gray, $gray, $gray);
            }
        }

        //Sectors
        $this->SetLineWidth(0.2);
        $angleStart = 0;
        $angleEnd = 0;
        $i = 0;
        foreach ($data as $val) {
            $angle = ($val * 360) / doubleval($this->sum);
            if ($angle != 0) {
                $angleEnd = $angleStart + $angle;
                $this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
                $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd);
                $angleStart += $angle;
            }
            $i++;
        }

        //Legends
        $this->SetFont('Courier', '', 10);
        $x1 = $XPage + 2 * $radius + 4 * $margin;
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal * ($hLegend + $margin)) / 2;
        for ($i = 0; $i < $this->NbVal; $i++) {
            $this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
            $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
            $this->SetXY($x2, $y1);
            $this->Cell(0, $hLegend, $this->legends[$i]);
            $y1 += $hLegend + $margin;
        }
    }

    /**
     * Responsável por criar um gráfico de Barras Horizontal
     * @param type $w Largura do Campo do Gráfico
     * @param type $h Altura do Campo Gráfico
     * @param type $data Array de dados
     * @param type $format %1 = texto, %v = valor, (%p) = porcentagem
     * @param int $color Array de corres do Gráfico
     * @param type $maxVal Comprimento máximo das Barras
     * @param type $nbDiv Quantidade de Divisões
     */
    public function BarDiagram($w, $h, $data, $format, $color = null, $maxVal = 0, $nbDiv = 4) {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        //if($color == null)
        //	$color=array(155,155,155);
        if ($color == null) {
            for ($i = 0; $i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $color[$i] = array($gray, $gray, $gray);
            }
        }
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $i = 0;
        foreach ($data as $val) {

            $this->SetFillColor($color[$i][0], $color[$i][1], $color[$i][2]);
            //Bar
            $xval = $XDiag;
            $lval = (int) ($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i], 0, 0, 'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos+5, $val);
        }
    }

    function SetLegends($data, $format) {
        $this->legends = array();
        $this->wLegend = 0;
        $this->sum = array_sum($data);
        $this->NbVal = count($data);
        foreach ($data as $l => $val) {
            $p = sprintf('%.2f', $val / $this->sum * 100) . '%';
            $legend = str_replace(array('%l', '%v', '%p'), array($l, $val, $p), $format);
            $this->legends[] = $legend;
            $this->wLegend = max($this->GetStringWidth($legend), $this->wLegend);
        }
    }

    /**
     * Responsável por criar um gráfico de Colunas
     * @param type $w Largura do Campo do Gráfico
     * @param type $h Altura do Campo Gráfico
     * @param type $data Array de dados
     * @param type $format %1 = texto, %v = valor, (%p) = porcentagem
     * @param int $color Array de corres do Gráfico
     * @param type $maxVal Comprimento máximo das Barras
     * @param type $nbDiv Quantidade de Divisões
     */
    public function ColunmDiagram($w, $h, $data, $format, $color = null, $maxVal = 0, $nbDiv = 4) {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($w - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($h - $margin * 3 - $this->wLegend);
        //if($color == null)
        //	$color=array(155,155,155);
        if ($color == null) {
            for ($i = 0; $i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $color[$i] = array($gray, $gray, $gray);
            }
        }
        if ($maxVal == 0) {
            $maxVal = max($data);
        } else {
            $maxVal = max($data) / $maxVal;
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $hDiag, $lDiag);

        $this->SetFont('Courier', '', 10);
        $i = 0;
        foreach ($data as $val) {

            $this->SetFillColor($color[$i][0], $color[$i][1], $color[$i][2]);
            //Bar

            $xval = $XDiag + ($i + 1) * $hBar - $eBaton / 2;
            $lval = (int) ($val * $unit);
            $yval = $YDiag - ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $lDiag + $YDiag - $lval, $hval, $lval, 'DF');

            //Legend
            $this->SetXY($xval, $lDiag+$YDiag);
            $this->RotatedText($xval, $lDiag+$YDiag+3, $this->legends[$i], -45);
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $YDiag + $lRepere * $i;
            $this->Line($XDiag, $xpos, $XDiag + $hDiag, $xpos);
            $val = $i * $valIndRepere;
            $xpos = $YDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($XDiag + $hDiag+1, $YDiag + ($YDiag + $lDiag) - $xpos-2, $val);
        }
                       
    }
    
    /**
     * Função de rotação de texto
     * @param type $x posição x
     * @param type $y posição y
     * @param type $txt texto
     * @param type $angle angulo de rotação
     */
    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    /**
     * Função de rotação de imagem
     * @param type $file imagem
     * @param type $x posição x
     * @param type $y posição y
     * @param type $w largura
     * @param type $h altura
     * @param type $angle angulo
     */
    function RotatedImage($file, $x, $y, $w, $h, $angle) {
        //Image rotated around its upper-left corner
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }

}

?>
