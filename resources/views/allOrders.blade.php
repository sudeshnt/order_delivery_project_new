@extends('master')

@section('content')
    <style>
        .table-hover>tbody>tr:hover{
            background-color:#f5f5f5;
        }

        .invoice {

             border: 1px solid #f4f4f4;
             padding: 0px;
             margin: 0px 0px;
        }
    </style>


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            All {{$option}} Orders
        </h1>
    </section>
    <div class="row" style="margin:0px; padding:1%;">
        {{--date rage for filtering orders--}}
        <div class="form-group col-md-4">
            <label>Apply Date range:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                @if(isset($filteredDate))
                    <input type="text" class="form-control pull-right" id="reservation" value="{{$filteredDate}}">
                @else
                    <input type="text" class="form-control pull-right" id="reservation">
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="row" style="margin-top: 3px;">
                @if($filterOrderType==1)
                    <button class="btn btn-success" style="margin-top: 22px;" onclick="function filterOrders() {
                                window.location='{{URL::to('allOrders/')}}/'+$('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD')+','+$('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD')+'/'+$('.nav-tabs .active > a').attr('id');
                            }
                            filterOrders();">Apply</button>
                    <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                                 window.location='{{URL::to('allOrders/all')}}'/+$('.nav-tabs .active > a').attr('id');
                            }
                            clickedReset();">Reset</button>
                @endif

                @if($filterOrderType==2)
                <button class="btn btn-success" style="margin-top: 22px;" onclick="function filterOrders() {
                            window.location='{{URL::to('deliverdOrders/')}}/'+$('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD')+','+$('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD')+'/'+$('.nav-tabs .active > a').attr('id');
                        }
                        filterOrders();">Apply</button>
                <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                             window.location='{{URL::to('deliverdOrders/all')}}'/+$('.nav-tabs .active > a').attr('id');
                        }
                        clickedReset();">Reset</button>
                @endif

                @if($filterOrderType==3)
                <button class="btn btn-success" style="margin-top: 22px;" onclick="function filterOrders() {
                            window.location='{{URL::to('notDeliveredOrders/')}}/'+$('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD')+','+$('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD')+'/'+$('.nav-tabs .active > a').attr('id');
                        }
                        filterOrders();">Apply</button>
                <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                             window.location='{{URL::to('notDeliveredOrders/all')}}'/+$('.nav-tabs .active > a').attr('id');
                        }
                        clickedReset();">Reset</button>
                @endif
            </div>
        </div>
    </div>
    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @if(isset($active_tab))
                    @if($active_tab=='tab1')
                        <li class="active"><a href="#tab_1" data-toggle="tab" id="tab1">All {{$option}} Orders </a></li>
                        <li><a href="#tab_2" data-toggle="tab" id="tab2">All {{$option}} Products</a></li>
                    @elseif($active_tab=='tab2')
                        <li><a href="#tab_1" data-toggle="tab" id="tab1">All {{$option}} Orders</a></li>
                        <li class="active"><a href="#tab_2" data-toggle="tab" id="tab2">All {{$option}} Products</a></li>
                    @endif
                @else
                    <li class="active"><a href="#tab_1" data-toggle="tab" id="tab1">All {{$option}} Orders</a></li>
                    <li><a href="#tab_2" data-toggle="tab" id="tab2">All {{$option}} Products</a></li>
                @endif
            </ul>
            <div class="tab-content" style="padding: 0px;">
                @if(isset($active_tab))
                    @if($active_tab=='tab1')
                        <div class="tab-pane active" id="tab_1">
                    @else
                        <div class="tab-pane" id="tab_1">
                    @endif
                @endif
                    {{--customer table--}}
                    <table id="orders_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th style="width: 36px;">Order Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th style="width: 56px;">Payment Status</th>
                            <th style="width: 52px;">Delivery Status</th>
                            <th>Delivered By</th>
                            <th>Delivered At</th>
                            <th style="width:102px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($allOrders as $order)
                            <tr{{-- onclick="getOrderDetails('{{$order->order_code}}')"--}}>
                                <td>{{$order->order_date}}</td>
                                <td>{{$order->order_code}}</td>
                                <td>{{$order->customer_name}}</td>
                                <td>₦ {{$order->full_amount}}</td>
                                <td>₦ {{$order->paid_amount}}</td>
                                <td>₦ {{$order->full_amount-$order->paid_amount}}</td>
                                @if($order->isPaid)
                                    <td><span class="label label-success" style="font-size: small">Paid</span></td>
                                @else
                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                @endif
                                @if($order->isDelivered)
                                    <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                @else
                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                @endif
                                @if($order->deliveryType=='byVehicle')
                                    <td>{{$order->vehicle_number}} : {{$order->driver_name}}</td>
                                @else
                                    <td>delivered on the spot</td>
                                @endif
                                @if($order->isDelivered)
                                    <td>{{$order->delivered_at}}</td>
                                @else
                                    <td style="text-align: center;">__</td>
                                @endif
                                <td>
                                    <select class="form-control" name="option" style="width: 100%;" onchange="ActionSelected(this.value,'{{$order->order_code}}');">
                                        <option selected>Select Action</option>
                                        <option value="view_order"> View Order</option>
                                         @if(Session::get('role_id')!=3)
                                            @if($order->isDelivered==0)
                                                <option value="delivery">Add Delivery</option>
                                            @else
                                                <option value="delivery" disabled>Add Delivery</option>
                                            @endif
                                        @endif
                                        @if(Session::get('role')=='Admin' || Session::get('role')== 'Cashier')
                                            @if($order->isPaid==0)
                                                <option value="payment">Add Payment</option>
                                            @else
                                                <option value="payment" disabled>Add Payment</option>
                                            @endif
                                        @endif
                                        <option value="view_payments">View Payments</option>
                                    </select>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>{{--tab 1 ends--}}
                @if(isset($active_tab))
                    @if($active_tab=='tab2')
                        <div class="tab-pane active" id="tab_2">
                    @else
                        <div class="tab-pane" id="tab_2">
                    @endif
                @endif
                    <div>
                        <table id="products_on_order_table"  class="table table-bordered table-hover allTables">
                            <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Order Code</th>
                                <th>Product Name</th>
                                <th>Product Size</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products_on_order as $product_order)
                                <tr>
                                    <td>{{$product_order->order_date}}</td>
                                    <td>{{$product_order->order_code}}</td>
                                    <td>{{$product_order->product_name}}</td>
                                    <td>{{$product_order->product_size}}</td>
                                    <td>{{$product_order->qty}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>{{--table ends--}}
                </div>{{--tab2 ends--}}
            </div>{{--tab content ends--}}
         </div>


    {{--View Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="" onclick="printDiv('printableArea')" target="_blank" class="btn btn-default" style="float:right;"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <section class="invoice" id="printableArea">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="page-header">
                                        <i class="fa fa-globe"></i> AdminLTE, Inc.
                                        {{--<small class="pull-right">Date: 2/10/2014</small>--}}
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-5 invoice-col">
                                    To
                                    <address>
                                        <strong id="customer_name"></strong><br>
                                        <div id="business_name"></div>
                                        <div id="customer_address"></div>
                                        <div id="customer_mobile"></div>
                                        <div id="customer_email"></div>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-5 invoice-col" style="padding: 0px;">
                                    <br>
                                    <br>
                                    <div id="order_code"></div>
                                    <div id="order_date"></div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Product</th>
                                                <th>Size</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products_table_content">

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">

                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Total:</th>
                                                <td><p id="full_amount"></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-danger"  style="float:right;"  data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--Delivery Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="deliveryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Delivery</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="{{ url('/addDelivery') }}">
                    <div class="box-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <div class='input-group date'>
                                            <input type='text' class="form-control"  name='delivery_date' id='delivery_date'/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-2'></div>
                                <div class='col-sm-4'>
                                    <div class="form-group">
                                        <label for="order_code_del">Order ID</label>
                                        <div class='input-group'>
                                            <input type='text' class="form-control"  name='order_code_del' id='order_code_del' readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="returned_date">Driver Reporting Date</label>
                                        <div class='input-group date'>
                                            <input type='text' class="form-control"  name='returned_date' id='returned_date'/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="whoRecieved">Received Person Name</label>
                                        <div class='input-group' style="width: 100%;">
                                            <input type='text' class="form-control"  name='whoReceived' id='whoReceived' required/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="customer">Customer</label>
                                        <div class='input-group' style="width: 100%;">
                                            <input type='text' class="form-control"  name='customer' id='customer' readonly/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="delivery_address">Delivery Address</label>
                                        <div class='input-group' style="width: 100%;">
                                            <input type='text' style="height: 100px;" class="form-control"  name='delivery_address' id='delivery_address' readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="box-footer">
                            <button type="submit" class="btn btn-primary" style="float: right;">Submit Delivery</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--Payment Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Payment</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="{{ url('/addPayment') }}">
                    <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="payment_date">Payment Date</label>
                                        <div class='input-group date'>
                                            <input type='text' class="form-control"  name='payment_date' id='payment_date'/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-2'></div>
                                <div class='col-sm-4'>
                                    <div class="form-group">
                                        <label for="order_code">Order ID</label>
                                        <div class='input-group'>
                                            <input type='text' class="form-control"  name='order_code' id='payment_order_code' readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <label>Balance</label>
                                    <div class='input-group' style="width: 63%;" >
                                        <input type="text" class="form-control" name="balance" id="balance" readonly/>
                                            <span class="input-group-addon">
                                                    <span {{--class="glyphicon glyphicon-usd"--}} style="font-size: large;">₦</span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <label>Amount</label>
                                    <div class='input-group' style="width: 60%;" >
                                        <input type="text" class="form-control" name="amount" id="amount" required/>
                                        <span class="input-group-addon">
                                                <span {{--class="glyphicon glyphicon-usd"--}}  style="font-size: large;">₦</span>
                                        </span>
                                        <span>
                                            <select class="form-control" name="ispaid" id="ispaid" style="width: 110%;">
                                                <option selected>Select Payment Option</option>
                                                <option value=true>Full Payment</option>
                                                <option value=false>Partial Payment</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" style="float: right;">Submit Payment</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--View Payments Modal--}}
    <div class="modal" tabindex="-1" role="dialog" id="viewPaymentsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Payments</h4>
                </div>
                <div class="modal-body">
                        <div class="box-body">
                           {{-- <div class="well" id="order_details">

                            </div>--}}
                            <div class="row" id="payments_table_div">

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        $('.modal').on('hidden.bs.modal', function (e) {
            var selects = document.getElementsByName('option');
            console.log(selects);
            for(select of selects){
                select.value = "Select Action";
            }
        });

        $('#delivery_date').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#returned_date').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#payment_date').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $(function () {
            $('#orders_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[ 0, "desc" ]]
            });
        });

        $(function () {
            $('#products_on_order_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[ 0, "desc" ]]
            });
        });


        function getOrderDetails(order_code){
            $('#myModal').modal('show');
            $.ajax({
                url: "{{ url('/getOrderDetails') }}"+"/"+order_code,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        function ActionSelected(selected,order_code){
            $.ajax({
                url: "{{ url('/getOrderDetails') }}"+"/"+order_code,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);
                    if(selected=='delivery'){
                        console.log('delivery');
                        $('#deliveryModal').modal('show');
                        $('#order_code_del').val(data.order_code);
                        $('#customer').val(data.customer_name);
                        $('#delivery_address').val(data.customer_address);
                    }
                    if(selected=='payment'){
                        $('#paymentModal').modal('show');
                        $('#payment_order_code').val(data.order_code);
                        $('#balance').val((data.full_amount-data.paid_amount).toFixed(2));
                    }
                    if(selected=='view_payments'){
                        $.ajax({
                            url: "{{ url('/getOrderPayments') }}"+"/"+order_code,
                            type: "get",
                            dataType: 'json',
                            async:true,
                            success: function(data){

                                var table_content = '<table id="payments_table"  class="table table-bordered table-hover allTables"><thead><tr><th>Payment Reference</th><th>Payment Date</th><th>Amount</th></tr></thead><tbody>';
                                var total_paid = 0;

                                for(payments of data){
                                    console.log(payments);
                                    table_content+='<tr><td>'+String("000000" + payments.payment_id).slice(-6)+'</td><td>'+payments.payment_date+'</td><td> ₦ '+payments.amount.toLocaleString()+'</td></tr>';
                                    total_paid+=Number(payments.amount);
                                }
                                table_content+='<tr><td></td><td>Total Paid</td><td> ₦ '+total_paid.toLocaleString()+'</td></tr>';
                                table_content+='</tbody></table>';
                                document.getElementById("payments_table_div").innerHTML =table_content;
                                $('#viewPaymentsModal').modal('show');
                            },
                            error: function(data)
                            {
                                console.log("error");
                            }
                        });
                    }
                    if(selected=="view_order"){
                        //getOrderDetails(data.order_code);
                        $.ajax({
                            url: "{{ url('/viewOrder') }}"+"/"+data.order_code,
                            type: "get",
                            dataType: 'json',
                            async:true,
                            success: function(data){
                                console.log(data);
                                document.getElementById("customer_name").innerHTML =data[0].customer_name;
                                document.getElementById("business_name").innerHTML =data[0].business_name;
                                document.getElementById("customer_address").innerHTML =data[0].customer_address;
                                document.getElementById("customer_mobile").innerHTML ='Phone: '+data[0].customer_mobile;
                                document.getElementById("customer_email").innerHTML ='Email: '+data[0].email;

                                document.getElementById("order_code").innerHTML = '<b>Order Id : </b>'+data[0].order_code;
                                document.getElementById("order_date").innerHTML = '<b>Order Date : </b>'+data[0].order_date;

                                document.getElementById("full_amount").innerHTML = '₦ '+data[0].full_amount.toLocaleString();
                                var table_content='';
                                var totalss = 0;
                                var total_units = 0;
                                for(product of data[1]){
                                    console.log(product);
                                    totalss+=Number(product.qty)*Number(product.unit_price);
                                    var subtotal = (product.qty*product.unit_price).toFixed(2);
                                    table_content+='<tr><td>'+product.product_code+'</td><td>'+product.product_name+'</td><td>'+product.product_size+'</td><td>'+product.qty+'</td><td>₦ '+product.unit_price.toLocaleString()+'</td><td>₦ '+Number(subtotal).toLocaleString()+'</td></tr>';
                                    total_units += Number(product.qty);
                                }
                                table_content+='<tr><td></td><td></td><td style="text-align: right;">Total Units : </td><td>'+total_units+'</td><td></td><td></td></tr>';
                                console.log(totalss);
                                document.getElementById("products_table_content").innerHTML = table_content;
                                $('#myModal').modal('show');
                            },
                            error: function(data)
                            {
                                console.log("error");
                            }
                        });
                    }
                },
                error: function(data)
                {
                    console.log("error");
                }
            });


        }

        function printDiv(divName) {
            $('#myModal').hide();
            $('.modal-backdrop').hide();
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        $('#reservation').daterangepicker();
    </script>
@endsection