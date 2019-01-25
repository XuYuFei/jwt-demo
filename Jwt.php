<?php
namespace app\index\controller;

use think\Controller;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

class Jwt extends Controller{
    
    public $secret  = "nbweo2i3nlxnla;3igasldnKWL2";
    
    public function _initialize(){
        // 跨域访问
        header('Access-Control-Allow-Origin: http://localhost:8080');
        
        // 也可以添加所有的请求为 允许，当然不推荐这样做了
        // header('Access-Control-Allow-Origin: *');
        
        // 设置允许headers: Authorization
        header("Access-Control-Allow-Headers: Authorization");
        
        // CORS跨域时axios无法获取服务器自定义的header信息
        header('Access-Control-Expose-Headers: token,uid');
        
        // CORS跨域，会先发送一次options请求预检，做不处理
        if($this->request->method() === 'OPTIONS'){
            die;
        }
    }
    
    // 登录
    public function login(){
        $user_id   = 123;
        $user_name = '北鱼';
        
        $token = $this->generateToken($user_id, $user_name);
        
        return json([
            'status' => 'success'
        ], 200, [
            'token' => $token
        ]);
    }
    
    // 列表
    public function getList(){
        $token = $this->request->header('authorization');
        
        $verify = $this->verifyToken($token);
        if(is_array($verify) && $verify['status'] == 'fail'){
            return json($verify);
        }
        $token  = $this->generateToken($verify->getClaim('user_id'), $verify->getClaim('user_name'));
        
        return json([
            'list' => [
                [
                    'title'  => 'title',
                    'desc'   => 'desc'
                ]
            ],
            'status' => 'success',
            'msg'    => '获取数据成功',
            'create_time' => date("Y-m-d H:i:s", $verify->getClaim("iat"))
        ], 200, [
            'token' => $token
        ]);
    }
    
    // 生成令牌
    private function generateToken($user_id, $user_name){
        $builder = new Builder();
        $signer  = new Sha256();
        
        $token = $builder->setIssuer("tp5")
                         ->setAudience("localhost:8080")
                         ->setId("abc", true)
                         ->setIssuedAt(time())
                         ->setNotBefore(time() + 60)
                         ->setExpiration(time() + 3600)
                         ->set("user_id", $user_id)
                         ->set("user_name", $user_name)
                         ->sign($signer, $this->secret)
                         ->getToken();
        $token = (string)$token;
        return $token;
    }
    
    // 验证令牌
    private function verifyToken($token){
        $signer = new Sha256();
        
        if(!$token){
            return [
                'msg'    => "Invalid token",
                'status' => 'fail'
            ];
        }
        
        try {
            $parse = (new Parser())->parse($token);
            
            if(!$parse->verify($signer, $this->secret)){
                return [
                    'msg'    => "Invalid token",
                    'status' => 'fail'
                ];
            }
            
            if($parse->isExpired()){
                return [
                    'msg'    => "Already expired",
                    'status' => 'fail'
                ];
            }
            
            return $parse;
        } catch (\Exception $e) {
            return [
                'msg'    => 'token异常',
                'status' => 'fail'
            ];
        }
    }
    
    public function test () {
        return $this->generateToken(1, '北鱼');
    }
    
}