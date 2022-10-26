var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  var options = {
    damping: '0.5'
  }
  Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}

$(document).ready(function () {
  var csrf_token = $('meta[name="csrf-token"]').attr('content');

  /* ===== Logout ===== */
  $('.btn-sign-out').click(function (e) {
    e.preventDefault();
    var route = $(this).data('route');
    $(this).after('' +
      '<form id="logout-form" action="'+route+'" method="POST" class="d-none">' +
      '   <input type="hidden" name="_token" value="'+ csrf_token +'">' +
      '</form>'
    );
    $('#logout-form').submit();
  });

  /* ===== Datatable ===== */
  $('.data-table').DataTable();

  /* ===== Modal ===== */
  $('.modal').find('form').submit(function (e) {
    e.preventDefault();
    $(this).find('[type=submit]').prop('disabled', true);

    var form_action = $(this).attr('action');
    var method = $(this).attr('method');
    var form_data = $(this).serialize();
    $.ajax({
      url: form_action,
      type: method,
      data: form_data,
      success:function (data) {
        // error
        if (data) {
          // clear error
          $('.invalid-feedback').remove();
          $(':input').removeClass('is-invalid');
          $('label').removeClass('text-danger');

          // give error
          $.each(data, function (input_name, error_message) {
            $('[name="'+ input_name +'"]')
              .addClass('is-invalid')
              .after('' +
              '<span class="invalid-feedback" role="alert">\n' +
              '   <strong>'+ error_message[0] +'</strong>\n' +
              '</span>')
              .parents('.form-group').children('label').addClass('text-danger')
            ;
          });
          $('form').find('[type=submit]').removeAttr('disabled');
        }
        // success
        else {
          $('form').find('[type=submit]').removeAttr('disabled');
          window.location.reload();
        }
      },
    });
  });

  // if modal is closed, all input and error message removed
  $('.modal').on('hidden.bs.modal', function () {
    $(':input', this).val('').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('label').removeClass('text-danger');
  });
});
