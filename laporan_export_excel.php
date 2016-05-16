<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
      die('This file should only be run from a Web Browser');

// Get parameter value
$ta_id       = $_GET["tahun_ajaran_id"];
$ta_name     = $_GET["tahun_ajaran_name"];
$ta_name_alt = str_replace(" ", "_", $ta_name);

/** Include PHPExcel */
require_once dirname(__FILE__) . '/lib/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Noerman Agustiyan")
							 ->setLastModifiedBy("Noerman Agustiyan")
							 ->setTitle("Laporan Jumlah Calon Siswa")
							 ->setSubject("Laporan Jumlah Calon Siswa")
							 ->setDescription("Menampilkan data calon siswa berdasarkan tahun ajaran yang dipilih")
							 ->setKeywords("calon-siswa pendaftaran psb ppdb siswa online daftar enroll database php");

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Laporan Jumlah Calon Siswa');

// Header Title
$objPHPExcel->getActiveSheet()->setCellValue("B2", " Laporan Jumlah Calon Siswa Pendaftaran Online. TA : $ta_name");
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);

// Header Column Setting
$objPHPExcel->getActiveSheet()->getStyle('B4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Width
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

// Value
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B4', 'No')
            ->setCellValue('C4', 'Nama Calon Siswa')
            ->setCellValue('D4', 'Asal Sekolah')
            ->setCellValue('E4', 'Tempat Lahir')
            ->setCellValue('F4', 'Tanggal Lahir')
            ->setCellValue('G4', 'Nama Orang Tua / Wali')
            ->setCellValue('H4', 'Pekerjaan Orang Tua / Wali')
            ->setCellValue('I4', 'Alamat')
            ->setCellValue('J4', 'Email Orang Tua / Wali')
            ->setCellValue('K4', 'No Telepon Orang Tua / Wali')
            ->setCellValue('L4', 'Status Penerimaan')
            ->setCellValue('M4', 'Checker')
            ;

// Header style
$objPHPExcel->getActiveSheet()->getStyle('B4:M4')->applyFromArray(
	array(
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('argb' => 'ccffcc')
		),
		'borders' => array(
			'top'    => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
		)
	)
);

// Require class database
require_once(__DIR__ . '/lib/db.class.php');
$databaseClass = new DB();

// Top Limit
$top_limit = 4;
      
// Content
$no            = 0;
$query_data_cs = "SELECT * FROM psb_data_siswa WHERE ta_id = '$ta_id'";
$data_list     = $databaseClass->query($query_data_cs);
foreach ($data_list as $dl) {
	$no++;
	$top_limit++;
	
	// Content style
	$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit.':M'.$top_limit)->applyFromArray(
		array(
			'borders' => array(
				'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		)
	);

	// Set zebra color (odds number)
	if ($top_limit%2==1) {
		$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit.':M'.$top_limit)->applyFromArray(
			array(
				'fill' => array(
				'type'  => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('argb' => 'e1eaea')
				)
			)
		);
	}

	// Content 
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B".$top_limit, $no)
            ->setCellValue("C".$top_limit, $dl["nama_calon_siswa"])
            ->setCellValue("D".$top_limit, $dl["asal_sekolah"])
            ->setCellValue("E".$top_limit, $dl["tempat_lahir_calon_siswa"])
            ->setCellValue("F".$top_limit, $dl["tanggal_lahir_calon_siswa"])
            ->setCellValue("G".$top_limit, $dl["nama_orang_tua_wali"])
            ->setCellValue("H".$top_limit, $dl["pekerjaan_orang_tua_wali"])
            ->setCellValue("I".$top_limit, $dl["alamat_orang_tua_wali"])
            ->setCellValue("J".$top_limit, $dl["email_orang_tua_wali"])
            ->setCellValue("K".$top_limit, $dl["telepon_orang_tua_wali"])
            ->setCellValue("L".$top_limit, $dl["status_penerimaan"])
            ->setCellValue("M".$top_limit, $dl["checker"])
            ;
}

// Wrap it
$objPHPExcel->getActiveSheet()->getStyle('B6:M'.$top_limit)->getAlignment()->setWrapText(true);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Calon_Siswa_'.$ta_name_alt.'_'.date('d/m/Y').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


?>