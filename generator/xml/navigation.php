<?php
$xml_file = "../../data/sitemap.xml";
$xml = file_get_contents($xml_file);
$current_page = "seite1_1";
$sep_navbar = " > ";

function link_gen_menu($siteobj)
{
    return "<a href='$siteobj->url' title='$siteobj->name2'>$siteobj->name1</a>";
}
function link_gen_bar($nav_el, $nav_el_name, $sep_navbar)
{
    return "<a href='$nav_el'>$nav_el_name</a>$sep_navbar";
}


if ($sitemapobj = simplexml_load_string($xml)) {
    
    //--Menu--
    
    $menu = "<ul>";
    
    //Top-Level Sites
    foreach ($sitemapobj->page as $site) {
        $menu .= "<li>";
        $menu .= link_gen_menu($site);
        
        //First-Level Sites
        if (!empty($site->page)) {
            $menu .= "<ul>";
            foreach ($site->page as $site_1) {
                if (!empty($site_1)) {
                $menu .= "<li>";
                $menu .= link_gen_menu($site_1);
                
                //Second-Level Sites
                if (!empty($site_1->page)) {
                    $menu .= "<ul>";
                    foreach ($site_1->page as $site_2) {
                        $menu .= "<li>";
                        $menu .= link_gen_menu($site_2);
                        $menu .= "</li>";
                    }
                    unset($site_2);
                    $menu .= "</ul>";
                }
                $menu .= "</li>";
                }
            }
            unset($site_1);
            $menu .= "</ul>";
        }
        $menu .= "</li>";
    }
    unset($site);

    $menu .= "</ul>";
    
    //--Navigation Bar--
    
    $nav_bar = "";
    $nav_element[] = "index";
    foreach ($sitemapobj->page as $site) {
        if (trim(strtolower($site->url)) != "index") {
            if ($site->url == $current_page) {
                $nav_element[] = $site->url;
            } elseif (!empty($site->page)) {
                    foreach ($site->page as $site_1) {
                        if ($site_1->url == $current_page) {
                            $nav_element[] = $site->url;
                            $nav_element[] = $site_1->url;
                        } elseif (!empty($site_1->page)) {
                            foreach ($site_1->page as $site_2) {
                                if ($site_2->url == $current_page) {
                                    $nav_element[] = $site->url;
                                    $nav_element[] = $site_1->url;
                                    $nav_element[] = $site_2->url;
                                }
                            }
                            unset($site_2);
                        }
                    }
                    unset($site_1);
            }
        }
    }
    unset($site);
    
    //Generate Navigation Bar
    foreach ($nav_element as $nav_el) {
        
        //Get Name1 of $nav_el (is currently the URL)
        foreach ($sitemapobj->page as $site) {
            if ($site->url == $nav_el) {
                $nav_el_name = $site->name1;
            } elseif (!empty($site->page)) {
                foreach ($site->page as $site_1) {
                    if ($site_1->url == $nav_el) {
                        $nav_el_name = $site_1->name1;
                    } elseif (!empty($site_1->page)) {
                        foreach ($site_1->page as $site_2) {
                            if ($site_2->url == $nav_el) {
                                $nav_el_name = $site_1->name1;
                            }
                        }
                        unset ($site_2);
                    }
                }
                unset($site_1);
            }
        }
        unset($site);
        
        //Add Element to NavBar
        $nav_bar .= link_gen_bar($nav_el, $nav_el_name, $sep_navbar);
    }
    unset($nav_el);
    unset($nav_el_name);
    
    //Remove End of the NavBar
    $nav_bar = substr($nav_bar, 0, strlen($nav_bar) - 3);
}
unset($sitemapobj);


//Debugging
echo $menu;
print_r($nav_element);
echo "<br>";
echo $nav_bar;
?>