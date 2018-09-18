<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Test extends Controller
{
    //律师信息
    public function imformation(){
        $uid=input('uid',0,'intval');
        $imformation=Db::name('user')->field('imageUrl,aboutMe,address,sws,tel,qq,wechat,relName,bdweizhi,email')->find($uid);
        return $imformation;
    }
    
    //专长
    public function speciality(){
        $uid=input('uid',0,'intval');
        $specialityId=db('user')->field('zc2')->find($uid);
        $zcStr=  str_replace('@', ',', trim($specialityId['zc2'],'@'));
        $specialityId=db('class_law')->where('id in('.$zcStr.')')->column('className');
        return $specialityId;
    }
    
    //文集列表 yx_user_art_zdy
    public function articel_list() {
        $uid=input('uid',0,'intval');
        $page=input('page',0,'intval');
		$fourClassId=input('fourClassId',0,'intval');
        $size=6;
        $start=$page*$size;
        // $list=db('user_art_zdy')->field('title,descript,id')->where('userId='.$uid)->limit($start,$size)->order('addtime desc')->select();
        $list=db('user_art_zdy')->field('title,descript,id,zhanshiId,imageUrl')->where('userId='.$uid.' and fourClassId='.$fourClassId)->limit($start,$size)->order('zhanshiId desc,addtime desc')->select();
        foreach($list as $k=>$v){
            $list[$k]['descript']=str_replace('&nbsp;','',($v['descript']));
			//文章图片
			$t_img=array("http://www.faweishi.com/images/ggimages/banner1.jpg","http://www.faweishi.com/images/ggimages/banner2.jpg"); 
			$title_num=array_rand($t_img,1);
			$title_img=$t_img[$title_num];				
			$list_img=$list[$k]['imageUrl'];		
			if(!$list_img){		
			$notes_img=$title_img;			
			}else{
			  $notes_img=$list_img;
			}
			  $list[$k]['imageUrl']=$notes_img;			
			

        }
		
        return $list;
    }
	
	//案例列表 yx_user_art_zdy
    public function case_list() {
        $uid=input('uid',0,'intval');
        $page=input('page',0,'intval');
		$fourClassId=input('fourClassId',0,'intval');
        $size=6;
        $start=$page*$size;    
        $case=db('user_art_zdy')->field('title,descript,id,zhanshiId,imageUrl')->where('fourClassId !='.$fourClassId.' and userId='.$uid)->limit($start,$size)->order('zhanshiId desc,addtime desc')->select();
        foreach($case as $k=>$v){
            $case[$k]['descript']=str_replace('&nbsp;','',($v['descript']));
			//文章图片
			$t_img=array("http://www.faweishi.com/images/ggimages/banner1.jpg","http://www.faweishi.com/images/ggimages/banner2.jpg"); 
			$title_num=array_rand($t_img,1);
			$title_img=$t_img[$title_num];				
			$list_img=$case[$k]['imageUrl'];
			
			if(!$list_img){		
			$notes_img=$title_img;			
			}else{
			  $notes_img=$list_img;
			}
			  $case[$k]['imageUrl']=$notes_img;
        }		
        return $case;
    }
    
    //文章内容
    public function article() {
        $aid=input('aid',0,'intval');
        $article=db('user_art_zdy')->field('title,contentInfo')->where('id='.$aid)->find();
        $article['contentInfo']=str_replace('&nbsp;',"\n",$article['contentInfo']);
        return $article;
    }
    
    //提交咨询
    public function consult() {
        $stream=input();
        $stream=json_decode($stream[0],true);
        $data=array(
            'userId'=>$stream['uid'],
            'telephone'=>$stream['phone'],
            'contentInfo'=>$stream['content'],
            'title'=>$stream['title'],
            'addtime'=>date('Y-m-d H:i:s'),
			'isPay'=>0,
			'money'=>0,
            'province'=>0,
            'city'=>0
        );
        $res=db('zixun')->insert($data);
        return $res;
    }
	
	//付费在线咨询-2018.4.2
    public function payConsult() {
        $stream=input();
        $stream=json_decode($stream[0],true);
        $data=array(
            'userId'=>$stream['uid'],
            'telephone'=>$stream['phone'],
            'contentInfo'=>$stream['content'],
            'isPay'=>1,
            'money'=>$stream['money'],
            'addtime'=>date('Y-m-d H:i:s'),
			'province'=>0,
            'city'=>0
        );
        $res=db('zixun')->insert($data);
        return $res;
    }
	
	
	//付费电话咨询-2018.4.2
    public function payConsult() {
        $stream=input();
        $stream=json_decode($stream[0],true);
        $data=array(
            'userId'=>$stream['uid'],
            'telephone'=>$stream['phone'],
            'isPay'=>1,
            'money'=>$stream['money'],
            'addtime'=>date('Y-m-d H:i:s'),
			'province'=>0,
            'city'=>0
        );
        $res=db('zixun')->insert($data);
        return $res;
    }
	
    
    //首页信息 banner 文集 律师风采  亲办案例
    public function index() {
        $uid=input('uid',0,'intval');
        $webId=input('webId',0,'intval');
		$fourClassId=input('fourClassId',0,'intval');
        
	    // $list=db('user_art_zdy')->field('title,id,fourClassId')->where('fourClassId',$fourClassId)->limit(0,5)->order('addtime desc')->select();
	    //律师文集
		$list=db('user_art_zdy')->field('title,id,fourClassId,zhanshiId,imageUrl')->where('fourClassId',$fourClassId)->limit(0,5)->order('zhanshiId desc,addtime desc')->select();
		//亲办案例
		$case=db('user_art_zdy')->field('title,id,fourClassId,imageUrl')->where('fourClassId !='.$fourClassId.' and webId='.$webId)->limit(0,5)->order('addtime desc')->select();
        
        $lsfc=db('artlsfc')->field('imageUrl')->where('webId='.$webId)->select();
		
		//2018.4.11文章图片		
		function pub_img($pub){
			foreach ($pub as $k=>$v) {			
			$t_img=array("http://www.faweishi.com/images/ggimages/banner1.jpg","http://www.faweishi.com/images/ggimages/banner2.jpg"); 
			$title_num=array_rand($t_img,1);
			$title_img=$t_img[$title_num];			
			$list_img=$pub[$k]['imageUrl'];
			
			if(!$list_img){		
			$notes_img=$title_img;			
			}else{
				$notes_img='http://www.faweishi.com/images/'.$list_img;
			}
			  $pub[$k]['imageUrl']=$notes_img;			
			}
			return $pub;
		}		
		$list=pub_img($list);
		$case=pub_img($case);
			
		//修改横幅图片-2018.3.30	
		$banner=db('user_gg_images_wap')->field('imageUrl')->where("secClassId=2055 and status=1 and userId=".$uid)->limit(0,3)->select();
        
        if(!$banner){
            $bannerArr=array('http://www.faweishi.com/images/ggimages/banner1.jpg','http://www.faweishi.com/images/ggimages/banner2.jpg');
        }else{
            foreach ($banner as $k=>$v) {
                $bannerArr[]="http://www.faweishi.com/lvshi/wap/images/".$v['imageUrl'];
            }
        }
				
        
        if($lsfc){
           foreach ($lsfc as $k=>$v) {
                $lsfcArr[]="http://www.faweishi.com/images/".$v['imageUrl'];
            } 
        }else{
            $lsfcArr="";
        }

       //$res=array($list,$lsfcArr,$bannerArr,$case);
       // return $res;
	   
	   $res['list']=$list;
	   $res['lsfcArr']=$lsfcArr;
	   $res['bannerArr']=$bannerArr;
	   $res['case']=$case;
	   return $res; 
  
    }
	
	//存储访客信息
	public function userInfo() {
        $info=input();
        $info=json_decode($info[0],true);
        $data=array(
            'nickname'=>$info['nickname'],
            'avatarurl'=>$info['avatarurl'],
            'gender'=>$info['gender'],
            'province'=>$info['province'],
            'city'=>$info['city'],
            'country'=>$info['country'],
            'lawyerId'=>$info['lawyerId'],
            'addtime'=>date('Y-m-d H:i:s')
        );
        $res=db('wx_userinfo')->insert($data);
		
		//访客信息记录
		$usersList=db('wx_userinfo')->distinct(true)->field('avatarUrl')->limit(0,7)->where('lawyerId='.$info['lawyerId'])->order('id desc')->select();
		//$usersCount=db('wx_userinfo')->where('lawyerId='.$info['lawyerId'])->count('id');
		$usersCount='10000+';
		
		if($usersList){
           foreach ($usersList as $k=>$v) {
            $usersListArr[]=$v['avatarUrl'];
            } 
        }else{
            $usersListArr="";
        }
		
		$result['usersList']=$usersListArr;
		$result['usersCount']=$usersCount;
        return $result;

    }
	
	
	//2018.4.13用户登录
	public function wxLogin() {
		
		/* 初始化并执行curl请求 */
		function getCurl($url){
		$ch = curl_init();
		$header = array('Content-type: application/json; charset=UTF-8');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); //  PHP 5.6.0 后必须开启
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置header响应头和编码
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
		
	$code = "021Ni0Xx1rR5gg05Ns0y17xlXx1Ni0XY"; 
    // $encryptedData = "authorization_code";  
    $appid = "wxb455a3a63d951ce7"; 
    $secret = "947650780dc97ca6a657830322f0a669"; 
	
	//$xcxInfo=db('user')->field('appId,secret')->where('lawyerId='.$info['lawyerId'])->select();                数据库获取
	//$appId= $xcxInfo[0]['appId'];
	//$secret= $xcxInfo[0]['secret'];

	
	$url="https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
	// print_r(getCurl($url));exit;
	$userInfo = getCurl($url);
	//{"session_key":"ck6fX+oYLhmrX2O1I1RWyQ==","openid":"om5IH0UwCqs0gTYpnvX-9JcUwpiI"}
	$userInfo= json_decode($userInfo,true);
	// var_dump($userInfo['openid']);  string(28) "om5IH0UwCqs0gTYpnvX-9JcUwpiI"
	$data=array(
            'openId'=>$userInfo['openid'],
        );
	
	$res=db('wx_userinfo')->where('lawyerId='.$info['lawyerId'])->insert($data); 
	return $res;
		
	}
}
