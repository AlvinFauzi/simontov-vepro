window.appUrl = $('meta[name="app-url"]').attr('content')

window.moment = require('moment')
window.Swal = require('sweetalert2')


moment.locale('id');

window.unauthAlert = function(message) {
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: modalAlert.failed,
        text: modalAlert.unauthorize,
        showConfirmButton: false,
        timer: 2500
    })
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $('#modalAction').on('shown.bs.modal', function() {
        $('input:text:visible:first', this).focus();
    });

    $('#modalAction').on('hidden.bs.modal', function() {
        $('#modalAction').find('input,textarea,select').removeClass('is-invalid').val('')
        $('#modalAction').find('select').removeClass('is-invalid').val('').trigger('change')
    });

    $('[data-toggle="tooltip"]').tooltip()

    $('.select2').select2();

});

require('./dashboard')
require('./flowrate')
require('./user-list')
require('./alarm-list')