@extends('layouts.master')
@section('title','إضافة فاتورة')

@section('css')
  
    <link href="{{asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">   
    <link href="{{asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}"> 
    <link rel="stylesheet" href="{{asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    إضافة فاتورة</span>
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

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي إدخال رقم الفاتورة" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                                    <!--     "{{ date('Y-M-D') }}" دالة جاهزة في اللارافيل ، الحروف الكابيتال والسمول بتفرق القيمة الديفولت هي تاريخ اليوم  -->
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                    <!--حياخد id  ويحتفظ فيه ويجيب الاسم  -->
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control">
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                    name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>
 <!--  الديفولت للخصم لازم يكون 0 لانه نوعه ديسيمال ، فحيسبب مشاكل لو كان فاضي-->
                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                    title="يرجي ادخال مبلغ الخصم "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value=0 required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value=" 5%">5%</option>
                                    <option value="10%">10%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    
    <script src="{{('assets/plugins/select2/js/select2.min.js') }}"></script>
  
    <script src="{{asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <script src="{{asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{asset('assets/js/select2.js') }}"></script>
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
    <!--كود الاجاكس لجلب المنتجات الخاصة بالقسم حسب ماتم اختياره 
    يعني ربط القسم بمنتجاته فقط-->
    <script>
        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>


    <script>
        function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            //مبلغ العمولة
            var Discount = parseFloat(document.getElementById("Discount").value); // الخصم من مبلغ العمولة في حال عدم تحقيق التارجت المتفق عليها بين الشركة والعميل
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value); //نسبة الضريبة
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value); // قيمة الضريبة
            var Amount_Commission2 = Amount_Commission - Discount;
            //مبلغ العمولة 2 = مبلغ العمولة - الخصم 
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {//لو كان مبلغ العمولة فاضي حيطلعلي رسالة 
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;
                // نتيجة1 =العمولة - الخصم *نسبة الضريبة (قيمة الضريبة للمبلغ كامل )
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                // نتيجة2 = نتيجة1 + مبلغ العمولة2 )( الإجمالي مع مبلغ الفاتورة )
                // الاجمالي = مبلغ العمولة + مبلغ الضريبة حسب نسبتها
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("Value_VAT").value = sumq;
                document.getElementById("Total").value = sumt;
            }
        }
    </script>


@endsection