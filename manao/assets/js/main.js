//AUTH
$('#log-in').click(function (e){
    e.preventDefault();

    $('input').removeClass('error_field');

    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val();

    $.ajax({
       url: 'vendor/signin.php',
       type: 'POST',
        dataType: 'json',
        data: {
           login: login,
            password: password,
        },
        success: function (data){
            if (data.status) {
                document.location.href = '/profile.php';
            } else {
                if(data.type === 1) {
                    data.fields.forEach(function (field){
                       $(`input[name="${field}"]`).addClass('error_field');
                    });
                }

                $('.message').text(data.message);
            }
        },
    });
});

//REG
$('#reg-in').click(function (e){
    e.preventDefault();

    $('input').removeClass('error_field');

    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val(),
        name = $('input[name="name"]').val(),
        email = $('input[name="email"]').val(),
        confirm_password = $('input[name="confirm_password"]').val();

    $.ajax({
        url: 'vendor/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password,
            name: name,
            email: email,
            confirm_password: confirm_password,
        },
        success: function (data){
            if (data.status) {
                document.location.href = '/index.php';
            } else {
                if(data.type === 1) {
                    data.fields.forEach(function (field){
                        $(`input[name="${field}"]`).addClass('error_field');
                    });
                }

                $('.message').text(data.message);
            }
        },
    });
});
