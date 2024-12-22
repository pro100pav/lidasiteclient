$(document).ready(function(){

    function addblock(id) {
        $('#messagesBots').append(`
        <div class="col-md-12 blockbots" id="block-`+id+`">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title datanumber" data-number="`+id+`">Сообщение #`+id+`</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Текстовка</label>
                        <textarea class="form-control" name="message[]" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>id картинки для вк</label>
                        <input class="form-control imageinputvk" name="imagevk[]" value="">
                    </div>
                    <div class="form-group">
                        <label>Ссылка на изображение</label>
                        <input class="form-control imageinput" name="imagemessage[]" >
                        <p class="small">Можно загрузить или сразу указать ссылку</p>
                    </div>
                    <div class="input-group">
                        <input type="file" name="file" class="inputfile">
                        <span class="downloadimage" data-download="block-`+id+`">Загрузить и получить ссылку</span>
                    </div>
                    <div class="buttommessage"></div>
                    <div class="row">
                        <div class="col-12">
                            <span class="btn btn-primary add-button">Добавить кнопку</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);
    }
    $("body").on("click", "#add-block", function() {
        let countBlock = $('.blockbots').length + 1;
        addblock(countBlock);
    });
    $("body").on("click", ".colorButton", function() {
        let buttonwrapper = $(this).parents('.buttonWrapper').attr('id');
        let color = $(this).attr('data-radiocolor');
        $('#'+buttonwrapper+' input.buttonBots').attr('data-color', color)
        $('#'+buttonwrapper+' input.buttonBots').attr('class', 'buttonBots')
        $('#'+buttonwrapper+' input.buttonBots').addClass(color)
    });
    $("body").on("click", ".direction", function() {
        let buttonwrapper = $(this).parents('.buttonWrapper').attr('id');
        $('.blockdirection').removeClass('d-none')
        $('.blockdirection').empty()
        $('.blockbots').each(function (index, element) {
            $('.blockdirection').append('<span class="selectdirection" data-block="'+buttonwrapper+'" data-kuda='+$(element).attr('id')+'>'+$('#'+$(element).attr('id')+' .card-title').html()+'</span><br>')
        })
        $('.blockdirection').append('<span class="selectdirection" data-block="'+buttonwrapper+'" data-kuda="messageclient">На сообщение пользователя</span><br>')
    });
    
    $("body").on("click", ".selectdirection", function() {
        let kuda = $(this).attr('data-kuda');
        $('.direction').attr('data-setdirection', kuda);
        $('.direction').html($(this).html());
        $('.blockdirection').addClass('d-none')
    });

    $("body").on("click", ".buttonBots", function() {
        let text = $(this).html();
        let kuda = $(this).attr('data-direction');
        let color = $(this).attr('data-color');
        let whatbut = $(this).parents('.buttonWrapper').attr('id');
        $('.textbutton').val(text)
        if(color == 'blue'){
            $('#radio1').prop('checked', true);
        }
        if(color == 'green'){
            $('#radio2').prop('checked', true);
        }
        if(color == 'red'){
            $('#radio3').prop('checked', true);
        }
        if(color == 'white'){
            $('#radio4').prop('checked', true);
        }
        $('.whatbut').val(whatbut);
        if(kuda){
            if(kuda == 'messageclient'){
                $('.direction').html('На сообщение пользователя')
                $('.direction').attr('data-setdirection', kuda)
            }else{
                $('.direction').html($('#'+kuda+' .datanumber').html())
                $('.direction').attr('data-setdirection', kuda)
            }
        }else{
            $('.direction').attr('data-setdirection', "");
            $('.direction').html('Выбрать');
        }
    });
    $("body").on("click", ".savebutton", function() {
        let whatbut = $('.whatbut').val();
        let direction = $('.direction').attr('data-setdirection');
        let text = $('.textbutton').val();
        let color = $('input[name="colorbutton"]:checked').attr('data-radiocolor');
        $('#'+whatbut+' .buttonBots').attr('data-direction', direction);
        $('#'+whatbut+' .buttonBots').attr('data-color', color);
        $('#'+whatbut+' .buttonBots').html(text);
        $('#'+whatbut+' .buttonBots').attr('class', 'buttonBots')
        $('#'+whatbut+' .buttonBots').addClass(color);
        $('.direction').attr('data-setdirection', "");
        $('.direction').html('Выбрать');
        $('#exampleModal').modal('hide');
    });
    $("body").on("click", ".deletebutton", function() {
        $(this).parents('.buttonWrapper').remove();
        $('.buttonWrapper').each(function (index, element) {
            $(element).attr('id', 'buttonWrapper'+(index+1))
        })
    });
    $("body").on("click", ".add-button", function() {
        let block = $(this).parents('.blockbots').attr('id');
        let buttonWrapper = $('.buttonWrapper').length

        $('#'+block+' .buttommessage').append(`
            <div class="buttonWrapper" id="buttonWrapper`+(buttonWrapper+1)+`">
                <div class="row">
                    <div class="col-11">
                    <button type="button" class="buttonBots blue" data-direction=""  data-color="blue" data-bs-toggle="modal" data-bs-target="#exampleModal">Текст кнопки</button>
                    </div>
                    <div class="col-1">
                        <span class="deletebutton">х</span>
                    </div>
                </div>
                
            </div>
        `)
    });
    



    $("body").on("click", ".save", function() {
        let bot = [];
        $('.blockbots').each(function (index, element) {
            let id = $(element).attr('id')
            arrayBtn = [];
                $('#'+id+' .buttonBots').each(function (index, element) {
                    arrayBtn.push({
                        id_block: $(element).parents('.buttonWrapper').attr('id'),
                        direction: $(element).attr('data-direction'),
                        color: $(element).attr('data-color'),
                        text_button: $(element).html(),
                    });
                })
            bot.push({
                id_mes: id,
                name_mes: $('#'+id+' .datanumber').attr('data-number'),
                image_mes: $('#'+id+' .imageinput').val(),
                image_vk: $('#'+id+' .imageinputvk').val(),
                text: $('#'+id+' textarea').val(),
                buttons: arrayBtn
            });
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/manager/bots/edit/'+$(this).attr('data-bot'),
            data: {
                'bot': bot,
            },
            success: function(html) {
                if(html == 'ok'){
                    $('.save').html('сохранено')
                }
            },
            error: function(xhr) {
                $('.error').html('');
                $.each(xhr.responseJSON.errors, function(key, value) {
                    $('.error').html(value);
                });
            }
        })
        console.log(bot)
    });





    $("body").on("click", ".downloadimage", function() {
            let block = $(this).attr('data-download');
            $('#'+block+' .imageinput').val('');
            var formData = new FormData();
            formData.append('file', $('#'+block+' .inputfile')[0].files[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    type: 'POST',
                    url: '/upload/photo-bot',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(html) {
                        console.log(html);
                        if (html.status == 'ok') {
                            $('#'+block+' .imageinput').val(html.location);
                        }
                        if (html.status == 'err') {
                            $('.error').html('Изображение не найдено');
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
});


