<header>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</header>
<?php

$dir = './Facture';
$files = scandir($dir, 1);
var_dump($files);
foreach ($files as $file){
    if($file === "." || $file ===".."){

    }else{
        $file = './Facture/'.$file
    ?>

    <embed src="<?= $file ?> "width="500" height="375 type="application/pdf">
<?php
}
}

$dir_iterator = new RecursiveDirectoryIterator(dirname(__FILE__));
$iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($iterator as $file) {
    if(substr($file, -2,2) === "\."){
        echo "hey";
        echo '<br>';
    }else{
        echo $file;
        echo '<br>';
    }
}
?>


