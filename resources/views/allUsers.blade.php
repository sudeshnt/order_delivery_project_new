@extends('master')

@section('content')

    <section class="content-header">
        <h1>
            Users
        </h1>
    </section>

    <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Users</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Users</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {{--customer table--}}
                    <table id="user_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>username</th>
                            <th>Role</th>
                            <th>Member Since</th>
                            @if(Session::get('role_id')==1)
                                <th></th>
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($all_users as $user)
                            <tr>
                                <td>{{$user->user_id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->role_name}}</td>
                                <td>{{$user->created_at}}</td>
                                @if(Session::get('role_id')==1)
                                    <td style="text-align: center;" onclick="editUser('{{$user->user_id}}');"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                                    <td style="text-align: center;" onclick="deleteUser('{{$user->user_id}}');"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="register-box-body">
                        <p class="login-box-msg">Register a new membership</p>

                        <form role="form" method="post" action="{{ url('/doRegister') }}" autocomplete="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group has-feedback">
                                <input type="text" name="name" class="form-control" placeholder="Full name" required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group">
                                <!-- <label>Role</label> -->
                                <select class="form-control select2" name="role_id" style="width: 100%;" placeholder="Role">
                                    <option value="1">Admin</option>
                                    <option value="2">Secretory</option>
                                    <option value="3">Cashier</option>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                @if($user_already_exist==true)
                                    <label style="color: red;">username already exists!</label>
                                @endif
                                <input type="text" name="username" class="form-control" placeholder="Username (must be unique)" autocomplete="off" required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                @if($errors->first('password'))
                                    <label style="color: red;">{{$errors->first('confirm_password')}}</label>
                                @endif
                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                @if($errors->first('confirm_password'))
                                    <label style="color: red;">{{$errors->first('confirm_password')}}</label>
                                @endif
                                <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" required>
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="userEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    <div class="register-box-body">

                        <form role="form" method="post" action="{{ url('/editUser') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="text" class="form-control" name="user_id" id="edit_user_id" style="visibility: hidden; height: 0px;">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_username">Username</label>
                                <input type="text" name="edit_username" id="edit_username" class="form-control" placeholder="Username (must be unique)" autocomplete="off" readonly required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_name">Name</label>
                                <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Full name" required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group">
                                <!-- <label>Role</label> -->
                                <label for="edit_role_id">Role</label>
                                <select class="form-control select2" name="edit_role_id" id="edit_role_id" style="width: 100%;" placeholder="Role">
                                    <option value="1">Admin</option>
                                    <option value="2">Secretory</option>
                                    <option value="3">Cashier</option>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_email">Email</label>
                                <input type="email" name="edit_email" id="edit_email" class="form-control" placeholder="Email" autocomplete="off" required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>

                            {{--<div class="form-group has-feedback">
                                <input type="password" name="edit_password" id="edit_password" class="form-control" placeholder="Password" autocomplete="off">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="edit_confirm_password" id="edit_confirm_password" class="form-control" placeholder="Retype password">
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>--}}
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Save Changes</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#user_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        function deleteUser(user_id){
            alertify.confirm('Are You Sure You Want to Delete this User?', function(){
                $.ajax({
                    url: "{{ url('/delete_user') }}",
                    type: "get",
                    data:{user_id:user_id},
                    dataType: 'json',
                    async:true,
                    success: function(data){
                        if(data=='success'){
                            alertify.success('User Deleted Successfully!');
                            window.location="{{URL::to('/users')}}";
                        } else{
                            alertify.error('User Delete Unsuccessful');
                        }
                    },
                    error: function(data)
                    {
                        console.log("error");
                    }
                });

            });
        }


        function editUser(user_id){
            $('#userEditModal').modal('show');
            $.ajax({
                url: "{{ url('/getUserById') }}"+"/"+user_id,
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