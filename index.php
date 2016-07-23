<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
	include('function.php');
    include('connect.php');
    include('lib/simple_html_dom.php');

    $html = file_get_html('http://vnexpress.net/tin-tuc/thoi-su');
    
    /*Lay tin top 1 category */
    $titleTop = $html->find('h1.title_news a.txt_link');
    $introTop = $html->find('h4.news_lead');
    $imageTop = $html->find('.block_news_big img.width_image_common');
    $strInsertImageTop = "";
    $srcImageTop = "";
    $strLinkTop = "";
    $strInsertTitleTop = "";
    $strInsertIntroTop = "";
    $textTop = "";
    foreach($titleTop as $item) {
	    $strInsertTitleTop = $item->innertext;
        $alias = strip_tags(changeTitle($strInsertTitleTop));
        $alias = str_replace("&nbsp;", "", $alias);
        $strLinkTop = $item->href;
        $htmlTop = file_get_html($strLinkTop);
        $contentTop = $htmlTop->find('div.fck_detail');
        $headersTop = array();
        $headersTop["title"] = $htmlTop-> find("title",0)-> plaintext;
        $headersTop["keywords"] = $htmlTop-> find("meta[name=keywords]",0) ->getAttribute('content');  
        $headersTop["description"] = $htmlTop-> find("meta[name=description]",0) ->getAttribute('content'); 
        foreach($contentTop as $it) {
           $textTop = $it->innertext;
        }
        
    }
    foreach($introTop as $item) {
	    $strInsertIntroTop = $item->innertext;
    }
    
    foreach($imageTop as $item) {
	    $srcImageTop = $item->src;
        $strInsertImageTop = basename($item->src);
        $url = 'image_cate_thegioi21072016/'.$strInsertImageTop;
        file_put_contents($url,file_get_contents($srcImageTop));
    }
    $created_at = "2016-07-21 09:25:29.000000";
    $cate_id = 1;
    $user_id = 7;
    $keywordTop = $headersTop["keywords"];
    $descriptionTop = $headersTop["description"];
    //$textTop = "123414";
    //echo $strInsertTitleTop."----".$strInsertIntroTop."----".$strLinkTop."----".$alias."---".$headers["keywords"]."---".$headers["description"];
    $strInsertTop = "INSERT INTO posts (`name`,`alias`,`intro`,`content`,`image`,`keyword`,`description`,`user_id`,`cate_id`,`created_at`,`updated_at`) VALUES('".$strInsertTitleTop."','".$alias."','".$strInsertIntroTop."','".$textTop."','".$strInsertImageTop."','".$keywordTop."','".$descriptionTop."','".$user_id."','".$cate_id."','".$created_at."','".$created_at."' )";
    //echo $strInsertTop;
    //mysqli_query($con,$strInsertTop);



    /*----------------------*/

    $arrTitles = $arrIntros = $arrAlias = $arrLinks = $arrPosts =  array();
    $objTitle = $html->find('li .block_image_news h3.title_news a.txt_link');
    foreach ($objTitle as $item) {
        if(strpos($item->href, 'http://vnexpress.net/photo/') !== false || strpos($item->href, 'http://vnexpress.net/interactive/') !== false || strpos($item->href, 'http://video.vnexpress.net/') !== false)
        {
            echo $item->href;
        }
        else 
        {
            array_push($arrTitles, strip_tags($item->innertext));
            array_push($arrAlias, strip_tags(changeTitle($item->innertext)));
            array_push($arrLinks, $item->href);
            $htmlPosts =  file_get_html($item->href);
            $objPosts = $htmlPosts->find('div.fck_detail');
            foreach ($objPosts as $it) {
                array_push($arrPosts, $it->innertext);
            }
        }
        //echo strip_tags($item->innertext)."<br />";
        //$item->innertext = trim($item->innertext);
        

    }

    $objIntro = $html->find('li div.block_image_news div.news_lead');
    foreach ($objIntro as $item) {
        array_push($arrIntros, $item->innertext);
        //echo $item->innertext;
    }

    
    
    for($i = 0; $i < count($arrAlias); $i++) {
        $arrAlias[$i] = rtrim($arrAlias[$i],'-');
        
    }
    echo "<pre>";
    print_r($arrLinks);
    echo "</pre>";
   
    echo "<pre>";
    print_r($arrTitles);
    echo "</pre>";

    echo "<pre>";
    print_r($arrAlias);
    echo "</pre>";
?>


