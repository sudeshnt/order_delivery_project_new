@extends('master')

@section('content')
    <section class="content-header">
        <h1>
            Damaged Productsz
        </h1>
    </section>
    <!-- Custom Tabs -->
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Damaged Products</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Damaged Products</a></li>
            </ul>
            <div class="tab-content" style="padding:3%;">
                <div class="tab-pane active" id="tab_1">
                    {{--accordian starts--}}
                    @foreach ($all_damaged_in_each_company as $key => $value)
                        <div class="panel-group" id="accordion">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$key}}</a>
                                    </h4>
                                </div>
                                <div id="collapse{{$index}}" class="panel-collapse collapse">

                                    <div class="panel-body" style="padding: 0px;">

                                        <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Code</th>
                                                <th>Product Size</th>
                                                <th>Available Amount</th>
                                                <th>Damaged Amount</th>
                                                @if(Session::get('role_id')==1)
                                                    <th></th>
                                                    <th></th>
                                                @endif
                                            </tr>
                                            </thead>


                                            <tbody>
                                            @foreach ($value as $damaged_product)
                                                <tr>
                                                    <td>{{$damaged_product->product_name}}</td>
                                                    <td>{{$damaged_product->product_code}}</td>
                                                    <td>{{$damaged_product->product_size}}</td>
                                                    <td style="color: forestgreen;">{{$damaged_product->available_amount}}</td>
                                                    <td style="color: indianred;">{{$damaged_product->qty}}</td>
                                                    @if(Session::get('role_id')==1)
                                                        <td style="text-align: center;" onclick="editDamagedProduct('{{$damaged_product->product_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                                        <td style="text-align: center;" onclick="deleteDamagedProduct('{{$damaged_product->product_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
                <div class="tab-pane" id="tab_2">
                    {{--<div style="margin-bottom: 25px;">
                        <label style="margin-right: 20px;"><input id="rdb1" type="radio" name="toggler" value="1" style="margin-right: 8px;"/>Add Existing</label>
                        <label><input id="rdb2" type="radio" name="toggler" value="2" style="margin-right: 8px;"/>Add New</label>
                    </div>--}}
                    <div id="blk-1">
                        <div class="row" style="width: 60%;">
                            <form role="form" method="post" action="{{ url('/addExistingDamaged') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group" style="width: 70%;">
                                    <label for="product_id">Damaged Product Name</label>
                                    <select class="form-control select2 product_details" name="product_id" id="product_id" style="width: 100%;" required>
                                        <option>Select Damaged Product</option>
                                        @foreach ($allProducts as $product)
                                            <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="damaged_qty">Damaged Quantity</label>
                                    <div class='input-group'>
                                        <input type='number' class="form-control"  name='damaged_qty' id='damaged_qty' required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    {{--<div id="blk-2" class="toHide" style="display:none">
                        <form role="form" method="post" action="{{ url('/addNewDamagedProducts') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="company_id">Company Name</label>
                                <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;">
                                    <option>Select Company</option>
                                    @foreach ($allCompanies as $company)
                                        <option value="{{$company->company_id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" required>
                            </div>
                            <div class="form-group">
                                <label for="damaged_amount">Damaged Amount</label>
                                <input type="number" class="form-control" name="damaged_amount" id="damaged_amount" placeholder="Enter Damaged Amount" required>
                            </div>
                            <div class="form-group">
                                <label for="product_size">Product Size</label>
                                <input type="text" class="form-control" name="product_size" id="product_size" placeholder="Enter Product Size" required>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="damagedProductEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Damaged Product</h4>
                </div>
                <div class="modal-body">
                    <form role="form"  method="post" action="{{ url('/editDamagedProduct') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <input type="text" class="form-control" name="damaged_product_id" id="damaged_product_id" style="visibility: hidden; height: 0px;">
                            </div>
                            <div class="form-group" style="margin-bottom: 0px;">
                                <input type="text" class="form-control" name="prev_qty" id="prev_qty" style="visibility: hidden; height: 0px; margin-bottom: 0px;">
                            </div>
                            <div class="form-group">
                                <label for="edit_damaged_amount">Damaged Amount</label>
                                <input type="number" class="form-control" name="edit_qty" id="edit_qty" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $("[name=toggler]").click(function(){
                $('.toHide').hide();
                $("#blk-"+$(this).val()).show('slow');
            });
        });
        $(function () {
            $('.allTables').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        function deleteDamagedProduct(product_id){
                alertify.confirm('Are You Sure You Want to Delete this Damaged Product?', function(){
                $.ajax({
                    url: "{{ url('/deleteDamagedProduct') }}",
                    type: "get",
                    data:{product_id:product_id},
                    dataType: 'json',
                    async:true,
                    success: function(data){
                        if(data=='success'){
                            alertify.success('Damaged Product Deleted Successfully!');
                            window.location="{{URL::to('/damagedProducts')}}";
                        } else{
                            alertify.error('Damaged Product Delete Unsuccessful');
                        }
                    },
                    error: function(data)
                    {
                        console.log("error");
                    }
                });

            });
        }


        function editDamagedProduct(product_id){
            $.ajax({
                url: "{{ url('/getDamagedProductById') }}"+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);
                    document.getElementById('damaged_product_id').value=data.product_id;
                    document.getElementById('prev_qty').value=data.qty;
                    document.getElementById('edit_qty').value=data.qty;
                    $('#damagedProductEditModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }
    </script>
@endsection