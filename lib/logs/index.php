<?php

recurse(".");

function recurse($path){
    foreach(scandir($path) as $o){
        if($o != "." && $o != ".."){
            $full = $path . "/" . $o;
            if(is_dir($full)){
                if(!file_exists($full . "/index.php")){
                    file_put_contents($full . "/index.php", "");
                }
                recurse($full);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>404 Not Found!</title>
</head>
<body>
    <h2>404 NOT FOUND!</h2>
    <p>Make sure you type the address correctly</p>
</body>
</html>