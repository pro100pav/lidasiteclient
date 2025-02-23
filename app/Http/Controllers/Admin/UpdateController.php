<?php
namespace App\Http\Controllers\Admin;

use App\Models\UpdateSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function update(Request $request)
    {
        $newupd = UpdateSistem::where('new_update', 1)->first();
        $newupd->new_update = 2;
        $newupd->save();
    }
    public function updateGet(Request $request)
    {
        $newupd = UpdateSistem::where('new_update', 1)->first();
        $updates = UpdateSistem::where('new_update', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.update', compact('newupd','updates'));
    }
}