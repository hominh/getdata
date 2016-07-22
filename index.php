<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
	include('function.php');
    include('connect.php');
    include('lib/simple_html_dom.php');
    //$curl = new cURL();
    //$html = $curl->get('http://vnexpress.net/tin-tuc/the-gioi');

    /*$result = array();

    if(preg_match('#<h2>Mở thưởng (.*?) ngày (.*?)</h2>#',$html,$match)) {
        $result['w'] = $match[1];
        $result['day'] = $match[2];

    }

    if(preg_match('#<td class="bor f2 db" colspan="12">(.*?)</td>#',$html,$match))
    {
        $result['db'] = $match[1];
    }
    if(preg_match('#<td class="bor f2" colspan="12">(.*?)</td>#',$html,$match))
    {
        $result['giainhat'] = $match[1];
    }

    if(preg_match('#<td class="span-2 bol f1b"><h3>Giải Nhì</h3></td>' ."\n" . '<td class="bol f2" colspan="6">(.*?)</td>' ."\n" . '<td class="bor f2" colspan="6">(.*?)</td>#',$html,$match))
    {
        $result['giainhi1'] = $match[1];
    }*/

    /*if(preg_match('#<td class="bol f2" colspan="6">(.*?)</td>#',$html,$match))
    {
        $result['giainhi1'] = $match[1];
    }

    if(preg_match('#<td class="bor f2" colspan="6">(.*?)</td>#',$html,$match))
    {
        $result['giainhi2'] = $match[1];
    }*/

    $html = file_get_html('http://vnexpress.net/tin-tuc/the-gioi');
    
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
        $alias = changeTitle($strInsertTitleTop);
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
    /*----------------------*/
    $strInsertTop = "INSERT INTO posts (`name`,`alias`,`intro`,`content`,`image`,`keyword`,`description`,`user_id`,`cate_id`,`created_at`,`updated_at`) VALUES('".$strInsertTitleTop."','".$alias."','".$strInsertIntroTop."','".$textTop."','".$strInsertImageTop."','".$keywordTop."','".$descriptionTop."','".$user_id."','".$cate_id."','".$created_at."','".$created_at."' )";
    echo $strInsertTop;
    mysqli_query($con,$strInsertTop);


?>

