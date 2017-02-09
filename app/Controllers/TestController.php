<?php
/**
 * Created by PhpStorm.
 * User: zoco
 * Date: 17/2/4
 * Time: 17:41
 */

namespace App\Controllers;

use App\Models\Main;
use App\Models\Tool;
use phpSplit\Split\Split;

/**
 * Class ChatController
 *
 * @package App\Controllers
 */
class TestController extends Controller {

    public function split() {
        $split = new Split();

        var_dump($split->simple("取了GameMode和FeedMode但是没有使用这两个值？"));
    }

    public function autolink() {
        $text = '大误 · 开工红包治疗法 http://daily.zhihu.com/story/9192382 http://pic2.zhimg.com/d26b5eb025de7ad3d17809ff5e5a0df1.jpg';
        echo Tool::autoLink($text);
    }
}