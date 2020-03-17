<?php
namespace app\api\Model;


use think\Model;

/**
 * Created by PhpStorm.
 * Users: moqintao
 * Date: 2020/3/14
 * Time: 10:08
 */

class Users extends Model
{
    /**
     * 设置主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 设置数据表名
     * @var string
     */
    protected $table = 'users';

    /**
     * 设置当前模型的数据库
     * @var string
     */
    protected $connection = 'ty';

    /**
     * 根据用户名查询
     * @param $username
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addUser($username){
        //TODO: 根据用户提交数据来创建新用户
        return 'this is user info!';
        return $this->where('u_name', $username)->find();
    }

    /**
     * 根据用户id更新用户
     * @param $id
     * @param $data
     * @return static
     */
    public function updateUser($id,$data){
        return $this->where('id', $id)->update($data);
    }



}