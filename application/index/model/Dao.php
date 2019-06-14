<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-26
 * Time: 0:01
 */

namespace app\index\model;

use think\Db;
use components\core\BaseObject;

class Dao extends BaseObject
{
    public static $table;

    /**
     * 获取查询构造器
     * @param null $tableName
     * @return \think\db\Query
     * @throws \Exception
     */
    public static function getQuery($tableName = null)
    {
        try {
            if (is_null($tableName) || empty($tableName)) {
                $tableName = self::$table;
            }
            return Db::table($tableName);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 通过原生SQL查询
     * @param $sql "select * from user where id=:id and username=:name"
     * @param null $bindParams ['id'=>[1,\PDO::PARAM_INT],'name'=>'thinkphp']
     * @param bool $master 是否从主服务器读数据
     * @param bool $pdo
     * @return mixed
     * @throws \Exception
     */
    public static function queryBySql($sql, $bindParams = null, $master = false, $pdo = false)
    {
        try {
            if (empty($bindParams)) {
                $ret = Db::query($sql, [], $master, $pdo);
                return $ret;
            } else {
                $ret = Db::query($sql, $bindParams, $master, $pdo);
                return $ret;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $sql "update user set age = 22 where id=:id and username=:name"
     * @param null $bindParams ['id'=>[1,\PDO::PARAM_INT],'name'=>'thinkphp']
     * @param bool $fetch 直接返回SQL而不是执行查询
     * @param bool $getLastInsertId 返回最后插入的ID
     * @param null $sequence 用于pgsql数据库指定自增序列名，其它数据库不必使用
     * @return int
     * @throws \Exception
     */
    public static function executeBySql($sql, $bindParams = null, $fetch = false, $getLastInsertId = false, $sequence = null)
    {
        try {
            if (empty($bindParams)) {
                $ret = Db::execute($sql, [], $fetch, $getLastInsertId, $sequence);
                return $ret;
            } else {
                $ret = Db::execute($sql, $bindParams, $fetch, $getLastInsertId, $sequence);
                return $ret;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    /**
     * 添加可读行共享锁
     * @param string $sqlWhere "id=:id and username=:name"
     * @param array $bindParams ['id'=>[1,\PDO::PARAM_INT],'name'=>'thinkphp']
     * @param null $tableName tp_user
     * @param array $fields ['id','name']
     * @throws \Exception
     */
    public static function addReadLock($sqlWhere = '', $bindParams = array(), $tableName = null, $fields = ['*'])
    {
        try {
            if (is_null($tableName) || empty($tableName)) {
                $tableName = self::$table;
            }
            Db::table($tableName)->field($fields)->where($sqlWhere)->bind($bindParams)->lock('lock in share mode')->find();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 添加写独占排他锁
     * @param string $sqlWhere "id=:id and username=:name"
     * @param array $bindParams ['id'=>[1,\PDO::PARAM_INT],'name'=>'thinkphp']
     * @param null $tableName tp_user
     * @param array $fields ['id','name']
     * @throws \Exception
     */
    public static function addWriteLock($sqlWhere = '', $bindParams = array(), $tableName = null, $fields = ['*'])
    {
        try {
            if (is_null($tableName) || empty($tableName)) {
                $tableName = self::$table;
            }
            Db::table($tableName)->field($fields)->where($sqlWhere)->bind($bindParams)->lock(true)->find();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 开启事务
     */
    public static function beginTransAction()
    {
        Db::startTrans();
    }

    /**
     * 提交事务
     */
    public static function commit()
    {
        Db::commit();
    }

    /**
     * 事务回滚
     */
    public static function rollBack()
    {
        Db::rollback();
    }

    public static function setTable($table)
    {
        self::$table = $table;
    }

    public static function getTable()
    {
        return self::$table;
    }
}