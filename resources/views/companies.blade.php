@extends('master')

@section('content')


    <section class="content-header">
        <h1>
            Companies
        </h1>
    </section>
    <!-- Custom Tabs -->
    {{--<div class="row">--}}
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Companies</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Company</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {{--company table--}}
                    <table id="company_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Company Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($allCompanies as $company)
                            <tr>
                                <td>{{$company->company_name}}</td>
                                <td>{{$company->company_email}}</td>
                                @if(Session::get('role_id')==1)
                                    <td style="text-align: center;" onclick="editCompany('{{$company->company_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                    <td style="text-align: center;" onclick="deleteCompany('{{$company->company_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form role="form"  method="post" action="{{ url('/addCompany') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="comp_name">Company Name</label>
                                <input type="text" class="form-control" name="company_name" id="comp_name" placeholder="Enter Company Name" required>
                            </div>
                            <div class="form-group">
                                <label for="comp_email">Company Email</label>
                                <input type="email" class="form-control" name="company_email" id="company_email" placeholder="Enter Company Email" required>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="companyEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Company</h4>
                </div>
                <div class="modal-body">
                    <form role="form"  method="post" action="{{ url('/editCompany') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="edit_company_id" id="edit_company_id" style="visibility: hidden; height: 0px;">
                            </div>
                            <div class="form-group">
                                <label for="edit_company_name">Company Name</label>
                                <input type="text" class="form-control" name="edit_company_name" id="edit_company_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_company_email">Company Email</label>
                                <input type="email" class="form-control" name="edit_company_email" id="edit_company_email" required>
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
    {{--</div>--}}
    <script>
        $(function () {
            $('#company_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false
            });
        });

        function deleteCompany(company_id){
            alertify.confirm('Are You Sure You Want to Delete this Company?', function(){
                $.ajax({
                    url: "{{ url('/delete_company') }}",
                    type: "get",
                    data:{company_id:company_id},
                    dataType: 'json',
                    async:true,
                    success: function(data){
                        if(data=='success'){
                            alertify.success('Company Deleted Successfully!');
                            window.location="{{URL::to('/companies')}}";
                        } else{
                            alertify.error('Company Delete Unsuccessful');
                        }
                    },
                    error: function(data)
                    {
                        console.log("error");
                    }
                });

            });
        }


        function editCompany(company_id){
            $('#companyEditModal').modal('show');
            $.ajax({
                url: "{{ url('/getCompanyById') }}"+"/"+company_id,
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