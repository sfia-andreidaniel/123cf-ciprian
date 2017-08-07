$(document).ready(function () {

    $("#loginForm").submit(function (event) {

        var email = $("#email").val();
        var password = $("#pwd").val();

        $.ajax({
            type: "POST",
            data: {
                action: 'authenticateUser',
                table: 'test_table1',
                email: email,
                password: password
            },
            url: "ajax_php/actions.php",
            beforeSend: function () {
                console.log('sending request ...');
            },
            dataType: "html",
            async: true,
            success: function (data) {

                var result = JSON.parse(data);
                const token = result['token'];

                if (result['error']) {

                    trackLogin(false);

                    $('#email').val('');
                    $('#pwd').val('');
                    $('#error').text(result['error']['message']);

                } else {

                    trackLogin(true);

                    $("#loginForm").hide();
                    $("#results").removeClass("hidden");

                    $.ajax({
                        type: "GET",
                        data: {
                            action: 'retrieveForms',
                            token: token
                        },
                        url: "ajax_php/actions.php",
                        beforeSend: function () {
                            console.log('sending request ...');
                        },
                        dataType: "html",
                        async: true,
                        success: function (data) {

                            var result = JSON.parse(data);

                            $.each(result['data'], function (i, v) {

                                $('#results').append('<h2>' + v['name'] + '</h2><div id="' + v['id'] + '"><div/>');
                                retrieveSubmissions(v['id'], token, v['name']);
                            });
                        }
                    });

                }

            }
        });

        event.preventDefault();
    });

    function trackLogin(write) {
        //write to file
        // $.ajax({
        //     type: "POST",
        //     data: {
        //         action: 'writeToFile',
        //         write: write,
        //     },
        //     url: "ajax_php/actions.php",
        //     beforeSend: function () {
        //         console.log('sending request ...');
        //     },
        //     dataType: "html",
        //     async: true,
        //     success: function (data) {
        //         console.log(data);
        //     }
        // });
    }

    function retrieveSubmissions(id, token, formName) {
        $.ajax({
            type: "GET",
            data: {
                action: 'retrieveSubmissions',
                token: token,
                id: id
            },
            url: "ajax_php/actions.php",
            beforeSend: function () {
                console.log('sending request ...');
            },
            dataType: "html",
            async: true,
            success: function (data) {

                var result = JSON.parse(data);

                var dates = [];

                $.each(result['data'], function (i, v) {
                    dates.push(v.date);
                });

                var minDate = dates.reduce(function (a, b) { return a < b ? a : b; });
                var maxDate = dates.reduce(function (a, b) { return a > b ? a : b; });

                $('#' + id).append('<p>The first submission was done on ' + minDate + ' on ' + formName + '</p> <p>The last submission was done on ' + maxDate + ' on ' + formName + '</p>');

            }
        });
    }

});