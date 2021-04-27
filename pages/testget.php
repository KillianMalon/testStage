<?php

require_once '../functions/sql.php';
require_once 'bdd.php';

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

$allcountry = countCountry($dbh);
$count = (int) $allcountry['0'];

var_dump($allcountry);
echo $count;

$parpage = 10;

$premier = ($currentPage * $parpage) - $parpage;

$pages = ceil($count/$parpage);

echo '<br>';
echo $pages;

$list = get_list_page($currentPage, $pages);
print_r($list);
echo '<br>';
foreach($list AS $link) {
    if ($link == '...')
        echo $link;
    else
        echo '<a href="?page=' . $link . '">'.$link.'</a>';
}

$premiere = testpage($dbh, $premier, $parpage);



