<?php
/**
 * 文件路径
 * @author bignerd
 * @since  2017-03-28T13:19:03+0800
 * @param  $file_path
 */
function download($file_path)
{

    if(file_exists($file_path)){
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    }
}
?>