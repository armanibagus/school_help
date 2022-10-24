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
});
