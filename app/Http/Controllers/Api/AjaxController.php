<?php

namespace App\Http\Controllers\Api;

use App\Models\UpdateSistem;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{

    public function update(Request $request){
        $req = $request->input();

        $info = UpdateSistem::create([
            'new_update' => 1,
            'version' => $req['version'],
            'type' => $req['type'],
        ]);
        return response()->json([
            'status' => true,
        ]);
    }
}