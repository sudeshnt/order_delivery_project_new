@extends('master')

@section('content')
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<div class="well well-lg">asdasdsa</div>--}}
                </div>
                <div class="modal-body" style="padding:0px;">
                    <div class="box-body">
                        <section class="invoice" id="printableArea" style="padding: 0px;margin: 0px;">
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
                                <div class="col-sm-1 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6 invoice-col" style="padding: 0px;">
                                    <br>
                                    <div id="order_code"></div>
                                    <div id="order_date"></div>
                                    <div id="delivered_at"></div>
                                    <div id="reported_at"></div>
                                    <div id="received_by"></div>
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
                                            <th>Product Size</th>
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
                                            {{--<tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>--}}
                                            <tr>
                                                <th>Total:</th>
                                                <td><p id="full_amount"></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-danger"  style="float:right;"  data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="content" style="padding-top: 2%; background: white;">
        {{--date range selector--}}
        <div class="row" style="margin:15px;">
            <div class="form-group col-md-4">
                <label>Apply Date range:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    @if(isset($filteredDate))
                         <input type="text" class="form-control pull-right" id="daterange" value="{{$filteredDate}}">
                    @else
                         <input type="text" class="form-control pull-right" id="daterange">
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="row" style="margin-left: 0px; margin-top: 3px;">
                    <button class="btn btn-success" style="margin-top: 22px;" onclick="filterDriverRecords();">Apply</button>
                    <button class="btn btn-danger" style="margin-top: 22px;" onclick="clickedReset();">Reset</button>
                </div>
            </div>
        </div>
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active"><a href="#most_responsive" data-toggle="tab">Most Responsive Drivers</a></li>
            <li><a href="#most_deliveries" data-toggle="tab">Drivers with Most Deliveries</a></li>
            <li><a href="#most_units" data-toggle="tab">Drivers with Most Delivery Units</a></li>
            <li><a href="#pending_deliveries" data-toggle="tab" style="color: #ff2845;">Pending Deliveries</a></li>
            {{--<li><a href="#green" data-toggle="tab">Green</a></li>
            <li><a href="#blue" data-toggle="tab">Blue</a></li>--}}
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="most_responsive">
                <div class="row">
                    @foreach ($most_responsive as $driver)
                        <div class="panel-group" id="accordion">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$driver["driver_name"]}}<br> <small>average delivery time : {{$driver["average_delivery_time"]}}</small></a>
                                    </h4>
                                </div>
                                <div id="collapse{{$index}}" class="panel-collapse collapse">

                                    <div class="panel-body">

                                        <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
                                            <thead>
                                            <tr>
                                                <th>Order Date</th>
                                                <th>Delivered at</th>
                                                <th>Driver Reported at</th>
                                                <th>Received By</th>
                                                <th style="width: 36px;">Order Code</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th style="width: 56px;">Payment Status</th>
                                                <th>Total Time</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $time_index=0;?>
                                            @foreach ($driver["orders"] as $order)
                                                <tr>

                                                    <td>{{$order->order_date}}</td>
                                                    <td>{{$order->delivered_at}}</td>
                                                    <td>{{$order->driver_returned_time}}</td>
                                                    <td>{{$order->whoReceived}}</td>
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
                                                    {{--@if($order->isDelivered)
                                                        <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                                    @else
                                                        <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                    @endif--}}
                                                    <?php $seconds=$driver["delivery_times"][$time_index]; ?>
                                                    <td>{{ (new \DateTime('@0'))->diff(new \DateTime("@$seconds"))->format('%a days, %h hours, %i minutes and %s seconds')}}</td>
                                                    <td style="text-align: center;" onclick="showCustomerOrders('{{$order->order_code}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>

                                                </tr>
                                                <?php $time_index++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="most_deliveries">
                <div class="row">
                @foreach ($sorted_by_highest_number_of_deliveries as $driver)
                    <div class="panel-group" id="accordion">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$driver["driver_name"]}}<br> <small>number of deliveries : {{$driver["number_of_orders"]}}</small></a>
                                </h4>
                            </div>
                            <div id="collapse{{$index}}" class="panel-collapse collapse">

                                <div class="panel-body">

                                    <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
                                        <thead>
                                            <tr>
                                                <th>Order Date</th>
                                                <th>Delivered at</th>
                                                <th>Driver Reported at</th>
                                                <th>Received By</th>
                                                <th style="width: 36px;">Order Code</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th style="width: 56px;">Payment Status</th>
                                                {{--<th style="width: 52px;">Delivery Status</th>--}}
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($driver["orders"] as $order)
                                            <tr>
                                                <td>{{$order->order_date}}</td>
                                                <td>{{$order->delivered_at}}</td>
                                                <td>{{$order->driver_returned_time}}</td>
                                                <td>{{$order->whoReceived}}</td>
                                                <td>{{$order->order_code}}</td>
                                                <td>{{$order->customer_name}}</td>
                                                <td>{{$order->full_amount}}</td>
                                                <td>{{$order->paid_amount}}</td>
                                                <td>{{$order->full_amount-$order->paid_amount}}</td>
                                                @if($order->isPaid)
                                                    <td><span class="label label-success" style="font-size: small">Paid</span></td>
                                                @else
                                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                @endif
                                                {{--@if($order->isDelivered)
                                                    <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                                @else
                                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                @endif--}}
                                                <td style="text-align: center;" onclick="showCustomerOrders('{{$order->order_code}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>
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
            </div>
            <div class="tab-pane" id="most_units">
                <div class="row">
                    @foreach ($sorted_by_highest_number_of_units_carried as $driver)
                        <div class="panel-group" id="accordion">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$driver["driver_name"]}}<br> <small>number of products : {{$driver["number_of_products_carried"]}}</small><br> <small>number of units : {{$driver["number_of_units_carried"]}}</small></a>
                                    </h4>
                                </div>
                                <div id="collapse{{$index}}" class="panel-collapse collapse">

                                    <div class="panel-body">

                                        <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
                                            <thead>
                                            <tr>
                                                <th>Order Date</th>
                                                <th>Delivered at</th>
                                                <th>Driver Reported at</th>
                                                <th>Received By</th>
                                                <th style="width: 36px;">Order Code</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th style="width: 56px;">Payment Status</th>
                                                <th style="width: 52px;"></th>
                                                {{----}}
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach ($driver["orders"] as $order)
                                                <tr>
                                                    <td>{{$order->order_date}}</td>
                                                    <td>{{$order->delivered_at}}</td>
                                                    <td>{{$order->driver_returned_time}}</td>
                                                    <td>{{$order->whoReceived}}</td>
                                                    <td>{{$order->order_code}}</td>
                                                    <td>{{$order->customer_name}}</td>
                                                    <td>{{$order->full_amount}}</td>
                                                    <td>{{$order->paid_amount}}</td>
                                                    <td>{{$order->full_amount-$order->paid_amount}}</td>
                                                    @if($order->isPaid)
                                                        <td><span class="label label-success" style="font-size: small">Paid</span></td>
                                                    @else
                                                        <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                    @endif
                                                    {{--@if($order->isDelivered)
                                                        <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                                    @else
                                                        <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                    @endif--}}



                                                    <td style="text-align: center;" onclick="showCustomerOrders('{{$order->order_code}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>
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
            </div>
            <div class="tab-pane" id="pending_deliveries">
              <div class="row">
                @foreach ($pending_deliveries_grouped_by_driver as $driver)
                    <div class="panel-group" id="accordion">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$driver["driver_name"]}}<br> <small style="color: #ff2845">number of pending deliveries : {{$driver["order_count"]}}</small></a>
                                </h4>
                            </div>
                            <div id="collapse{{$index}}" class="panel-collapse collapse">

                                <div class="panel-body">
                                    <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th style="width: 80px;">Order Code</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th style="width: 56px;">Payment Status</th>

                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($driver["orders"] as $order)
                                            <tr>
                                                <td>{{$order->order_date}}</td>
                                                <td>{{$order->order_code}}</td>
                                                <td>{{$order->customer_name}}</td>
                                                <td>{{$order->full_amount}}</td>
                                                <td>{{$order->paid_amount}}</td>
                                                <td>{{$order->full_amount-$order->paid_amount}}</td>
                                                @if($order->isPaid)
                                                    <td><span class="label label-success" style="font-size: small">Paid</span></td>
                                                @else
                                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                @endif
                                                {{--@if($order->isDelivered)
                                                    <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                                                @else
                                                    <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                                                @endif--}}


                                                <td style="text-align: center;" onclick="showCustomerOrders('{{$order->order_code}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>
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
        </div>
            {{--<div class="tab-pane" id="green">
                <h1>Green</h1>
                <p>green green green green green</p>
            </div>
            <div class="tab-pane" id="blue">
                <h1>Blue</h1>
                <p>blue blue blue blue blue</p>
            </div>--}}
        </div>
    </div>

    <script>

        $('#daterange').daterangepicker();

        function showCustomerOrders(order_code){
            //getOrderDetails(data.order_code);
            $.ajax({
                url: "{{ url('/viewOrder') }}"+"/"+order_code,
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

                    document.getElementById("delivered_at").innerHTML = '<b>Delivered at : </b>'+data[0].delivered_at;
                    document.getElementById("reported_at").innerHTML = '<b>Driver Reported at : </b>'+data[0].driver_returned_time;
                    document.getElementById("received_by").innerHTML = '<b>Order Received By : </b>'+data[0].whoReceived;

                    document.getElementById("full_amount").innerHTML = '₦ '+data[0].full_amount;
                    var table_content='';
                    var total_units = 0;
                    for(product of data[1]){
                        console.log(product);
                        table_content+='<tr><td>'+product.product_code+'</td><td>'+product.product_name+'</td><td>'+product.product_size+'</td><td>'+product.qty+'</td><td>₦ '+product.unit_price+'</td><td>₦ '+(product.qty*product.unit_price).toFixed(2)+'</td></tr>';
                        total_units += Number(product.qty);
                    }
                    table_content+='<tr><td></td><td style="text-align: right;">Total Units : </td><td>'+total_units+'</td><td></td><td></td></tr>'
                    document.getElementById("products_table_content").innerHTML = table_content;
                    $('#myModal').modal('show');
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }

        //filter driver records
        function filterDriverRecords(){
            var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
            if(startDate!=endDate){
                console.log($('#daterange').data('daterangepicker'));
                window.location="{{URL::to('driver_tracking')}}"+"/"+startDate+"/"+endDate;
            }else{

            }
        }
        //reset daterange
        function clickedReset() {
            document.getElementById('daterange').innerHTML='';
            window.location="{{URL::to('driver_tracking')}}"+"/then/now";
        };
    </script>
@endsection
