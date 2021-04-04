<?php

namespace App\Http\Controllers;

use App\Order;
use App\GroceryOrderChild;
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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Order::with(['userOrder', 'categoryOrder'])->orderBy('id', 'DESC')->paginate(10);
        $currency_code = Setting::where('id', 1)->first()->currency;

        $technical = User::where('role', 3)->get();
        // dd( $data );
        return view('admin.order.orders', ['orders' => $data, 'technical' => $technical]);
    }


    public function ordersList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();
            $query = Order::with(['userOrder', 'categoryOrder'])->orderBy('id', 'DESC');

            if ($request->has('order_id') and $request->order_id > 0) {
                $query->where('id', $request->order_id);
            }
            if ($request->has('daterange') and $data['daterange']!=null ) {
                $query->whereBetween('time', explode(' - ', $data['daterange']));

            }
            if ($request->has('technical') and $data['technical']!=null ) {

                $query->whereHas('userOrder', function ($query) use ($request) {
                    $query->where('id', $request->user_id);
                });

            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('userOrder.name', function ($row) {
                return $row->userOrder->name ?? "";
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : "";
            });

            $table->editColumn('payment_type', function ($row) {
                return $row->payment_type ? $row->payment_type : "";
            });

            $table->addColumn('status', function ($row) {
                return $row->statusname->status_name ?? '';
            });

            $table->addColumn('actions', function ($row) {
                return '<a href="' . url(adminPath() . 'viewOrder/' . $row->id) . '" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                <i class="fas fa-eye"></i></a>';
            });

            $table->rawColumns(['actions']);
            return $table->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\GroceryOrder $groceryOrder
     * @return \Illuminate\Http\Response
     */
    public function show(GroceryOrder $groceryOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\GroceryOrder $groceryOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(GroceryOrder $groceryOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\GroceryOrder $groceryOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroceryOrder $groceryOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\GroceryOrder $groceryOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroceryOrder $groceryOrder)
    {
        //
    }

    public function viewsingleOrder($id)
    {
        $data = Order::with(['userOrder', 'categoryOrder'])->find($id);

        // $currency_code = Setting::where('id',1)->first()->currency;
        //$currency = Currency::where('code',$currency_code)->first()->symbol;

        return view('admin.order.singleOrder', ['data' => $data]);
    }

    public function orderInvoice($id)
    {
        $data = GroceryOrder::with(['shop', 'customer', 'deliveryGuy', 'orderItem'])->find($id);
        $currency_code = Setting::where('id', 1)->first()->currency;
        $currency = Currency::where('code', $currency_code)->first()->symbol;
        return view('admin.GroceryOrder.invoice', ['data' => $data, 'currency' => $currency]);
    }

    public function printGroceryInvoice($id)
    {
        $data = GroceryOrder::with(['shop', 'customer', 'deliveryGuy', 'orderItem'])->where('id', $id)->first();
        $currency_code = Setting::where('id', 1)->first()->currency;
        $currency = Currency::where('code', $currency_code)->first()->symbol;
        return view('admin.GroceryOrder.invoicePrint', ['data' => $data, 'currency' => $currency]);
    }

    public function groceryRevenueReport()
    {
        $currency_code = Setting::where('id', 1)->first()->currency;
        $currency = Currency::where('code', $currency_code)->first()->symbol;
        $data = GroceryOrder::with(['shop', 'customer'])->where([['payment_status', 1], ['owner_id', Auth::user()->id]])->orderBy('id', 'DESC')->get();
        // $data = GroceryOrder::with(['shop','customer'])->where('owner_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $shops = GroceryShop::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $value->shop_name = GroceryShop::where('id', $value->shop_id)->first()->name;
        }
        return view('admin.GroceryOrder.revenueReport', ['data' => $data, 'currency' => $currency, 'shops' => $shops]);
    }

    public function accpetOrder($id)
    {

        $order = GroceryOrder::findOrFail($id)->update(['order_status' => 'Approved']);
        $msg = array(
            'icon' => 'fas fa-thumbs-up',
            'msg' => 'Order is Accepted Successfully',
            'heading' => 'Seccess',
            'type' => 'default'
        );

        return redirect()->back()->with('success', $msg);
    }


    public function rejectOrder($id)
    {

        GroceryOrder::findOrFail($id)->update(['order_status' => 'Cancel']);
        $order = GroceryOrder::findOrFail($id);
        $user = User::findOrFail($order->customer_id);
        $notification = Setting::findOrFail(1);
        $shop_name = CompanySetting::where('id', 1)->first()->name;
        $message = NotificationTemplate::where('title', 'Cancel Order')->first()->message_content;
        $detail['name'] = $user->name;
        $detail['order_no'] = $order->order_no;
        $detail['shop'] = GroceryShop::findOrFail($order->shop_id)->name;
        $detail['shop_name'] = $shop_name;
        $data = ["{{name}}", "{{order_no}}", "{{shop}}", "{{shop_name}}"];
        $message1 = str_replace($data, $detail, $message);

        if ($notification->push_notification == 1) {
            if ($user->enable_notification == 1) {
                if ($user->device_token != null) {
                    $userId = $user->device_token;
                    try {
                        OneSignal::sendNotificationToUser(
                            $message1,
                            $userId,
                            $url = null,
                            $data = null,
                            $buttons = null,
                            $schedule = null
                        );
                    } catch (\Exception $e) {

                    }
                }
            }
        }

        $image = NotificationTemplate::where('title', 'Cancel Order')->first()->image;
        $data1 = array();
        $data1['user_id'] = $order->customer_id;
        $data1['order_id'] = $order->id;
        $data1['title'] = 'Grocery Order Cancled';
        $data1['message'] = $message1;
        $data1['image'] = $image;
        $data1['notification_type'] = "Grocery";

        Notification::create($data1);

        $msg = array(
            'icon' => 'fas fa-thumbs-up',
            'msg' => 'Order is Cancel Successfully',
            'heading' => 'Seccess',
            'type' => 'default'
        );

        return redirect()->back()->with('success', $msg);
    }

    public function changeGroceryOrderStatus(Request $request)
    {


        // dd($request->all());
        $order = GroceryOrder::findOrFail($request->id);
        $status = $request->status;
        if ($order->payment_status == 0 && $status == "Delivered") {
            return response()->json(['data' => $order, 'success' => false], 200);
        } else {
            GroceryOrder::findOrFail($request->id)->update(['order_status' => $request->status]);
            $order = GroceryOrder::findOrFail($request->id);
            $user = User::findOrFail($order->customer_id);

            if ($status == 'Cancel' || $status == 'Approved' || $status == 'Delivered' || $status == "OrderReady") {
                if ($status == 'Delivered') {
                    GroceryOrder::find($request->id)->update(['payment_status' => 1]);
                }
                $notification = Setting::findOrFail(1);
                $shop_name = CompanySetting::where('id', 1)->first()->name;
                $content = NotificationTemplate::where('title', 'Order Status')->first()->mail_content;
                $message = NotificationTemplate::where('title', 'Order Status')->first()->message_content;
                $detail['name'] = $user->name;
                $detail['order_no'] = $order->order_no;
                $detail['shop'] = GroceryShop::findOrFail($order->shop_id)->name;
                $detail['status'] = $status;
                $detail['shop_name'] = $shop_name;
                if ($notification->mail_notification == 1) {
                    // Mail::to($user)->send(new OrderStatus($content,$detail));
                }
                if ($notification->sms_twilio == 1) {
                    $sid = $notification->twilio_account_id;
                    $token = $notification->twilio_auth_token;
                    // $client = new Client($sid, $token);
                    // $data = ["{{name}}", "{{order_no}}", "{{shop}}","{{status}}", "{{shop_name}}"];
                    // $message1 = str_replace($data, $detail, $message);
                    // $client->messages->create(
                    // '+918758164348',
                    //     array(
                    //         'from' => $notification->twilio_phone_number,
                    //         'body' =>  $message1
                    //     )
                    // );
                }
                if ($notification->push_notification == 1) {
                    if ($user->device_token != null) {
                        try {
                            Config::set('onesignal.app_id', env('APP_ID'));
                            Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
                            Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));
                            $data = ["{{name}}", "{{order_no}}", "{{shop}}", "{{status}}", "{{shop_name}}"];
                            $message1 = str_replace($data, $detail, $message);
                            $userId = $user->device_token;
                            OneSignal::sendNotificationToUser(
                                $message1,
                                $userId,
                                $url = null,
                                $data = null,
                                $buttons = null,
                                $schedule = null
                            );
                        } catch (\Exception $e) {

                        }
                    }
                }
                $data = ["{{name}}", "{{order_no}}", "{{shop}}", "{{status}}", "{{shop_name}}"];
                $message1 = str_replace($data, $detail, $message);
                $image = NotificationTemplate::where('title', 'Order Status')->first()->image;

                $data1 = array();
                $data1['user_id'] = $order->customer_id;
                $data1['order_id'] = $order->id;
                $data1['title'] = 'Order ' . $status;
                $data1['message'] = $message1;
                $data1['image'] = $image;
                $data1['notification_type'] = "Grocery";
                Notification::create($data1);
            }

            return response()->json(['data' => $order, 'success' => true], 200);
        }

    }

}
