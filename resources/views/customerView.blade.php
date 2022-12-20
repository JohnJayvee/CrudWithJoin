<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel Trial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('customer.index') }}">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">Orders</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                {{-- profile --}}
                                <a class="dropdown-item" href="{{ route('auth.changePassword') }}">
                                    {{ __('Profile') }}
                                </a>

                                {{-- Logout --}}
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                    {{ __('Logout') }}
                                </a>

                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <br>
        {{-- <h1>Laravel Trial</h1> --}}
        <a class="btn btn-success" href="javascript:void(0)" id="createNewCustomer"> Create New Customer</a>
        <br><br>
        <span id="success_message"></span>

        <table class="table table-bordered data-table" style="width: 100%;text-align:center;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>

                    <th width="300px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    {{-- create modal --}}
    <div class="modal fade" id="c_ajaxModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="c_modelHeading" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="c_customerForm" name="customerFormCreate" class="form-horizontal">
                        <input type="hidden" id="c_customer_id" name="customer_id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_name" name="c_name"
                                    placeholder="Enter Name" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_name"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_address" name="c_address"
                                    placeholder="Enter Address" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_address"></strong>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-12 control-label">Phone Number</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_phone_number" name="c_phone_number"
                                    placeholder="Enter Phone Number" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_phone_number"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_email" name="c_email"
                                    placeholder="Enter Email" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_email"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="c_saveBtn" class="btn btn-primary">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit modal --}}
    <div id="UpdateAjaxModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="UpdateModelHeading" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="u_customerForm" class="form-horizontal" name="customerFormEdit">
                        <input type="hidden" id="u_customer_id" name="customer_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Firstname</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_name" class="form-control name" name="u_name"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_name"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lastname</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_address" class="form-control address" name="u_address"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_address"></strong>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-12 control-label">Phone Number</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_phone_number" class="form-control address"
                                    name="u_phone_number" placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_phone_number"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_email" class="form-control address" name="u_email"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_email"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="updateBtn" class="btn btn-primary" value="edit">Save
                                changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> --}}
    @include('ajax.customerAjax')
</body>

</html>
