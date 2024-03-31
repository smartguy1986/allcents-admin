/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var base_url = $('head base').attr('href');

function formValidate(x) {
    // alert('submitted');
    $('.field-error').remove();
    var value = ''
    var id;
    var name = '';
    var error_html = '';
    var error_text;
    var flag = '1';
    //var label_text = '';


    $(".text-r").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error');
        //console.log(value);
        if (value.trim() == '') {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });



    $(".text-ph").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();

        error_text = $(this).attr('data-error2');
        //console.log(value);
        var phone_pattern = /^[0-9]*$/;
        if (phone_pattern.test(value) == false) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });

    // $(".text-ph-n").each(function() {
    //     value = $(this).val();
    //     //name = $(this).attr('name');
    //     //label_text = $(this).next('label').children('span').html();

    //     error_text = $(this).attr('data-error3');
    //     error_text2 = $(this).attr('data-error4');
    //     //console.log(value);
    //     if (value.trim() == '') {
    //         flag = '0';
    //         //$(this).next('label').attr('style', 'border-color: #ff0000');
    //         error_html = '<span class="field-error">'+ error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //         //textarea.text-active + label{border-color: #f18a21;}
    //     }
    //     else
    //     {
    //         $.ajax({
    //             url: 'http://sanganayi.webtecs.co.uk/signup/checkphone',
    //             data: ({ phone: value }),
    //             type: 'post',
    //             success: function(data) {
    //                 console.log(data);
    //                 if(data == 'exist')
    //                 {
    //                     flag = '0';
    //                     //$(this).next('label').attr('style', 'border-color: #ff0000');
    //                     $(".field-error2").show();
    //                 }
    //             }             
    //         });
    //     }
    // });
    // $(".text-ph2").each(function() {
    //     value = $(this).val();

    //     error_text = $(this).attr('data-error2');
    //     var phone_pattern = /^[0-9]*$/;
    //     if (phone_pattern.test(value) == false)
    //     {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    // });
    $(".text-em").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        //console.log(value);
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (reg.test(value) == false) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });


    $(".text-ar").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        //console.log(value);
        //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (value.length < 1) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });
    $(".text-dr").each(function () {
        error_text = $(this).attr('data-error2');
        //console.log(value);

        if ($(".text-dr option:selected").index() <= 0) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    // $(".text-dr2").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr2 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    //     else
    //     {
    //         flag = '1';
    //     }
    // });


    // $(".text-dr3").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr3 option:selected").index() <= 0) {

    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    //     else
    //     {
    //         flag = '1';
    //     }
    // });

    // $(".text-dr4").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr4 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    //     else
    //     {
    //         flag = '1';
    //     }

    // });

    // $(".text-dr5").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr5 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr6").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr6 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr7").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr7 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr8").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr8 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr9").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr9 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr10").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr10 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-dr11").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     if ($(".text-dr11 option:selected").index() <= 0) {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }

    // });

    // $(".text-num").each(function() {
    //     value = $(this).val();
    //     //name = $(this).attr('name');
    //     //label_text = $(this).next('label').children('span').html();
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);
    //     //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    //     if (!isNaN(value))
    //     {

    //     } else {
    //         flag = '0';
    //         //$(this).next('label').attr('style', 'border-color: #ff0000');
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //         //textarea.text-active + label{border-color: #f18a21;}
    //     }

    // });

    // $(".text-chk").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     var count_checked = $("[name='jobinterest[]']:checked").length; // count the checked rows
    //     if (count_checked == 0)
    //     {
    //         flag = '0';
    //         $('#interest-error').show();
    //     }
    //     var count_checked = $("[name='studyinterest[]']:checked").length; // count the checked rows
    //     if (count_checked == 0) {
    //         flag = '0';
    //         $('#interest-error').show();

    //     }
    // });

    // $(".text-chk2").each(function() {
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);

    //     var count_checked = $("[name='interest[]']:checked").length; // count the checked rows
    //     if (count_checked == 0)
    //     {
    //         flag = '0';
    //         $('#interest-error').show();
    //     }
    // });

    // $(".g-recaptcha").each(function() {
    //     value = $(this).val();
    //     //name = $(this).attr('name');
    //     //label_text = $(this).next('label').children('span').html();
    //     error_text = $(this).attr('data-error2');
    //     //console.log(value);
    //     //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    //     if (grecaptcha.getResponse() == "") {
    //         flag = '0';
    //         //$(this).next('label').attr('style', 'border-color: #ff0000');
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    // });

    // $(".social").each(function() {
    //     var facebook = document.getElementById('facebook').value;
    //     var twitter = document.getElementById('twitter').value;
    //     var google = document.getElementById('google').value;
    //     var linkedin = document.getElementById('linkedin').value;

    //     if (facebook == "" && twitter == "" && google == "" && linkedin == "")
    //     {
    //         $('#social-error').show();
    //         flag = '0';
    //     }
    // });

    // $(".social2").each(function() {
    //     var facebook = document.getElementById('facebook').value;
    //     var twitter = document.getElementById('twitter').value;
    //     var google = document.getElementById('google').value;
    //     var linkedin = document.getElementById('linkedin').value;
    //     var website = document.getElementById('website').value;

    //     if (facebook == "" && twitter == "" && google == "" && linkedin == "" && website == "")
    //     {
    //         $('#social-error2').show();
    //         flag = '0';
    //     }
    //     else
    //     {
    //         $('#social-error2').hide();
    //     }
    // });

    //alert(x);
    if (flag == '1') {
        if (x == '5') {
            var r = confirm('Have you checked all the job details and are happy to make it live ?');
        }
        if (x == '4') {
            var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        }
        if (x == '2') {
            var r = confirm('Make sure you are happy with all the information you have provided before submitting.');
        }
        if (x == '3') {
            var r = confirm('Please ensure you have reviewed all your information and are happy to submit it.');
        }

        if (x == '0') {
            var r = true;
        }

        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }
}

function formValidateTopic() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-topic").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-dr-topic").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error2');
        console.log(value);
        if (value.length < 1) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-ar-topic").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        console.log(value);
        //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (value == '' || value == null) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidateNotice() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-topic").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-dr-topic").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error2');
        console.log(value);
        if (value.length < 1) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-ar-topic").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        console.log(value);
        //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (value == '' || value == null) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidateUpdateTopic() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-topic2").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-dr-topic2").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error2');
        console.log(value);
        if (value.length < 1) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-ar-topic2").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        //console.log(value);
        //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (value.length < 1) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidateUpdateNotice() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-topic2").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-dr-topic2").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error2');
        console.log(value);
        if (value.length < 1) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-ar-topic2").each(function () {
        value = $(this).val();
        //name = $(this).attr('name');
        //label_text = $(this).next('label').children('span').html();
        error_text = $(this).attr('data-error2');
        //console.log(value);
        //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (value.length < 1) {
            flag = '0';
            //$(this).next('label').attr('style', 'border-color: #ff0000');
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
            //textarea.text-active + label{border-color: #f18a21;}
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidatecat() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-cat").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidatenotcat() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    // $(".text-val-notcat").each(function () {
    //     value = $(this).val();
    //     error_text = $(this).attr('data-error');
    //     console.log(value);
    //     if (value.trim() == '') {
    //         flag = '0';
    //         error_html = '<span class="field-error">' + error_text + '</span>';
    //         $(this).next('label').after(error_html);
    //     }
    // });

    $(".text-val-notice-cat").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    console.log(flag);
    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidatebranch() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-branch").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

function formValidatecell() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-cell").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}


function formValidatesubcat() {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-subcat").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    if (flag == '0') {
        return false;
    }
    else {
        var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
}