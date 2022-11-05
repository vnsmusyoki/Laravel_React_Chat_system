<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class BusinessDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:businessowner']);
    }
    public function checkauth()
    {
        $user = auth()->user();
        return $user;
    }

    public function index()
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            // if ($this->checkauth()->hasPermission('create-order')) {
            //     return view('client.place-new-order');
            // } else {
            //     Toastr::error('No permission to access this page', 'Error', ["positionClass" => "toast-top-right"]);
            //     return redirect('client/no-access');
            // }
            return view('business.dashboard');
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function addproduct()
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                return view('business.create-product');
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function storeproduct(Request $request)
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                $this->validate($request, [
                    'product_name' => 'required|string|min:5',
                    'product_price' => 'required|numeric|min:30',
                    'product_image' => 'required|image|mimes:jpeg,jpg,png|max:20048',
                    'product_description' => 'required|string|min:5',
                    'stock_available' => 'required|numeric|min:1',
                ]);

                $timenow = time();
                $checknum = "1234567898746351937463790";
                $checkstring = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte";
                $checktimelength = 6;
                $checksnumlength = 6;
                $checkstringlength = 20;
                $randnum = substr(str_shuffle($timenow), 0, $checktimelength);
                $randstring = substr(str_shuffle($checknum), 0, $checksnumlength);
                $randcheckstring = substr(str_shuffle($checkstring), 0, $checkstringlength);
                $totalstring = str_shuffle($randcheckstring . "" . $randnum . "" . $randstring);

                $new = new Product;
                $new->seller_id = auth()->user()->id;
                $new->product_name = $request->product_name;
                $new->price = $request->product_price;
                $new->quantity = $request->stock_available;
                $fileNameWithExt = $request->product_image->getClientOriginalName();
                $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $Extension = $request->product_image->getClientOriginalExtension();
                $filenameToStore = $fileName . '-' . auth()->user()->id . '.' . $Extension;
                $path = $request->product_image->storeAs('products', $filenameToStore, 'public');
                $new->image = $filenameToStore;
                $new->slug = $totalstring;
                $new->description = $request->product_description;
                $new->save();

                Toastr::success('New product uploaded successfully', 'Alert', ["positionClass" => "toast-bottom-right"]);
                return redirect()->route('businessowner.myproducts');
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function myproducts()
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                $products = Product::where('seller_id', auth()->user()->id)->get();
                return view('business.my-products', compact('products'));
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function editproduct($slug)
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                $product = Product::where('seller_id', auth()->user()->id)->where('slug', $slug)->first();
                if ($product) {
                    return view('business.edit-product', compact('product'));
                } else {
                    Toastr::error('Unable to retrieve this product details', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->back();
                }
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function updateproduct(Request $request, $slug)
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                $this->validate($request, [
                    'product_name' => 'required|string|min:5',
                    'product_price' => 'required|numeric|min:30',
                    'product_image' => 'nullable|image|mimes:jpeg,jpg,png|max:20048',
                    'product_description' => 'required|string|min:5',
                    'stock_available' => 'required|numeric|min:1',
                ]);


                $new = Product::where('seller_id', auth()->user()->id)->where('slug', $slug)->first();
                if ($new) {
                    $new->seller_id = auth()->user()->id;
                    $new->product_name = $request->product_name;
                    $new->price = $request->product_price;
                    $new->quantity = $request->stock_available;
                    if ($request->hasFile('product_image')) {
                        Storage::delete('public/products/' . $new->image);
                        $fileNameWithExt = $request->product_image->getClientOriginalName();
                        $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $Extension = $request->product_image->getClientOriginalExtension();
                        $filenameToStore = $fileName . '-' . auth()->user()->id . '.' . $Extension;
                        $path = $request->product_image->storeAs('products', $filenameToStore, 'public');
                        $new->image = $filenameToStore;
                    }
                    $new->description = $request->product_description;
                    $new->save();

                    Toastr::success('Product updated successfully', 'Alert', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->route('businessowner.myproducts');
                } else {
                    Toastr::error('Unable to retrieve this product details', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->back();
                }
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
    public function deleteproduct($slug)
    {
        $this->checkauth();
        if (auth()->user()->hasRole('businessowner')) {

            if ($this->checkauth()->hasPermission('manage-products')) {
                $product = Product::where('seller_id', auth()->user()->id)->where('slug', $slug)->first();
                if ($product) {
                    Storage::delete('public/products/' . $product->image);
                    $product->delete();
                    Toastr::success('Product deleted successfully', 'Alert', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->route('businessowner.myproducts');
                } else {
                    Toastr::error('Unable to retrieve this product details', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->back();
                }
            } else {
                Toastr::error('No permission to access products page', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('No authorized to access admin dashboard.Log in to your account', 'Error', ["positionClass" => "toast-top-right"]);

            return redirect()->route('login');
        }
    }
}
