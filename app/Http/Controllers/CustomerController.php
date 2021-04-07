<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\UserAddress;
use App\Setting;
use Razorpay\Api\Api;
use App\AdminNotification;
use App\CompanySetting;
use App\NotificationTemplate;
use App\UserGallery;
use App\OwnerSetting;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Avatar;
use Auth;
use Zip;
use DB;
use App;
use App\Order;
use Redirect;
use Twilio\Rest\Client;
use App\Mail\UserVerification;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Notification;
use App\Coupon;
use App\GroceryOrder;
use App\GroceryShop;
use App\GroceryOrderChild;
use App\GroceryReview;
use App\GrocerySubCategory;
use App\GroceryItem;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = User::where('role', 2)->orderBy('id', 'DESC')->get();
        return view('admin.users.users', ['users' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.addUser');
    }

    public function tech_posting(Request $request)
    {
        $request->validate([
            'first_id' => 'required',
            'last_id' => 'required',
            'totalTeachnical' => 'required',
                    ]);
        $data = $request->all();


        $user = User::create($data);
        if ($user->role == 1) {
            $setting['user_id'] = $user->id;
            OwnerSetting::create($setting);
        }

        return response(['success'=>true]);

    }

    public function techniciansList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = User::query()->where('role', 3)->orderBy('id', 'DESC');

            if ($request->has('status') and $request->status) {
                $query->where('status', $request->status);
            }
            if ($request->has('email') and $request->email) {
                $query->where('email', $request->email);
            }
            if ($request->has('name') and $request->name) {
                $query->where('name', $request->name);
            }
            if ($request->has('phone') and $request->phone) {
                $query->where('phone', $request->phone);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('image', function ($row) {
                return '<img class=" avatar-lg round-5" src="' . url('images/upload/' . $row->image) . '">';
            });
            $table->addColumn('created_at', function ($row) {
                return $row->created_at != null ? $row->created_at->diffForHumans() : '';
            });
            $table->editColumn('status', function ($row) {
                return ' <span class="badge badge-dot mr-4">
                                                        <i class="' . $row->status == 0 ? "bg-success" : "bg-danger" . '"></i>
                                                        <span class="status">' . $row->status == 0 ? "Active" : "Deactive" . '</span>
                                                    </span>';
            });
            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'Customer/' . $row->id . '/edit') . '">' . __('Edit') . '</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Customer`,' . $row->id . ');" href="#">' . __('Delete') . '</a>
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'technicalAccountStatmentPage/' . $row->id) . '">' . __('Technical Account Statment') . '</a>
                                                </div>
                                            </div>
';
            });

            $table->rawColumns(['actions', 'image', 'role']);
            return $table->make(true);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function technicalAccountStatment(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = Order::query()->orderBy('id', 'DESC');

            $profit_ratio=CompanySetting::first()['profit_ratio'];

            $query->whereHas('technician', function ($query) use ($data) {
                $query->where('id',$data['id']);
            });

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('category', function ($row) {
                return $row->categoryOrder->translation()->name ;
            });
            $table->addColumn('owner_profit', function ($row)use($profit_ratio) {
                return $row->profit_ratio ? ($row->price*$row->profit_ratio)/100:$profit_ratio;
            });

            $table->addColumn('technical_profit', function ($row)use($profit_ratio) {
                return $row->profit_ratio ?($row->price*(100-$row->profit_ratio)/100) :$profit_ratio ;
            });
            $table->addIndexColumn();


            $table->rawColumns([ 'category', 'technical_profit', 'owner_profit']);
            return $table->make(true);
        }

    }

    public function technicalAccountStatmentPage($id = null)
    {


      $checkUser= user::findOrfail($id);
        return view('admin.users.technicalAccountStatmentPage', compact('id'));
    }

    public function storeList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = User::query()->where('role', 4)->orderBy('id', 'DESC');

            if ($request->has('status') and $request->status) {
                $query->where('status', $request->status);
            }
            if ($request->has('email') and $request->email) {
                $query->where('email', $request->email);
            }
            if ($request->has('name') and $request->name) {
                $query->where('name', $request->name);
            }
            if ($request->has('phone') and $request->phone) {
                $query->where('phone', $request->phone);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('image', function ($row) {
                return '<img class=" avatar-lg round-5" src="' . url('images/upload/' . $row->image) . '">';
            });
            $table->addColumn('created_at', function ($row) {
                return $row->created_at != null ? $row->created_at->diffForHumans() : '';
            });
            $table->editColumn('status', function ($row) {
                return ' <span class="badge badge-dot mr-4">
                                                        <i class="' . $row->status == 0 ? "bg-success" : "bg-danger" . '"></i>
                                                        <span class="status">' . $row->status == 0 ? "Active" : "Deactive" . '</span>
                                                    </span>';
            });
            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'Customer/' . $row->id . '/edit') . '">' . __('Edit') . '</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Customer`,' . $row->id . ');" href="#">' . __('Delete') . '</a>

                                                </div>
                                            </div>
