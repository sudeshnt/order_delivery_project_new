@extends('master')

@section('content')

	<style type="text/css">
		.row {
			margin: 0%;
		}
	</style>

	<section class="content-header">
		<h1>
			Customer Zones
		</h1>
	</section>

	<!-- Custom Tabs -->
	<div class="row">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab">All Customer Zones</a></li>
				<li><a href="#tab_2" data-toggle="tab">Add Customer Zone</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					{{--accordian starts--}}
					@foreach ($customers_in_each_zone as $zone)
						<div class="panel-group" id="accordion">

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$zone->zone_name}}  &#160 &#160  <label style="color: limegreen">( {{sizeof($zone->customers)}} Cutomers)</label></a>

										<button type="button" class="btn btn-box-tool" onclick="deleteCustomerZone('{{$zone->zone_id}}');" data-widget="remove" style="float: right; margin-top: -6px;"><i class="fa fa-times"></i></button>
										<button type="button" class="btn btn-box-tool" onclick="editCustomerZone('{{$zone->zone_id}}','{{$zone->zone_name}}');" data-widget="remove" style="float: right; margin-top: -6px;"><i class="fa fa-pencil"></i></button>

									</h4>

								</div>
								<div id="collapse{{$index}}" class="panel-collapse collapse">

									<div class="panel-body">

										<table id="example{{$index}}"  class="table table-bordered table-hover allTables">
											<thead>
											<tr>
												<th>Name</th>
												<th>Business Name</th>
												<th>Address</th>
												<th>Mobile</th>
											</tr>
											</thead>


											<tbody>
											@foreach ($zone->customers as $customer)
												<tr>
													<td>{{$customer->customer_name}}</td>
													<td>{{$customer->business_name}}</td>
													<td>{{$customer->customer_address}}</td>
													<td>{{$customer->customer_mobile}}</td>
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
					<form role="form"  method="post" action="{{ url('/addCustomerZone') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="box-body">
							<div class="form-group">
								<label for="customer_zone">Customer Zone Name</label>
								<input type="text" class="form-control" name="customer_zone" id="customer_zone" placeholder="Enter Customer Zone Name" required>
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

	<div class="modal fade" tabindex="-1" role="dialog" id="customerZoneEditModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Customer Zone</h4>
				</div>
				<div class="modal-body">
					<form role="form"  method="post" action="{{ url('/editCustomerZone') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="box-body">
							<div class="form-group">
								<input type="text" class="form-control" name="customer_zone_id" id="customer_zone_id" style="visibility: hidden; height: 0px;">
							</div>
							<div class="form-group">
								<label for="edit_customer_zone_name">Customer Zone Name</label>
								<input type="text" class="form-control" name="edit_customer_zone_name" id="edit_customer_zone_name" required>
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

	<!-- jQuery 2.2.0 -->

	<!-- data tables -->

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

		function deleteCustomerZone(zone_id){
			alertify.confirm('Are You Sure You Want to Delete this Customer Zone?', function(){
				$.ajax({
					url: "{{ url('/delete_customer_zone') }}",
					type: "get",
					data:{zone_id:zone_id},
					dataType: 'json',
					async:true,
					success: function(data){
						if(data=='success'){
							alertify.success('Customer Zone Deleted Successfully!');
							window.location="{{URL::to('/customerZones')}}";
						} else{
							alertify.error('Customer Zone Delete Unsuccessful');
						}
					},
					error: function(data)
					{
						console.log("error");
					}
				});
			});
		}
		function editCustomerZone(zone_id,zone_name){
			document.getElementById('customer_zone_id').value=zone_id;
			document.getElementById('edit_customer_zone_name').value=zone_name;
			$('#customerZoneEditModal').modal('show');
		}
	</script>


@endsection