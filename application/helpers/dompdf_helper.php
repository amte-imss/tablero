 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

      use Dompdf\Adapter\CPDF;
      use Dompdf\Dompdf;
      use Dompdf\Exception;

      function generarPdf($html, $filename, $options) {
            require_once("dompdf".DIRECTORY_SEPARATOR."autoload.inc.php");
            if ( isset($html) ) {
                $html = stripslashes($html);
                $dompdf = new Dompdf();
                $dompdf->loadHtml(utf8_decode($html));
                $dompdf->setPaper("a4", $options["orientacion"]);
                $dompdf->render();
                $dompdf->stream($filename . ".pdf");
            }
        }

          
          // Esta función queda deshabilidata temporalmente por actualización de 
          // versión de dompdf de 0.5 a 0.8 checar cambios para habilitar de nuevo.
//	function guardarPdf($html, $filename, $ruta = ".\\assets\\") {
//		require_once("dompdf".DIRECTORY_SEPARATOR."autoload.inc.php");
//		if ( isset($html) ) {
//			$html = stripslashes($html);
//			$dompdf = new DOMPDF();
//			$dompdf->load_html($html);
//			$dompdf->render();
//			$pdfoutput = $dompdf->output();
//			$fp = fopen($ruta.$filename.".pdf", "a");
//			fwrite($fp, $pdfoutput);
//			fclose($fp);
//	   }
//	}