';
            });

            $table->rawColumns(['actions', 'image', 'role']);
            return $table->make(true);
        }

    }

    public function customerList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = User::query()->where('role', 1)->orderBy('id', 'DESC');

            if ($request->has('status') and $request->status) {
                $query->where('status', $request->status);
            }
            if ($request->has('email') and $request->email) {
                $query->where('email', $request->email);
            }
            if ($request->has('name') and $request->name) {
                $query->where('name', $request->name);
            }
            if ($request->has('phone') and $request->phone) {
                $query->where('phone', $request->phone);
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('image', function ($row) {
                return '<img class=" avatar-lg round-5" src="' . url('images/upload/' . $row->image) . '">';
            });
            $table->addColumn('created_at', function ($row) {
                return $row->created_at != null ? $row->created_at->diffForHumans() : '';
            });


            $table->editColumn('status', function ($row) {
                return ' <span class="badge badge-dot mr-4">
                                                        <i class="' . $row->status == 0 ? "bg-success" : "bg-danger" . '"></i>
                                                        <span class="status">' . $row->status == 0 ? "Active" : "Deactive" . '</span>
                                                    </span>';
            });
            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'Customer/' . $row->id . '/edit') . '">' . __('Edit') . '</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Customer`,' . $row->id . ');" href="#">' . __('Delete') . '</a>

                                                </div>
                                            </div>
';
            });

            $table->rawColumns(['actions', 'image', 'role']);
            return $table->make(true);
        }

    }

    public function adminList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = User::query()->where('role', 2)->orderBy('id', 'DESC');

            if ($request->has('status') and $request->status) {
                $query->where('status', $request->status);
            }
            if ($request->has('email') and $request->email) {
                $query->where('email', $request->email);
            }
            if ($request->has('name') and $request->name) {
                $query->where('name', $request->name);
            }
            if ($request->has('phone') and $request->phone) {
                $query->where('phone', $request->phone);
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('image', function ($row) {
                return '<img class=" avatar-lg round-5" src="' . url('images/upload/' . $row->image) . '">';
            });
            $table->addColumn('created_at', function ($row) {
                return $row->created_at != null ? $row->created_at->diffForHumans() : '';
            });


            $table->editColumn('status', function ($row) {
                return ' <span class="badge badge-dot mr-4">
                                                        <i class="' . $row->status == 0 ? "bg-success" : "bg-danger" . '"></i>
                                                        <span class="status">' . $row->status == 0 ? "Active" : "Deactive" . '</span>
                                                    </span>';
            });
            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'Customer/' . $row->id . '/edit') . '">' . __('Edit') . '</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Customer`,' . $row->id . ');" href="#">' . __('Delete') . '</a>

                                                </div>
                                            </div>
