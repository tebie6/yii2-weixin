<?php

/*
 * This file is part of the abei2017/yii2-wx.
 *
 * (c) abei <abei@nai8.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace tebie6\wx;

use tebie6\wx\core\Exception;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;

/**
 * bootstrap
 * 此类负责模块其他类的驱动以及相关变量的初始化
 *
 * @link https://nai8.me/yii2wx
 * @author abei<abei@nai8.me>
 * @package tebie6\wx
 */
class Application extends Component {

    /**
     * yii2-wx配置
     * @var
     */
    public $conf;

    /**
     * http客户端
     * @var
     */
    public $httpClient;

    /**
     * 类映射
     * @var array
     */
    public $classMap = [
        /**
         * 基础接口
         */
        'core.accessToken'=>'tebie6\wx\core\AccessToken',// token

        /**
         * 公众号接口
         */
        'mp.base'=>'tebie6\wx\mp\core\Base',    // 二维码
        'mp.qrcode'=>'tebie6\wx\mp\qrcode\Qrcode',    // 二维码
        'mp.shorturl'=>'tebie6\wx\mp\qrcode\Shorturl',    // 短地址
        'mp.server'=>'tebie6\wx\mp\server\Server',    // 服务接口
        'mp.remark'=>'tebie6\wx\mp\user\Remark',  //  会员备注
        'mp.user'=>'tebie6\wx\mp\user\User',  //  会员管理
        'mp.tag'=>'tebie6\wx\mp\user\Tag',    //  会员标签
        'mp.menu'=>'tebie6\wx\mp\menu\Menu',  // 菜单
        'mp.js'=>'tebie6\wx\mp\js\Js',    //  JS
        'mp.template'=>'tebie6\wx\mp\template\Template', //   消息模板
        'mp.pay'=>'tebie6\wx\mp\payment\Pay',//  支付接口
        'mp.mch'=>'tebie6\wx\mp\payment\Mch',//  企业付款
        'mp.redbag'=>'tebie6\wx\mp\payment\Redbag',//  红包
        'mp.oauth'=>'tebie6\wx\mp\oauth\OAuth',//  web授权
        'mp.resource'=>'tebie6\wx\mp\resource\Resource',//  素材
        'mp.kf'=>'tebie6\wx\mp\kf\Kf',//  客服
        'mp.customService'=>'tebie6\wx\mp\kf\CustomService',//  群发

        /**
         * 微信小程序接口
         */
        'mini.user'=>'tebie6\wx\mini\user\User', // 会员
        'mini.pay'=>'tebie6\wx\mini\payment\Pay', // 支付
        'mini.qrcode'=>'tebie6\wx\mini\qrcode\Qrcode', // 二维码&小程序码
        'mini.template'=>'tebie6\wx\mini\template\Template', // 模板消息
    ];

    public function init(){
        parent::init();
        $this->httpClient = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * 驱动函数
     * 此函数主要负责生成相关类的实例化对象并传递相关参数
     *
     * @param $api string 类的映射名
     * @param array $extra  附加参数
     * @throws Exception
     * @return object
     */
    public function driver($api,$extra = []){
        $config = [
            'conf'=>$this->conf,
            'httpClient'=>$this->httpClient,
            'extra'=>$extra,
        ];

        if(empty($api) OR isset($this->classMap[$api]) == false){
            throw new Exception('很抱歉，你输入的API不合法。');
        }

        $config['class'] = $this->classMap[$api];

        return Yii::createObject($config);
    }
}