<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Koppaz\PdfHandlerBundle\Model\PDFMY;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        //[width, height, flag, name, font]
        $stickers = [
            [76, 12, 'https://cdn.countryflags.com/thumbs/united-kingdom/flag-400.png', 'Lewis Hamilton'],
            [76, 12, 'https://cdn.countryflags.com/thumbs/united-kingdom/flag-400.png', 'Lewis Hamilton'],
            [76, 12, 'https://cdn.countryflags.com/thumbs/united-kingdom/flag-400.png', 'Lewis Hamilton'],
            [76, 12, 'https://cdn.countryflags.com/thumbs/united-kingdom/flag-400.png', 'Lewis Hamilton']
        ];
        $pdf = new PDFMY('P', 'mm', 'A3');
        $pdf->SetMargins(0, 0); //need to be called before AddPage()
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(100, 100, 100);
        $cl = 0;
        $currentYLarge = 15;
        $currentYSmall = 15;
        $rows = 0;
        
        foreach ($stickers as $sticker) {
            $pdf->SetFontSize(16);
            $pdf->SetY($currentYLarge - 15);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell($sticker[0] * 1.5, 10, 'bicistickerslike-large-format', 1, 0, '', true);
            $pdf->SetFillColor(100, 100, 100);
            $pdf->SetX(0);
            $pdf->Cell($sticker[0] * 1.5, $sticker[1] * 6 * 1.5, '', 1, 0, '');
            $pdf->SetY($currentYLarge);
            for($i = 0; $i < 6; $i++){
                $pdf->SetFontSize(16);
                $pdf->SetX($sticker[0] * 0.25); // middle of cell
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $sticker[0], $sticker[1], 3, 'DF'); //print rounded rect
                $pdf->Cell($sticker[0], $sticker[1], '', 0, 0, '');
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->SetY($currentYLarge + $sticker[1] / 4);
                $pdf->SetX($x - $sticker[0] + 5);
                $pdf->Cell(10, 6, '', 1);
                $pdf->Image($sticker[2], $x - $sticker[0] + 5, null, 10, 6);
                $pdf->SetX($pdf->GetX() + 2);
                $pdf->SetY($pdf->GetY() - 6, false);
                if(strlen($sticker[3]) > 19) {
                    $pdf->SetFontSize(14);
                }
                $pdf->Cell($sticker[0] / 1.37, 6, utf8_decode($sticker[3]), );
                $pdf->SetX($x);
                $pdf->SetY($y, false);
                $cl++;
    
                //%3 == 3 stickers per lines
                if ($cl % 1 == 0) {
                    $pdf->Ln(15);
                    $currentYLarge += 15;
                    $pdf->SetY($currentYLarge);
                }
            }

            $currentYLarge += 25;
            
            
            $pdf->SetFillColor(0, 0, 0);
            $pdf->SetY($currentYSmall - 15);
            $pdf->SetX(150);
            $pdf->Cell($sticker[0] * 1.5, 10, 'bicistickerslike-small-format', 1, 0, '', true);
            $pdf->SetFillColor(100, 100, 100);
            $pdf->SetX(150);
            $pdf->Cell($sticker[0] * 1.5, $sticker[1] * 6 * 1.5, '', 1, 0, '');
            $pdf->SetY($currentYSmall, false);
            for($i = 0; $i < 6; $i++){
                $pdf->SetX(175);
                $pdf->SetFontSize(12);
                $pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), $sticker[0] * 0.8, $sticker[1] * 0.8, 3, 'DF');
                $pdf->Cell($sticker[0] *0.8, $sticker[1] * 0.8, '', 0, 0, '');
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->SetY($currentYSmall + ($sticker[1] * 0.8 )/ 4, false);
                $pdf->SetX($x - $sticker[0] * 0.8 + 5);
                $pdf->Cell(10, 6, '', 1);
                $pdf->Image($sticker[2], $x - $sticker[0] * 0.8 + 5, null, 10, 6);
                $pdf->SetX($pdf->GetX() + 2);
                $pdf->SetY($pdf->GetY() - 6, false);
                if(strlen($sticker[3]) > 19) {
                    $pdf->SetFontSize(14);
                }
                $pdf->Cell(($sticker[0] / 1.37) * 0.8, 6, utf8_decode($sticker[3]), );
                $pdf->SetX($x);
                $pdf->SetY($y, false);
                $cl++;
    
                //%3 == 3 stickers per lines
                if ($cl % 1 == 0) {
                    $pdf->Ln(15);
                    $currentYSmall += 12;
                    $pdf->SetY($currentYSmall, false);
                }
            }

            $currentYSmall += 40;

            $rows++;
            if($rows == 3) {
                $pdf->AddPage();
                $currentYLarge = 15;
                $currentYSmall = 15;
            }
            
        }
        $pdf->Output();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
}
