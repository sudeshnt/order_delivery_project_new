@extends('master')

@section('content')

    <section class="content-header">
        <h1>
            Products
        </h1>
    </section>
    <!-- Custom Tabs -->
    <style type="text/css">
        .row {
            margin: 0%;
        }
    </style>
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Products</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Product</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {{--company table--}}
                    <table id="products_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Company Name</th>
                            <th>Available Amount</th>
                            <th>Unit Price</th>
                            <th>Product Size</th>
                            <th></th>
                            <th></th>
                            @if(Session::get('role_id')==1)
                                <th></th>
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($allProducts as $product)
                            <tr>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_code}}</td>
                                <td>{{$product->company_name}}</td>
                                <td>{{$product->available_amount}}</td>
                                <td>₦ {{$product->unit_price}}</td>
                                <td>{{$product->product_size}}</td>
                                <td style="text-align: center;" onclick="showProductOrders('{{$product->product_id}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>
                                <td style="text-align: center;" onclick="showStockIn('{{$product->product_id}}');"><i class="fa fa-list fa-2x" aria-hidden="true"></i></td>
                                @if(Session::get('role_id')==1)
                                    <td style="text-align: center;" onclick="editProduct('{{$product->product_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                    <td style="text-align: center;" onclick="deleteProduct('{{$product->product_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                        <div class="box-body">
                            <div style="margin-bottom: 25px;">
                                <label style="margin-right: 20px;"><input id="rdb1" type="radio" name="toggler" value="1" style="margin-right: 8px;"/>Add Stock</label>
                                <label><input id="rdb2" type="radio" name="toggler" value="2" style="margin-right: 8px;"/>Add New Product</label>
                            </div>
                            <div id="blk-2" class="toHide" style="display:none">
                                <form role="form" method="post" action="{{ url('/addProduct') }}">
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
                                {{--<div class="form-group">
                                    <label for="product_code">Product Code</label>
                                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" required>
                                </div>--}}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="product_code">Product Code</label>
                                            <div class='input-group'>
                                                <input type="text" class="form-control" name="product_code" id="product_code"  required readonly />
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-random" onclick="javascript:setProductCode();"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label for="product_amount">Added Quantity</label>
                                    <input type="number" class="form-control" name="product_amount" id="product_amount" placeholder="Enter Amount" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_unitprice">Unit Price</label>
                                    <input type="text" class="form-control" name="product_unitprice" id="product_unitprice" placeholder="Enter Unit Price" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_size">Product Size</label>
                                    <input type="text" class="form-control" name="product_size" id="product_size" placeholder="Enter Product Size" required>
                                </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div id="blk-1" class="toHide" style="display:none">
                            <form role="form" method="post" action="{{ url('/addStockExistingProduct') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control select2" name="product_id" id="product_id" style="width: 100%;">
                                        <option>Select Product</option>
                                        @foreach ($allProducts as $product)
                                            <option value="{{$product->product_id}}">{{$product->product_code}} : {{$product->product_name}} ({{$product->product_size}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="added_amount">Added Quantity</label>
                                    <input type="number" class="form-control" name="added_amount" id="added_amount" placeholder="Enter Added Amount" required>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                </div>

            </div>
            <!-- /.tab-content -->
        </div>
    </div>


    {{--View Product Orders Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="viewProductOrdersModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Product Orders</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                      <div class="row">
                        {{--date rage for filtering orders--}}
                            <div class="form-group col-md-8">
                                <div id="product_id_div" hidden></div>
                                <label>Apply Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row" style="margin-top: 3px;">
                                <button class="btn btn-success" style="margin-top: 22px;" onclick="filterProductOrders();">Apply</button>
                                <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                                            document.getElementById('reservation').innerHTML='';
                                            showProductOrders(document.getElementById('product_id_div').innerHTML);
                                        }
                                        clickedReset();">Reset</button>
                                </div>
                            </div>
                      </div>
                        <div class="row" id="product_orders_table_div">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="viewProductStockInReportsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Product Stock In Reports</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            {{--date rage for filtering orders--}}
                            <div class="form-group col-md-8">
                                <div id="product_id_div_stock" hidden></div>
                                <label>Apply Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="stockInFilter">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row" style="margin-top: 3px;">
                                    <button class="btn btn-success" style="margin-top: 22px;" onclick="filterProductStockIn();">Apply</button>
                                    <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                                            document.getElementById('stockInFilter').innerHTML='';
                                            showStockIn(document.getElementById('product_id_div_stock').innerHTML);
                                        }
                                        clickedReset();">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="product_stock_in_table_div">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="productEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Product</h4>
                </div>
                <div class="modal-body">
                    <form role="form"  method="post" action="{{ url('/editProduct') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="prev_product_code" id="prev_product_code" style="visibility: hidden; height: 0px;">
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="edit_company_id">Company Name</label>
                                <select class="form-control select2" name="edit_company_id" id="edit_company_id" style="width: 100%;" required>
                                    <option>Select Company</option>
                                    @foreach ($allCompanies as $company)
                                        <option value="{{$company->company_id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_product_name">Product Name</label>
                                <input type="text" class="form-control" name="edit_product_name" id="edit_product_name" required>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <label for="edit_product_code">Product Code</label>
                                    <div class='input-group'>
                                        <input type="text" class="form-control" name="edit_product_code" id="edit_product_code" required readonly />
                                        <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-random" onclick="javascript:setEditProductCode();"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_available_amount">Added Quantity</label>
                                <input type="number" class="form-control" name="edit_available_amount" id="edit_available_amount" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_unit_price">Unit Price</label>
                                <input type="text" class="form-control" name="edit_unit_price" id="edit_unit_price" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="edit_product_size">Product Size</label>
                                <input type="text" class="form-control" name="edit_product_size" id="edit_product_size" required>
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
        var startDate;
        var endDate;
        $(function () {
            $('#products_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
        $('#reservation').daterangepicker();
        $('#stockInFilter').daterangepicker();

        $(function() {
            $("[name=toggler]").click(function(){
                $('.toHide').hide();
                $("#blk-"+$(this).val()).show('slow');
            });
        });

        function setProductCode(){
            var rand = Math.floor((Math.random() * 1000000)+1);
            document.getElementById('product_code').value = 'P-'+("000000" + rand).slice(-6);
        }

        function setEditProductCode(){
            var rand = Math.floor((Math.random() * 1000000)+1);
            document.getElementById('edit_product_code').value = 'P-'+("000000" + rand).slice(-6);
        }

        function showProductOrders(product_id){
            $.ajax({
                url: "{{ url('/getProductOrders') }}"+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    document.getElementById("product_id_div").innerHTML=product_id;
                    var table_content = '<table id="payments_table"  class="table table-bordered table-hover allTables">'+
                                        '<thead>'+
                                        '<tr>'+
                                        '<th>Date</th>'+
                                        '<th>Ordered By</th>'+
                                        '<th>Opening Stock</th>'+
                                        '<th>Closing Qty</th>'+
                                        '<th>Ordered Qty</th>'+
                                        '</tr>'+
                                        '</thead>'+
                                        '<tbody id="table_body">';
                    var product_name='';
                    for(order of data){
                        //console.log(order);
                        var opening_stock = Number(order.available_amount)+Number(order.qty);
                        table_content+='<tr><td>'+order.order_date+'</td><td>'+order.customer_name+'</td><td>'+opening_stock+'</td><td>'+order.available_amount+'</td><td>'+order.qty+'</tr>';
                        product_name = order.product_name;
                    }
                    table_content+= '</tbody>'+
                                    '</table>';
                    document.getElementById("product_orders_table_div").innerHTML = table_content;

                    $(function () {
                        $('#payments_table').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": false
                        });
                    });
                    $('#viewProductOrdersModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        function filterProductOrders(){
            console.log('xxx');
            var startDate = $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');
            var product_id = document.getElementById('product_id_div').innerHTML;
            $.ajax({
                url: "{{ url('/getProductOrders') }}"+"/"+startDate+"/"+endDate+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data[0]);
                    /*document.getElementById("table_body").innerHTML*/
                    var table_content = '<table id="payments_table"  class="table table-bordered table-hover allTables">'+
                            '<thead>'+
                            '<tr>'+
                            '<th>Date</th>'+
                            '<th>Ordered By</th>'+
                            '<th>Opening Stock</th>'+
                            '<th>Closing Amount</th>'+
                            '<th>Ordered Amount</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody id="table_body">';
                    var product_name='';
                    for(order of data){
                        //console.log(order);
                        var opening_stock = Number(order.available_amount)+Number(order.qty);
                        table_content+='<tr><td>'+order.order_date+'</td><td>'+order.customer_name+'</td><td>'+opening_stock+'</td><td>'+order.available_amount+'</td><td>'+order.qty+'</tr>';
                        product_name = order.product_name;
                    }
                    table_content+= '</tbody>'+
                            '</table>';
                    document.getElementById("product_orders_table_div").innerHTML = table_content;

                    $(function () {
                        $('#payments_table').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": false
                        });
                    });
                   // $('#viewProductOrdersModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        function showStockIn(product_id){
            console.log(product_id);
            $.ajax({
                url: "{{ url('/getStockInReports') }}"+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);
                    document.getElementById("product_id_div_stock").innerHTML=product_id;
                    var table_content = '<table id="stock_in_table"  class="table table-bordered table-hover allTables">'+
                            '<thead>'+
                            '<tr>'+
                            '<th>Date</th>'+
                            '<th>Opening Stock</th>'+
                            '<th>Stock In Qty</th>'+
                            '<th>Closing Stock</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody id="table_body">';
                    for(stock_in of data){
                        var closing_stock = Number(stock_in.opening_stock)+Number(stock_in.qty);
                        table_content+='<tr><td>'+stock_in.created_at+'</td><td>'+stock_in.opening_stock+'</td><td>'+stock_in.qty+'</td><td>'+closing_stock+'</td></tr>';
                    }
                    table_content+= '</tbody>'+
                            '</table>';
                    document.getElementById("product_stock_in_table_div").innerHTML = table_content;

                    $(function () {
                        $('#stock_in_table').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": false
                        });
                    });
                    $('#viewProductStockInReportsModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        function filterProductStockIn(){
            console.log('xxx');
            var startDate = $('#stockInFilter').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('#stockInFilter').data('daterangepicker').endDate.format('YYYY-MM-DD');
            var product_id = document.getElementById('product_id_div_stock').innerHTML;
            $.ajax({
                url: "{{ url('/getStockInReports') }}"+"/"+startDate+"/"+endDate+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);
                    /*document.getElementById("table_body").innerHTML*/
                    var table_content = '<table id="stock_in_table"  class="table table-bordered table-hover allTables">'+
                            '<thead>'+
                            '<tr>'+
                            '<th>Date</th>'+
                            '<th>Opening Stock</th>'+
                            '<th>Stock In Qty</th>'+
                            '<th>Closing Stock</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody id="table_body">';
                    for(stock_in of data){
                        var closing_stock = Number(stock_in.opening_stock)+Number(stock_in.qty);
                        table_content+='<tr><td>'+stock_in.created_at+'</td><td>'+stock_in.opening_stock+'</td><td>'+stock_in.qty+'</td><td>'+closing_stock+'</td></tr>';
                    }
                    table_content+= '</tbody>'+
                            '</table>';
                    document.getElementById("product_stock_in_table_div").innerHTML = table_content;

                    $(function () {
                        $('#stock_in_table').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": false
                        });
                    });
                    // $('#viewProductOrdersModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        function deleteProduct(product_id){
            alertify.confirm('Are You Sure You Want to Delete this Product?', function(){
                $.ajax({
                    url: "{{ url('/delete_product') }}",
                    type: "get",
                    data:{product_id:product_id},
                    dataType: 'json',
                    async:true,
                    success: function(data){
                        if(data=='success'){
                            alertify.success('Product Deleted Successfully!');
                            window.location="{{URL::to('/products')}}";
                        } else{
                            alertify.error('Product Delete Unsuccessful');
                        }
                    },
                    error: function(data)
                    {
                        console.log("error");
                    }
                });

            });
        }


        function editProduct(product_id){
            $('#productEditModal').modal('show');
            $.ajax({
                url: "{{ url('/getProductById') }}"+"/"+product_id,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    document.getElementById('prev_product_code').value = data.product_code;
                    $.each(data, function(k, v) {
                        var element = document.getElementById('edit_'+k);
                        if(element!=null){
                            element.value = v;
                        }
                    });
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }
    </script>

@endsection