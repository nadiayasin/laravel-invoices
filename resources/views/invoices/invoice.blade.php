@extends('layouts.master')
@section('title','قائمة الفواتير')
@section('css')
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notification -->
<link href="{{asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                الفواتير</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row opened -->
@if (session()->has('delete'))

<script>
window.onload = function() {
    notif({
        msg: "تم حذف الفاتورة بنجاح",
        type: "success"
    })
}
</script>

@endif

@if (session()->has('status_update'))
<script>
window.onload = function() {
    notif({
        msg: "تم تحديث حالة الدفع بنجاح",
        type: "success"
    })
}
</script>
@endif
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-sm-6 col-md-3 mg-t-10 mg-md-t-0">
                        <a class="modal-effect btn btn-sm btn-primary" href="invoice/create" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; إضافة فاتورة</a>

                        <a class="modal-effect btn btn-sm btn-primary" href="{{ ('/export_invoice') }}"
                            style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير Excel</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة </th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الإجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">العمليات </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0 ?>
                            @foreach($invoices as $invoice)
                            <?php $i++ ?>

                            <tr>
                                <td>{{$i}}</td>
                                <td><a href="{{('/invoice-details') }}/{{ $invoice->id }}"
                                        style="font-weight: bolder;">{{$invoice->invoice_number}}</a></td>
                                <td>{{$invoice->invoice_Date}}</td>
                                <td>{{$invoice->Due_date}}</td>
                                <td>{{$invoice->product}}</td>
                                <td>
                                    {{$invoice->section->section_name}}</td>
                                <td>{{$invoice->Total}}</td>
                                <!--أنسق الحالة، مدفوعة تكون اخضر ، وغير مدغوعة احمر ، لو كانت غير السابق باللون الاصفر  -->
                                <td> @if ($invoice->Value_Status == 1)
                                    <span class="text-success">{{ $invoice->Status }}</span>
                                    @elseif($invoice->Value_Status == 2)
                                    <span class="text-danger">{{ $invoice->Status }}</span>
                                    @else
                                    <span class="text-warning">{{ $invoice->Status }}</span>
                                    @endif
                                </td>

                                <td>

                                    <div class="dropdown">
                                        <button aria-expanded="false" aria-haspopup="true"
                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                            type="button">العمليات<i class="fas fa-caret-down ml-1"></i>
                                        </button>
                                        <div class="dropdown-menu tx-13">

                                            <a class=" dropdown-item" href="{{route('invoice.edit',$invoice->id)}}"
                                                title="تعديل"><i class="la la-edit"></i>تعديل </a>


                                            <a class=" dropdown-item" href="{{route('invoice.destroy',$invoice->id)}}"
                                                onclick="return confirm('هل أنت متأكد من حذف {{$invoice->invoice_number}} ؟')"
                                                title="حذف"><i class="la la-remove">حذف</i> </a>


                                            <a class="dropdown-item" href="{{ route('status_show', $invoice->id) }}"><i
                                                    class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;
                                                تغيير حالة الدفع</a>



                                        </div>
                                    </div>

                                 </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- /row -->
</div>

@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notification js -->
<script src="{{asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection