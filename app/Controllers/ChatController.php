<?php

namespace App\Controllers;

use App\Models\Main;
use App\Models\Third;
use App\Models\Weather;

/**
 * Class ChatController
 *
 * @package App\Controllers
 */
class ChatController extends Controller {

    public function index() {
        //echo json_encode(['data' => 123]);
        $content = $_REQUEST['content'];
        switch ($content) {
            case '帮助':
                $answer = '哈哈哈';
                break;
            case 'ls':
                $answer = '帮助<br>';
                break;
            case '张帅图片':
                $answer = Third::baiduImg('狗');
                break;
            case '计算':
                $answer = Third::calculate('2+2');
                break;
            case 'wiki':
                $answer = Third::wiki('天安门');
                break;
            case 'google':
                $answer = Third::google('天安门');
                break;
            case 'zhihu':
                $answer = Third::zhihu('123');
                break;
            case 'boobs':
                $answer = Third::boobs(2);
                break;
            case 'butts':
                $answer = Third::butts(2);
                break;
            case 'gif':
                $answer = Third::gif('dog');
                break;
            case 'yunpan':
                $answer = Third::yunpan('哈哈哈');
                break;
            case 'pixabay':
                $answer = Third::pixabay('dog');
                break;
            case 'tumblr':
                $answer = Third::tumblr();
                break;
            case 'weather':
                $answer = Weather::get('beijing');
                break;
            default:
                $answer = $this->talk($_REQUEST['content']);
                break;
        }
        z_log($_REQUEST['content']);
        echo json_encode(['data' => $answer]);
    }

    private function talk($content) {
        $key = '2085ad3cb7af434a8091153da3b44fbe';
        $re  = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key=' . $key . '&info=' . $content), true);
        z_log($re['code'] . ':' . $re['text']);
        $code = $re['code'];
        switch ($code) {
            case 100000:
                $content = $re['text'];
                break;
            case 200000:
                $content = $re['text'] . $re['url'];
                break;
            case 302000:
                $list    = $re['list'];
                $i       = rand(0, count($list) - 1);
                $list    = $list[$i];
                $content = $re['text'] . '：' . $list['article'];
                break;
            case 305000:
                $list    = $re['list'];
                $i       = rand(0, count($list) - 1);
                $list    = $list[$i];
                $content = '起始站：' . $list['start'] . '，到达站：' . $list['terminal'] . '，开车时间：' . $list['starttime'] . '，到达时间：' . $list['endtime'] . '。亲，更多信息请上网查询哦！';
                break;
            case 306000:
                $list    = $re['list'];
                $i       = rand(0, count($list) - 1);
                $list    = $list[$i];
                $content = '航班：' . $list['flight'] . '，航班路线：' . $list['route'] . '，起飞时间：' . $list['starttime'] . '，到达时间：' . $list['endtime'] . '。亲，更多信息请上网查询哦！';
                break;
            case 310000:
                $list    = $re['list'];
                $i       = rand(0, count($list) - 1);
                $list    = $list[$i];
                $content = $list['info'] . '中奖号码：' . $list['number'] . '。亲，小赌怡情，大赌伤身哦！';
                break;
            case 40004:
                $content = '今天累了，明天再聊吧';
                break;
            default:
                $content = $re['text'];
        }

        return $content;
    }
}