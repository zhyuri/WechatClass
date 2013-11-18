<?php

class fetch
{
    private $url;

    function __construct()
    {
        $url = "http://blog.csdn.net/yuri_4_vera";
    }

    public function get()
    {
        $content = file_get_contents($this->url);
    
        $regex = '/<li>(.*?)<\/li>/si';
        if(preg_match_all($regex, $content,$result,PREG_PATTERN_ORDER))
        {
            for ( $i = 0; $i < 7; $i ++ )
            {
                    $result[1][$i] = preg_replace("<[][^<span>]*>","", $result[1][$i]);
                    $result[1][$i] = preg_replace("<[][^/]*>","", $result[1][$i]);
            }
            return $result[1];
        }
    }
}

?>