<?php

namespace App\Http\Controllers;

use App\Order;
use App\GroceryOrderChild;
use App\OrderStatus;
use App\Setting;
use App\GroceryShop;
use Config;
use Auth;
use OneSignal;
use App\Currency;
use App\User;
use App\CompanySetting;
use App\Notification;
use App\NotificationTemplate;
use Illuminate\Http\Request;
use DataTables;
use App\Role;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $role=Role::where('name','!=','Admin')->get();
        return view('admin.notification.notification', ['role'=>$role]);
    }


    public function store(Request $request)
    {

      //  dd('mm Good');

        $request->validate([
            'role' => 'required',
            'title' => 'required',
            'body' => 'required',

        ]);

        $data = $request->all();





        toastr()->success('Are you the 6 fingered man?');
        return redirect()->back();
    }


}
