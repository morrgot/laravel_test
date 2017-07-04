<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 22:55
 */

namespace App\Domain\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Domain\Models
 *
 * @method static static find
 */
abstract class BaseModel extends Model
{
    public $timestamps = false;
}