';
            });

            $table->rawColumns(['actions', 'image', 'role']);
            return $table->make(true);
        }

    }

    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users',
            'phone' => 'bail|required',
            // 'dateOfBirth' => 'bail|required',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 0;
        $data['referral_code'] = mt_rand(1000000, 9999999);
        $data['otp'] = mt_rand(100000, 999999);
        if (isset($request->image) && $request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        } else {
            // $image = Avatar::create($request->email)->toBase64();
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $image);
            // $imageName = str_random(10).'.'.'png';
            // $destinationPath = public_path('/images/upload');
            // \File::put($destinationPath. '/' . $imageName, base64_decode($image));
            // $data['image']=$imageName;
            $data['image'] = 'user.png';
        }

        $user_verify = Setting::where('id', 1)->first()->user_verify;
        if ($user_verify == 1) {
            $data['verify'] = 0;
        } else if ($user_verify == 0) {
            $data['verify'] = 1;
        }

        $user = User::create($data);
        if ($user->role == 1) {
            $setting['user_id'] = $user->id;
            OwnerSetting::create($setting);
        }

        return redirect('Customer');

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
        //
        $data = User::findOrFail($id);

        return view('admin.users.editUser', ['data' => $data]);
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
            'email' => 'bail|required|unique:users,email,' . $id . ',id',
            'phone' => 'bail|required',
            // 'dateOfBirth' => 'bail|required',
        ]);
        $data = $request->all();

        if (isset($request->image) && $request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        User::findOrFail($id)->update($data);
        return redirect(adminPath() . 'Customer');
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
            $user = User::findOrFail($id);
            if ($user->role == 0) {
                $Order = GroceryOrder::where('customer_id', $id)->get();
                if ($Order) {
                    foreach ($Order as $value) {
                        $OrderChild = GroceryOrderChild::where('order_id', $value->id)->get();
                        if ($OrderChild) {
                            foreach ($OrderChild as $oc) {
                                $oc->delete();
                            }
                        }
                        $value->delete();
                    }
                }

                $GroceryReview = GroceryReview::where('customer_id', $id)->get();
                if ($GroceryReview) {
                    foreach ($GroceryReview as $r) {
                        $r->delete();
                    }
                }
                $Notification = Notification::where('user_id', $id)->get();
                if ($Notification) {
                    foreach ($Notification as $n) {
                        $n->delete();
                    }
                }
                $UserAddress = UserAddress::where('user_id', $id)->get();
                if ($UserAddress) {
                    foreach ($UserAddress as $n) {
                        $n->delete();
                    }
                }
                $UserGallery = UserGallery::where('user_id', $id)->get();
                if ($UserGallery) {
                    foreach ($UserGallery as $g) {
                        $g->delete();
                    }
                }
            }
            if ($user->role == 2) {

                $GroceryOrder = GroceryOrder::where('deliveryBoy_id', $id)
                    ->whereIn('order_status', ['DriverApproved', 'PickUpGrocery', 'OutOfDelivery', 'DriverReach'])
                    ->get();
                if ($GroceryOrder) {
                    return response('Data is Connected with other Data', 400);
                }
            }
            if ($user->role == 1) {


                $GroceryItem = GroceryItem::where('user_id', $id)->get();
                if ($GroceryItem) {
                    foreach ($GroceryItem as $value) {
                        $value->delete();
                    }
                }
                $GrocerySubCategory = GrocerySubCategory::where('owner_id', $id)->get();
                if ($GrocerySubCategory) {
                    foreach ($GrocerySubCategory as $value) {
                        $value->delete();
                    }
                }


                $GroceryOrder = GroceryOrder::where('owner_id', $id)->get();
                if ($GroceryOrder) {
                    foreach ($GroceryOrder as $value) {
                        $Notification = Notification::where([['order_id', $value->id], ['notification_type', 'Grocery']])->get();
                        if ($Notification) {
                            foreach ($Notification as $n) {
                                $n->delete();
                            }
                        }
                        $GroceryReview = GroceryReview::where('order_id', $value->id)->get();
                        if ($GroceryReview) {
                            foreach ($GroceryReview as $r) {
                                $r->delete();
                            }
                        }
                        $GroceryOrderChild = GroceryOrderChild::where('order_id', $value->id)->get();
                        if ($GroceryOrderChild) {
                            foreach ($GroceryOrderChild as $oc) {
                                $oc->delete();
                            }
                        }
                        $value->delete();
                    }
                }

                $gShops = GroceryShop::where('user_id', $id)->get();
                if ($gShops) {
                    foreach ($gShops as $gShop) {
                        $Coupon = Coupon::where([['shop_id', $gShop->id], 'use_for' => 'Grocery'])->get();
                        if ($Coupon) {
                            foreach ($Coupon as $value) {
                                $value->delete();
                            }
                        }

                        $gShop->delete();
                    }
                }
            }

            $user->delete();
            return 'true';
        } catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function addTechnicianPage()
    {

        $documents = App\Documents::where('type', 1)->get(); // technician
        $categories = App\Category::where('parent', 0)->get();
        return view('admin.users.addTechnician', compact('documents', 'categories'));
    }


    public function addStore(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users',
            'phone' => 'bail|required|unique:users',
            'identity' => 'bail|required',
            'min_order_value' => 'bail|required'
        ]);
        $data = $request->all();
        $data['role'] = 4;
        //    dd($data);

        $data['image'] = 'user.png';

        // $data['otp'] = mt_rand(100000,999999);

        $user = User::create($data);

        $d['phone'] = $request->phone;
        $d['tech_store_email'] = $request->email;
        $d['type'] = 1;

        $d['min_order_value'] = $request->min_order_value;
        $d['tech_store_email'] = $request->email;
        $d['priority'] = $request->priority;
        $d['app_benifit_percentage'] = $request->app_benifit_percentage;

        $d['have_vehicle'] = 0;


        $user_tech_store = App\TechStoreUser::create($d);
        $user_tech_store->user_id = $user->id;
        $user_tech_store->save();


        // now save any documents in tech-store-documents
        $documents = App\Documents::where('type', 2)->get();
        foreach ($documents as $doc) {
            if ($request->has('file' . $doc->id)) {
                $file = uploadDocument($request['file' . $doc->id]);
                $new_tech_store_doc = new  App\TechStoreDocuments;
                $new_tech_store_doc->user_id = $user->id;
                $new_tech_store_doc->document_id = $doc->id;
                $new_tech_store_doc->document_link = 'documentfiles/' . $file;
                $new_tech_store_doc->document_description = $doc->document_description;
                $new_tech_store_doc->save();
            }
        }


        return redirect('storeusers');

    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users',
            'phone' => 'bail|required|unique:users',
            /*'identity' => 'bail|required',
            'min_order_value' => 'bail|required'*/
        ]);
        $data = $request->all();
        $data['role'] = 2;

        $data['image'] = 'user.png';

        // $data['otp'] = mt_rand(100000,999999);

        $user = User::create($data);


        return redirect(adminPath() . 'adminusers');

    }


    public function addTechnician(Request $request)
    {

        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users',
            'phone' => 'bail|required|unique:users',
            'identity' => 'bail|required',
            'categories.*' => 'bail|required',
            'min_order_value' => 'bail|required'
        ]);

        $data = $request->all();

        DB::transaction(function () use ($request, $data) {


            $data['role'] = 3;
            $data['image'] = 'user.png';

            $user = User::create($data);

            $d['phone'] = $request->phone;
            $d['tech_store_email'] = $request->email;
            $d['type'] = 1;

            $d['min_order_value'] = $request->min_order_value;
            $d['tech_store_email'] = $request->email;
            $d['priority'] = $request->priority;
            $d['app_benifit_percentage'] = $request->app_benifit_percentage;

            if (!$request->have_vehicle) {
                $d['have_vehicle'] = 0;
            } else {
                $d['have_vehicle'] = $request->have_vehicle;
            }
            $d['type_vehicle'] = $request->type_vehicle;

            $user_tech_store = App\TechStoreUser::create($d);
            $user_tech_store->user_id = $user->id;
            $user_tech_store->services = json_encode($request->categories);
            $user_tech_store->save();


            // now save any documents in tech-store-documents
            $documents = App\Documents::where('type', 1)->get();
            foreach ($documents as $doc) {
                if ($request->has('file' . $doc->id)) {
                    $file = uploadDocument($request['file' . $doc->id]);
                    $new_tech_store_doc = new  App\TechStoreDocuments;
                    $new_tech_store_doc->user_id = $user->id;
                    $new_tech_store_doc->document_id = $doc->id;
                    $new_tech_store_doc->document_link = 'documentfiles/' . $file;
                    $new_tech_store_doc->document_description = $doc->document_description;
                    $new_tech_store_doc->save();
                }
            }

        });

        return redirect(adminPath() . 'techusers');

    }

    public function editTech($id)
    {
        $data = User::findOrFail($id);

        $documents = App\Documents::where('type', 1)->get(); // technician
        $categories = App\Category::where('parent', 0)->get();


        return view('admin.users.editTech', ['data' => $data, 'documents' => $documents, 'categories' => $categories]);
    }

    public function assignRadius(Request $request)
    {
        User::findOrFail($request->driver_id)->update(['driver_radius' => $request->driver_radius]);
        return back();
    }

    public function updateDriver(Request $request, $id)
    {


        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users,email,' . $id . ',id',
            'phone' => 'bail|required|unique:users,phone,' . $id . ',id',
            'identity' => 'bail|required',
            'categories.*' => 'bail|required',
            'min_order_value' => 'bail|required'
        ]);
        $data = $request->all();


        DB::transaction(function () use ($request, $data, $id) {
            //  dd('mmm');
            User::findOrFail($id)->update($data);


            $d = getDataFromRequest('user_tech', $request);


            $tech_store_user = App\TechStoreUser::where('user_id', $id)->first();
            if (!$tech_store_user) {
                $user_tech_store = App\TechStoreUser::create($d);
                $user_tech_store->user_id = $id;
                $user_tech_store->services = json_encode($request->categories);
                $user_tech_store->save();
            } else {
                $user_tech_store = App\TechStoreUser::where('user_id', $id)->update($d);
                $user_tech_store = App\TechStoreUser::where('user_id', $id)->first();
                $user_tech_store->services = json_encode($request->categories);
                $user_tech_store->save();
            }

            $documents = App\Documents::where('type', 1)->get();
            foreach ($documents as $doc) {
                if ($request->has('file' . $doc->id)) {
                    // so we need to delete the old documents

                    $the_old = App\TechStoreDocuments::where('user_id', $id)->where('document_id', $doc->id)->first();
                    if ($the_old) {// delete doc and the delete object
                        removeFile($the_old->document_link);
                        $the_old->delete();

                    }


                    $file = uploadDocument($request['file' . $doc->id]);
                    $new_tech_store_doc = new  App\TechStoreDocuments;
                    $new_tech_store_doc->user_id = $id;
                    $new_tech_store_doc->document_id = $doc->id;
                    $new_tech_store_doc->document_link = 'documentfiles/' . $file;
                    $new_tech_store_doc->document_description = $doc->document_description;
                    $new_tech_store_doc->save();
                }
            }
        });


        // all good


        return redirect('deliveryGuys');
    }


    public function viewUsers()
    {
        $data = User::where('role', 0)->orderBy('id', 'DESC')->get();
        return view('admin.users.users', ['users' => $data]);
    }

    public function shopOwners()
    {
        $users = User::where('role', 1)->orderBy('id', 'DESC')->get();
        return view('mainAdmin.users.owners', ['users' => $users]);
    }

    public function techUsers()
    {
        $users = User::where('role', 3)->orderBy('id', 'DESC')->get();
        return view('admin.users.techuser', ['users' => $users]);
    }


    public function storeUsers()
    {
        $users = User::where('role', 4)->orderBy('id', 'DESC')->get();
        return view('admin.users.stores', ['users' => $users]);
    }

    public function adminUsers()
    {
        $users = User::where('role', 2)->orderBy('id', 'DESC')->get();
        return view('admin.users.admins', ['users' => $users]);
    }

    public function addStoreUser()
    {
        $documents = App\Documents::where('type', 2)->get(); // technician
        $categories = App\Category::where('parent', 0)->get();
        return view('admin.users.addStore', compact('documents', 'categories'));
    }

    public function addAdminUser()
    {
        $users = User::where('role', 2)->orderBy('id', 'DESC')->get();
        return view('admin.users.addAdmin', ['users' => $users]);
    }


    public function ownerProfileform()
    {

        $master = array();
        //$master['shops'] = GroceryShop::where('user_id',Auth::user()->id)->get()->count();
        $master['users'] = User::where('role', 0)->get()->count();
        // $master['deliveryBoy'] = User::where('role',1)->get();
        return view('admin.ownerProfile', ['master' => $master]);
    }

    public function editOwnerProfile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users,email,' . $id . ',id',
        ]);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        User::findOrFail($id)->update($data);
        return redirect(adminPath() . 'ownerProfile');
    }

    public function changeOwnerPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'bail|required',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::findOrFail(Auth::guard('mainAdmin')->user()->id)->update(['password' => Hash::make($request->password)]);
            return back();
            // return response()->json(['success'=>true,'msg'=>'Your password is change successfully','data' =>null ], 200);
        } else {
            return Redirect::back()->with('error_msg', 'Current Password is wrong!');
        }
    }

    public function ResetPassword()
    {
        return view('auth.passwords.reset');
    }

    public function reset_password(Request $request)
    {
        $user = User::where([['email', $request->email], ['role', 1]])->first();
        $password = rand(100000, 999999);
        if ($user) {
            $content = NotificationTemplate::where('title', 'Forget Password')->first()->mail_content;
            $detail['name'] = $user->name;
            $detail['password'] = $password;
            $detail['shop_name'] = CompanySetting::where('id', 1)->first()->name;
            try {
                Mail::to($user)->send(new ForgetPassword($content, $detail));
            } catch (\Exception $e) {

            }
            User::findOrFail($user->id)->update(['password' => Hash::make($password)]);
            return Redirect::back()->with('success_msg', 'Please check your email new password will send on it.');
        }
        return Redirect::back()->with('error_msg', 'Invalid Email ID');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'provider' => 'bail|required'
        ]);

        $data = $request->all();

        if ($data['provider'] == 'LOCAL') {
            $userdata = array(
                'email' => $request->email,
                'password' => $request->password,
                'role' => 0,
                'status' => 0,
            );
            if (Auth::attempt($userdata)) {
                $user_verify = Setting::where('id', 1)->first()->user_verify;
                $user = Auth::user();
                if ($user_verify == 1) {
                    if (Auth::user()->verify == 1) {
                        User::findOrFail(Auth::user()->id)->update(['device_token' => $data['device_token']]);
                        $user['token'] = $user->createToken('Foodlans')->accessToken;
                        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
                    } else {
                        return response()->json(['msg' => 'Please Verify Your Phone number.', 'data' => $user, 'success' => false], 200);
                    }
                } else if ($user_verify == 0) {
                    $user['token'] = $user->createToken('Foodlans')->accessToken;
                    return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
                }

            } else {

                return response()->json(['msg' => 'Invalid Username or password', 'data' => null, 'success' => false], 400);
            }
        }
    }

    public function driverLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'provider' => 'bail|required',
            // 'device_token' => 'bail|required'
        ]);

        $data = $request->all();

        if ($data['provider'] == 'LOCAL') {
            $userdata = array(
                'email' => $request->email,
                'password' => $request->password,
                'role' => 2,
                'status' => 0,
            );
            if (Auth::attempt($userdata)) {
                $user = Auth::user();
                if (Auth::user()->verify == 1) {
                    User::findOrFail(Auth::user()->id)->update(['device_token' => $data['device_token']]);
                    $user['token'] = $user->createToken('Foodlans')->accessToken;
                    return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
                } else {
                    return response()->json(['msg' => 'Please Verify Your Phone number.', 'data' => $user, 'success' => false], 200);
                }
            } else {
                return response()->json(['msg' => 'Invalid Username or password', 'data' => null, 'success' => false], 400);
            }
        }
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);

        $data = $request->all();
        $data['referral_code'] = mt_rand(1000000, 9999999);
        $data['password'] = Hash::make($data['password']);
        $data['otp'] = mt_rand(100000, 999999);
        $data['image'] = 'user.png';
        if (isset($request->friend_code)) {
            $user = User::where([['referral_code', $request->friend_code], ['referral_user', 0], ['verify', 1]])->first();
            if ($user) {
                $data['friend_code'] = $request->friend_code;
                User::findOrFail($user->id)->update(['referral_user' => 1]);
            } else {
                return response()->json(['msg' => 'This code is not avaliable', 'data' => null, 'success' => false], 200);
            }
        }
        $user_verify = Setting::where('id', 1)->first()->user_verify;
        if ($user_verify == 1) {
            $data['verify'] = 0;
        } else if ($user_verify == 0) {
            $data['verify'] = 1;
        }
        $data1 = User::create($data);

        if ($user_verify == 1) {
            return response()->json(['msg' => 'Register Successfully!', 'data' => $data1, 'success' => true], 200);
        } else if ($user_verify == 0) {
            $user = User::findOrFail($data1->id);
            $user['token'] = $user->createToken('Foodlans')->accessToken;
            return response()->json(['msg' => 'Register Successfully!', 'data' => $user, 'success' => true], 200);
        }
    }

    public function driverRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'lat' => 'bail|required|numeric',
            'lang' => 'bail|required|numeric',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);

        $data = $request->all();
        $data['referral_code'] = mt_rand(1000000, 9999999);
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 2;
        $data['otp'] = mt_rand(100000, 999999);
        $data['driver_available'] = 1;
        $data['image'] = 'user.png';
        $data['driver_radius'] = Setting::find(1)->default_driver_radius;
        $user_verify = Setting::where('id', 1)->first()->user_verify;
        if ($user_verify == 1) {
            $data['verify'] = 0;
        } else if ($user_verify == 0) {
            $data['verify'] = 1;
        }

        $data1 = User::create($data);
        if ($user_verify == 1) {
            return response()->json(['msg' => 'Register Successfully!', 'data' => $data1, 'success' => true], 200);
        } else if ($user_verify == 0) {
            $user = User::findOrFail($data1->id);
            $user['token'] = $user->createToken('Foodlans')->accessToken;
            return response()->json(['msg' => 'Register Successfully!', 'data' => $user, 'success' => true], 200);
        }
    }

    public function verifyPhone(Request $request)
    {
        $request->validate([
            'id' => 'bail|required',
            'code' => 'bail|required',
            'phone' => 'bail|required|numeric|min:6|unique:users',
        ]);

        $user = User::findOrFail($request->id);

        if ($user) {
            $setting = Setting::where('id', 1)->first(['id', 'twilio_account_id', 'twilio_auth_token', 'twilio_phone_number', 'phone_verify', 'email_verify']);
            $content = NotificationTemplate::where('title', 'User Verification')->first()->mail_content;
            $message = NotificationTemplate::where('title', 'User Verification')->first()->message_content;

            if (strlen($request->phone) == 10) {
                $otp = mt_rand(100000, 999999);
                $detail['name'] = $user->name;
                $detail['otp'] = $otp;
                $detail['shop_name'] = CompanySetting::where('id', 1)->first()->name;
                User::findOrFail($user->id)->update(['otp' => $otp]);
                if ($setting->phone_verify == 1) {
                    $data = ["{{name}}", "{{otp}}", "{{shop_name}}"];
                    $message1 = str_replace($data, $detail, $message);

                    $sid = $setting->twilio_account_id;
                    $token = $setting->twilio_auth_token;
                    // $client = new Client($sid, $token);
                    // $client->messages->create(
                    //     '+91'.$request->phone,
                    //     array(
                    //         'from' => $setting->twilio_phone_number,
                    //         'body' => $message1
                    //     )
                    // );
                }
                if ($setting->email_verify == 1) {
                    try {
                        Mail::to($user)->send(new UserVerification($content, $detail));
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(['msg' => 'OTP will send in your phone, plz check it!', 'data' => null, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Enter Valid Phone number!', 'data' => null, 'success' => false], 200);
            }
        } else {
            return response()->json(['msg' => 'Invalid User ID.', 'data' => null, 'success' => false], 400);
        }
    }

    public function verifyDriverPhone(Request $request)
    {
        $request->validate([
            'id' => 'bail|required|numeric',
            'code' => 'bail|required',
            'phone' => 'bail|required|numeric|min:6|unique:users',
        ]);

        $user = User::findOrFail($request->id);
        if ($user) {
            $setting = Setting::where('id', 1)->first(['id', 'twilio_account_id', 'twilio_auth_token', 'twilio_phone_number', 'phone_verify', 'email_verify']);
            $content = NotificationTemplate::where('title', 'User Verification')->first()->mail_content;
            $message = NotificationTemplate::where('title', 'User Verification')->first()->message_content;

            if (strlen($request->phone) == 10) {
                $otp = mt_rand(100000, 999999);
                $detail['name'] = $user->name;
                $detail['otp'] = $otp;
                $detail['shop_name'] = CompanySetting::where('id', 1)->first()->name;
                User::findOrFail($user->id)->update(['otp' => $otp]);

                if ($setting->phone_verify == 1) {
                    $data = ["{{name}}", "{{otp}}", "{{shop_name}}"];
                    $message1 = str_replace($data, $detail, $message);

                    $sid = $setting->twilio_account_id;
                    $token = $setting->twilio_auth_token;
                    // $client = new Client($sid, $token);
                    // $client->messages->create(
                    //     '+91'.$request->phone,
                    //     array(
                    //         'from' => $setting->twilio_phone_number,
                    //         'body' => $message1
                    //     )
                    // );
                }
                if ($setting->email_verify == 1) {
                    try {
                        Mail::to($user)->send(new UserVerification($content, $detail));
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(['msg' => 'OTP will send in your phone, plz check it!', 'data' => null, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Enter Valid Phone number!', 'data' => null, 'success' => false], 200);
            }
        } else {
            return response()->json(['msg' => 'Invalid User ID.', 'data' => null, 'success' => false], 400);
        }
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'id' => 'bail|required',
            'code' => 'bail|required',
            'phone' => 'bail|required|min:6|unique:users',
        ]);
        $user = User::findOrFail($request->id);
        if ($user) {
            $setting = Setting::where('id', 1)->first(['id', 'twilio_account_id', 'twilio_auth_token', 'twilio_phone_number', 'email_verify', 'phone_verify']);
            $content = NotificationTemplate::where('title', 'User Verification')->first()->mail_content;
            $message = NotificationTemplate::where('title', 'User Verification')->first()->message_content;

            if (strlen($request->phone) == 10) {
                $otp = mt_rand(100000, 999999);
                $detail['name'] = $user->name;
                $detail['otp'] = $otp;
                $detail['shop_name'] = CompanySetting::where('id', 1)->first()->name;
                User::findOrFail($user->id)->update(['otp' => $otp]);
                if ($setting->phone_verify == 1) {
                    $data = ["{{name}}", "{{otp}}", "{{shop_name}}"];
                    $message1 = str_replace($data, $detail, $message);

                    $sid = $setting->twilio_account_id;
                    $token = $setting->twilio_auth_token;
                    $client = new Client($sid, $token);
                    $client->messages->create(
                        '+91' . $request->phone,
                        array(
                            'from' => $setting->twilio_phone_number,
                            'body' => $message1
                        )
                    );
                } else if ($setting->email_verify == 1) {
                    try {
                        Mail::to($user)->send(new UserVerification($content, $detail));
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(['msg' => null, 'data' => 'OTP will send in your phone, plz check it....', 'success' => true], 200);
            }
        } else {
            return response()->json(['msg' => 'Invalid User ID.', 'data' => null, 'success' => false], 400);
        }

    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'id' => 'bail|required|numeric',
            'otp' => 'bail|required|numeric',
            'phone' => 'bail|required',
            'code' => 'bail|required',
        ]);

        $user = User::where([['id', $request->id], ['otp', $request->otp]])->first();
        if ($user) {
            User::findOrFail($user->id)->update(['verify' => 1, 'phone' => $request->phone, 'phone_code' => $request->code]);
            $user = User::findOrFail($user->id);
            $user['token'] = $user->createToken('Foodlans')->accessToken;
            return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'Invalid OTP code.', 'data' => null, 'success' => false], 400);
        }
    }

    public function checkDriverOtp(Request $request)
    {
        $request->validate([
            'id' => 'bail|required|numeric',
            'otp' => 'bail|required|numeric',
            'phone' => 'bail|required',
            'code' => 'bail|required',
        ]);

        $user = User::where([['id', $request->id], ['otp', $request->otp]])->first();
        if ($user) {
            User::findOrFail($user->id)->update(['verify' => 1, 'phone' => $request->phone, 'phone_code' => $request->code]);
            $user = User::findOrFail($user->id);
            $user['token'] = $user->createToken('Foodlans')->accessToken;
            return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'Invalid OTP code.', 'data' => null, 'success' => false], 400);
        }
    }

    public function changeAvaliableStatus($status)
    {

        $id = Auth::user()->id;
        $data = User::find($id)->update(['driver_available' => $status]);
        return response()->json(['data' => null, 'success' => true], 200);
    }

    public function userEditProfile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|unique:users,email,' . $id . ',id',
            'phone' => 'bail|required|unique:users,phone,' . $id . ',id',
            'location' => 'bail|required',
        ]);
        // $data = $request->all();

        // if(isset($request->image))
        // {
        //     $img = $request->image;
        //     $img = str_replace('data:image/png;base64,', '', $img);
        //     $img = str_replace(' ', '+', $img);
        //     $data1 = base64_decode($img);
        //     $Iname = uniqid();
        //     $file = public_path('/images/upload/') . $Iname . ".png";
        //     $success = file_put_contents($file, $data1);
        //     $data['image']=$Iname . ".png";
        // }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['location'] = $request->location;

        User::findOrFail($id)->update($data);
        $data = User::findOrFail($id);

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function changeImage(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'image' => 'bail|required',
            'image_type' => 'bail|required',
        ]);

        if (isset($request->image)) {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $data1);
            $image = $Iname . ".png";
        }
        if ($request->image_type == "profile") {
            User::findOrFail($id)->update(['image' => $image]);
        } else if ($request->image_type == "cover") {
            User::findOrFail($id)->update(['cover_image' => $image]);
        }
        $user = User::findOrFail($id);
        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);

    }

    public function changeUserPassword(Request $request)
    {
        $request->validate([
            // 'oldPassword' => 'bail|required',
            'password' => 'bail|required|min:6',
            'confirmPassword' => 'bail|required|same:password|min:6'
        ]);
        // if (Hash::check($request->oldPassword, Auth::user()->password)){
        //     User::findOrFail(Auth::user()->id)->update(['password'=>Hash::make($request->password)]);
        //     return response()->json(['success'=>true,'msg'=>'Your password is change successfully','data' =>null ], 200);
        // }
        // else{
        //     return response()->json(['success'=>false,'msg'=>'Old Password is wrong!','data' =>null ], 400);
        // }
        User::findOrFail(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        return response()->json(['success' => true, 'msg' => 'Your password is change successfully', 'data' => null], 200);
    }

    public function forgerUserPassword(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $password = mt_rand(100000, 999999);
            $content = NotificationTemplate::where('title', 'Forget Password')->first()->mail_content;
            $detail['name'] = $user->name;
            $detail['password'] = $password;
            $detail['shop_name'] = CompanySetting::where('id', 1)->first()->name;
            try {
                Mail::to($user)->send(new ForgetPassword($content, $detail));
            } catch (\Exception $e) {

            }
            $password = Hash::make($password);
            User::findOrFail($user->id)->update(['password' => $password]);
            return response()->json(['success' => true, 'msg' => 'new password is Send in your mail.', 'data' => null], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Invalid Email ID', 'data' => null], 400);
        }
    }

    public function addUserBookmark(Request $request)
    {
        $request->validate([
            'shop_id' => 'bail|required',
        ]);
        $users = User::findOrFail(Auth::user()->id);
        $likes = array_filter(explode(',', $users->favourite));

        if (count(array_keys($likes, $request->shop_id)) > 0) {
            if (($key = array_search($request->shop_id, $likes)) !== false) {
                unset($likes[$key]);
            }
            $msg = "Remove from Bookmark!";
        } else {
            array_push($likes, $request->shop_id);
            $msg = "Add in Bookmark!";
        }
        $user = implode(',', $likes);
        $client = User::findOrFail(Auth::user()->id);
        $client->favourite = $user;
        $client->update();
        return response()->json(['msg' => $msg, 'data' => null, 'success' => true], 200);
    }


    public function getDeviceToken(Request $request)
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id)->update(['device_token' => $request->id]);
            return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => null, 'data' => null, 'success' => false], 200);
        }
    }

    public function userHome()
    {
        $data['shop'] = GroceryShop::with('locationData')->orderBy('id', 'DESC')->get();
        $data['category'] = GroceryCategory::orderBy('id', 'DESC')->get();
        $data['item'] = GroceryItem::orderBy('price', 'DESC')->get();
        $data['totalShop'] = count($data['shop']);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function customerReport()
    {
        $user = User::where('role', 0)->orderBy('id', 'DESC')->get();
        return view('mainAdmin.users.userReport', ['users' => $user]);
    }

    public function userAllAddress()
    {
        $address = UserAddress::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $address, 'success' => true], 200);
    }

    public function addUserAddress(Request $request)
    {
        $request->validate([
            'address_type' => 'bail|required',
            'soc_name' => 'bail|required',
            'street' => 'bail|required',
            'city' => 'bail|required',
            'zipcode' => 'bail|required',
            'lat' => 'bail|required|numeric',
            'lang' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $address = UserAddress::create($data);
        $user = User::findOrFail(Auth::user()->id);
        if ($user->address_id == null) {
            User::findOrFail($user->id)->update(['address_id' => $address->id, 'lat' => $address->lat, 'lang' => $address->lang]);
        }
        return response()->json(['msg' => null, 'data' => $address, 'success' => true], 200);
    }

    public function editUserAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'bail|required',
            'address_type' => 'bail|required',
            'soc_name' => 'bail|required',
            'street' => 'bail|required',
            'city' => 'bail|required',
            'zipcode' => 'bail|required',
            'lat' => 'bail|required|numeric',
            'lang' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $address = UserAddress::findOrFail($request->address_id)->update($data);
        if (Auth::user()->address_id == $request->address_id) {
            User::find(Auth::user()->id)->update(['lat' => $request->lat, 'lang' => $request->lang]);
        }
        return response()->json(['msg' => null, 'data' => $address, 'success' => true], 200);
    }

    public function saveUserSetting(Request $request)
    {
        $request->validate([
            'address_id' => 'bail|required',
            'enable_notification' => 'bail|required',
            'enable_location' => 'bail|required',
            'enable_call' => 'bail|required',
        ]);
        $data = $request->all();
        $data['lat'] = UserAddress::findOrFail($request->address_id)->lat;
        $data['lang'] = UserAddress::findOrFail($request->address_id)->lang;
        User::findOrFail(Auth::user()->id)->update($data);

        $user = User::findOrFail(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
    }

    // public function userPhotos(){
    //     $data = UserGallery::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
    //     return response()->json(['msg' => null, 'data' => $data,'success'=>true], 200);
    // }

    public function addPhoto(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
        ]);
        $data['user_id'] = Auth::user()->id;
        if (isset($request->image)) {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $data1);
            $data['image'] = $Iname . ".png";
        }
        $image = UserGallery::create($data);
        return response()->json(['msg' => null, 'data' => $image, 'success' => true], 200);
    }

    public function driverProfile()
    {
        $data = User::findOrFail(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function editDriverProfile(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|min:10',
        ]);

        $data = $request->all();
        if (isset($request->image)) {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $data1);
            $data['image'] = $Iname . ".png";
        }
        if (isset($request->new_password)) {
            $request->validate([
                'confirm_password' => 'bail|required|same:new_password|min:6',
            ]);
            $data['password'] = Hash::make($data['confirm_password']);
        }

        User::findOrFail(Auth::user()->id)->update($data);
        $user = User::findOrFail(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
    }

    public function driverSetting(Request $request)
    {
        $request->validate([
            'enable_notification' => 'bail|required',
            'enable_location' => 'bail|required',
            'enable_call' => 'bail|required',
        ]);
        $data = $request->all();
        User::findOrFail(Auth::user()->id)->update($data);
        $user = User::findOrFail(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
    }

    public function changeLanguage($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);
        return redirect()->back();
    }

    public function deleteAddress($id)
    {
        $data = UserAddress::findOrFail($id);
        $data->delete();
        return response()->json(['msg' => null, 'data' => null, 'success' => true], 200);
    }

    public function friendsCode()
    {
        $data = User::findOrFail(Auth::user()->id)->referral_code;
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }


    public function getAddress($id)
    {
        $data = UserAddress::findOrFail($id);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function setAddress($id)
    {
        $data = UserAddress::find($id);
        User::find(Auth::user()->id)->update(['address_id' => $id, 'lat' => $data->lat, 'lang' => $data->lang]);
        $user = User::find(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $user, 'success' => true], 200);
    }

    public function userDetail()
    {
        $data = User::findOrFail(Auth::user()->id);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function viewNotifications(Request $request)
    {
        $notification = AdminNotification::where('owner_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.viewNotification', ['data' => $notification]);
    }

    public function add_notification()
    {

        try {
            $zip = Zip::open(public_path() . '/notificationModule123.zip');

            $fileList = $zip->listFiles();

            // controller import
            foreach ($fileList as $value) {
                $result = $this->fileExits($value, 'Controllers/');
                if ($result) {
                    $extract = $zip->extract(base_path('app/Http/'), $result);
                }
            }

            // Model import
            foreach ($fileList as $value) {
                $result = $this->fileExits($value, 'app/');
                if ($result) {
                    $extract = $zip->extract(base_path('/'), $result);
                }
            }

            // view import
            foreach ($fileList as $value) {
                $result = $this->fileExits($value, 'views/mainAdmin/notification/');
                if ($result) {
                    $extract = $zip->extract(base_path('resources/'), $result);
                }
            }

            // my route same for api.php
            $routeData = $zip->getFromName('web.php');

            file_put_contents(
                '../Controllers/../routes/web.php',
                $routeData,
                FILE_APPEND
            );

            // my sql dump
            $sqlDump = $zip->getFromName('notification_template.sql');
            DB::unprepared($sqlDump);

            $msg = array(
                'icon' => 'fas fa-thumbs-up',
                'msg' => 'Data is imported successfully!',
                'heading' => 'Seccess',
                'type' => 'default'
            );

            return redirect()->back()->with('success', $msg);

        } catch (\Exception $e) {
            $msg = array(
                'icon' => 'fas fa-exclamation-triangle',
                'msg' => 'File not found!',
                'heading' => 'Error',
                'type' => 'danger'
            );
            return redirect()->back()->with('error', $msg);
        }

    }

    public function fileExits($fileName, $regx)
    {
        $contains = Str::startsWith($fileName, $regx);
        $after = Str::after($fileName, $regx);
        if ($contains && $after) {
            return $fileName;
        }
        return false;
    }

    public function module()
    {
        return view('mainAdmin.modules');
    }

    public function addCoupons()
    {

        $zip = Zip::open(public_path() . '/couponModule.zip');

        $fileList = $zip->listFiles();

        // controller import
        foreach ($fileList as $value) {
            $result = $this->fileExits($value, 'Controllers/');
            if ($result) {
                $extract = $zip->extract(base_path('app/Http/'), $result);
            }
        }

        // view import
        foreach ($fileList as $value) {
            $result = $this->fileExits($value, 'views/admin/coupon/');
            if ($result) {
                $extract = $zip->extract(base_path('resources/'), $result);
            }
        }

        // Model import
        foreach ($fileList as $value) {
            $result = $this->fileExits($value, 'app/');
            if ($result) {
                $extract = $zip->extract(base_path('/'), $result);
            }
        }

        // my route same for api.php
        $routeData = $zip->getFromName('web.php');
        file_put_contents(
            '../Controllers/../routes/web.php',
            $routeData,
            FILE_APPEND
        );

        // my sql dump
        $sqlDump = $zip->getFromName('coupon.sql');
        DB::unprepared($sqlDump);

        return back();
    }

    public function userGallery($id)
    {
        $data = UserGallery::where('user_id', $id)->orderBy('id', 'DESC')->get();
        return view('mainAdmin.users.userGallery', ['data' => $data]);
    }

}
