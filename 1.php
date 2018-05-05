<?php
error_reporting(0);

$tvid=isset($_GET['tv']) ? $_GET['tv'] : '';
$idd=isset($_GET['id']) ? $_GET['id'] : '1';

function curl_http($url)
{
    // 霈曄蔭霂瑟�仍, ��㗇𧒄�䠷�閬�,��㗇𧒄�嗘�滨鍂,��贝窈瘙�穃��糓�炏��匧笆摨𠉛����
    //$header[] = "Content-type: application/x-www-form-urlencoded";
    $UserAgent = "Mozilla/5.0 (Linux; U; Android 2.3.6; zh-cn; GT-S5660 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MicroMessenger/4.5.255";
    $curl = curl_init();	//��𥕦遣銝�銝芣鰵��URL韏��
    curl_setopt($curl, CURLOPT_URL, $url);	//霈曄蔭URL��𣬚㮾摨𠉛��厰★
    curl_setopt($curl, CURLOPT_HEADER, 0);  //0銵函內銝滩�枏枂Header嚗�1銵函內颲枏枂
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);	//霈曉�𡁏糓�炏�遬蝷箏仍靽⊥,1�遬蝷綽��0銝齿遬蝷箝��
    //憒�𨀣�𣂼�笔蘨撠��𤘪�𡏭�𥪜���䔶�滩䌊�𢆡颲枏枂隞颱�訫��捆���𨅯仃韐亥�𥪜�靭ALSE
    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_ENCODING, '');	//霈曄蔭蝻𣇉�聢撘𧶏�䔶蛹蝛箄”蝷箸𣈲�����㗇聢撘讐��𣇉��
    //header銝凌�𦯷ccept-Encoding: �嗪������捆嚗峕𣈲����𣇉�聢撘譍蛹嚗�"identity"嚗�"deflate"嚗�"gzip"��
    curl_setopt($curl, CURLOPT_REFERER, "mp.weixin.qq.com");
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    //霈曄蔭餈嗘葵�厰★銝箔�銝芷�鮋妟��(鞊� �𦚵ocation: ��)��仍嚗峕�滚𦛚�膥隡𡁏�𠰴��枏�䥅TTP憭渡�������煾��(瘜冽�讛�蹱糓�鍦�垍��釶HP撠��煾�耦憒� �𦚵ocation: �𦦵�仍)��
    
    $data = curl_exec($curl); 
    //echo curl_errno($curl); //餈𥪜��0�𧒄銵函內蝔见�𤩺�銵峕�𣂼��
    curl_close($curl);	//���𡡒cURL韏�琜��僎��𦠜𦆮蝟餌�蠘���
    
    return $data;

}


function tvids($id)
{
    switch ($id) {
    case 'tv':
        return $id;
        break;
    case 'ty':
        return $id;
        break;
    case 'ys':
        return $id;
        break;
    case 'ws':
        return $id;
        break;
    case 'njitv':
        return $id;
        break;
    case 'lnitv':
        return $id;
        break;
    case 'snitv':
        return $id;
        break;
    case 'hbitv':
        return $id;
        break;
    case 'fjitv':
        return $id;
        break;
    case 'gditv':
        return $id;
        break;
    case 'jxitv':
        return $id;
        break;
    case 'gdutv':
        return $id;
        break;
    case 'btv':
        return $id;
        break;
    case 'hktv':
        return "gtitv";
        break;
    default:
        return 'ys';
        break;
    }
}

function http_url($url)
{
    $header = get_headers($url,1);
    if (strpos($header[0],'301') || strpos($header[0],'302')) {
        if(is_array($header['Location'])) {
            $info = $header['Location'][count($header['Location'])-1];
        }else{
            $info = $header['Location'];
        }
    }
    return $info;
}

if($tvid){
    $content=curl_http('http://m.iptv789.com/iptv.php?tid='.tvids($tvid));
    preg_match_all('/<li><a href="(.*?)" data-ajax="(.*?)">(.*?)<\/a><\/li>/m', $content, $matches);
    
    foreach ($matches[1] as $key=>$value) {
        
        $content=curl_http("http://m.iptv789.com/wxiptv.php".$value);
        
        preg_match_all('/<option value="(.*?)">(.*?)<\/option>/m', $content, $tvVal[]);

    }

    $str=explode('?', $tvVal[$idd-1][1][0]);

    $tvurl = http_url("http://m.iptv789.com/m3u8.php?".$str[1]);
    header("Content-type: application/vnd.apple.mpegurl");
    header("Location: $tvurl");

    
}else{
  echo "颲枏���㕑秤.";  
}



?>
