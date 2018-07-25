<?php

namespace App\Base\PDF;

use App\Base\PDF\PDFAbstract;
use Response;

define('DOMPDF_ENABLE_REMOTE', true);
define('DOMPDF_ENABLE_AUTOLOAD', false);
define('DOMPDF_TEMP_DIR', storage_path('/'));
define('DOMPDF_FONT_DIR', storage_path('/'));
define('DOMPDF_FONT_CACHE', storage_path('/'));
define('DOMPDF_LOG_OUTPUT_FILE', storage_path('/dompdf_log'));

require_once base_path() . '/vendor/dompdf/dompdf/dompdf_config.inc.php';

class domPDF extends PDFAbstract
{
    private function getPdf($html)
    {
        $pdf = new \DOMPDF();
        $pdf->set_paper($this->paperSize, $this->paperOrientation);
        $pdf->load_html($html);
        $pdf->render();

        return $pdf;
    }

    public function getOutput($html)
    {
        $pdf = $this->getPdf($html);

        return $pdf->output();
    }

    public function save($html, $filename)
    {
        file_put_contents($filename, $this->getOutput($html));
    }

    /**
     * Make the PDF downloadable by the user
     *
     * @param string $filename
     *
     *  @return \Illuminate\Http\Response
     */
    public function download($html, $filename)
    {
        $response = Response::make($this->getOutput($html), 200);

        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response->send();
    }

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $filename
     * 
     * @return \Illuminate\Http\Response
     */
    public function stream($html, $filename = 'document.pdf')
    {
        $response = Response::make($this->getOutput($html), 200);

        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'inline; filename="' . $filename . '"');

        return $response->send();
    }
}
