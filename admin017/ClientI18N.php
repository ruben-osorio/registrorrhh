<?php
        
//Client @0-B0CA0DFA
define("RelativePath", ".");
define("PathToCurrentPage", "");
define("FileName", "");
include(RelativePath . "/Common.php");
$ClientFileEncoding = "UTF-8";
$AllowedFiles = array(
    "/^DatePicker\\.js$/" => "content-type: text/javascript; charset=$ClientFileEncoding",
    "/^Functions\\.js$/" => "content-type: text/javascript; charset=$ClientFileEncoding",
    "/^Globalize\\.js$/" => "content-type: text/javascript; charset=$ClientFileEncoding",
    "/^[\\w\\/]+_events\\.js$/" => "content-type: text/javascript; charset=$ClientFileEncoding"
);
$file = CCGetFromGet("file");
foreach ($AllowedFiles as $FileMask => $FileType) {
    if (preg_match($FileMask, $file)) {
        $file_content = "";
        $file_path = RelativePath . "/" . $file;
        if (file_exists($file_path)) {
            $fh = fopen($file_path, "rb");
            if (filesize($file_path))
                $file_content = fread($fh, filesize($file_path));
            fclose($fh);
            $file_content = preg_replace_callback("/\\{res:\s*(\w+)\\}/is", function($matches) use ($CCSLocales, $FileEncoding, $ClientFileEncoding) {
                return CCConvertEncoding($CCSLocales->GetText($matches[1]), $FileEncoding, $ClientFileEncoding);
            }, $file_content);
        }
        header($FileType);
        echo $file_content;
        exit;
    }
}
//End Client


?>
