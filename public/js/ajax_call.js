// Post Ajax Call function
function ajaxPost(url, data, callback, formdata = true) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (formdata) {
        $.ajax({
            method: "POST",
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (rdata) {
                callback(true, rdata)
            }, error: function (edata) {
                callback(false, edata)
            }
        });
    } else {
        $.ajax({
            method: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (rdata) {
                callback(true, rdata)
            }, error: function (edata) {
                callback(false, edata)

            }
        });
    }
}

// Get Ajax Call function
function ajaxGet(url, queryParam, callback) {
    $.ajax({
        method: "GET",
        url: url,
        data: queryParam,
        dataType: 'json',
        async: false,
        success: function (rdata) {
            callback(true, rdata)
        }, error: function (edata) {

            callback(false, edata)
        }
    });
}
    