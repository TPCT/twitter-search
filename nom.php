<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function cookies()
    {
        $cookie_file = substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)), 0, 5) . substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 27)), 0, 7) . substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)), 0, 5);
        return $cookie_file;
    }
    $m = cookies() . ".txt";
    $s = $m;
    function search($keyword = '', $number = 0)
    {
        global $s;
        $ch = curl_init();
        $data = [];
        $refresh_url = '';
        curl_setopt($ch, CURLOPT_URL, "https://mobile.twitter.com/search?q=" . urlencode($keyword));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $s);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $s);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko');
        $page = curl_exec($ch);
        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $find = new DOMXPath($doc);
        $find1 = new DOMXPath($doc);
        while ($find->query('//div[@class="noresults"]')->length == 0) {
            $refresh = $find->query('//td[@class="r"]');
            if ($refresh->length > 0) {
                foreach ($refresh as $re) {
                    foreach ($re->childNodes as $r) {
                        if ($r->nodeName == 'a') {
                            $refresh_url = 'https://m.twitter.com' . ($r->getAttribute('href'));
                            break;
                        }
                    }
                }
            }
            curl_setopt($ch, CURLOPT_URL, $refresh_url);
            $page = curl_exec($ch);
            $doc = new DOMDocument();
            $doc->loadHTML($page);
            $find = new DOMXPath($doc);
            $tweets = $find->query('//td[@class="tweet-content"]');
            $userinfo = $find->query('//td[@class="user-info"]');
            $timestamp = $find->query('//td[@class="timestamp"]');
            for ($i = 0; $i <= $tweets->length - 1; $i++) {
                $t = [];
                @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Timestamp-Data: ' . $timestamp[$i]->textContent)));
                @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'User-Data: ' . $userinfo[$i]->textContent)));
                @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Tweet-Url: <a href="https://www.twitter.com' . explode('?', $timestamp[$x]->childNodes[1]->getAttribute('href'))[0].'\">URL</a>')));
                @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Tweet-Data: ' . $tweets[$i]->textContent)));
                if (!in_array($t, $data)) {
                    $data[] = $t;
                }
            }
        }
        for ($i = 0; $i < $number; $i++) {
            @$load_more = $find1->query('//div[@class="w-button-more"]')[0]->childNodes[1]->getAttribute('href');
            if ($load_more) {
                $load_more = 'https://mobile.twitter.com' . $load_more;
                curl_setopt($ch, CURLOPT_URL, $load_more);
                $page = curl_exec($ch);
                $doc = new DOMDocument();
                $doc->loadHTML($page);
                $find1 = new DOMXPath($doc);
                $tweets = $find1->query('//td[@class="tweet-content"]');
                $userinfo = $find1->query('//td[@class="user-info"]');
                $timestamp = $find1->query('//td[@class="timestamp"]');
                for ($x = 0; $x <= $tweets->length - 1; $x++) {
                    $t = [];
                    @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Timestamp-Data: ' . $timestamp[$x]->textContent)));
                    @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'User-Data: ' . $userinfo[$x]->textContent)));
                    @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Tweet-Url: <a href="https://www.twitter.com' . explode('?', $timestamp[$x]->childNodes[1]->getAttribute('href'))[0].'\">URL</a>')));
                    @$t[] = preg_replace('/\s+/', ' ', str_ireplace("\t", '', str_ireplace("\n", '', 'Tweet-Data: ' . $tweets[$x]->textContent)));
                    if (!in_array($t, $data)) {
                        $data[] = $t;
                    }
                }
            } else {
            }
        }
        if (json_encode(($data))) {
            return json_encode(($data));
        } else {
            return json_encode([["None"]]);
        }
    }
    function start()
    {
        global $s;
        if (isset($_POST['query']) and isset($_POST['number']) and isset($_POST['runtime'])) {
            if (strlen($_POST['query']) > 0 and @(int)$_POST['number'] >= 0) {
                $tweets = search($_POST['query'], @(int)$_POST['number']);
                print_r($tweets);
                @fopen($s,'w+');
                @unlink($s);
            } else {
                print('[+] Something error Occurred.');
            }
        } else {
            print('[+] Something error Occurred.');
        }
    }
    start();
}else{
    header("Location: /index.php");
}
?>
