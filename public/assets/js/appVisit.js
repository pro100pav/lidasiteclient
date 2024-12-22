function copytext(el) {
    var $tmp = $("<input>");
    $("body").append($tmp);

    $tmp.val($(el).attr('href')).select();
    document.execCommand("copy");
    $tmp.remove();

}
$("body").on("click", ".copy", function() {
    copytext('#' + $(this).attr('data-copy'))
    $("body").append('<div class="alert alert-success alabs" role="alert">Ссылка скопировано</div>');
        setTimeout(function () {
            $('.alabs').remove();
        }, 1500);
});

$("body").on("click", ".close-video", function() {
    $('.videosvis').empty();
    let id = $(this).attr('data-visitka');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/goldenCard/getvideo/'+id,
        data: [],
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(html) {
            if (html.status == 'ok') {
                let acc = '';
                
                $.each(html.content, function (index, value) {
                    acc += '<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"data-bs-target="#collapse'+index+'" aria-expanded="true"aria-controls="collapse'+index+'">'+value.name+'</button></h2><div id="collapse'+index+'" class="accordion-collapse collapse"data-bs-parent="#accordionExample"><div class="accordion-body"><div class="embed-responsive embed-responsive-16by9"><iframe width="100%" height="350" src="https://rutube.ru/play/embed/'+value.linkvideo+'" frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div></div></div>';
                });

                $('.videosvis').append('<div class="accordion" id="accordionExample">'+acc+'</div>');

                                    
                
                console.log(html.content);
            }
            if (html.status == 'err') {
                
            }
        },
        error: function(xhr) {
            $('.error').html('');
            $.each(xhr.responseJSON.errors, function(key, value) {
                $('.error').html(value);
            });
        }
    })
});
