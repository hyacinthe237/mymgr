<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_SUCCESS      = 200;
    const HTTP_CREATED      = 201;
    const HTTP_BADREQUEST   = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN    = 403;
    const HTTP_NOTFOUND     = 404;
    const HTTP_ERROR        = 500;
}
