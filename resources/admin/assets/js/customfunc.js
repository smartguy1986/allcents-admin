var base_url = $('head base').attr('href');

$(document).ready(function () {
    setTimeout(function () {
        $('.alert').hide('slow');
    }, 5000);
});

$(document).ready(function () {
    $('#comingsoon').on('click', function () {
        $('comingsoonModal').modal('show');
    });
});
// $('#deleteModal').on('show.bs.modal', function (event) {
//     console.log('modal open');
//     var myValid = $(event.relatedTarget).data('deletelink');
//     var mytext = $(event.relatedTarget).data('deletetext');
//     //alert(myVal);
//     $("#confirmBtndel").attr("href", myValid);
//     $("#deletetext").text(mytext);
// });

function checkmycredentials() {

    //var form = $('#adminLoginform').serializeArray();

    var adminemail = $('#inputEmailAddress').val();
    var adminpass = $('#inputChoosePassword').val();

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(adminemail)) {
        alert('Please provide a valid email address');
        $('#inputEmailAddress').focus();
        return false;
    }
    else {
        $.ajax({
            type: "POST",
            url: base_url + 'AdminController/checkcredentialsAdmin',
            data: { adminemail: adminemail, adminpass: adminpass },
            success: function (data) {
                //alert(data);
                if (data == 'success') {
                    window.location.replace(base_url + 'dashboard/');
                }
                if (data == 'fail') {
                    $('#result-data').html('<br><span class="field-error">Incorrect Username or Password! Please try again. If you are an User, you dont have access to Dashboard.</span>');
                }
            },
            error: function (err) {
                $('#result-data').html(err);
            }
        });
    }
    return false;
}

function editmyprovince(x) {
    // alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'region/getregiondetails',
        data: { rid: x },
        success: function (data) {
            $('#editRegionModal').modal('show');
            $('#editregion').html(data);
        },
        error: function (err) {
            $('#editRegionModal').modal('show');
            $('#editregion').html(err);
        }
    });
}

function editmycity(x, y) {
    // alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'region/getcitydetails',
        data: { cid: x, rid: y },
        success: function (data) {
            $('#editCityModal').modal('show');
            $('#editcity').html(data);
        },
        error: function (err) {
            $('#editCityModal').modal('show');
            $('#editcity').html(err);
        }
    });
}

function editmycategory(x) {
    // alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'categories/getcategorydetails',
        data: { cid: x },
        success: function (data) {
            $('#editCategoryModal').modal('show');
            $('#editcategory').html(data);
        },
        error: function (err) {
            $('#editcategoryModal').modal('show');
            $('#editcategory').html(err);
        }
    });
}

function editmysubcategory(x, y) {
    // alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'categories/getsubcategorydetails',
        data: { sid: x, cid: y },
        success: function (data) {
            $('#editSubCategoryModal').modal('show');
            $('#editsubcategory').html(data);
        },
        error: function (err) {
            $('#editSubCategoryModal').modal('show');
            $('#editsubcategory').html(err);
        }
    });
}

function viewmyarticle(x) {
    //alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'events/getarticle',
        data: { aid: x },
        success: function (data) {
            var response = $.parseJSON(data);
            $('#articleModal').modal('show');
            $('#articletitle').html(response.title);
            $('#articlecontent').html('<strong>English :</strong>' + response.topic_content + '<br>');
        },
        error: function (err) {
            $('#articleModal').modal('show');
            $('#articlecontent').html(err);
        }
    });
}

function fetchMyProvince(country) {
    // alert(country);
    $.ajax({
        type: "POST",
        url: base_url + 'users/getprovince',
        data: { cid: country },
        success: function (data) {
            $('#inputuserprovince').find('option').remove().end().append(data);
            $('#inputuserdistricts').find('option').remove().end().append("<option value=''>Select District</option>");
        },
        error: function (err) {
            $('#show_province').html("<div class='col-md-6'>No Provinces available for this country.</div>");
        }
    });
}

function fetchMyDistrict(province) {
    // alert(province);
    // var selectedText = $("#inputuserdistricts").find("option:selected").text();
    $.ajax({
        type: "POST",
        url: base_url + 'users/getdistrict',
        data: { pname: province },
        success: function (data) {
            $('#inputuserdistricts').find('option').remove().end().append(data);
        },
        error: function (err) {
            $('#show_district').html("<div class='col-md-6'>No districts available for this province.</div>");
        }
    });
}

function getMyAPIData(x) {
    // alert(x);
    $.ajax({
        type: "POST",
        url: base_url + 'dashboard/getapidata',
        data: { aid: x },
        success: function (data) {
            $('#apiresp').html(data);
        },
        error: function (err) {
            $('#apiresp').html("<div class='col-md-6'>No data available for this API.</div>");
        }
    });
    return false;
}


function formValidateUser(x) {
    //alert('submitted');

    $('.field-error').remove();
    var value = '';
    var error_html = '';
    var error_text;
    var flag = '1';

    $(".text-val-user").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error');
        console.log(value);
        if (value.trim() == '') {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-dr-user").each(function () {
        value = $(this).val();
        error_text = $(this).attr('data-error2');
        console.log(value);
        if (value.length < 1) {
            flag = '0';
            error_html = '<span class="field-error">' + error_text + '</span>';
            $(this).next('label').after(error_html);
        }
    });

    $(".text-em-user").each(function () {
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

    $(".text-ar-user").each(function () {
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