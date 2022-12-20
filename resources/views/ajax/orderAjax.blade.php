<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var customers = $.ajax({
            url: "{{ route('order.index') }}",
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
            ajax: customers,
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
                    data: 'delivery_address',
                    name: 'delivery_address'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'package_weight',
                    name: 'package_weight'
                },
                {
                    data: 'dimension',
                    name: 'dimension'
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
        $('#createNewCustomer').click(function() {
            $('#c_saveBtn').val("create-customer");
            $('#c_order_id').val('');
            $('#c_orderForm').trigger("reset");
            $('#c_modelHeading').html("Create New Customer");
            $('#c_ajaxModal').modal('show');

        });

        // Create Save Function
        $('#c_orderForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                data: $('#c_orderForm').serialize(),
                url: "{{ route('order.store') }}",
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
                        $('#c_orderForm')[0].reset();
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
        $('body').on('click', '.editCustomer', function() {
            var customer_id = $(this).data('id');
            var editData = '{{ route('order.edit', ':id') }}';
            editUrl = editData.replace(':id', customer_id);
            $.get(editUrl, function(data) {
                console.log(data);
                $('#UpdateModelHeading').html("Edit Order");
                $('#u_saveBtn').val("edit-customer");
                $('#UpdateAjaxModal').modal('show');
                $('#u_order_id').val(data.id);
                $('#u_customer').val(data.customer_id);
                $('#u_delivery_address').val(data.delivery_address);
                $('#u_phone_number').val(data.phone_number);
                $('#u_package_weight').val(data.package_weight);
                $('#u_dimension').val(data.dimension);



            })
        });

        // Edit Save Function
        $('#u_orderForm').on('submit', function(event) {
            event.preventDefault();
            var updateCustomerID = $('#u_order_id').val();
            var updateData = '{{ route('order.update', ':id') }}';
            updateUrl = updateData.replace(':id', updateCustomerID);
            $.ajax({
                data: $('#u_orderForm').serialize(),
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
                        $('#u_orderForm')[0].reset();
                        $('#UpdateAjaxModal').modal('hide');
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
        $('body').on('click', '.deleteOrder', function() {
            var deleteOrderID = $(this).data('id');
            var editData = '{{ route('order.destroy', ':id') }}';
            deleteUrl = editData.replace(':id', deleteOrderID);
            console.log(deleteOrderID);

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
