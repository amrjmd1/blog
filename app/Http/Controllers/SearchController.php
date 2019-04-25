<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search()
    {
        $value = $_GET['value'];
        if ($value != null) {
            $find = User::select('name', 'image')->where('name', 'like', '%' . $value . '%')->get();
            if ($find->count() == 0) {
                return $find;
            }
        } else {
            $find = null;
        }

        return response()->json(array('msg' => $find));

    }
}
