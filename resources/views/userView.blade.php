<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel 8 Crud</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <br>
        {{-- <h1>Laravel 8 Crud with Ajax</h1> --}}
        <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Create New User</a>
        <br><br>
        <span id="success_message"></span>

        <table class="table table-bordered data-table" style="width: 100%;text-align:center;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>FirstName</th>
                    <th>LastName</th>
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
                    <form id="c_userForm" name="userFormCreate" class="form-horizontal">
                        <input type="hidden" id="c_user_id" name="user_id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Firstname</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_firstName" name="c_firstName"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_firstName"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lastname</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="c_lastName" name="c_lastName"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-c_lastName"></strong>
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
    <div id="u_ajaxModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="u_modelHeading" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="u_userForm" class="form-horizontal" name="userFormEdit">
                        <input type="hidden" id="u_user_id" name="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Firstname</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_firstName" class="form-control firstName" name="u_firstName"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_firstName"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lastname</label>
                            <div class="col-sm-12">
                                <input type="text" id="u_lastName" class="form-control lastName" name="u_lastName"
                                    placeholder="Enter Title" value="" maxlength="50">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-u_lastName"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="u_saveBtn" class="btn btn-primary" value="edit">Save changes
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
    @include('ajax.userAjax')
</body>

</html>
