require('./bootstrap');

$(document).ready(function () {
    //Фильтрация цитат по источнику
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

    //Подготовка формы "поделиться"
    $('#list-quotes').on('click', '.share-quote-btn', function () {
        $('#modal-share-quote').modal('show');
        $('[name="quote_id"]').val($(this).attr('data-id'));
        $('[name="type"]').val($(this).attr('data-share-type'));
    });

    //Отправка формы "поделиться"
    $('#form-share-quote').submit(function (e) {
        let url = $(this).attr('action');
        let data = $(this).serialize();
        e.preventDefault();
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: () => {
                  $('.result-info').html('<div class="alert alert-success">Цитата будет скоро отправлена.</div>');
            },
            error: (data) => {
                if (data.status === 422) {
                    let errors = '';

                    $.each(data.responseJSON.errors, function (index, error) {
                        for (i = 0; i < error.length; i++) {
                            errors += '<li ">'+error[i]+'</li>';
                        }
                    });

                    $('.result-info').html('<div class="alert alert-danger"><ul class="form-errors-list">' + errors + '</ul></div>');
                }
            }
        });
    });
});
