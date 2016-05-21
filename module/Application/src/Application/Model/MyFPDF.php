<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 26.03.2015
 * Time: 10:10
 */

namespace Application\Model;

use fpdf\FPDF;

class MyFPDF extends FPDF
{
    private $replace = null;

    private $B = 0;
    private $I = 0;
    private $U = 0;
    private $HREF = '';
    private $ALIGN = '';

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);

        $this->replace["search"][] = "<em>";
        $this->replace["replace"][] = "<i>";

        $this->replace["search"][] = "</em>";
        $this->replace["replace"][] = "</i>";

        $this->replace["search"][] = "&amp;";
        $this->replace["replace"][] = "&";

        $this->replace["search"][] = "&nbsp;";
        $this->replace["replace"][] = "";
    }

    public function WriteHTML($h, $html)
    {
        //HTML parser
        $html = str_replace("\n", ' ', $html); //Zeilenumbruch entfernen, wird durch <br/> dargestellt
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                //Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                elseif ($this->ALIGN == 'center')
                    $this->Cell(0, $h, $e, 0, 1, 'C');
                else
                    parent::Write($h, $e);
            } else {
                //Tag
                if ($e{0} == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    //Extract properties
                    $a2 = split(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $prop = array();
                    foreach ($a2 as $v)
                        if (ereg('^([^=]*)=["\']?([^"\']*)["\']?$', $v, $a3))
                            $prop[strtoupper($a3[1])] = $a3[2];
                    $this->OpenTag($tag, $prop, $h);
                }
            }
        }
    }

    function OpenTag($tag, $prop, $h)
    {
        //Opening tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $prop['HREF'];
        if ($tag == 'BR')
            $this->Ln($h);
        if ($tag == 'P') {
            $this->Ln($h*1.5);
            if (isset($prop["ALIGN"])) {
                $this->ALIGN = $prop['ALIGN'];
            }
        }
        if ($tag == 'HR') {
            if ($prop['WIDTH'] != '')
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin - $this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x, $y, $x + $Width, $y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    public function CloseTag($tag)
    {
        //Closing tag
        if ($tag == 'B' or $tag == 'I' or $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
        if ($tag == 'P')
            $this->ALIGN = '';
    }

    public function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s)
            if ($this->$s > 0)
                $style .= $s;
        $this->SetFont('', $style);
    }

    public function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }

    public function Write($h, $txt, $link = '', $html = false)
    {
        $txt = str_replace($this->replace["search"], $this->replace["replace"], $txt);
        if ($html) {
            $this->WriteHTML($h, $txt);
        } else {
            parent::Write($h, $txt, $link);
        }
    }
} 