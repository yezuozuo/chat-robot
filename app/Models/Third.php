<?php
/**
 * Created by PhpStorm.
 * User: zoco
 * Date: 17/2/4
 * Time: 18:13
 */

namespace App\Models;

/**
 * Class Third
 *
 * @package App\Models
 */
class Third extends Main {

    /**
     * 百度图片
     *
     * @param $text
     * @return string
     */
    static public function baiduImg($text) {
        $data = array(
            'tn'      => 'resultjson_com',
            'ipn'     => 'rj',
            'ct'      => '201326592',
            'fp'      => 'result',
            'cl'      => '2',
            'adpicid' => '',
            'istype'  => '2',
            'word'    => $text,
        );
        $url  = 'image.baidu.com/search/acjson?' . http_build_query($data);
        $res  = Tool::curl($url);

        if (!isset($res['data'])) {
            $res_str = 'api error!';
        } else {
            $rand_key = array_rand($res['data']);
            $rand_arr = $res['data'][$rand_key];
            $res_str  = ($rand_arr['middleURL'] ? $rand_arr['middleURL'] : $rand_arr['thumbURL']) . PHP_EOL;
        }

        return $res_str;
    }

    /**
     * 计算
     *
     * @param $text
     * @return bool|mixed
     */
    static public function calculate($text) {
        $data = array(
            'expr' => $text,
        );
        $url  = "http://api.mathjs.org/v1/?" . http_build_query($data);
        $res  = Tool::curl($url);

        return $res;
    }

    /**
     * wiki
     *
     * @param $text
     * @return string
     */
    static public function wiki($text) {
        $lang     = 'en';
        $is_search  = false;

        if ($is_search) {
            //https://en.wikipedia.org/w/api.php?&format=json&action=query&list=search&srlimit=20&srsearch=beijing&continue=
            $data = array(
                'format'   => 'json',
                'action'   => 'query',
                'list'     => 'search',
                'srlimit'  => '20',
                'continue' => '',
                //'srsearch' => implode(' ', $parms),
            );
        } else {
            //https://en.wikipedia.org/w/api.php?&format=json&action=query&prop=extracts&exchars=300&redirects=1&exsectionformat=plain&explaintext=&titles=beijing
            $data = array(
                'format'          => 'json',
                'action'          => 'query',
                'prop'            => 'extracts',
                'exchars'         => '300',
                'redirects'       => 1,
                'exsectionformat' => 'plain',
                'explaintext'     => '',
                'titles'          => $text,
                //'titles' => implode(' ', $parms),
            );
        }

        $url = "https://{$lang}.wikipedia.org/w/api.php?" . http_build_query($data);
        $res = Tool::curl($url);

        $res_str = '';
        if (!isset($res['query'])) {
            $res_str = '好像出问题了，稍后再试下吧！';
        } else {
            if ($is_search) {
                if (empty($res['query']['search'])) {
                    $res_str = 'No results found';
                } else {
                    foreach ($res['query']['search'] as $v) {
                        $res_str .= $v['title'] . PHP_EOL;
                    }
                }
            } else {
                if (empty($res['query']['pages'])) {
                    $res_str = 'No results found';
                } else {
                    foreach ($res['query']['pages'] as $v) {
                        $res_str .= (isset($v['extract']) ? $v['extract'] : $v['title']) . PHP_EOL;
                    }
                }
            }
        }

        return $res_str;
    }

    /**
     * @param $text
     * @return string
     */
    static public function zhihu($text) {
        $url = "http://news-at.zhihu.com/api/4/news/latest";
        $res = Tool::curl($url);

        if (!isset($res['stories'])) {
            $res_str = '好像出问题了，稍后再试下吧！';
        } else {
            $rand_key = array_rand($res['stories']);
            $tmp      = $res['stories'][$rand_key];
            $res_str  = $tmp['title'] . PHP_EOL;
            $res_str .= ('http://daily.zhihu.com/story/' . $tmp['id']) . PHP_EOL;
            $res_str .= $tmp['images'][0] . PHP_EOL;
        }

        return $res_str;
    }

    /**
     * @param $num
     * @return null|string
     */
    static public function boobs($num) {
        $url = "http://api.oboobs.ru/noise/{$num}";
        $res = Tool::curl($url);

        $res_str = null;
        if (!isset($res) || !isset($res[0]['preview'])) {
            $res_str = 'Cannot get that boobs, trying another one...';
        } else {
            foreach ($res as $v) {
                $res_str = 'http://media.oboobs.ru/' . $v['preview'];
            }
        }

        if (empty($res_str)) {
            $res_str = 'Cannot get that boobs, trying another one...';
        }

        return $res_str;
    }

