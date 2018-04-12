<?php
/*
 * This file is part of the abei2017/yii2-wx
 *
 * (c) abei <abei@nai8.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace tebie6\wx\mp\user;

use tebie6\wx\core\Driver;
use tebie6\wx\core\AccessToken;
use tebie6\wx\core\Exception;

/**
 * 备注助手
 * @author abei<abei@nai8.me>
 * @link https://nai8.me/yii2wx
 * @package tebie6\wx\mp\user
 */
class Remark extends Driver {

    const API_UPDATE_REMARK_URL = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark";

    /**
     * @var bool 接口令牌
     */
    private $accessToken = false;

    public function init(){
        parent::init();

        $this->accessToken = (new AccessToken(['conf'=>$this->conf,'httpClient'=>$this->httpClient,'extra'=>[]]))->getToken();
    }

    /**
     * 给一个用户打备注
     *
     * @param $openId
     * @param $remark
     * @return bool
     * @throws Exception
     */
    public function update($openId,$remark){
        $this->httpClient->formatters = ['uncodeJson'=>'tebie6\wx\helpers\JsonFormatter'];
        $response = $this->post(self::API_UPDATE_REMARK_URL."?access_token={$this->accessToken}",['openid'=>$openId,'remark'=>$remark])
            ->setFormat('uncodeJson')->send();

        $data = $response->getData();
        if(isset($data['errcode']) && $data['errcode'] == 0){
            return true;
        }else{
            throw new Exception($data['errmsg'],$data['errcode']);
        }
    }

}