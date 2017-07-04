<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 14:46
 */

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ServerErrorException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(500, $message, $previous, array(), $code);
    }
}