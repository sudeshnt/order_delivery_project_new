@extends('master')

@section('content')
	<section class="content-header">
        <h1>
            Vehicle Zones
        </h1>
    </section>
<!-- Custom Tabs -->
	   <div class="row">	
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">All Vehicle Zones</a></li>
              <li><a href="#tab_2" data-toggle="tab">Add Vehicle Zone</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
				  {{--accordian starts--}}
				  @foreach ($vehicles_in_each_zone as $zone)
					  <div class="panel-group" id="accordion">

						  <div class="panel panel-default">
							  <div class="panel-heading">
								  <h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$zone->zone_name}} &#160 &#160  <label style="color: limegreen">( {{sizeof($zone->vehicles)}} Vehicles)</label></a>
									  <button type="button" class="btn btn-box-tool" onclick="deleteVehicleZone('{{$zone->zone_id}}');" data-widget="remove" style="float: right; margin-top: -6px;"><i class="fa fa-times"></i></button>
									  <button type="button" class="btn btn-box-tool" onclick="editVehicleZone('{{$zone->zone_id}}','{{$zone->zone_name}}');" data-widget="remove" style="float: right; margin-top: -6px;"><i class="fa fa-pencil"></i></button>
								  </h4>
							  </div>
							  <div id="collapse{{$index}}" class="panel-collapse collapse">

								  <div class="panel-body" style="padding: 0px;">

									  <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
										  <thead>
										  <tr>
											  <th>Vehicle Number</th>
											  <th>Driver Name</th>
											  <th>Current Status</th>
										  </tr>
										  </thead>


										  <tbody>
										  @foreach ($zone->vehicles as $vehicle)
											  <tr>
												  <td>{{$vehicle->vehicle_number}}</td>
												  <td>{{$vehicle->driver_name}}</td>
												  @if($vehicle->isAssigned==0)
												  	  <td><span class="label label-success" style="font-size: small">Available</span></td>
												  @else
													  <td><span class="label label-danger" style="font-size: small">Assigned</span></td>
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
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                	<form role="form"  method="post" action="{{ url('/addVehicleZone') }}">
		            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
		              <div class="box-body">
		                <div class="form-group">
		                  <label for="vehicle_zone">Vehicle Zone Name</label>
		                  <input type="text" class="form-control" name="vehicle_zone" id="vehicle_zone" placeholder="Enter Vehicle Zone Name" required>
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

	<div class="modal fade" tabindex="-1" role="dialog" id="vehicleZoneEditModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Vehicle Zone</h4>
				</div>
				<div class="modal-body">
					<form role="form"  method="post" action="{{ url('/editVehicleZone') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="box-body">
							<div class="form-group">
								<input type="text" class="form-control" name="vehicle_zone_id" id="vehicle_zone_id" style="visibility: hidden; height: 0px;">
							</div>
							<div class="form-group">
								<label for="name">Vehicle Zone Name</label>
								<input type="text" class="form-control" name="edit_vehicle_zone_name" id="edit_vehicle_zone_name" required>
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
			$('.allTables').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});
		});

		function deleteVehicleZone(zone_id){
			alertify.confirm('Are You Sure You Want to Delete this Vehicle Zone?', function(){
				$.ajax({
					url: "{{ url('/delete_vehicle_zone') }}",
					type: "get",
					data:{zone_id:zone_id},
					dataType: 'json',
					async:true,
					success: function(data){
						if(data=='success'){
							alertify.success('Vehicle Zone Deleted Successfully!');
							window.location="{{URL::to('/vehicleZones')}}";
						} else{
							alertify.error('Vehicle Zone Delete Unsuccessful');
						}
					},
					error: function(data)
					{
						console.log("error");
					}
				});
			});
		}
		function editVehicleZone(zone_id,zone_name){
			document.getElementById('vehicle_zone_id').value=zone_id;
			document.getElementById('edit_vehicle_zone_name').value=zone_name;
			$('#vehicleZoneEditModal').modal('show');
		}
	</script>

@endsection