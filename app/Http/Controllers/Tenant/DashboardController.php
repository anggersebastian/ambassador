<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\TenantUserCreateUpdateRequest;
use App\Tenant\TenantRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboard, $tenant;

    public function __construct(TenantRepository $tenant){
        $this->tenant   = $tenant;
    }

    public function index(){
        return view('tenant.dashboard');
    }

    public function profile(Request $request){
        $user   = $this->tenant->findTenantUser(Auth::guard('tenant')->user()->id);
        $tenant = $this->tenant->findTenant($user->tenant_id);

        return view('tenant.profile.detail', compact('user','tenant'));
    }

    public function tenantForm(Request $request){
        $user   = $this->tenant->findTenantUser(Auth::guard('tenant')->user()->id);
        $tenant = $this->tenant->findTenant($user->tenant_id);
        $categories = $this->tenant->getTenantCategories();

        return view('tenant.form', compact('user','tenant','categories'));
    }

    public function tenantSave(Request $request){
        $user       = $this->tenant->findTenantUser(Auth::guard('tenant')->user()->id);
        $id         = $user->tenant_id;
        $inputs     = $request->all();
        $tenant     = $this->tenant->saveTenant($id, $inputs);


        alertNotify(true, "Tenant updated!", $request);
        return redirect(url('tenant/profile'));
    }

    public function profileForm(){
        $user   = $this->tenant->findTenantUser(Auth::guard('tenant')->user()->id);
        $tenant = $this->tenant->findTenant($user->tenant_id);

        return view('tenant.profile.form', compact('user','tenant'));
    }

    public function profileSave($id = null, TenantUserCreateUpdateRequest $request){
        $user       = $this->tenant->findTenantUser(Auth::guard('tenant')->user()->id);
        if($user->id != $id){
            alertNotify(false, "User is not yours", $request);
            return redirect()->back();
        }

        $inputs                 = $request->all();
        $inputs['tenant_id']    = $user->tenant_id;
        $inputs['role']         = 'admin';
        $user                   = $this->tenant->saveTenantUser($id, $inputs);


        alertNotify(true, "Tenant User updated!", $request);
        return redirect(url('tenant/profile'));
    }

    public function products(Request $request){
        $tenantId               = Auth::guard('tenant')->user()->tenant_id;
        $filters['tenant_id']   = $tenantId;

        $products               = $this->tenant->getTenantProducts($filters);

        return view('tenant.product.list', compact('products'));
    }

    public function productForm($id = null, Request $request){
        $tenantId               = Auth::guard('tenant')->user()->tenant_id;
        $product                = $this->tenant->findTenantProduct($id);
        if($id AND (!$product OR $product->tenant_id != $tenantId)){
            alertNotify(false, "Product is not yours", $request);
            return redirect()->back();
        }

        return view('tenant.product.form', compact('product'));
    }

    public function productSave($id = null, Request $request){
        $inputs     = $request->all();
        $tenantId   = Auth::guard('tenant')->user()->tenant_id;

        $product    = $this->tenant->findTenantProduct($id);
        if($id AND (!$product OR $product->tenant_id != $tenantId)){
            alertNotify(false, "Product is not yours", $request);
            return redirect()->back();
        }

        $product    = $this->tenant->saveTenantProduct($id, $tenantId, $inputs);
        alertNotify(true, "Product Saved!", $request);

        return redirect(url('tenant/product'));
    }

    public function productDelete($id = null, Request $request)
    {
        $tenantId               = Auth::guard('tenant')->user()->tenant_id;
        $product                = $this->tenant->findTenantProduct($id);
        if(!$product OR $product->tenant_id != $tenantId){
            alertNotify(false, "Product is not yours", $request);
            return redirect()->back();
        }

        $this->tenant->deleteTenantProduct($id);

        alertNotify(true, "Product deleted", $request);
        return redirect(url('tenant/product'));
    }

    public function users(Request $request){
        $tenantId               = Auth::guard('tenant')->user()->tenant_id;
        $filters['tenant_id']   = $tenantId;
        $users                  = $this->tenant->getTenantUsers($filters);
        return view('tenant.users.list', compact('users'));
    }
}