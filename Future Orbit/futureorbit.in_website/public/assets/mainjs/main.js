$(document).ready(function () {
    $('form[data-toggle="submit"]').find('button[type="submit"]').removeAttr('disabled');
});

function show_toaster (attr) {
    toastr.remove();
    let duration = attr.duration ? attr.duration : "3000";

    toastr.options = {
        closeButton       : false,
        newestOnTop       : true,
        progressBar       : true,
        positionClass     : "toast-top-right",
        preventDuplicates : false,
        showDuration      : "300",
        hideDuration      : duration,
        timeOut           : duration,
        extendedTimeOut   : duration,
        showEasing        : "swing",
        hideEasing        : "linear",
        showMethod        : "fadeIn",
        hideMethod        : "fadeOut",
        tapToDismiss      : false,
    }

}

$(document).on('submit', 'form[data-toggle="submit"]', function (e) {
    e.preventDefault();
    let form = $(this);
    let submit_btn = form.find('button[type=submit]');
    let formData = new FormData(this);
    submit_btn.attr('disabled','disabled').addClass('loading');
   
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: form.attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function (response) {
            submit_btn.removeAttr('disabled').removeClass('loading');
            if ((response.status == 'success')) {
             
                toastr.success(response.msg);
            }
            else {
                printErrorMsg(response.error);

            }

        
        },
        error: function (jqXHR) {
            // ajax_error_toaster (jqXHR);
            submit_btn.removeAttr('disabled').removeClass('loading');
        }
    });
});

function printErrorMsg(msg) {
    $.each(msg, function (key, value) {
        $('#' + key + '_err').attr('class',' mdi mdi-check-circle-outline text-danger').text(value);

    });

    $('input').on('keyup', function () {
        var key = $(this).attr('name');

        if ($(this).val() === '') {
            $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
        } else {
            $('#' + key + '_err').hide();
        }
    })
    $('textarea').on('keyup', function () {
        var key = $(this).attr('name');
        if ($(this).val() === '') {
            $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
        } else {
            $('#' + key + '_err').hide();
        }
    })

    $('select').on('click', function () {
        var key = $(this).attr('name');
        //  alert(key);
        if ($(this).val() === '') {
            $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
        } else {
            $('#' + key + '_err').hide();
        }
    })
}

//dynamic dependent dropdown code on contact us page

$(document).on('change', 'select[name="classname"]', function () {
   
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
        }
    });
    var lms_course_id = this.value;
   var urlroute= $('#routeurl').val()
 
    console.log(lms_course_id);
   if(lms_course_id!=' '){
$.ajax({
  
    url:urlroute,
    data: {
        course_id:lms_course_id
    },

    success: function (response) {
   
        $('#course').html('<option value="">-- Select Option --</option>');
        $.each(response.fetchcourses, function (key, value) {
            $("#course").append('<option value="' + value
                .lms_course_id + '">' + value.lms_child_course_name + '</option>');
        });
    
    },

});
   }
   else{
    $('#course').html('<option value="">-- Select Option --</option>');
   }

});

    $(function () {
            $('#primaryphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
