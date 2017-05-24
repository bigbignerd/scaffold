<?php
function fileExist($url)
{
    $file_headers = @get_headers($url);
    if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 500 Internal Server Error') {
        $exists = false;
    }else{
        $exists = true;
    }
    return $exists;
}
?>