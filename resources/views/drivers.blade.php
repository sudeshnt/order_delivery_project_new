@extends('master')

@section('content')

    <style type="text/css">
        .row {
            margin: 0%;
        }
    </style>
    <section class="content-header">
        <h1>
            Drivers
        </h1>
    </section>
    <!-- Custom Tabs -->
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Drivers</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Drivers</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {{--drivers table--}}
                    <table id="drivers_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Driver Number</th>
                            <th>Address</th>
                            <th>Mobile No</th>
                            @if(Session::get('role_id')==1)
                                <th></th>
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($allDrivers as $driver)
                            <tr>
                                <td>{{$driver->driver_name}}</td>
                                <td>{{$driver->address}}</td>
                                <td>{{$driver->mobile}}</td>
                                @if(Session::get('role_id')==1)
                                    <td style="text-align: center;" onclick="editDriver('{{$driver->driver_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                    <td style="text-align: center;" onclick="deleteDriver('{{$driver->driver_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form role="form"  method="post" action="{{ url('/addDriver') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Driver's Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Driver's Name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile_no">Mobile Number</label>
                                <input type="tel" class="form-control" name="mobile_no" id="mobile" placeholder="Enter Mobile Number" required>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="driverEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Driver</h4>
                </div>
                <div class="modal-body">
                    <form role="form"  method="post" action="{{ url('/editDriver') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="driver_id" id="edit_driver_id" style="visibility: hidden; height: 0px;">
                            </div>
                            <div class="form-group">
                                <label for="name">Driver's Name</label>
                                <input type="text" class="form-control" name="driver_name" id="edit_driver_name" placeholder="Enter Driver's Name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="edit_address" placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile_no">Mobile Number</label>
                                <input type="tel" class="form-control" name="mobile_no" id="edit_mobile" placeholder="Enter Mobile Number" required>
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
            $('#drivers_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        function deleteDriver(driver_id){
            alertify.confirm('Are You Sure You Want to Delete this Driver?', function(){
                $.ajax({
                    url: "{{ url('/delete_driver') }}",
                    type: "get",
                    data:{driver_id:driver_id},
                    dataType: 'json',
                    async:true,
                    success: function(data){
                        if(data=='success'){
                            alertify.success('Driver Deleted Successfully!');
                            window.location="{{URL::to('/drivers')}}";
                        } else{
                            alertify.error('Driver Delete Unsuccessful');
                        }
                    },
                    error: function(data)
                    {
                        console.log("error");
                    }
                });

            });
        }


        function editDriver(driver_id){
            $('#driverEditModal').modal('show');
            $.ajax({
                url: "{{ url('/getDriverById') }}"+"/"+driver_id,
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