<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var users = $.ajax({
            url: "{{ route('user.index') }}",
            type: "GET",
            dataType: 'json',
            success: function(response) {
                console.log(response.data);
                return response.data;
            },
            error: function(response) {
                console.log(response.data);
                return response.data;
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: users,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false
                },
                {
                    data: 'firstName',
                    name: 'firstName'
                },
                {
                    data: 'lastName',
                    name: 'lastName'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                }
            ]
        });

        // increment function
        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        // Create function
        $('#createNewUser').click(function() {
            $('#c_saveBtn').val("create-user");
            $('#c_user_id').val('');
            $('#c_userForm').trigger("reset");
            $('#c_modelHeading').html("Create New User");
            $('#c_ajaxModal').modal('show');

        });

        // Create Save Function
        $('#c_userForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                data: $('#c_userForm').serialize(),
                url: "{{ route('user.store') }}",
                type: "POST",
                dataType: 'JSON',
                success: function(data) {
                    // if (data.errors) {
                    //     $.each(data.errors, function(key, value) {
                    //         if (key == $('#' + key).attr('id')) {
                    //             $('#' + key).addClass('is-invalid')
                    //             $('#error-' + key).text(value)
                    //         }
                    //     })
                    // }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success +
                            '</div>';
                        $('.form-control').removeClass('is-invalid')
                        $('#c_userForm')[0].reset();
                        $('#c_ajaxModal').modal('hide');
                        table.ajax.reload();
                    }

                },
                error: function(data) {
                    var XHR = $.parseJSON(data.responseText);
                    if (XHR.errors) {
                        $.each(XHR.errors, function(key, value) {
                            if (key == $('#' + key).attr('id')) {
                                $('#' + key).addClass('is-invalid')
                                $('#error-' + key).text(value)
                            }
                        })
                    }
                }
            });
        });

        // Edit function
        $('body').on('click', '.editUser', function() {
            var user_id = $(this).data('id');
            var editData = '{{ route('user.edit', ':id') }}';
            editUrl = editData.replace(':id', user_id);
            $.get(editUrl, function(data) {
                console.log(data);
                $('#u_modelHeading').html("Edit User");
                $('#u_saveBtn').val("edit-user");
                $('#u_ajaxModal').modal('show');
                $('#u_user_id').val(data.id);
                $('#u_firstName').val(data.firstName);
                $('#u_lastName').val(data.lastName);

            })
        });

        // Edit Save Function
        $('#u_userForm').on('submit', function(event) {
            event.preventDefault();
            var updateUserID = $('#u_user_id').val();
            var updateData = '{{ route('user.update', ':id') }}';
            updateUrl = updateData.replace(':id', updateUserID);
            $.ajax({
                data: $('#u_userForm').serialize(),
                url: updateUrl,
                type: "PUT",
                dataType: 'JSON',
                success: function(data) {
                    // if (data.errors) {
                    //     $.each(data.errors, function(key, value) {
                    //         if (key == $('#' + key).attr('id')) {
                    //             $('#' + key).addClass('is-invalid')
                    //             $('#error-' + key).text(value)
                    //         }
                    //     })
                    // }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success +
                            '</div>';
                        $('.form-control').removeClass('is-invalid')
                        $('#u_userForm')[0].reset();
                        $('#u_ajaxModal').modal('hide');
                        table.ajax.reload();
                    }

                },
                error: function(data) {
                    var XHR = $.parseJSON(data.responseText);
                    if (XHR.errors) {
                        $.each(XHR.errors, function(key, value) {
                            if (key == $('#' + key).attr('id')) {
                                $('#' + key).addClass('is-invalid')
                                $('#error-' + key).text(value)
                            }
                        })
                    }
                }
            });


        });

        // Delete function
        $('body').on('click', '.deleteUser', function() {
            var deleteUserID = $(this).data('id');
            var editData = '{{ route('user.destroy', ':id') }}';
            deleteUrl = editData.replace(':id', deleteUserID);
            console.log(deleteUserID);

            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        console.log('Success:', data);
                        table.ajax.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }


                });
            }
        });
    });

</script>
