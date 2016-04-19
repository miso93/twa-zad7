/**
 * Created by Michal on 19.04.2016.
 */

var MyApp = {
    base_url : null,
    submitForm: function (form, callback) {

        console.log('submit form');

        $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'multipart/form-data',
                type: 'POST'
            })
            .always(function (data) {

                if (data.responseText != undefined) {
                    var response = JSON.parse(data.responseText);

                    if (isArray(response)) {
                        for (var i in response) {
                            toastr[response[i].type](response[i].message);
                        }
                    } else {
                        toastr[response.type](response.message);
                    }

                    if (typeof callback === "function") {
                        callback(response);
                    }
                }


            });

    }
};