<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\ProductCategory;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /*
    |---------------------------------------------
    | LIST ALL PRODUCT CATEGORIES
    |---------------------------------------------
    */
    public function listAllProductCategories(Request $request)
    {
        $productCategory                   = ProductCategory::findorFail($id);

        return response()->json($productCategory, 200);
    }

    /*
    |---------------------------------------------
    | LIST A PRODUCT CATEGORY
    |---------------------------------------------
    */
    public function listAProductCategory(Request $request, $id)
    {
        $productCategory                   = ProductCategory::paginate(10);

        return response()->json($productCategory, 200);
    }

    /*
    |---------------------------------------------
    | STORE NEW PRODUCT CATEGORY
    |---------------------------------------------
    */
    public function storeProductCategory(Request $request)
    {
        $user_id                            = Auth::id();

        try {
            DB::beginTransaction();
            $productCategory                = new ProductCategory($request->all());
            $productCategory->created_by    = $user_id;
            $productCategory->updated_by    = $user_id;
            $productCategory->save();
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $productCategory, 'message' => 'Product Category Created Successfully'], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage(). ',' . ' Product Category could not be created, Please ensure data is inputted correctly.'], 400);
        }
    }

    /*
    |---------------------------------------------
    | UPDATE A PRODUCT CATEGORY
    |---------------------------------------------
    */
    public function updateProductCategory(Request $request, $id)
    {
        $user_id                            = Auth::id();

        try {
            DB::beginTransaction();
            $productCategory                = ProductCategory::findorFail($id);
            $productCategory->updated_by    = $user_id;
            $productCategory->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $productCategory, 'message' => 'Product Category Updated Successfully'], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage(). ',' . ' Product Category could not be updated, Please ensure data is inputted correctly.'], 400);
        }
    }

    /*
    |---------------------------------------------
    | DELETE A PRODUCT CATEGORY
    |---------------------------------------------
    */
    public function deleteProductCategory(Request $request, $id)
    {
        $productCategory                       = ProductCategory::find($id);
        if($productCategory !== null){
            if($productCategory->delete()){
                $data = [
                    "status"        => "success",
                    "message"       => "Product Category was deleted successfully"
                ];
            }else{
                $data = [
                    "status"        => "error",
                    "message"       => "Error deleting Product Category!"
                ];
            }
        }else{
            $data = [
                "status"            => "error",
                "message"           => "No Product Category found!"
            ];
        }

        return response()->json($data, 200);
    }
}
