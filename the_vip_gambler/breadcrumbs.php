<?php
function breadcrumbs() {
    $theFullUrl = $_SERVER["REQUEST_URI"];
    $urlArray=explode("/",$theFullUrl);
    echo '<strong>You are here:</strong> <a href="/">Home</a>';
    while (list($j,$text) = each($urlArray)) {
        $dir='';
        if ($j > 1) {
            $i=1;
            while ($i < $j) {
                $dir .= "/" . $urlArray[$i];
                $text = $urlArray[$i];
                $i++;
            }
            if($j < count($urlArray)-1) echo ' &raquo; <a href="'.$dir.'">' . str_replace("-", " ", $text) . '</a>';
        }
    }
    echo wp_title();
}
breadcrumbs();
?>