<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-08 11:34:36
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-08 11:36:28
 */
namespace Yjtec\Repo;

use DB;
trait DBTrait
{
    public function start()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }

    public function rollback()
    {
        DB::rollBack();
    }

    public function transaction($callback)
    {
        DB::transaction($callback);
    }
}
