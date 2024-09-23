// product vdieo
setInterval(function () {
    if (window.matchMedia("(max-width: 768px)").matches) {
        var v_h = $('.huzi-video-section .huzi-video .huzi-mob-img').height();
        $('.huzi-video-section .huzi-video').css('padding-bottom', v_h + 'px');
    } else {
        var v_h = $('.huzi-video-section .huzi-video .huzi-desk-img').height();
        $('.huzi-video-section .huzi-video').css('padding-bottom', v_h + 'px');
    }
}, 1000);
// HUZAIFA JS
$(".huzi-play-btn").click(function () {
    $(this).parent().find('iframe')[0].src += "?autoplay=1";
    $(this).parent().find('img').addClass('huzi-disable');
    $(this).addClass('huzi-disable');
});

// Brands Logos Slider
$('.logo-images').slick({
    infinite: true,
    speed: 300,
    autoplay: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: '<div class="amr-arrow-bg amr-arrow-left"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.41675 1.61108L1.41675 9.61108L9.41675 17.6111" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    nextArrow: '<div class="amr-arrow-bg amr-arrow-right"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 17.6111L9 9.61108L0.999999 1.61108" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    responsive: [
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 575,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 426,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// 3Ts Slider
$('.logo-images1').slick({
    infinite: true,
    speed: 300,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: '<div class="amr-arrow-bg amr-arrow-left"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.41675 1.61108L1.41675 9.61108L9.41675 17.6111" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    nextArrow: '<div class="amr-arrow-bg amr-arrow-right"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 17.6111L9 9.61108L0.999999 1.61108" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    responsive: [
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 426,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});
$('.logo-images2').slick({
    infinite: true,
    speed: 300,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: '<div class="amr-arrow-bg amr-arrow-left"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.41675 1.61108L1.41675 9.61108L9.41675 17.6111" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    nextArrow: '<div class="amr-arrow-bg amr-arrow-right"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 17.6111L9 9.61108L0.999999 1.61108" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    responsive: [
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 426,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});
$('.logo-images3').slick({
    infinite: true,
    speed: 300,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: '<div class="amr-arrow-bg amr-arrow-left"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.41675 1.61108L1.41675 9.61108L9.41675 17.6111" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    nextArrow: '<div class="amr-arrow-bg amr-arrow-right"><svg class="amr-arrows" width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 17.6111L9 9.61108L0.999999 1.61108" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
    responsive: [
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 426,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});



// accordion
$(".huzi-accordion-warp .huzi-ac-title").click(function () {
    if ($(this).next(".huzi-ac-body").hasClass("active")) {
        $(this).next(".huzi-ac-body").removeClass("active").slideUp();
        $(this).removeClass("active");
    } else {
        $(".huzi-accordion-warp .huzi-ac-title").removeClass("active");
        $(".huzi-ac-item .huzi-ac-body").removeClass("active").slideUp();
        $(this).next(".huzi-ac-body").addClass("active").slideDown();
        $(this).addClass("active");
    }
});

$(".huzi-accordion-warp.amr-accordion-wrap .huzi-ac-item:first-child .huzi-ac-title").addClass("active");
$(".huzi-accordion-warp.amr-accordion-wrap .huzi-ac-item:first-child .huzi-ac-body").slideDown().addClass("active");



// fitment
const modal = document.querySelector(".modal");
const trigger = document.querySelector(".trigger");
const closeButton = document.querySelector(".close-button");
function toggleModal() {
    modal.classList.toggle("show-modal");
}
function windowOnClick(event) {
    if (event.target === modal) {
        toggleModal();
    }
}
trigger.addEventListener("click", toggleModal);
closeButton.addEventListener("click", toggleModal);
window.addEventListener("click", windowOnClick);





// const modal_2 = document.querySelector(".model.bundle-modal");
// const trigger_2 = document.querySelector(".bundle-trigger");
// const closeButton_2 = document.querySelector(".close-button");
// function toggleModal_2() {
//   modal_2.classList.toggle("show-modal");
// }
// function windowOnClick_2(event) {
//   if (event.target === modal_2) {
//     toggleModal_2();
//   }
// }
// trigger_2.addEventListener("click", toggleModal_2);
// closeButton_2.addEventListener("click", toggleModal_2);
// window.addEventListener("click", windowOnClick_2);



// fitment test
$('#single_trigger_id').on("click", function () {


    var bundle_check = false;
    var temp___sku__;
    if (($('.kit-icon').text()) == "") {
        bundle_check = false;
        temp___sku__ = ($('.product_tem_sku__').text()).split(',');

        $("#test_fitment_id").css("background", "#fff");
        $("#test_fitment_id").css("border-color", "#fff");
        $("#test_fitment_id").css("color", "#045F68");
        $("#test_fitment_id").text('Check');
        $(".huzi-ac-body p").html(``);
        //     $("#fitment_sku_id option").text( $('.psgl-sku span').text()  );
        //     $("#fitment_sku_id option").val( $('.psgl-sku span').text() );
        $("#fitment_sku_id option").text(temp___sku__[0]);
        $("#fitment_sku_id option").val(temp___sku__[0]);
        / <!-- -->  /
        $("#fitment_year_id").html('<option value="" >Year</option>');
        $("#fitment_make_id").html('<option value="" >Make</option>');
        $("#fitment_model_id").html('<option value="" >Model</option>');
        / <!-- -->  /

        if (temp___sku__[0] != "") {
            $.ajax({
                url: "https://autooutletllc.com/miniapp_shopify/fitment_getData_with_sku.php",
                type: "POST",
                async: false,
                data: {
                    'getData_with_sku': 1,
                    'search_sku': temp___sku__[0]
                },
                success: function (data) {
                    var resp = JSON.parse(data);
                    var res_data = (resp.data);
                    var years___array = [];
                    var make___array = [];
                    var model___array = [];
                    if (resp.status == true) {
                        if (res_data != []) {
                            for (let index = 0; index < res_data.length; index++) {
                                years___array.push(res_data[index][1]);
                                make___array.push(res_data[index][2]);
                                model___array.push(res_data[index][3]);
                            }
                        }
                    }

                    years___array = [...new Set(years___array)];
                    make___array = [...new Set(make___array)];
                    model___array = [...new Set(model___array)];

                    for (let index = 0; index < years___array.length; index++) {
                        $("#fitment_year_id").append('<option value="' + years___array[index] + '">' + years___array[index] + '</option>');
                    }
                    for (let index = 0; index < make___array.length; index++) {
                        $("#fitment_make_id").append('<option value="' + make___array[index] + '">' + make___array[index] + '</option>');
                    }
                    for (let index = 0; index < model___array.length; index++) {
                        $("#fitment_model_id").append('<option value="' + model___array[index] + '">' + model___array[index] + '</option>');
                    }


                },
                error: function (e) {

                }
            });
        }

    } else if (($('.kit-icon').text()) == '  KIT  KIT') {
        bundle_check = true;
        temp___sku__ = (($('.product_tem_sku__').text()).split(',')).slice(0, -1);
    }
    //   $("#test_fitment_id").css("background","#fff");
    //   $("#test_fitment_id").css("border-color","#fff");
    //   $("#test_fitment_id").css("color","#045F68");
    //   $("#test_fitment_id").text('Check');
    //   $(".huzi-ac-body p").html(``);
    //   $("#fitment_sku_id option").text( $('.psgl-sku span').text()  );
    //   $("#fitment_sku_id option").val( $('.psgl-sku span').text() );
    //   / <!-- -->  /
    //   $("#fitment_year_id").html('<option value="" >Year</option>');
    //   $("#fitment_model_id").html('<option value="" >Model</option>');
    //   / <!-- -->  /

    //   var temp___tags = null;
    //   jQuery.getJSON(window.Shopify.routes.root + 'products/'+ (window.location.pathname).split("/")[ (window.location.pathname).split("/").length  - 1  ] +'.js', function(product) {
    //     // console.log(product);
    //     temp___tags = product.tags;
    //     // $('.psgl-sku span').text();
    //     var str = temp___tags;
    //     var years___ = null;
    //     years___ = str.filter(item=>!isNaN(parseInt(item)));
    //     // console.log( years___ );
    //     var model___ = null;
    //     model___ = temp___tags.filter(function(obj) { return years___.indexOf(obj) == -1; });
    //     // console.log(model___);
    //     for (let index = 0; index < years___.length; index++) {
    //       $("#fitment_year_id").append('<option value="'+ years___[index] +'">'+ years___[index] +'</option>');                    
    //     }
    //     for (let index = 0; index < model___.length; index++) {
    //       $("#fitment_model_id").append('<option value="'+ model___[index] +'">'+ model___[index] +'</option>');                    
    //     }

    //   });
});
// $('.fitment .trigger').on("click", function() {
//   $("#fitment_sku_id option").text($('.psgl-sku span').text());
//   $("#fitment_sku_id option").val($('.psgl-sku span').text());
//   /* <!-- -->  */
//   $("#fitment_year_id").html('<option value="" >Year</option>');
//   $("#fitment_model_id").html('<option value="" >Model</option>');
//   /* <!-- -->  */
//   var temp___car_companies_name = ["daihatsu","dodge","donkervoort","ds","ferrari","fiat","fisker","ford","honda","hummer","hyundai","infiniti","iveco","jaguar","jeep","kia","ktm","lada","lamborghini","lancia","land rover","landwind","lexus","lotus","maserati","maybach","mazda","mclaren","mercedes-benz","mg","mini","mitsubishi","morgan","nissan","opel","peugeot","porsche","renault","rolls-royce","rover","saab","seat","skoda","smart","ssangyong","subaru","suzuki","tesla","toyota","volkswagen","volvo","audi","bmw","buick","cadillac","chevrolet","chrysler","gm","gem","gmc","isuzu","lincoln","mercury","oldsmobile","pontiac","regal","saturn"];
//   var temp___tags = null;
//   jQuery.getJSON(window.Shopify.routes.root + 'products/' + (window.location.pathname).split("/")[(window.location.pathname).split("/").length - 1] + '.js', function(product) {
//     // console.log(product);
//     temp___tags = product.tags;
//     // $('.psgl-sku span').text();
//     var str = temp___tags;
//     var years___ = null;
//     var model_type___ = [];
//     years___ = str.filter(item => !isNaN(parseInt(item)));
//     // console.log( years___ );
//     var model___ = null;
//     model___ = temp___tags.filter(function(obj) {
//       return years___.indexOf(obj) == -1;
//     });
//     // console.log(model___);
//     for (let index = 0; index < years___.length; index++) {
//       $("#fitment_year_id").append('<option value="' + years___[index] + '">' + years___[index] + '</option>');
//     }
//     for (let index = 0; index < model___.length; index++) {
//       // const found = temp___car_companies_name.find(element => element == (model___[index]).toLowerCase() );
//       const match = temp___car_companies_name.find(element => {
//         if (  ((model___[index]).toLowerCase()).includes( element )  ) {
//           $("#fitment_model_id").append('<option value="' + model___[index] + '">' + model___[index] + '</option>');
//         }
//       });
//     }
//     for (let index = 0; index < model___.length; index++) {
//       const found = temp___car_companies_name.find(element => element == (model___[index]).toLowerCase() );
//       if (found == null) {
//         model_type___.push(model___[index]);
//       }
//     }
//     //                 console.log(model_type___);

//   }); 
// });


$("#test_fitment_id").on('click', function () {
    if ($("#fitment_sku_id").val() != "" && $("#fitment_year_id").val() != "" && $("#fitment_model_id").val() != "") {
        // console.log("Pass...");
        $.ajax({
            url: "https://autooutletllc.com/miniapp_shopify/fitment_test_process.php",
            type: "post",
            data: {
                sku_: $("#fitment_sku_id").val(),
                year_: $("#fitment_year_id").val(),
                make_: $("#fitment_make_id").val(),
                model_: $("#fitment_model_id").val()
            },
            success: function (response) {
                var resp = JSON.parse(response);
                //         console.log(resp);
                if (resp.status == true) {
                    $("#test_fitment_id").css("background", "#108f10");
                    $("#test_fitment_id").css("border-color", "#108f10");
                    $("#test_fitment_id").css("color", "#fff");
                    $("#test_fitment_id").text('Verified');
                    $(".huzi-ac-body p").html(`<b>Fitment Result :: </b>` + resp.data.note + `.`);
                } else {
                    $("#test_fitment_id").css("background", "#f00");
                    $("#test_fitment_id").css("border-color", "#f00");
                    $("#test_fitment_id").css("color", "#fff");
                    $("#test_fitment_id").text('Failed');
                    $(".huzi-ac-body p").html(``);
                    $(".huzi-ac-body p").html(`<b>Fitment Result :: </b>No Related data Found! .<br>`);
                }

                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
});

$("#fitment_year_id , #fitment_model_id").on('change', function () {
    $("#test_fitment_id").css("background", "#fff");
    $("#test_fitment_id").css("border-color", "#fff");
    $("#test_fitment_id").css("color", "#045F68");
    $("#test_fitment_id").text('Check');
    $(".huzi-ac-body p").html(``);
});


// bundle fitment 

$('#bundle-trigger___id').on("click", function () {
    $(".test-fitment_test____").css("background", "#045F68");
    $(".test-fitment_test____").css("border-color", "#045F68");
    $(".test-fitment_test____").css("color", "#fff");
    $(".test-fitment_test____").text('Check');
    $(".huzi-ac-body p").html(``);
    $(".fitment_year_").html('<option value="" >Year</option>');
    $(".fitment_make_").html('<option value="" >Make</option>');
    $(".fitment_model_").html('<option value="" >Model</option>');

    var leng = $(".fitment-input.fitment_sku_").length;
    for (let sku_i = 0; sku_i < leng; sku_i++) {
        var temp_sku = $($(".fitment-input.fitment_sku_")[sku_i]).val();
        var temp___tags = null;
        // console.log(temp___tags);

        if (temp_sku != "") {
            $.ajax({
                url: "https://autooutletllc.com/miniapp_shopify/fitment_getData_with_sku.php",
                type: "POST",
                async: false,
                data: {
                    'getData_with_sku': 1,
                    'search_sku': temp_sku
                },
                success: function (data) {
                    var resp = JSON.parse(data);
                    var res_data = (resp.data);
                    var years___array = [];
                    var make___array = [];
                    var model___array = [];
                    if (resp.status == true) {
                        if (res_data != []) {
                            for (let index = 0; index < res_data.length; index++) {
                                years___array.push(res_data[index][1]);
                                make___array.push(res_data[index][2]);
                                model___array.push(res_data[index][3]);
                            }
                        }
                    }

                    years___array = [...new Set(years___array)];
                    make___array = [...new Set(make___array)];
                    model___array = [...new Set(model___array)];

                    for (let index = 0; index < years___array.length; index++) {
                        $($(".fitment_year_")[sku_i]).append('<option value="' + years___array[index] + '">' + years___array[index] + '</option>');
                    }
                    for (let index = 0; index < make___array.length; index++) {
                        $($(".fitment_make_")[sku_i]).append('<option value="' + make___array[index] + '">' + make___array[index] + '</option>');
                    }
                    for (let index = 0; index < model___array.length; index++) {
                        $($(".fitment_model_")[sku_i]).append('<option value="' + model___array[index] + '">' + model___array[index] + '</option>');

                    }

                },
                error: function (e) {

                }
            });
        }
    }
});


$(".test-fitment_test____").on('click', function () {
    $(".huzi-ac-body p").html(`<b>Fitment Result :: </b>`);
    var it____self = $(this);
    var sku_____ = $(this).parent().find(".fitment-input.fitment_sku_").val();
    var year_____ = $(this).parent().find(".fitment-input.fitment_year_").val();
    var make_____ = $(this).parent().find(".fitment-input.fitment_make_").val();
    var model_____ = $(this).parent().find(".fitment-input.fitment_model_").val();


    if (sku_____ != "" && year_____ != "" && model_____ != "" && make_____ != "") {

        $.ajax({
            url: "https://autooutletllc.com/miniapp_shopify/fitment_test_process.php",
            type: "post",
            data: {
                sku_: sku_____,
                year_: year_____,
                make_: make_____,
                model_: model_____
            },
            success: function (response) {
                var resp = JSON.parse(response);
                console.log(resp);
                if (resp.status == true) {
                    it____self.css("background", "#108f10");
                    it____self.css("border-color", "#108f10");
                    it____self.css("color", "#fff");
                    it____self.text('Verified');
                    $(".huzi-ac-body p").html($(".huzi-ac-body p").html() + `<br><b>` + resp.data.part_no + ` :: </b><br>` + resp.data.note + `.`);
                } else {
                    it____self.css("background", "#f00");
                    it____self.css("border-color", "#f00");
                    it____self.css("color", "#fff");
                    it____self.text('Failed');
                    $(".huzi-ac-body p").html(``);
                    $(".huzi-ac-body p").html(`<b>Fitment Result :: </b>No Related data Found! .<br>`);
                }

                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
});


$(".fitment-input.fitment_year_ , .fitment-input.fitment_model_").on('change', function () {
    var test_button______ = $(this).parent().parent().find("button");
    test_button______.css("background", "#045F68");
    test_button______.css("border-color", "#045F68");
    test_button______.css("color", "#fff");
    test_button______.text('Check');
    $(".huzi-ac-body p").html(``);
});


$(document).ready(function () {
    var bundle_check = false;
    var temp___sku__;
    if (($('.kit-icon').text()) == "") {
        bundle_check = false;
        temp___sku__ = ($('.product_tem_sku__').text()).split(',');
    } else if (($('.kit-icon').text()) == '  KIT  KIT') {
        bundle_check = true;
        temp___sku__ = (($('.product_tem_sku__').text()).split(',')).slice(0, -1);
    }

    $.ajax({
        url: "https://autooutletllc.com/miniapp_shopify/fitment_dataTable_process.php",
        type: "post",
        async: false,
        data: {
            sku___: temp___sku__,
            get__table_data: 'getData',
            is_bundle: bundle_check
        },
        success: function (response) {
            var resp = JSON.parse(response);
            //       console.log(resp);
            if (resp.status == true) {
                console.log(resp.data);
                var html__tr_data = '';
                if (resp.data.length > 0) {
                    for (let index = 0; index < resp.data.length; index++) {
                        var t_data = resp.data[index];
                        html__tr_data += '<tr>';
                        html__tr_data += '<td>' + t_data['year'] + '</td>';
                        html__tr_data += '<td>' + t_data['make_id'] + '</td>';
                        html__tr_data += '<td>' + t_data['model_id'] + '</td>';
                        html__tr_data += '<td>' + t_data['note'] + '</td>';
                        html__tr_data += '</tr>';
                    }
                }
                $("#fitment_data_table-id tbody").html("" + html__tr_data + "");
                $("#fitment_data_table_bundle-id tbody").html("" + html__tr_data + "");

            } else {

            }
            // You will get response from your PHP page (what you echo or print)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});