    /**
     * @param $num
     * @return null|string
     */
    static public function butts($num) {
        $url = "http://api.obutts.ru/noise/{$num}";
        $res = Tool::curl($url);

        $res_str = null;
        if (!isset($res) || !isset($res[0]['preview'])) {
            $res_str = 'Cannot get that boobs, trying another one...';
        } else {
            foreach ($res as $v) {
                $res_str = 'http://media.obutts.ru/' . $v['preview'];
            }
        }

        if (empty($res_str)) {
            $res_str = 'Cannot get that boobs, trying another one...';
        }

        return $res_str;
    }

    /**
     * @param $text
     * @return string
     */
    static public function gif($text) {

        $data = array(
            'api_key' => 'dc6zaTOxFJmzC',
            'limit'   => '5',
            'offset'  => '0',
            'rating'  => 'y',
            'fmt'     => 'json',
            'q'       => $text,
        );
        $url  = 'http://api.giphy.com/v1/gifs/search?' . http_build_query($data);
        $res  = Tool::curl($url);

        if (!isset($res['data'])) {
            $res_str = 'api error!';
        } else {
            $rand_key = array_rand($res['data']);
            $rand_arr = $res['data'][$rand_key];

            if (isset($rand_arr['images']) && isset($rand_arr['images']['original'])) {
                $res_str = $rand_arr['images']['original']['url'] . PHP_EOL;
            } else {
                $res_str = $rand_arr['url'] . PHP_EOL;
            }
        }

        return $res_str;
    }

    /**
     * @param $text
     * @return string
     */
    static public function yunpan($text) {
        $data = array(
            'key' => 'AIzaSyACNEu_BDGyBwZiQjZ5fw3ksHzo56FeoGA',
            'cx' => '010607825858754423132:z7eh-8uygee',
            'q' => $text,
        );
        $url = "https://www.googleapis.com/customsearch/v1?" . http_build_query($data);
        $res = Tool::curl($url);

        $res_str = '';
        if (!empty($res['items'])) {
            foreach ($res['items'] as $v) {
                $res_str = $res_str . $v['title'] . ' - ' . $v['link'] . PHP_EOL;
            }
        }

        if (empty($res_str)) {
            $res_str = 'api error!';
        }

        return $res_str;
    }

    /**
     * @param $text
     * @return string
     */
    static public function pixabay($text) {
        $data = array(
            'key' => '2247422-5a682bb78206ac4882ff8954a',
            'image_type' => 'all',
            'lang' => 'zh',
            'orientation' => 'all',
            'safesearch' => 'false',
            'order' => 'latest',
            'page' => '1',
            'per_page' => '5',
            'pretty' => 'false',
            'q' => $text,
        );
        $url = 'https://pixabay.com/api/?' . http_build_query($data);
        $res = Tool::curl($url);

        if (!isset($res['hits'])) {
            $res_str = 'api error!';
        } else {
            $rand_key = array_rand($res['hits']);
            $rand_arr = $res['hits'][$rand_key];
            $res_str = ($rand_arr['webformatURL'] ? $rand_arr['webformatURL'] : $rand_arr['previewURL']) . PHP_EOL;
        }

        return $res_str;
    }

    /**
     * @return null|string
     */
    static public function tumblr() {

        //可以查询的博客地址
        $base_blog_arr = array(
            'jumpinggirlsession.tumblr.com',
            'carudamon119.tumblr.com',
            'wonderwall99999.tumblr.com',
            'nanamizm.tumblr.com',
            'beatutifulwoman.tumblr.com',
            'kusanoryu.tumblr.com',
            'phorbidden.tumblr.com',
            'uchida4649.tumblr.com',
            'czzoo.tumblr.com',
            'tetu0831.tumblr.com',
            'asagaonosakukisetu.tumblr.com',
            'renatakeda.tumblr.com',
            'kpivy8.tumblr.com',
            'fukunono22.tumblr.com',
        );

        $send_image_num = 1;
        //默认地址
        $blog_url = $base_blog_arr[array_rand($base_blog_arr)];

        //处理成 URL
        $tmp = explode('.', $blog_url);
        if (count($tmp) == 1) {
            $blog_url .= '.tumblr.com';
        }

        // 查询
        $data = array(
            'api_key' => 'PAI0ehMRq9LJQienTSyk934REZ8z9tbEz8hKZSrgDBOukv49Oz',
            'type' => 'photo',
            'notes_info' => 'false',
        );
        $url = "https://api.tumblr.com/v2/blog/{$blog_url}/posts?" . http_build_query($data);
        $res = Tool::curl($url);

        $res_str = null;
        if (isset($res['meta']) && isset($res['meta']['status']) && $res['meta']['status'] == 200) {
            if (isset($res['response']) && isset($res['response']['posts'])) {

                $posts = $res['response']['posts'];
                shuffle($posts);

                for ($i = 0; $i < count($posts) && $i < $send_image_num; $i++) {
                    $post = $posts[$i];
                    $res_str = $post['slug'] . ' - ' . $post['photos'][0]['original_size']['url'];
                }
            }
        }

        if (empty($res_str)) {
            $res_str = 'Cannot get that blog, trying another one...';
        }

        return $res_str;
    }
}