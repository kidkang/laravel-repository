<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-08 11:27:55
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-08 13:37:17
 */
namespace Yjtec\Repo\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use HasFactory;
    protected $table = 'demo';
    protected $fillable = ['name'];
}
