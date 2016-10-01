/**
 * Created by mithishri on 9/29/2016.
 */
$('#r-password').change(function () {

    $('#signup-form .help-block').remove();


    if ($(this).val() == $('#s-password').val()) {
    }

    else
        $('#signup-tab')
            .append(`<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top: 20px">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Oh Snap!</strong> Passwords are not matching. </div>`);


});

$('#login-form').on('submit', function (event) {

    event.preventDefault();
    $.post('login.php', $('#login-form').serialize(), function (data) {

        $('#login-tab .alert').remove();

        if (data == '') {

            location.reload();

        }

        else {


            $('#login-tab').append(data);

        }
    });

});

$('#signup-form').on('submit', function (event) {

    event.preventDefault();
    $.post('signup.php', $('#signup-form').serialize(), function (data) {

        $('#signup-tab .alert').remove();
        if (data && data != "") {
            $('#signup-tab').append(data);
        }
        else
            location.reload();

    });

});
