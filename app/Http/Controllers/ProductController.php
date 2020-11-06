<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductCategory;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*
    |---------------------------------------------
    | LIST ALL PRODUCTS
    |---------------------------------------------
    */
    public function listAllProducts(Request $request)
    {
        $products                   = Product::paginate(10);

        return response()->json($products, 200);
    }

    /*
    |---------------------------------------------
    | LIST A PRODUCT
    |---------------------------------------------
    */
    public function listAProduct(Request $request, $id)
    {
        $product                   = Product::findorFail($id);

        return response()->json($product, 200);
    }

    /*
    |---------------------------------------------
    | STORE A NEW PRODUCT
    |---------------------------------------------
    */
    public function storeProduct(Request $request)
    {
        $user_id                            = Auth::id();

        $file                               = '';
        if ($request->hasFile('ProductImage')) {
            $file                           = $request->file('ProductImage')->getClientOriginalName();
            $filename                       = $request->ProductImage->storeAs('public/product_images', $file);
        }

        try {
            DB::beginTransaction();
            $product                        = new Product($request->all());
            $product->ProductImage          = $file;
            $product->created_by            = $user_id;
            $product->updated_by            = $user_id;
            $product->save();
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $product, 'message' => 'Product Created Successfully'], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage(). ',' . ' Product could not be created, Please ensure data is inputted correctly.'], 400);
        }
    }

    /*
    |---------------------------------------------
    | UPDATE A PRODUCT
    |---------------------------------------------
    */
    public function updateProduct(Request $request, $id)
    {
        $user_id                            = Auth::id();

        $product                            = Product::find($id);

        $file                               = $product->ProductImage;
        if ($request->hasFile('ProductImage')) {
            $file                           = $request->file('ProductImage')->getClientOriginalName();
            $filename                       = $request->ProductImage->storeAs('public/product_images', $file);
        }

        try {
            DB::beginTransaction();
            $product->Product           = $request->Product;
            $product->CategoryID        = $request->CategoryID;
            $product->Quantity          = $request->Quantity;
            $product->Amount            = $request->Amount;
            $product->EntryDate         = $request->EntryDate;
            $product->ExpiryDate        = $request->ExpiryDate;
            $product->ProductImage      = $file;
            $product->updated_by        = $user_id;
            $product->update();
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $product, 'message' => 'Product Updated Successfully'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage(). ',' . ' Product could not be updated, Please ensure data is inputted correctly.'], 400);
        }
    }

    /*
    |---------------------------------------------
    | DELETE A PRODUCT
    |---------------------------------------------
    */
    public function deleteProduct(Request $request, $id)
    {
        $product                       = Product::find($id);
        if($product !== null){
            if($product->delete()){
                $data = [
                    "status"        => "success",
                    "message"       => "Product was deleted successfully"
                ];
            }else{
                $data = [
                    "status"        => "error",
                    "message"       => "Error deleting Product!"
                ];
            }
        }else{
            $data = [
                "status"            => "error",
                "message"           => "No Product found!"
            ];
        }

        return response()->json($data, 200);
    }

    /*
    |---------------------------------------------
    | CREATE 50 PRODUCTS WITH PRODUCT FACTORY
    |---------------------------------------------
    */
    public function runProduct(Request $request) 
    {
        $products                   = factory(Product::class, 50)->create()->each(function($u) {
            $u->product_category()->save(factory(ProductCategory::class)->make());
        });

        return response()->json($products, 201);
    }
}
