<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel Trial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <br>
        {{-- <h1>Laravel Trial</h1> --}}
        <a class="btn btn-success" href="javascript:void(0)" id="createNewCustomer"> Create New Order</a>
        <br><br>
        <span id="success_message"></span>

        <table class="table table-bordered data-table" style="width: 100%;text-align:center;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Delivery address</th>
                    <th>phone number</th>
                    <th>package weight</th>
                    <th>dimension</th>

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
                    <form id="c_orderForm" name="customerFormCreate" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Customer</label>
                            <div class="col-sm-12">
                                <select id="c_customer" name="c_customer" class="form-select form-control" >
                                    <option selected value="">Select Customer</option>
                                    @foreach ($join as $row)
                                        <option value="{{ $row['id'] }}">
                                            {{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_customer"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Delivery Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_delivery_address" name="c_delivery_address"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_delivery_address"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone Number</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_phone_number" name="c_phone_number"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_phone_number"></strong>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-12 control-label">Package Weight</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_package_weight" name="c_package_weight"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_package_weight"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dimension</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_dimension" name="c_dimension"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_dimension"></strong>
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
                        <input type="hidden" id="u_customer_id" name="u_customer_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Customer</label>
                            <div class="col-sm-12">
                                <select id="u_customer" name="u_customer" class="form-select form-control" >
                                    <option selected value="">Select Customer</option>
                                    @foreach ($join as $row)
                                        <option value="{{ $row['id'] }}">
                                            {{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_customer"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Delivery Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="u_delivery_address" name="u_delivery_address"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_delivery_address"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone Number</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="u_phone_number" name="u_phone_number"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_phone_number"></strong>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-12 control-label">Package Weight</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="u_package_weight" name="u_package_weight"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_package_weight"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dimension</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="u_dimension" name="u_dimension"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_dimension"></strong>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> --}}
    @include('ajax.orderAjax')
</body>

</html>
