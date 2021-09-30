<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\controller;
use Auth;
use DB;
use Session;
use App\Models\sections;
use App\Models\products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=sections::all();
        $products=products::all();
        return view('products.product',compact('sections','products'));
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
    {     $validatedData = $request->validate
      ([// انجلش
            'product_name' => 'required|unique:products|max:255',
        ],[// للتعريب
            'product_name.required' =>'يرجي إدخال اسم المنتج',
            'product_name.unique' =>'اسم المنتج مسجل مسبقاً',
        ]);

       
        Products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        
        session()->flash('Add', 'تم إضافة المنتج بنجاح ');
        return redirect('/product'); 

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, products $products)

        {
            // حيروح على جدول الأقسام حيث اسم القسم في الريكوست ويجيب الid تبعه ويحتفظ فيها 
            $id = sections::where('section_name', $request->section_name)->first()->id;
    // حيروح على جدول المنتجات ويجيب ال id المطلوب 
            $products = products::findOrFail($request->pro_id);
            $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
            ]);
     
            session()->flash('edit','تم تعديل المنتج بنجاح');
            return back();
        }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
   
    public function destroy(Request $request,$id)
    {
        DB::table("products")->where("id",$id)->delete();
        session()->flash("delete","تم حذف المنتج بنجاح");
        return redirect("/product");
    }
     
}