<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\controller;
use App\Models\User;
use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\sections;
use App\Models\products;
use App\Models\invoices_details;
use Illuminate\Support\Facades\Storage;
use App\Exports\invoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\AddInvoice;
use Symfony\Component\ErrorHandler\Error\FatalError;
use DB;
use session;
use Auth;
use Illuminate\Http\Request;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoice',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=sections::all();
        $products=products::all();
        return view('invoices.add',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
      
        { // حيضيف البيانات التالية للداتا بيس
            invoices::create([
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
            ]);
             // اخر id  انحفظ ياخده معاه ويشتغل عليه
            $invoice_id = invoices::latest()->first()->id;
            invoices_details::create([
                'id_Invoice' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
    
            //إذا كان يوجد مرفق فياخد :
           if ($request->hasFile('pic')) {
      // آخر id 
                $invoice_id = Invoices::latest()->first()->id;
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $request->invoice_number;
    
                $attachments = new invoices_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice_number;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice_id;
                $attachments->save();
    
                // move pic 
                //   حيحفظ اسم المرفق  في الداتا بيس ولكن المرفق نفسه في السيرفر
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
            //  Attachments يحفظ فيه رقم الفاتورة واسمها المدخل ، داخل ملف البوبلبيك حيعمل ملف اسمه 
            }
    
    // لارسال الايميل 
    
                $user = User::get();
                Notification::send($user, new AddInvoice($invoice_id));
              //  $user->notify(new AddInvoice($invoice_id)); دالة أخرى 

    /*
            $user = User::get();
            $invoices = invoices::latest()->first();
            Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));
    
            event(new MyEventClass('hello world'));
    */
            session()->flash('Add', 'تم إضافة الفاتورة بنجاح');
            return back();
        }
    
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {
        
        //first حتجيب row وحدة فقط
        $invoices = invoices::find($id);
        $sections = sections::all();
        return view('invoices.edit', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoices)
    { //حيدور على id بناء ع المطلوب
        $invoices = invoices::findOrFail($request->invoice_id);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        $invoices = invoices::all();
        //حياخد ال id الي جاييني من الريكوست 
        /*ازم تكوني بالأول حتى يحدف من الpublic 
        والا حبحدف الفاتورة بدون مايقرب ع public
        */
        $Details = invoices_attachments::where('invoice_id', $id)->first();
        // لو كان مش فارغ حيجيب رقم الفاتورة
        if (!empty($Details->invoice_number)) {
           // حيحدف كل ملف المرفقات 
            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        DB::table("invoices")->where("id",$id)->delete();
        //forcedelete  ----حيحدفها من الداتا بيس 
        // delete  ----- حيحتفظ فيها في الداتا بيس والتالي تؤرشف
        session()->flash("delete","تم حذف الفاتورة بنجاح");
        return back();
         }
  
       //الدالة خاصة في صفحة اضافة الفاتورة حتى يجلب المنتجات الخاصة بالقسم المدخل فقط 
       public function getproducts($id)
       {
           $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
           return json_encode($products);
       }

       public function status_update(Request $request, $id)
       { 
           $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
        // الريكويست
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1, // 1 مدفوعة 
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3, // 3 غير مدفوعة
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('status_update');
        return redirect('/invoice');


       }

       public function export() 
       {
           return Excel::download(new invoicesExport, 'invoices.xlsx');
       }

}
