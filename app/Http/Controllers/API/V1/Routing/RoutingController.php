<?php

namespace App\Http\Controllers\API\V1\Routing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoutingController extends Controller
{

    public function breadCrumb()
    {
        //
    }

    public function blog($category, $post)
    {
        dd($category, $post);
    }

    public function commerce()
    {
        //
    }
}
