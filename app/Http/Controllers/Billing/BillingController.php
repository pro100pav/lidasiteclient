<?php

namespace App\Http\Controllers\Billing;

use Auth;
use App\Models\User;
use App\Models\Bot\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index(){
        return view('dashboard.billing.index');
    }

}
