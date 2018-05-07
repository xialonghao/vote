<?php

namespace app\vote\controller;
use think\Controller;
use think\DB;
class Vote extends Controller{
    public function alldata(){
        $val=input('get.val',1);
        $count=input('get.count',5);
        $all_count=db('user')->where('is_job=0')->count();
        $res=db('user')->where('is_job=0')->limit(($val-1)*$count,$count)->select();
        if($res){
            return json(
                array('code'=>1,
                    'msg'=>'查询成功',
                    'count'=>$all_count,
                    'res'=>$res));
        }else{
            return json(
                array('code'=>0,
                    'msg'=>'没有数据',
                ));
        }
    }
    public function isvote()
    {
        session_start();
        // 指定允许其他域名访问
        header("Access-Control-Allow-Origin: *");
        $obeys =input('post.obey');//这是接受三个字段的沟通能力和做事能力，服从能力
        $works = input('post.work');
        $communs = input('post.commun');
        $content =input('post.content');
        $id = 3;//投票人id
        $userid = input('post.userid');//被投票人的id定死
        //求出当月月初的第一天的时间
        $time_money = date('Y-m', time()); //2018-3-01 00:00:00
        $money = $time_money . '-01 00:00:00';
        //求出本月投票人是否齐全过
        $info = db('vote')->fetchSql(true)->where("waievr=1 and inputtime>' ". $money . "' and userid=" . $id)->count();
        if ($info >= 1) {
            return json(
                array(
                    'code' => 0,
                    'msg' => '投票人已经弃权'
                )
            );
            exit;
        }
        //求出本月投票人投票的次数
        $info2 = db('vote')->where("inputtime>'" . $money ." ' and userid=" . $id)->count();
        if ($info2 >= 5) {
            return json(
                array(
                    'code' => 0,
                    'msg' => '投票人已投票五次'
                )
            );
        }
        //求出被投票人是否满分
        $info3 = db('vote')->where("inputtime>' ". $money ." ' and asid=" . $userid)->field('obey,work,commun')->select();
        $obey = 0;
        $work = 0;
        $commun = 0;
        foreach ($info3 as $v) {
            $obey = $v['obey'] + $obey;
            $work = $v['work'] + $work;
            $commun = $v['commun'] + $commun;
        }
        if ($obey >= 100 || $work >= 100 || $commun >= 100) {
            return json(
                array(
                    'code' => 0,
                    'msg' => '被投票人已经满分'
                )
            );
        }
//        $info4 = db('vote')->where("asid='.$id.'")->find();//投票
//        if (date('m', strtotime($info4['inputtime'])) != date('m', time())) {
//            $info4 = db('user')->where("userid='.$id.'")->update(['grade' => 80]);
//
//            $info5 = db('vote')->insert(['grade' => 80]);
//        } else
//            if ($info4['grade'] > 0) {
//                db('user')->where("userid='.$id.'")->update(['grade' => 'grade - 20']);
//                $info6 = db('vote')->insert(['grade' => 80]);
//            } else {
//
//            }
        //求出加上投票分数之后是否超过一百
        $obey = $obey + $obeys;
        $work = $work + $works;
        $commun = $commun + $communs;
        if ($obey > 100 || $work > 100 || $commun > 100) {
            return json(
                array(
                    'code' => 0,
                    'msg' => '被投票人原有分数加上现在的分数超过100了 '
                )
            );
        }
        //如果这些判断全都过了  就可以添加数据了
        $data['userid'] = $userid;
        $data['asid'] = $id;
        $data['inputtime'] = date('Y-m-d H:i:s', time());
        $data['content'] = $content;
        $data['waiver'] = 0;
        $data['obey'] = $obeys;
        $data['work'] = $works;
        $data['commun'] = $communs;
        $rer = db('vote')->insert($data);
        if ($rer) {
            return json(
                array(
                    'code' => 1,
                    'msg' => '添加成功'
                )
            );
        }
    }
    public function index(){
        return $this->fetch();
    }
//    public function flash(){
//        $inf1=db('vote')->field('obey,work,commun')->select();
//        foreach($inf1 as $key=>$val){
//              $grade=$val['obey']+$val['work']+$val['commun'];
//        }
//        if($grade){
//            return json(
//                array(
//                    grade=>$grade,
//                    'code' => 0,
//                    'msg' => '显示分数'
//                )
//            );
//        }
//    }

    //接受投票人的id和被投票人的id
    //一个月只能投五票的话，投票表里有一个字段存这个用户最后投的时间戳，
    // 然后用户点投票的时候判断这个当前时间-2592000是否小于那个时间戳就可以了，
    //如果小于的话不可以投了,
    // 就是点投票的时候做一下判断就可以了
    //1.首先我要接受投票人id和被投票人的id
    //2.首先一个月只能投5票每一个人有5次投票的机会
    //投一票20分每个人一个月只能投5票满分100分
    //如果满分了就判断这个人不能再投了已经满分了
    //存的时间戳用拼接起来然后用foreach循环判断如果有五次时间戳了就代表这个人不能再投了
    //3.数据库设计
    //一个是被投票用户usid，评论内容content，
    //服从能力:obey,做事能力:work,沟通能力:commun,
    //投票时间inputtime，弃权waiver，投票数count，


}
?>