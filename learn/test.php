<?php
$file = fopen("php://memory", 'w');
fwrite($file, "Hello World \n");
fwrite($file, "j'aime travaille dans le equipe \n");
fclose($file);

$stream = fopen("php://memory", "r");
while (!feof($stream)) {
    echo fgetc($stream);
}
fclose($stream);

// $handle = fopen("https://google.com", "r");
// while (!feof($handle)) {
//     echo fgetc($handle);
// }
// fclose($handle);
