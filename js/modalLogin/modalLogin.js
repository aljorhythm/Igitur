//modal Login z-index: 9 * (10**6) 
var ModalLogin = {
    //default success is refresh
    //default failure is alert
    Success: function() {
        location.reload();
    }, Failure: function() {
        alert('failed');
    },
    Display: function(duration, callback) {
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
            padding: '10px'
        }).appendTo(modal);

        var x = $("<a>").css({
            position: 'relative',
            float: 'right',
            color: '#666666',
            'border-radius': '5px',
            'font-size': 'large',
            'text-align': 'center'
        }).html("X").on({'click': function(e) {
                ModalLogin.Close();
            }
        }).hover(function() {
            $(this).css({
                cursor: 'pointer',
                color: 'black'
            });
        }, function() {
            $(this).css({
                cursor: 'default',
                color: '#666666'
            });
        }).appendTo(loginBox);
        var container = $("<div>").css({clear: 'both', 'margin-top': '10%'}).appendTo(loginBox);
        container.append('Username: ');
        ModalLogin.username = $("<input>").attr('id', 'username').appendTo(container);

        container.append('<br>Password: ');
        ModalLogin.password = $("<input>").attr({'type': 'password', id: 'password'}).keyup(function(event) {
            if (event.keyCode === 13) {
                ModalLogin.submit.click();
            }
            return false;
        }).appendTo(container);
        container.append('<br>');
        ModalLogin.submit = $("<button>").html('Login').on('click', function(e) {
            console.log('here'); 
            Igitur.UAC.Login(ModalLogin.username[0].value, ModalLogin.password[0].value, function(d) {
                console.log(d); 
                if (d === true) {
                    ModalLogin.Success();
                } else {
                    ModalLogin.Failure();
                }
            });
            e.preventDefault();
            return false;
        }).appendTo(container);

        ModalLogin.Display = function(duration, callback) {
            if (typeof (duration) !== 'undefined') {
                modal.fadeIn(duration, callback);
            }
            else {
                modal.show();
            }
            modal.find('#username').focus();
        };
        ModalLogin.Hide = function(duration, callback) {
            if (typeof (duration) !== 'undefined') {
                modal.fadeOut(duration, callback);
            }
            else {
                modal.hide();
            }
        };
        ModalLogin.Hide();
        $('body').append(modal);
        ModalLogin.Display(duration, callback);
        ModalLogin.JqueryObject = function() {
            return modal;
        };
        ModalLogin.Destroy = function(duration, callback) {
            ModalLogin.Hide(duration, function() {
                modal.remove();
                callback();
            });
        };
    }};
 