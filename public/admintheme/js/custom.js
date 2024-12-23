 var dompet = function(){
	 "use strict"
	/* Search Bar ============ */
	var screenWidth = $( window ).width();
	var screenHeight = $( window ).height();
	
	
	var handleNiceSelect = function(){
		if(jQuery('.default-select').length > 0 ){
			jQuery('.default-select').niceSelect();
			
		}
	}

	var handlePreloader = function(){
		setTimeout(function() {
			jQuery('#preloader').remove();
			$('#main-wrapper').addClass('show');
		},800);	
		
	}

    var handleMetisMenu = function() {
		if(jQuery('#menu').length > 0 ){
			$("#menu").metisMenu();
		}
		jQuery('.metismenu > .mm-active ').each(function(){
			if(!jQuery(this).children('ul').length > 0)
			{
				jQuery(this).addClass('active-no-child');
			}
		});
	}
   
    var handleAllChecked = function() {
		$("#checkAll").on('change',function() {
			$("td input, .email-list .custom-checkbox input").prop('checked', $(this).prop("checked"));
		});
	}

	var handleNavigation = function() {
		$(".nav-control").on('click', function() {

			$('#main-wrapper').toggleClass("menu-toggle");

			$(".hamburger").toggleClass("is-active");
		});
	}
  
	var handleCurrentActive = function() {
		for (var nk = window.location,
			o = $("ul#menu a").filter(function() {
				
				return this.href == nk;
				
			})
			.addClass("mm-active")
			.parent()
			.addClass("mm-active");;) 
		{
			
			if (!o.is("li")) break;
			
			o = o.parent()
				.addClass("mm-show")
				.parent()
				.addClass("mm-active");
		}
	}

	var handleMiniSidebar = function() {
		$("ul#menu>li").on('click', function() {
			const sidebarStyle = $('body').attr('data-sidebar-style');
			if (sidebarStyle === 'mini') {
				console.log($(this).find('ul'))
				$(this).find('ul').stop()
			}
		})
	}
   
	var handleMinHeight = function() {
		var win_h = window.outerHeight;
		var win_h = window.outerHeight;
		if (win_h > 0 ? win_h : screen.height) {
			$(".content-body").css("min-height", (win_h + 60) + "px");
		};
	}
    
	var handleDataAction = function() {
		$('a[data-action="collapse"]').on("click", function(i) {
			i.preventDefault(),
				$(this).closest(".card").find('[data-action="collapse"] i').toggleClass("mdi-arrow-down mdi-arrow-up"),
				$(this).closest(".card").children(".card-body").collapse("toggle");
		});

		$('a[data-action="expand"]').on("click", function(i) {
			i.preventDefault(),
				$(this).closest(".card").find('[data-action="expand"] i').toggleClass("icon-size-actual icon-size-fullscreen"),
				$(this).closest(".card").toggleClass("card-fullscreen");
		});



		$('[data-action="close"]').on("click", function() {
			$(this).closest(".card").removeClass().slideUp("fast");
		});

		$('[data-action="reload"]').on("click", function() {
			var e = $(this);
			e.parents(".card").addClass("card-load"),
				e.parents(".card").append('<div class="card-loader"><i class=" ti-reload rotate-refresh"></div>'),
				setTimeout(function() {
					e.parents(".card").children(".card-loader").remove(),
						e.parents(".card").removeClass("card-load")
				}, 2000)
		});
	}

    var handleHeaderHight = function() {
		const headerHight = $('.header').innerHeight();
		$(window).scroll(function() {
			if ($('body').attr('data-layout') === "horizontal" && $('body').attr('data-header-position') === "static" && $('body').attr('data-sidebar-position') === "fixed")
				$(this.window).scrollTop() >= headerHight ? $('.dlabnav').addClass('fixed') : $('.dlabnav').removeClass('fixed')
		});
	}
	
	var handleDlabScroll = function() {
		jQuery('.dlab-scroll').each(function(){
			var scroolWidgetId = jQuery(this).attr('id');
			const ps = new PerfectScrollbar('#'+scroolWidgetId, {
			  wheelSpeed: 2,
			  wheelPropagation: true,
			  minScrollbarLength: 20
			});
            ps.isRtl = false;
		})
	}
	
	var handleMenuTabs = function() {
		if(screenWidth <= 991 ){
			jQuery('.menu-tabs .nav-link').on('click',function(){
				if(jQuery(this).hasClass('open'))
				{
					jQuery(this).removeClass('open');
					jQuery('.fixed-content-box').removeClass('active');
					jQuery('.hamburger').show();
				}else{
					jQuery('.menu-tabs .nav-link').removeClass('open');
					jQuery(this).addClass('open');
					jQuery('.fixed-content-box').addClass('active');
					jQuery('.hamburger').hide();
				}
				//jQuery('.fixed-content-box').toggleClass('active');
			});
			jQuery('.close-fixed-content').on('click',function(){
				jQuery('.fixed-content-box').removeClass('active');
				jQuery('.hamburger').removeClass('is-active');
				jQuery('#main-wrapper').removeClass('menu-toggle');
				jQuery('.hamburger').show();
			});
		}
	}
	
	var handleChatbox = function() {
		jQuery('.bell-link').on('click',function(){
			jQuery('.chatbox').addClass('active');
		});
		jQuery('.chatbox-close').on('click',function(){
			jQuery('.chatbox').removeClass('active');
		});
	}
	
	var handlePerfectScrollbar = function() {
		if(jQuery('.dlabnav-scroll').length > 0)
		{
			//const qs = new PerfectScrollbar('.dlabnav-scroll');
			const qs = new PerfectScrollbar('.dlabnav-scroll');
			
			qs.isRtl = false;
		}
	}

	var handleBtnNumber = function() {
		$('.btn-number').on('click', function(e) {
			e.preventDefault();

			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='" + fieldName + "']");
			var currentVal = parseInt(input.val());
			if (!isNaN(currentVal)) {
				if (type == 'minus')
					input.val(currentVal - 1);
				else if (type == 'plus')
					input.val(currentVal + 1);
			} else {
				input.val(0);
			}
		});
	}
	
	var handleDlabChatUser = function() {
		jQuery('.dlab-chat-user-box .dlab-chat-user').on('click',function(){
			jQuery('.dlab-chat-user-box').addClass('d-none');
			jQuery('.dlab-chat-history-box').removeClass('d-none');
            //$(".chatbox .msg_card_body").height(vHeightArea());
            //$(".chatbox .msg_card_body").css('height',vHeightArea());
		}); 
		
		jQuery('.dlab-chat-history-back').on('click',function(){
			jQuery('.dlab-chat-user-box').removeClass('d-none');
			jQuery('.dlab-chat-history-box').addClass('d-none');
		}); 
		
		jQuery('.dlab-fullscreen').on('click',function(){
			jQuery('.dlab-fullscreen').toggleClass('active');
		});
        
        /* var vHeight = function(){ */
            
        /* } */
        
        
	}
	
	
	var handleDlabFullScreen = function() {
		jQuery('.dlab-fullscreen').on('click',function(e){
			if(document.fullscreenElement||document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement) { 
				/* Enter fullscreen */
				if(document.exitFullscreen) {
					document.exitFullscreen();
				} else if(document.msExitFullscreen) {
					document.msExitFullscreen(); /* IE/Edge */
				} else if(document.mozCancelFullScreen) {
					document.mozCancelFullScreen(); /* Firefox */
				} else if(document.webkitExitFullscreen) {
					document.webkitExitFullscreen(); /* Chrome, Safari & Opera */
				}
			} 
			else { /* exit fullscreen */
				if(document.documentElement.requestFullscreen) {
					document.documentElement.requestFullscreen();
				} else if(document.documentElement.webkitRequestFullscreen) {
					document.documentElement.webkitRequestFullscreen();
				} else if(document.documentElement.mozRequestFullScreen) {
					document.documentElement.mozRequestFullScreen();
				} else if(document.documentElement.msRequestFullscreen) {
					document.documentElement.msRequestFullscreen();
				}
			}		
		});
	}
	
	var handleshowPass = function(){
		jQuery('.show-pass').on('click',function(){
			jQuery(this).toggleClass('active');
			if(jQuery('#dlab-password').attr('type') == 'password'){
				jQuery('#dlab-password').attr('type','text');
			}else if(jQuery('#dlab-password').attr('type') == 'text'){
				jQuery('#dlab-password').attr('type','password');
			}
		});
	}
	
	var heartBlast = function (){
		$(".heart").on("click", function() {
			$(this).toggleClass("heart-blast");
		});
	}
	
	var handleDlabLoadMore = function() {
		$(".dlab-load-more").on('click', function(e)
		{
			e.preventDefault();	//STOP default action
			$(this).append(' <i class="fa fa-refresh"></i>');
			
			var dlabLoadMoreUrl = $(this).attr('rel');
			var dlabLoadMoreId = $(this).attr('id');
			
			$.ajax({
				method: "POST",
				url: dlabLoadMoreUrl,
				dataType: 'html',
				success: function(data) {
					$( "#"+dlabLoadMoreId+"Content").append(data);
					$('.dlab-load-more i').remove();
				}
			})
		});
	}
	
	var handleLightgallery = function(){
		if(jQuery('#lightgallery').length > 0){
			$('#lightgallery').lightGallery({
				loop:true,
				thumbnail:true,
				exThumbImage: 'data-exthumbimage'
			});
		}
	}
	var handleCustomFileInput = function() {
		$(".custom-file-input").on("change", function() {
			var fileName = $(this).val().split("\\").pop();
			$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	}
    
  	var vHeight = function(){
        var ch = $(window).height() - 206;
        $(".chatbox .msg_card_body").css('height',ch);
    }
    
	var domoPanel = function(){
		if(jQuery('.dlab-demo-content').length > 0 ){
			const ps = new PerfectScrollbar('.dlab-demo-content');
			$('.dlab-demo-trigger').on('click', function() {
					$('.dlab-demo-panel').addClass('show');
			  });
			  $('.dlab-demo-close, .bg-close').on('click', function() {
					$('.dlab-demo-panel').removeClass('show');
			  });
			  
			  $('.dlab-demo-bx').on('click', function() {
				  $('.dlab-demo-bx').removeClass('demo-active');
				  $(this).addClass('demo-active');
			  });
		} 
	} 
	
	var handleDatetimepicker = function(){
		if(jQuery("#datetimepicker1").length>0) {
			$('#datetimepicker1').datetimepicker({
				inline: true,
			});
		}
	}
	
	var handleCkEditor = function(){
		if(jQuery("#ckeditor").length>0) {
			ClassicEditor
			.create( document.querySelector( '#ckeditor' ), {
				// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
			} )
			.then( editor => {
				window.editor = editor;
			} )
			.catch( err => {
				console.error( err.stack );
			} );
		}
	}
	
	var handleMenuPosition = function(){
		
		if(screenWidth > 1024){
			$(".metismenu  li").unbind().each(function (e) {
				if ($('ul', this).length > 0) {
					var elm = $('ul:first', this).css('display','block');
					
					var off = elm.offset();
					var l = off.left;
					var w = elm.width();
					var elm = $('ul:first', this).removeAttr('style');
					var docH = $("body").height();
					var docW = $("body").width();
					
					if(jQuery('html').hasClass('rtl')){
						var isEntirelyVisible = (l + w <= docW);	
					}else{
						var isEntirelyVisible = (l > 0)?true:false;	
					}
						
					if (!isEntirelyVisible) {
						$(this).find('ul:first').addClass('left');
					} else {
						$(this).find('ul:first').removeClass('left');
					}
				}
			});
		}
	}	
  
	/* Function ============ */
	return {
		init:function(){
			handleMetisMenu();
			handleAllChecked();
			handleNavigation();
			handleCurrentActive();
			handleMiniSidebar();
			handleMinHeight();
			handleDataAction();
			handleHeaderHight();
			handleDlabScroll();
			handleMenuTabs();
			handleChatbox();
			handlePerfectScrollbar();
			handleBtnNumber();
			handleDlabChatUser();
			handleDlabFullScreen();
			handleshowPass();
			heartBlast();
			handleDlabLoadMore();
			handleLightgallery();
			handleCustomFileInput();
			vHeight();
			domoPanel();
			handleDatetimepicker();
			handleCkEditor();
		},

		
		load:function(){
			handlePreloader();
			handleNiceSelect();
		},
		
		resize:function(){
			vHeight();
			
		},
		
		handleMenuPosition:function(){
			handleMenuPosition();
		},
	}
	
}();

/* Document.ready Start */	
jQuery(document).ready(function() {
	$('[data-bs-toggle="popover"]').popover();
    'use strict';
	dompet.init();
	
});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load',function () {
	'use strict'; 
	dompet.load();
	setTimeout(function(){
			dompet.handleMenuPosition();
	}, 1000);
	
});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on('resize',function () {
	'use strict'; 
	dompet.resize();
	setTimeout(function(){
			dompet.handleMenuPosition();
	}, 1000);
});
/*  Window Resize END */



