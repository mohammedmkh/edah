<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Order;
use Auth;
use App\Shop;
use App\Setting;
use App\Currency;
use Illuminate\Http\Request;
use DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $s = array();

        $data = Coupon::orderBy('id', 'DESC')->get();

        $currency_code = Setting::where('id', 1)->first()->currency;
        // $currency = Currency::where('code',$currency_code)->first()->symbol;

        return view('admin.coupon.viewCoupon', ['coupons' => $data]);
    }

    public function couponsList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = Coupon::query()->orderBy('id', 'DESC');

            if ($request->has('status') and $request->status ) {
                $query->where('status', $request->status);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('discount', function ($row) {
                return $row->discount . $row->type == "percentage" ? ' %' : '';
            });
            $table->editColumn('max_use', function ($row) {
                return $row->max_use ;
            });
            $table->editColumn('use_count', function ($row) {
                return $row->use_count ;
            });
            $table->editColumn('duration', function ($row) {
                return $row->start_date . ' to ' . $row->end_date;
            });

            $table->editColumn('status', function ($row) {
                return ' <span class="badge badge-dot mr-4">
                                                        <i class="' . $row->status == 0 ? "bg-success" : "bg-danger" . '"></i>
                                                        <span class="status">' . $row->status == 0 ? __('Active') :  __('DeActive') . '</span>
                                                    </span>';
            });
            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="'.url(adminPath().'Coupon/'.$row->code.'/edit').'">'. __('Edit') .'</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Coupon`,'.$row->id.');" href="#">'. __('Delete') .'</a>

                                                </div>
                                            </div>
';
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
        // $shop = GroceryShop::where('user_id',Auth::user()->id)->get();
        return view('admin.coupon.addGroceryCoupon');
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
        $request->validate([
            'name' => 'bail|required',
            'type' => 'bail|required',
            'discount' => 'bail|required',
            'max_use' => 'bail|required',
            'start_date' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        $date = explode(" to ", $request->start_date);
        $data['start_date'] = $date[0];
        $data['end_date'] = $date[1];
        $data['use_for'] = 'Grocery';
        $data['code'] = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000);


        Coupon::create($data);
        toastr()->success(__('Successfully completed'));

        return redirect('GroceryCoupon');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Coupon::where('code', $id)->first();
        return view('admin.coupon.editCoupon', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'bail|required',
            'type' => 'bail|required',
            'discount' => 'bail|required',
            'max_use' => 'bail|required',
            'start_date' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->start_date) {
            $date = explode(" to ", $request->start_date);
            $data['start_date'] = $date[0];
            $data['end_date'] = $date[1];
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        Coupon::find($id)->update($data);
        toastr()->success(__('Successfully completed'));

        return redirect(adminPath() . 'Coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $delete = Coupon::find($id);
            $delete->delete();
            return 'true';
        } catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function viewGroceryCoupon()
    {
        $data = Coupon::where([['status', 0], ['use_for', 'Grocery']])->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function viewGroceryShopCoupon($id)
    {
        $data = Coupon::where([['shop_id', $id], ['status', 0], ['use_for', 'Grocery']])->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

}
