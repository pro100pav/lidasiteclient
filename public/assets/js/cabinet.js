
document.addEventListener('DOMContentLoaded', function() {

    const inputPassword = document.querySelector('.form-password');

    if (inputPassword) {
        inputPassword.addEventListener('click', function() {
            var passwordInput = document.querySelector("#password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    }
    function copytext(el) {
        var $tmp = $("<input>");
        $("body").append($tmp);
    
        $tmp.val($(el).attr('href')).select();
        document.execCommand("copy");
        $tmp.remove();
    
    }
    $("body").on("click", ".copy", function() {
        copytext('#' + $(this).attr('data-copy'))
        UIkit.notification("<span uk-icon='icon: check'></span> Скопировано");
            setTimeout(function () {
                UIkit.notification.closeAll()
            }, 1500);
    });

    // const iconSidebar = document.querySelector('.icon-sidebar-a');
    
    //  if (iconSidebar) {
    //     const sidebar = document.querySelector('.sidebar');
    //     iconSidebar.addEventListener('click', function() {
    //         sidebar.classList.add('show');
    //     });
    //     const sidebarCloseIcon = document.querySelector('.sidebar-close-icon');
    //     sidebarCloseIcon.addEventListener('click', function() {
    //     sidebar.classList.remove('show');
    //     });
    // }

    // document.getElementById('generatekey').addEventListener('click', function() {
    //     // Создаем новый объект XMLHttpRequest
    //     var xhr = new XMLHttpRequest();

    //     // Настраиваем запрос
    //     xhr.open('POST', '/form/generate', true); // Замените 'your-api-endpoint' на ваш URL

    //     // Устанавливаем заголовок Content-Type для POST-запроса
    //     xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    //     // Устанавливаем обработчик события для завершения запроса
    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState === 4 && xhr.status === 200) {
    //             // Обрабатываем ответ от сервера
    //             var response = xhr.responseText;

    //             // Помещаем ответ в элемент с id reskey
    //             document.getElementById('reskey').innerText = response;

    //             // Удаляем элемент с id generatekey
    //             var generateKeyButton = document.getElementById('generatekey');
    //             if (generateKeyButton) {
    //                 generateKeyButton.remove();
    //             }
    //         }
    //     };

    //     // Данные для отправки в формате JSON
    //     var data = JSON.stringify({
    //         key: 'value' // Замените на ваши данные
    //     });

    //     // Отправляем запрос
    //     xhr.send(data);
    // });

    if($('#pricekey2').length){
        const price1 = document.getElementById('pricekey2').textContent;
        const input1 = document.getElementById('formkey1');
        const resultSpan1 = document.getElementById('respay');
        const resultLiSpan1 = document.getElementById('resli');
    
        input1.addEventListener('input', function() {
            // Получаем значение из input и преобразуем его в число
            const value = parseFloat(input1.value);
            // Проверяем, является ли значение числом
            if (!isNaN(value)) {
                if(value == 10){
                    resultSpan1.textContent = '25000';
                }else{
                    const result = value * price1;
                    resultSpan1.textContent = result;
                }
                const result2 = value * 100 * value;
                resultLiSpan1.textContent = result2;
            } else {
                // Если значение не является числом, отображаем 0
                resultSpan1.textContent = '0';
                resultLiSpan1.textContent = '0';
            }
        });
    
        const price2 = document.getElementById('pricekey1').textContent;
        const input2 = document.getElementById('formkey2');
        const resultSpan2 = document.getElementById('respayyear');
        const resultLiSpan2 = document.getElementById('resliyear');
    
        input2.addEventListener('input', function() {
            // Получаем значение из input и преобразуем его в число
            const value = parseFloat(input2.value);
            // Проверяем, является ли значение числом
            if (!isNaN(value)) {
                if(value == 10){
                    resultSpan2.textContent = '5000';
                }else{
                    const result = value * price2;
                    resultSpan2.textContent = result;
                }
                const result2 = value * 50 * value;
                resultLiSpan2.textContent = result2;
            } else {
                // Если значение не является числом, отображаем 0
                resultSpan2.textContent = '0';
                resultLiSpan2.textContent = '0';
            }
        });
    }
    if($('#pricevisit').length){
        let price = document.getElementById('pricevisit').textContent;
        let input = document.getElementById('formvisit');
        let resultSpan = document.getElementById('respricevis');
        let resultLiSpan = document.getElementById('reslivis');
        let procevisres = document.getElementById('procevisres');
        let respricevismonth = document.getElementById('respricevismonth');
    
        input.addEventListener('input', function() {
            // Получаем значение из input и преобразуем его в число
            const value = parseFloat(input.value);
            // Проверяем, является ли значение числом
            if (!isNaN(value)) {
                let li = 0;
                if(value > 0){
                    price = 500;
                    li = value * 200;
                }
                if(value > 2){
                    price = 400;
                    li = value * 300;
                }
                if(value > 4){
                    price = 300;
                    li = value * 400;
                }
                if(value > 9){
                    price = 250;
                    li = value * 500;
                }
                const result = value * price;
                resultSpan.textContent = result;
                procevisres.textContent = price;
                resultLiSpan.textContent = li;
                respricevismonth.textContent = (price / 12).toFixed(2);
            } else {
                // Если значение не является числом, отображаем 0
                resultSpan.textContent = '0';
                resultLiSpan.textContent = '0';
                procevisres.textContent = price;
                respricevismonth.textContent = 0;
            }
        });
    }
    


    if($('.classs').length){
        var chart;
        let bot = $('.classs').attr('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         $.ajax({
            type: 'post',
            url: '/partner/structura/JSON/'+bot,
            data: {},
            success: function(data) {
                $('.chart-container').removeClass('d-none')
                $('.spinner-border').remove()
                $('.countclass').html(data.length - 1)
                chart = new d3.OrgChart()
                    .container('.chart-container')
                    .data(data)
                    .nodeId((dataItem) => dataItem.customId)
                    .parentNodeId((dataItem) => dataItem.customParentId)
                    .nodeWidth((node) => 300)
                    .nodeHeight((node) => 80)
                    .childrenMargin((node) => 90)
                    .compact(!!(compact++%2))
                    .nodeContent((node) => {
                        return `<div class="wrapper_node ${node.data.classActive}">
                            <div class="row align-items-center">
                                <div class="col-4">
                                </div>
                                <div class="col-8">
                                    <div class="name text-center">${node.data.name}</div>
                                    <div class="text-center">ID ${node.data.customId}</div>
                                </div>
                            </div>
                        </div>`;
                    })
                    .render();
                var compact = 0;
                chart.compact(!!(compact++%60)).render().fit()
                
            },
            error: function (xhr) {
                $.each(xhr.responseJSON.errors, function (index, value) {

                    $('.errors').append('<p>' + value[0] + '</p>');
                });
                
            }
        });
        $("body").on("click", ".expand", function() {
            chart.expandAll()
        });
        
        $("body").on("click", ".collapsestr", function() {
            chart.collapseAll()
        });
        $("body").on("click", ".center", function() {
            chart.fit()
        });
    }
    if($('.visitkaConstr').length){
        $('#summernote').summernote({
            lang: 'ru-RU',
            placeholder: 'Ваш текст',
            tabsize: 2,
            height: 120,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link']],
            ]
          });
        let back = $('input[name="radio2"]:checked').val();
        $('.prevu').css('background-image', 'url(' + back + ')');

        $('input[name="radio2"]').click(function(){
            $('.prevu').css('background-image', 'url(' + $(this).val() + ')');
        });

        let ofor = $('input[name="radio3"]:checked').val();
        $('.ofor').css('background-image', 'url(' + ofor + ')');

        $('input[name="radio3"]').click(function(){
            $('.ofor').css('background-image', 'url(' + $(this).val() + ')');
        });

        $('#name').bind('input', function(){
            $('.name').html($(this).val());
            if($(this).val().length < 1){
                $('.name').html('Ваше имя');
            }
        });
        $('#introtext').bind('input', function(){
            $('.introtext').html($(this).val());
            if($(this).val().length < 1){
                $('.introtext').html('Слоган');
            }
        });
        $("body").on("click", ".addBut", function() {
            if($('.buttonprev').length == 4){
                $('.resbut').html('Максимально 4 кнопки, лимит достигнут');
                UIkit.modal($('#add-button')).hide();
            }else{
                let name = $('#namebut').val();
                let link = $('#link').val();
                if(name.length < 1){
                    $('.errBut').html('Не заданно имя кнопки');
                }else{
                    let type = $('#typebut').val();
                    $('#form-visitka').append('<input type="hidden" name="button[]" value="'+[name, type]+'">');
                    $('.buttonsadds').append('<div class="edvisbv buttonprev"><p>'+name+'</p></div>');
                    $('#namebut').val('');
                    $('#linkh').val(link);
                    UIkit.modal($('#add-button')).hide();
                }
                
            }
            
        });
        $("body").on("click", ".addVideo", function() {
            let name = $('#namevid').val();
            if(name.length < 1){
                $('.errVid').html('Не заданно имя видео');
            }
            let code = $('#codevid').val();
            if(code.length < 1){
                $('.errVid').html('Не задан код видео');
            }else{
                $('#form-visitka').append('<input type="hidden" name="video[]" value="'+[name, code]+'">');
                $('.videossadds').append('<div class="edvisbv videoprev"><p>'+name+'</p></div>');
                $('#namevid').val('');
                $('#codevid').val('');
                UIkit.modal($('#add-video')).hide();
            }
        });
        $("body").on("change", "#typebut", function() {
            if($(this).val() == 4){
                $('#blocklink').show()
            }else{
                $('#blocklink').hide()
            }
        })

        $("body").on("click", ".delbut", function() {
            let id = $(this).parent().attr('id');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/goldenCard/delbtn/'+id.replace(/\D/g, ''),
                data: [],
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(html) {
                    if (html.status == 'ok') {
                        $('#'+id).remove()
                    }
                    if (html.status == 'err') {
                        $('.errBut').html('Ошибка удаления');
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
        $("body").on("click", ".delvideo", function() {
            let id = $(this).parent().attr('id');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/goldenCard/delvideo/'+id.replace(/\D/g, ''),
                data: [],
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(html) {
                    if (html.status == 'ok') {
                        $('#'+id).remove()
                    }
                    if (html.status == 'err') {
                        $('.errVid').html('Ошибка удаления');
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
    }

    $("body").on("change", "#upimg", function() {
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/goldenCard/visit/upload/photo',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(html) {
                if (html.status == 'ok') {
                    $('#photo').val(html.location);
                    $('.img-vis').attr('src', html.location);
                    $('.resp').html('Успешно загружено');
                }
                if (html.status == 'err') {
                    $('.resp').html('Изображение не найдено');
    
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