if ($('#text').length) {
	$('#text').bind('input', function(){
		$('#counttext').html($(this).val().length);
		if($('#text').val().length > 0){
			$('#fun').hide();
			$('#selfun option[value="0"]').prop('selected', true);
			$('.default-select').niceSelect('update');
		}else{
			$('#fun').show();
		}
	});
	$('#counttext').html($('#text').val().length);
	if($('#text').val().length > 0){
		$('#fun').hide();
		$('#selfun option[value="0"]').prop('selected', true);
		$('.default-select').niceSelect('update');
	}else{
		$('#fun').show();
	}
	
}

$("body").on("change", "#messageImg", function() {
	var formData = new FormData();
	formData.append('file', $(this)[0].files[0]);
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: 'POST',
		url: '/manager/bottemplates/message/upload/photo',
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(html) {
			if (html.status == 'ok') {
                $('#photomessage').val(html.location);
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

if($('.videoMessage').length){
	let browseFile = $('#browseFileAny');
	let resumable = new Resumable({
		target: '/manager/bottemplates/message/upload/video',
		query:{_token: $('meta[name="csrf-token"]').attr('content')} ,// CSRF token
		fileType: ['mp4','avi'],
		fileTypeErrorCallback: function(file, errorCount) {
			alert('Формат файла не поддерживается, загрузите пожалйста видео формата mp4 или avi');
		},
		maxFiles: 1,
		maxFileSize: 41838182,
		maxFileSizeErrorCallback:function(file, errorCount) {
			alert('Максимальный размер файла должен быть не более 40 мб');
		  },
		headers: {
			'Accept' : 'application/json'
		},
		testChunks: false,
		throttleProgressCallbacks: 1,
	});

	resumable.assignBrowse(browseFile[0]);

	resumable.on('fileAdded', function (file) { // trigger when file picked
		showProgress();
		resumable.upload() // to actually start uploading.
	});

	resumable.on('fileProgress', function (file) { // trigger when file progress update
		updateProgress(Math.floor(file.progress() * 100));
	});

	resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
		response = JSON.parse(response)
		$('#videomessage').val(response.path);
		$('.progress-any').hide();
		$('.resVideo').html('Успешно загружено');
	});

	resumable.on('fileError', function (file, response) { // trigger when there is any error
		alert('Ошибка при загрузке видео')
	});


	let progress = $('.progress-any');
	function showProgress() {
		progress.find('.progress-bar').css('width', '0%');
		progress.find('.progress-bar').html('0%');
		progress.find('.progress-bar').removeClass('bg-success');
		progress.show();
	}

	function updateProgress(value) {
		progress.find('.progress-bar').css('width', `${value}%`)
		progress.find('.progress-bar').html(`${value}%`)
	}

	function hideProgress() {
		progress.hide();
	}
}
if($('.videoMessage2').length){
	let browseFile2 = $('#browseFileSquare');
	let resumable2 = new Resumable({
		target: '/manager/bottemplates/message/upload/noticevideo',
		query:{_token: $('meta[name="csrf-token"]').attr('content')} ,// CSRF token
		fileType: ['mp4'],
		fileTypeErrorCallback: function(file, errorCount) {
			alert('Формат файла не поддерживается, загрузите пожалйста видео формата mp4');
		},
		maxFiles: 1,
		maxFileSize: 20 * 1024 * 1024,
		maxFileSizeErrorCallback:function(file, errorCount) {
			alert('Максимальный размер файла должен быть не более 20 мб');
		  },
		headers: {
			'Accept' : 'application/json'
		},
		testChunks: false,
		throttleProgressCallbacks: 1,
	});

	resumable2.assignBrowse(browseFile2[0]);

	resumable2.on('fileAdded', function (file) { // trigger when file picked
		showProgress();
		resumable2.upload() // to actually start uploading.
	});

	resumable2.on('fileProgress', function (file) { // trigger when file progress update
		updateProgress(Math.floor(file.progress() * 100));
	});

	resumable2.on('fileSuccess', function (file, response) { // trigger when file upload complete
		response = JSON.parse(response)
		$('#videomessagenotice').val(response.path);
		$('.progress-square').hide();
		$('.resVideoNotice').html('Успешно загружено');
	});

	resumable2.on('fileError', function (file, response) { // trigger when there is any error
		alert('Ошибка при загрузке видео')
	});


	let progress = $('.progress-square');
	function showProgress() {
		progress.find('.progress-bar').css('width', '0%');
		progress.find('.progress-bar').html('0%');
		progress.find('.progress-bar').removeClass('bg-success');
		progress.show();
	}

	function updateProgress(value) {
		progress.find('.progress-bar').css('width', `${value}%`)
		progress.find('.progress-bar').html(`${value}%`)
	}

	function hideProgress() {
		progress.hide();
	}
}

    $("body").on("click", ".createbut", function() {
        $('#itemid').val($(this).attr('data-item-id'));
        $('input[name="textbutton"]').val('');
        $('input[name="callback"]').val('');
        $('input[name="editiid"]').val('');
        $('.cre').val('Создать');
    });
    $("body").on("click", ".delmesel", function() {
		var el = $(this)
        var mediaElement = el.prev('video, img');
		var mediaSrc = mediaElement.attr('src');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: 'POST',
			url: '/manager/bottemplates/message/delete/file',
			data: {
				messageId: $('#mesid').html(),
				tip: el.attr('data-type-media'),
				file_url: mediaSrc,
				
			},
			success: function(html) {
				location.reload();

			},
			error: function(xhr) {
				$('.error').html('');
				$.each(xhr.responseJSON.errors, function(key, value) {
					$('.error').html(value);
				});
			}
		})
    });
    $("body").on("click", ".editbtn", function() {
        $('#itemid').val($(this).attr('data-item-id'));
        $('input[name="textbutton"]').val($(this).attr('data-item-text'));
        $('input[name="editiid"]').val($(this).attr('data-item-idbut'));
        let callback = $(this).attr('data-item-callback')
        if($(this).attr('data-item-type') == 2){
            $('input[name="callback"]').val(callback);
        }else{
            $('input[name="callback"]').val('');
            $('#optionBut option[value='+callback+']').prop('selected', true);
        }
        $('.cre').val('Сохранить');
        
    });
