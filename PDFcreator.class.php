<?
require_once('libs/tcpdf/config/lang/eng.php'); //llamada a la clase tcpdf
require_once('libs/tcpdf/tcpdf.php'); //llamada a la clase tcpdf
class PDF6 extends TCPDF {
    public  $pie2;
    public  $cabecera2;
    public $footer;
    public function getPie2() {
        return $this->pie2;
    }
    public function setPie2($par) {
        $this->pie2=$par;
    }

    public function getCabecera2() {
        return $this->cabecera2;
    }
    public function setCabecera2($cab) {
        $this->cabecera2=$cab;
    }

    public function Header() {
        $this->SetY(10);
        $this->SetFont('gothic', '', 6);
        $this->writeHTML($this->getCabecera2(), false, 0, true, 0);
    }
    public function Footer() {
       // $this->SetY(-27);
        //$this->SetFont('gothic', '', 6);
        //$this->writeHTML($this->getPie2(), false, 0, true, 0);
        $this->SetY(-10);
        $this->SetFont('helvetica', 'I', 8);
		$this->writeHTML("");
        //$this->Cell(176, 2, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, 0, 'R');
    }
   
}
?>