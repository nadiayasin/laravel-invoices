@extends('layouts.master')
@section('title','قائمة المنتجات')
@section('css')
<!-- Internal Data table css -->
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
<!---Internal Owl Carousel css-->
<link href="{{ asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{ asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
<!--- Select2 css -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتجات</span>
        </div>
    </div>

</div>
<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('delete') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('error') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-sm-6 col-md-3 mg-t-10 mg-md-t-0">
                        <button class="btn btn-success btn-block" data-effect="effect-scale" data-toggle="modal"
                            href="#exampleModal"><i
                                class="fas fa-plus"></i>&nbsp;إضافة منتج</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0"> المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php $i=0 ?>
                            @foreach($products as $product)
                            <?php $i++ ?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->section->section_name}}</td>
                                <td>{{$product->description}}</td>
                                <td>

                                    <button class="btn btn-outline-success btn-sm"
                                        data-name="{{ $product->product_name }}" data-pro_id="{{ $product->id }}"
                                        data-section_name="{{ $product->section->section_name }}"
                                        data-description="{{ $product->description }}" data-toggle="modal"
                                        data-target="#edit_product"><i class="las la-pen"></i></button>



										<button class="btn btn-outline-danger btn-sm "
                                        href="{{route('product.delete',$product->id)}}"
                                        onclick="return confirm('هل أنت متأكد من حذف {{$product->name}} ؟')" title="حذف"><i
                                            class="la la-remove"></i> </a>

                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة منتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('product.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> المنتج</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                        <select name="section_id" id="section_id" class="form-control" required>
                            <option value="" selected disabled> حدد القسم</option>
                            @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تأكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit -->
    <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action='product/update' method="post">
                    @method('put')
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title">اسم المنتج :</label>

                            <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                            <input type="text" class="form-control" name="product_name" id="product_name">
                        </div>

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                        <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                            @foreach ($sections as $section)
                            <option>{{ $section->section_name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="des">ملاحظات :</label>
                            <textarea name="description" cols="20" rows="5" id='description'
                                class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
</div>
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ asset('assets/js/table-data.js') }}"></script>
<!-- Internal Prism js-->
<script src="{{ asset('assets/plugins/prism/prism.js') }}"></script>
<!--Internal  Datepicker js -->
<script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!-- Internal Select2 js-->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ asset('assets/js/modal.js') }}"></script>
<!-- جافا سكريبت لموديولة التعديل -->
<script>
$('#edit_product').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var product_name = button.data('name')
    var section_name = button.data('section_name')
    var pro_id = button.data('pro_id')
    var description = button.data('description')
    var modal = $(this)
    modal.find('.modal-body #product_name').val(product_name);
    modal.find('.modal-body #section_name').val(section_name);
    modal.find('.modal-body #description').val(description);
    modal.find('.modal-body #pro_id').val(pro_id);
})

</script>



@endsection