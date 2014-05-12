//modal Login z-index: 9 * (10**6)
var ModalLogin = {
    //default success is refresh
    //default failure is alert
    Display: function(success, failure) {
        console.log('asd');
        var modal = $("<div>").css({
            height: '100vh',
            width: '100vw',
            background: 'rgba(0,0,0,0.4)',
            position: 'fixed',
            left: '0',
            top: '0',
            'z-index': '999999'
        });

        var loginBox = $("<div>").css({
            'box-sizing': 'border-box',
            '-moz-box-sizing': 'border-box',
            '-webkit-box-sizing': 'border-box',
            height: '150px',
            width: '400px',
            background: 'white',
            position: 'absolute',
            top: '45%',
            left: '50%',
            margin: '-100px 0 0 -200px',
            'border-radius': '4px',
            'text-align': 'center',
            'padding-top': '50px'
        }).appendTo(modal);

        var x = $("<a>").css({
            position: 'absolute',
            right: '-10px',
            top: '-10px',
            background: 'black',
            color: 'white',
            'border-radius': '5px',
            width: '20px',
            'text-align': 'center'
        }).html("x").on({'click': function(e) {
                ModalLogin.Hide();
            }, 'mouseover': function() {
                $(this).css({
                    cursor: 'pointer'
                });
            }
        }).appendTo(loginBox);
        loginBox.append('Username: ');
        var username = $("<input>").attr('id', 'username').appendTo(loginBox);

        loginBox.append('<br>Password: ');
        var password = $("<input>").attr({'type': 'password', id: 'password'}).appendTo(loginBox);
        loginBox.append('<br>');
        var submit = $("<button>").html('Login').on('click', function() {
            Igitur.UAC.Login(username[0].value, password[0].value, function(d) {
                if (d === true) {
                    if (typeof success !== 'undefined')
                        success();
                    else {
                        location.reload();
                    }
                } else {
                    if (typeof failure !== 'undefined')
                        failure();
                    else {
                        alert('credentials not valid');
                    }
                }
            });
        }).appendTo(loginBox);

        $('body').append(modal);
        ModalLogin.Display = function() {
            modal.css('display', 'block');
        };
        ModalLogin.Hide = function() {
            modal.css('display', 'none');
        };
    }};