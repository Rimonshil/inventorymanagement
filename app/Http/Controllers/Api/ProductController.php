<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;
use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('products')
                 ->join('categories','products.category_id','categories.id')
                 ->join('suppliers','products.supplier_id','suppliers.id')
                 ->select('categories.category_name','suppliers.name','products.*')
                 ->orderBy('products.id','DESC')
                 ->get();

                 return response()->json($product);
                 
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'category_id' => 'required',
            'buying_price'=>'required',
            'selling_price'=>'required',
            'supplier_id'=>'required'


        ]);

        if($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0 ,$position);
            $ext = explode('/',$sub)[1];

            $name = time().".".$ext;
            $img = Image::make($request->image)->resize(240,200);
            
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            $img->save($image_url);


            $employee = new Product();
            $employee->product_name = $request->product_name;
            $employee->category_id = $request->category_id;
            $employee->product_code = $request->product_code;
            $employee->root = $request->root;
            $employee->buying_price = $request->buying_price;
            $employee->selling_price = $request->selling_price;
            $employee->supplier_id = $request->supplier_id;
            $employee->buying_date = $request->buying_date;

            $employee->product_quantity = $request->product_quantity;
           

           $employee->image = $image_url;
           $employee->save();


        }else{

            $employee = new Product();
            $employee->product_name = $request->product_name;
            $employee->category_id = $request->category_id;
            $employee->product_code = $request->product_code;
            $employee->root = $request->root;
            $employee->buying_price = $request->buying_price;
            $employee->selling_price = $request->selling_price;
            $employee->supplier_id = $request->supplier_id;
            $employee->buying_date = $request->buying_date;

            $employee->product_quantity = $request->product_quantity;
           $employee->save();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = DB::table('products')->where('id',$id)->first();
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Employee::where('id',$id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        $photo = $product->image;
        if($photo){
            unlink($photo);
            DB::table('products')->where('id',$id)->delete();
        }else{
            DB::table('products')->where('id',$id)->delete();

        }
    }
}
