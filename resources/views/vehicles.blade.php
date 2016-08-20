@extends('master')

@section('content')

    <style type="text/css">
        .row {
            margin: 0%;
        }
    </style>
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicles
    </h1>
</section>

<!-- Custom Tabs -->
<div class="row">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">All Vehicles</a></li>
            <li><a href="#tab_2" data-toggle="tab">Add Vehicle</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {{--vehicles table--}}
                <table id="vehicle_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Vehicle Number</th>
                        <th>Vehicle Zone</th>
                        <th>Driver Name</th>
                        <th>Vehicle Status</th>
                        <th>Assigned Date</th>
                        <th>Assigned Customer Zone</th>
                        @if(Session::get('role_id')==1)
                            <th></th>
                            <th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allVehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->vehicle_number}}</td>
                            <td>{{$vehicle->zone_name}}</td>
                            <td>{{$vehicle->driver_name}}</td>
                            @if($vehicle->isAssigned==1)
                                <td><span class="label label-danger" style="font-size: small">Assigned</span></td>
                            @else
                                <td><span class="label label-success" style="font-size: small">Available</span></td>
                            @endif

                            @if($vehicle->assigned_date=='0000-00-00 00:00:00')
                                <td  style="text-align: center;">-</td>
                            @else
                            <td>{{$vehicle->assigned_date}}</td>
                            @endif
                            <td>
                                <select class="form-control " id="customer_zone_{{$vehicle->vehicle_id}}" onchange="CustomerZoneSelected(this,'{{$vehicle->vehicle_id}}');">
                                    @if($vehicle->isAssigned==0)
                                        <option selected>Assign Customer Zone</option>
                                    {{--@else
                                        <option value="{{$vehicle->customer_zone_name}}" selected>{{$vehicle->customer_zone_name}}</option>--}}
                                    @endif
                                    @foreach($customer_zones as $customer_zone)
                                        @if($vehicle->customer_zone_name == $customer_zone->zone_name)
                                            <option value="{{$customer_zone->zone_id}}" selected>{{$customer_zone->zone_name}}</option>
                                        @else
                                            <option value="{{$customer_zone->zone_id}}">{{$customer_zone->zone_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            @if(Session::get('role_id')==1)
                                <td style="text-align: center;" onclick="editVehicle('{{$vehicle->vehicle_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                <td style="text-align: center;" onclick="deleteVehicle('{{$vehicle->vehicle_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row"><button class="btn btn-danger" style="font-size: x-large; margin: 1%;" onclick="ResetAllVehicles();">Reset All</button></div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <form role="form"  method="post" action="{{ url('/addVehicle') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="number">Vehicle Number</label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="Enter Vehicle Number" required>
                        </div>
                        <div class="form-group">
                            <label>Driver</label>
                            <select class="form-control select2" name="driver" style="width: 100%;" required>
                                <option value="">Select a Driver</option>
                                @foreach ($driver_list as $driver)
                                    <option value="{{$driver->driver_id}}">{{$driver->driver_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Zone</label>
                            <select class="form-control select2" name="zone_id" style="width: 100%;" required>
                                <option value="">Select a Vehicle Zone</option>
                                @foreach ($zones_list as $zone)
                                    <option value="{{$zone->zone_id}}">{{$zone->zone_name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>

    <div class="modal fade" tabindex="-1" role="dialog" id="vehicleEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Vehicle</h4>
                </div>
                <div class="modal-body">
                    <form role="form"  method="post" action="{{ url('/editVehicle') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="vehicle_id" id="edit_vehicle_id" style="visibility: hidden; height: 0px;">
                            </div>
                            <div class="form-group">
                                <label for="number">Vehicle Number</label>
                                <input type="text" class="form-control" name="number" id="edit_vehicle_number" placeholder="Enter Vehicle Number" required>
                            </div>
                            <div class="form-group">
                                <label>Driver</label>
                                <select class="form-control select2" name="driver" id="edit_driver_id" style="width: 100%;" required>
                                    <option value="">Select a Driver</option>
                                    @foreach ($driver_list as $driver)
                                        <option value="{{$driver->driver_id}}">{{$driver->driver_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Vehicle Zone</label>
                                <select class="form-control select2" name="zone_id" id="edit_zone_id" style="width: 100%;" required>
                                    <option value="">Select a Vehicle Zone</option>
                                    @foreach ($zones_list as $zone)
                                        <option value="{{$zone->zone_id}}">{{$zone->zone_name}}</option>
                                    @endforeach
                                </select>
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
    $(function () {
        $('#vehicle_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });

    //reset assigned vehicles to not assigned
    function ResetAllVehicles(){
        alertify.confirm('Are You Sure You Want to Reset All Assigned Vehicles ?', function(){
            $.ajax({
                url: "{{ url('/resetAllVehicles') }}",
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    alertify.success('Reset Successful')
                    location.reload();
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        });
    }

    function CustomerZoneSelected(customer_zone,vehicle_id){
        console.log();
        alertify.confirm('Are You Sure You Want to Assign the Vehicle to '+customer_zone.options[customer_zone.selectedIndex].text+'?', function(){
            $.ajax({
                url: "{{ url('/assignVehicleToCustomerZone') }}"+"/"+vehicle_id+"/"+customer_zone.value,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    //console.log(data);
                    alertify.success('Vehicle Assignment Successful')
                    location.reload();
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        });
    }

    function deleteVehicle(vehicle_id){
        alertify.confirm('Are You Sure You Want to Delete this Vehicle?', function(){
            $.ajax({
                url: "{{ url('/delete_vehicle') }}",
                type: "get",
                data:{vehicle_id:vehicle_id},
                dataType: 'json',
                async:true,
                success: function(data){
                    if(data=='success'){
                        alertify.success('Vehicle Deleted Successfully!');
                        window.location="{{URL::to('/vehicles')}}";
                    } else{
                        alertify.error('Vehicle Delete Unsuccessful');
                    }
                },
                error: function(data)
                {
                    console.log("error");
                }
            });

        });
    }


    function editVehicle(vehicle_id){
        $('#vehicleEditModal').modal('show');
        $.ajax({
            url: "{{ url('/getVehicleById') }}"+"/"+vehicle_id,
            type: "get",
            dataType: 'json',
            async:true,
            success: function(data){
                console.log(data);
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