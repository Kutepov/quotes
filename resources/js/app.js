require('./bootstrap');

//Фильтрация цитат по источнику
$(document).ready(function () {
    $('#source-filter').change(function () {
        let source = $(this).val();

        $.ajax({
            url: '/',
            type: "GET",
            data: {
                source: source,
            },
            success: (data) => {
                let positionParameters = location.pathname.indexOf('?');
                let url = location.pathname.substring(positionParameters, location.pathname.length);
                let newUrl = url + '?';
                newUrl += 'source=' + source;
                history.pushState({}, '', newUrl);

                $('#list-quotes').html(data);
            },
        });
    });
});
