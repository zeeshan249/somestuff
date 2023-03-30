@extends('Frontend.Layouts.frontendlayout')
@section('content')
<div class="page-title">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <h2 class="ipt-title">Contact Us</h2>
          

         </div>
      </div>
   </div>
</div>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Agency List Start ================================== -->
<section>

   <div class="container">

      <!-- row Start -->
      <div class="row">

         <div class="col-lg-7 col-md-7">
             <form  id="contact" method="POST" action="{{ route('contactenquiry') }}">
                 @csrf
            <div class="row">

               <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                     <label>Name</label>
                     <input type="text" class="form-control simple"  name="name">
                      <i class="mdi mdi-check-circle-outline" id="name_err"></i>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                     <label>Email</label>
                     <input type="email" class="form-control simple"  name="email">
                      <i class="mdi mdi-check-circle-outline" id="email_err"></i>
                  </div>
               </div>
            </div>

            <div class="form-group">
               <label>Subject</label>
               <input type="text" class="form-control simple"  name="subject">
                <i class="mdi mdi-check-circle-outline" id="subject_err"></i>
            </div>

            <div class="form-group">
               <label>Message</label>
               <textarea class="form-control simple" name="message"></textarea>
                <i class="mdi mdi-check-circle-outline" id="message_err"></i>
            </div>

            <div class="form-group">
               <button id="btn_reg" type="submit" class="btn btn-theme-light-2 rounded" type="submit">Submit Request</button>
            </div>
             </form>
         </div>

         <div class="col-lg-5 col-md-5">
            <div class="contact-info">

               <h2>Get In Touch</h2>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

               <div class="cn-info-detail">
                  <div class="cn-info-icon">
                     <i class="ti-home"></i>
                  </div>
                  <div class="cn-info-content">
                     <h4 class="cn-info-title">Reach Us</h4>
                     2512, New Market,<br>Eliza Road, Sincher 80 CA,<br>Canada, USA
                  </div>
               </div>

               <div class="cn-info-detail">
                  <div class="cn-info-icon">
                     <i class="ti-email"></i>
                  </div>
                  <div class="cn-info-content">
                     <h4 class="cn-info-title">Drop A Mail</h4>
                     support@Rikada.com<br>Rikada@gmail.com
                  </div>
               </div>

               <div class="cn-info-detail">
                  <div class="cn-info-icon">
                     <i class="ti-mobile"></i>
                  </div>
                  <div class="cn-info-content">
                     <h4 class="cn-info-title">Call Us</h4>
                     (41) 123 521 458<br>+91 235 548 7548
                  </div>
               </div>

            </div>
         </div>

      </div>
      <!-- /row -->

   </div>

</section>
<!-- ============================ Agency List End ================================== -->
<script>
    $(document).ready(function() {
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': false,
            'progressBar': true,
            'preventDuplicates': false,
            'showDuration': '6000',
            'hideDuration': '6000',
            'timeOut': '1500',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        } });
</script>
<script>

    $(document).on('submit', '#contact', function (e) {
        e.preventDefault();
        let form = $(this);
        let submit_btn = form.find('button[type=submit]');
        let formData = new FormData(this);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: form.attr('action'),
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function (){
                $('#btn_reg').html('Processing...');
            },
            success: function (response) {
                if ((response.status == 'success')) {
                    $('#contact')[0].reset();
                    toastr.success(response.msg);
                }
                else {
                    printErrorMsg(response.error);

                }
            },
            complete:function (data){
                $('#btn_reg').html('Submit Request');
            },

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
    }
</script>
<!-- ============================ Call To Action ================================== -->

@endsection
