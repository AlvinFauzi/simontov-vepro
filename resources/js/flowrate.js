if (location.pathname === `${appUrl}/flowrate`) {
    $(function() {
        let endPoint = `${appUrl}/flowrate`
        let table;
        table = $('#data-table').DataTable({
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'mb-3',
                title: 'Flowrate Data'
            }, {
                extend: 'colvis',
                className: 'mb-3',
            }, ],
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000],
                [10, 25, 50, 100, 500, 1000],
            ],

            language: {
                url: ($('#activeLanguage').data('lang') != 'en') ? `${appUrl}/lang_id.json` : null
            },
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: `${endPoint}`,
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'mag_date',
                    name: 'mag_date'
                },
                {
                    data: 'flowrate',
                    name: 'flowrate'
                },
                {
                    data: 'totalizer_1',
                    name: 'totalizer_1'
                },
                {
                    data: 'totalizer_2',
                    name: 'totalizer_2'
                },
                {
                    data: 'totalizer_3',
                    name: 'totalizer_3'
                },
                {
                    data: 'analog_1',
                    name: 'analog_1'
                },
                {
                    data: 'analog_2',
                    name: 'analog_2'
                },
                {
                    data: 'status_battery',
                    name: 'status_battery'
                },
                {
                    data: 'alarm',
                    name: 'alarm'
                },
                {
                    data: 'bin_alarm',
                    name: 'bin_alarm'
                },
                {
                    data: 'file_name',
                    name: 'file_name'
                },
            ],

        });

        table.buttons().container()
            .appendTo('#data-table_wrapper .col-md-4');

        $('#addButton').click(function() {
            $('#modalAction').modal('show');
            $('.modal-title').text('New Data');
        });

        $('#data-table').on('click', '.detail-data', function() {
            const id = $(this).data('id')
            $.ajax({
                type: 'get',
                url: `${endPoint}/${id}`,
                dataType: "json",
                success: function(res) {
                    $('#modalDetail').modal('show');
                    $('.modal-title').text('detail');
                    $('#detail-name').text(res.name)
                    $('#detail-code').text(res.code)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.warn(thrownError);
                    if (xhr.status == 403) {
                        unauthAlert(xhr.responseJSON.message)
                    }
                }
            });
        });

        $('#data-table').on('click', '.edit-data', async function() {
            const id = $(this).data('id')
            await $.ajax({
                type: 'get',
                url: `${endPoint}/${id}`,
                dataType: "json",
                success: function(res) {
                    $('#modalAction').modal('show');
                    $('.modal-title').text('Update Data');
                    $('input[name="name"]').val(res.name);
                    $('input[name="code"]').val(res.code);
                    $('input[name="id"]').val(res.id);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.warn(thrownError);
                    if (xhr.status == 403) {
                        unauthAlert(xhr.responseJSON.message)
                    }
                }
            });
        });

        $('#data-table').on('click', '.delete-data', function() {
            let id = $(this).data('id')
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Data Will Destroyed Permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'delete',
                        url: `${endPoint}/${id}`,
                        dataType: "json",
                        async: true,
                        success: function(data) {
                            successAlert(data.message)
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            unauthAlert(xhr.responseJSON.message)
                        }
                    });
                }
            });

        });

        $('.btn-action').click(function() {
            const id = $('[name="id"]').val()
            $.ajax({
                type: (id != '') ? 'put' : 'post',
                url: (id != '') ? `${endPoint}/${id}` + '' : `${endPoint}`,
                data: {
                    name: $('[name="name"]').val(),
                    code: $('[name="code"]').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#modalAction').modal('hide');
                    successAlert(data.message);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) {
                        $('.modal-body').find('input,textarea,select').removeClass(
                            'is-invalid')
                        let error = xhr.responseJSON.errors
                        $.each(error, function(index, value) {
                            $('[name="' + index + '"]').addClass('is-invalid')
                            $('#error-' + index).text(value[0]).show();
                        });
                    }
                    if (xhr.status == 403) {
                        unauthAlert(xhr.responseJSON.message)
                    }
                }
            });

        });

        function successAlert(message) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Congratulation',
                text: `${message}`,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                table.ajax.reload(null, false);
            });
        }




    });
}