$("body").on("click", ".addstep", function() {

	$('#editstep').val(0);
	$('#videocurs').val('');
	$('#oldvideo').val('');
	$('#summernote').summernote('code', '');
	$('#videoPreview').attr('src', '');

});
$("body").on("click", ".openedit", function() {
	let parent = $(this).parents('.itemcourse').attr('id');
	let text = $('#'+parent+' .content').html();
	let video = $('#'+parent+' video').attr('src');
    let images = '';
    $('.gallery .row').empty();
    $('.imga').each(function(i, obj) {
        if(i == 0){
            images += $(obj).attr('src');
        }else{
            images += ','+$(obj).attr('src');
        }
        $('.gallery .row').append('<div class="col-2"><img src="'+$(obj).attr('src')+'" class="img-fluid"></div>')
    });
	$('#editstep').val(parent);
	$('#videocurs').val(video);
	$('#oldvideo').val(video);
	$('#gallery').val(images);
	$('#summernote').summernote('code', text);
	$('#videoPreview').attr('src', video);
	var myModal = new bootstrap.Modal(document.getElementById('bd-example-modal-lg'));
	myModal.show();

});

if ($('#summernote').length) {
	$('#summernote').summernote({
		lang: 'ru-RU',
		placeholder: 'Что хотите рассказать?',
		tabsize: 2,
		height: 150,
		toolbar:[
			['insert',['link']],
			['style',['bold','italic','underline']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['para', ['ul', 'ol']],
		],
		styleTags: [
			'p',
			'h4', 'h5', 'h6'
			],
	});
}
if ($('.settingtarif').length) {
	$('.settingtarif input:checkbox').click(function(){
        let del = 0;
        let tarifset = $(this).val();
        let tarif = $(this).attr('data-tarif');
        if ($(this).is(':checked')){
            
        } else {
            del = 1;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         $.ajax({
            type: 'post',
            url: '/manager/tarifs/set-tarif-setting',
            data: {
                tarif: tarif,
                tarifset: tarifset,
                delete: del,
            },
            success: function(data) {
                $('.alert').removeClass('d-none');
                $('.alert p').html(data);
                setTimeout(function () {
                    $('.alert').addClass('d-none');
                }, 1500);
            },
            error: function (xhr) {
                $.each(xhr.responseJSON.errors, function (index, value) {

                    $('.errors').append('<p>' + value[0] + '</p>');
                });
                
            }
        });
    });
}