<?php

namespace App\Http\Controllers;
use PDF;


class PDFController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function generatePDF($data, $view, $type = 'view')
    {
        if ($type == 'view') {
            $html = view($view, $data)->render();
            $pdf = new \Dompdf\Dompdf();
            $pdf->setPaper('A4', 'portrait');
            $backgroundImage = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('imagens/Logo_fundo.png')));
            $backgroundHtml = '<img src="' . $backgroundImage . '" style="opacity: 0.1; position: fixed; left: 5%; top: 15%; width: 100%; height: 100%; z-index: 0; pointer-events: none;">';
            $html = $backgroundHtml . $html;
            $pdf->loadHtml($html);
            $pdf->render();
            return $pdf->stream('ordendeservico.pdf');

        } else {
            return $data;
        }
    }
}
