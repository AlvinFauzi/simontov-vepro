if (location.pathname == appUrl + '/alarm') {
    $(function() {
        let endPoint = appUrl + '/alarm'
        let table;
        table = $('#data-table').DataTable({
            language: {
                url: ($('#activeLanguage').data('lang') != 'en') ? appUrl + '/lang_id.json' : null
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return `
                  <button type="button" data-id="${row.id}" class="btn btn-icon btn-info detail-data"><i class="fa fa-eye"></i></button>
                  <button type="button" data-id="${row.id}" class="btn btn-icon btn-warning edit-data"><i class="fa fa-pencil"></i></button>
                  <button type="button" data-id="${row.id}" class="btn btn-icon btn-danger delete-data"><i class="fa fa-trash"></i></button>
                  `
                    }

                }
            ],
        });

        $('#addButton').on('click', function() {
            $('#modalAction').modal('show');
            $('.modal-title').text(modal.new);
        });

        $('#data-table').on('click', '.detail-data', function() {
            const id = $(this).data('id')
            $.ajax({
                type: 'get',
                url: `${endPoint}/${id}`,
                dataType: "json",
                success: function(res) {
                    $('#modalDetail').modal('show');
                    $('.modal-title').text(modal.detail);
                    $('#detail-name').text(res.data.name)
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
                    $('.modal-title').text(modal.update);
                    $('input[name="id"]').val(res.data.id);
                    $('input[name="name"]').val(res.data.name);
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
                title: modalAlert.alert,
                text: modalAlert.alertText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: button.deleteYes,
                cancelButtonText: button.deleteNo,
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
                        },
                    });
                }
            });

        });

        $('.btn-action').on('click', function() {
            const id = $('[name="id"]').val()
            let permissionList = []
            $('#permission :selected').each(function(i, val) {
                permissionList.push($(val).val())
            });
            $.ajax({
                type: (id != '') ? 'put' : 'post',
                url: (id != '') ? `${endPoint}/${id}` + '' : `${endPoint}`,
                data: {
                    name: $('[name="name"]').val(),
                },
                dataType: "json",
                success: function(data) {
                    $('#modalAction').modal('hide');
                    successAlert(data.message);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseJSON.errors);
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
                title: success.title,
                text: `${message}`,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                table.ajax.reload(null, false);
            });
        }

    });
}