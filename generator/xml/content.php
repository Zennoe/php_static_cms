<?php
$xml_file_con = "../../data/content.xml";
$xml_con = file_get_contents($xml_file_con);
$xml_file_sitemap = "../../data/sitemap.xml";
$xml_sitemap = file_get_contents($xml_file_sitemap);
$current_page = "index";
$content = "No content loaded :(";

if ($contentobj = simplexml_load_string($xml_con) && $sitemapobj = simplexml_load_string($xml_sitemap)) {
    foreach ($contentobj->page as $cur_contentobj) {
        if (trim($cur_contentobj->url) == $current_page) {
            $content = trim($cur_contentobj->content);
            
        }
    }
    unset($cur_contentobj);
} else {
    // TODO convert to error
    echo "SimpleXML error!";
}

// Debugging
echo $current_page;
echo "<br>";
echo $content;
?>