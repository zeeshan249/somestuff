<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Home</title>

    <!-- Custom CSS -->
    <link href="{{url('/')}}/public/assets/frontend/css/styles.css" rel="stylesheet">

    <!-- Custom Color Option -->
    <link href="{{url('/')}}/public/assets/frontend/css/colors.css" rel="stylesheet">
    <script src="{{url('/')}}/public/assets/frontend/js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    input[required] + label:after {
    content:'*';
    color: red;
}
</style>
</head>

<body class=" blog-page blue-skin">

<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div id="preloader"><div class="preloader"><span></span><span></span></div></div>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <!-- Start Navigation -->
    <div class="header header-light head-shadow">
        <div class="container">
            <nav id="navigation" class="navigation navigation-landscape">
                <div class="nav-header">
                    <a class="nav-brand" href="#">
                        <img src="{{url('/')}}/assets/frontend/img/logo.png" class="logo" alt="" />
                    </a>
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper" style="transition-property: none;">
                    <ul class="nav-menu">

                        <li class="{{ Request::is('index') ? 'active' : '' }}" ><a href="{{route('index')}}">Home<span class="submenu-indicator"></span></a></li>
                        <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{route('about')}}">About<span class="submenu-indicator"></span></a></li>

                        <li class="{{ Request::is('property-list') ? 'active' : '' }}"><a href="{{route('propertylist')}}">Property<span class="submenu-indicator"></span></a>

                        </li>

                        <li class="{{ Request::is('blogs') ? 'active' : '' }}"><a href="{{route('blogs')}}">Blog<span class="submenu-indicator"></span></a></li>

                        <li class="{{ Request::is('agents') ? 'active' : '' }}"><a href="{{route('agents')}}">Agents<span class="submenu-indicator"></span></a></li>

                        <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{route('contact')}}">Contact<span class="submenu-indicator"></span></a></li>

                        <li><a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#signup">Sign Up</a></li>

                    </ul>

                    <ul class="nav-menu nav-menu-social align-to-right">
                        <li class="add-listing light">
                            <a href="{{url('https://peadminuat.dreamplesk.com/')}}"  class="text-success">
                                <i class="fas fa-user-circle mr-2"></i>Signin</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="modal fade signup" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content" id="sign-up">
                <span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
                <div class="modal-body">
                    <h4 class="modal-header-title">Sign Up</h4>
                    <h4 style="font-size: xx-large;
    display: flex;
    justify-content: center;">In order to Enter A Property Listing</h4>
                    <div class="login-form">
                        <form  id="signupform" method="POST" action="{{ route('signup') }}">
                            @csrf
                            <div class="row">

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">

                                        <div class="input-with-icon">
                                           
                                            <input type="text" class="form-control" name="firstname" id="fname" placeholder="First Name *">
                                          
                                            <i class="ti-user"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="firstname_err"></i>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="text" class="form-control" name="lastname" placeholder="Last Name *">
                                            <i class="ti-user"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="lastname_err"></i>
                                    </div>
                                 </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="email" class="form-control" name="user_email" placeholder="Email *">
                                            <i class="ti-email"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="user_email_err"></i>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="text" class="form-control" name="nickname" placeholder="nickname">
                                            <i class="ti-email"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="user_email_err"></i>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="text" class="form-control" name="sec_phone" id="secondaryphone" maxlength="12" placeholder="Secondary Phone">
                                            <i class="lni-phone-handset"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id=""></i>
                                    </div>
                                </div>

                                <!-- <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <select name="birth_month"  class="form-select">
                                                <option value="">Select Birth Month *</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>

                                            </select>
                                          
                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="birth_month_err"></i>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                        <select name="birth_date"  class="form-select">
                                                <option value="">Select Birth Date *</option>
                                                
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>


                                            </select>
                                           
                                         </div>
                                         <i class="mdi mdi-check-circle-outline" id="birth_date_err"></i>
                                    </div>
                                </div> -->

                                {{--                            <div class="col-lg-6 col-md-6">--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <div class="input-with-icon">--}}
                                {{--                                        <input type="text" class="form-control" placeholder="Username">--}}
                                {{--                                        <i class="ti-user"></i>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="password" name="password" class="form-control" placeholder="password *">
                                            <i class="ti-unlock"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="password_err"></i>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="text" name="phone1" id="primaryphone" maxlength="12" class="form-control" placeholder="Primary Phone *">
                                            <i class="lni-phone-handset"></i>

                                        </div>
                                        <i class="mdi mdi-check-circle-outline" id="phone1_err"></i>
                                    </div>
                                </div>
                                @php
                                    $role=DB::table('roles')->where('is_role_active',1)
                                   ->where('user_display_role',1)
                                   ->get();
                                @endphp
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <select class="form-control" name="role">
                                                @foreach($role as $name)
                                                    <option value="{{$name->id}}">{{$name->name}}</option>

                                                @endforeach
                                            </select>
                                            <i class="ti-briefcase"></i>
                                            <i class="mdi mdi-check-circle-outline" id="role_err"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <button id="btn_reg22" type="submit" class="btn btn-md full-width btn-theme-light-2 rounded">Sign Up</button>
                            </div>

                        </form>
                    </div>
                    {{--                <div class="modal-divider"><span>Or login via</span></div>--}}
                    {{--                <div class="social-login mb-3">--}}
                    {{--                    <ul>--}}
                    {{--                        <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>--}}
                    {{--                        <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Google+</a></li>--}}
                    {{--                    </ul>--}}
                    {{--                </div>--}}
                    <div class="text-center">
                        <p class="mt-5"><i class="ti-user mr-1"></i>Already Have An Account? <a href="{{url('https://peadmin.dreamplesk.com')}}" class="link">Go For LogIn</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Navigation -->
    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content" id="registermodal">
                <span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
                <div class="modal-body">
                    <h4 class="modal-header-title">Log In</h4>
                    <div class="login-form">
                        <form>

                            <div class="form-group">
                                <label>User Name</label>
                                <div class="input-with-icon">
                                    <input type="text" class="form-control" placeholder="Username">
                                    <i class="ti-user"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-with-icon">
                                    <input type="password" class="form-control" placeholder="*******">
                                    <i class="ti-unlock"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md full-width btn-theme-light-2 rounded">Login</button>
                            </div>

                        </form>
                    </div>
                    <div class="modal-divider"><span>Or login via</span></div>
                    <div class="social-login mb-3">
                        <ul>
                            <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Google+</a></li>
                        </ul>
                    </div>
                    <div class="text-center">
                        <p class="mt-5"><a href="#" class="link">Forgot password?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- ============================================================== -->


    <!-- ============================ Hero Banner  Start================================== -->
@yield('content')
    <!-- ============================ Call To Action End ================================== -->



    <!-- ============================ Footer Start ================================== -->
    <section class="theme-bg call-to-act-wrap">
        <div class="container">
           <div class="row">
              <div class="col-lg-12">

                 <div class="call-to-act">
                    <div class="call-to-act-head">
                       <h3>Want to Become a Real Estate Agent?</h3>
                       <span>We'll help you to grow your career and growth.</span>
                    </div>
                    <a href="#" class="btn btn-call-to-act">SignUp Today</a>
                 </div>

              </div>
           </div>
        </div>
     </section>
    <footer class="dark-footer skin-dark-footer">
        <div>
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <img src="{{url('/')}}/assets/frontend/img/logo-light.png" class="img-footer" alt="" />
                            <div class="footer-add">
                                <p>Version: 1.0.1.4</p>
                                <p>Address Here</p>
                                <p>Phone Number</p>
                                <p>Email</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h4 class="widget-title">Navigations</h4>
                            <ul class="footer-menu">
                                <li><a href="{{route('about')}}">About Us</a></li>
                             
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            
                            </ul>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h4 class="widget-title">The Highlights</h4>
                            <ul class="footer-menu">
                                <li><a href="#">Apartment</a></li>
                                <li><a href="#">My Houses</a></li>
                                <li><a href="#">Restaurant</a></li>
                                <li><a href="#">Nightlife</a></li>
                                <li><a href="#">Villas</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h4 class="widget-title">My Account</h4>
                            <ul class="footer-menu">
                                <li><a href="#">My Profile</a></li>
                                <li><a href="#">My account</a></li>
                                <li><a href="#">My Property</a></li>
                                <li><a href="#">Favorites</a></li>
                                <li><a href="#">Cart</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6">
                        <p class="mb-0">© 2022 Real Estate. Designd By <a href="#">MGTS</a> All Rights Reserved</p>
                    </div>

                    <div class="col-lg-6 col-md-6 text-right">
                        <ul class="footer-bottom-social">
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- ============================ Footer End ================================== -->

    <!-- Log In Modal -->
{{--    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">--}}
{{--            <div class="modal-content" id="registermodal">--}}
{{--                <span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>--}}
{{--                <div class="modal-body">--}}
{{--                    <h4 class="modal-header-title">Log In</h4>--}}
{{--                    <div class="login-form">--}}
{{--                        <form>--}}

{{--                            <div class="form-group">--}}
{{--                                <label>User Name</label>--}}
{{--                                <div class="input-with-icon">--}}
{{--                                    <input type="text" class="form-control" placeholder="Username">--}}
{{--                                    <i class="ti-user"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label>Password</label>--}}
{{--                                <div class="input-with-icon">--}}
{{--                                    <input type="password" class="form-control" placeholder="*******">--}}
{{--                                    <i class="ti-unlock"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <button type="submit" class="btn btn-md full-width btn-theme-light-2 rounded">Login</button>--}}
{{--                            </div>--}}

{{--                        </form>--}}
{{--                    </div>--}}
{{--                    <div class="modal-divider"><span>Or login via</span></div>--}}
{{--                    <div class="social-login mb-3">--}}
{{--                        <ul>--}}
{{--                            <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>--}}
{{--                            <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Google+</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <p class="mt-5"><a href="#" class="link">Forgot password?</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- End Modal -->

    <!-- Sign Up Modal -->

    <!-- End Modal -->

    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{url('/')}}/public/assets/frontend/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/popper.min.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/rangeslider.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/select2.min.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/jquery.magnific-popup.min.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/slick.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/slider-bg.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/lightbox.js"></script>
<script src="{{url('/')}}/public/assets/frontend/js/imagesloaded.js"></script>

<script src="{{url('/')}}/public/assets/frontend/js/custom.js"></script>
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
    @if (Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}");
    @endif
    $('#town').change(function(){
        var towncity=$("#town option:selected").text();
        $('#jj').val(towncity);
    })

    $('#ptypes').change(function(){
        var ptypes=$("#ptypes option:selected").val();

        $('#propertytype').val(ptypes);
    })

    $('#bedrooms').change(function(){
        var nobedrooms=$("#bedrooms option:selected").val();
        $('#nobedrooms').val(nobedrooms);
    })

    $('#bathrooms').change(function(){
        var nobathrooms=$("#bathrooms option:selected").val();

        $('#nobathrooms').val(nobathrooms);
    })
    function propvalues(){
        var a=[];
        var price =  $("input:radio[name='prices']:checked").val();
        $('#singleprice').val(price);

        $("input:checkbox[name='allamenitiesfilter']:checked").each(function(){
            a.push($(this).val());
            $('#allamenities').val(a);
            // alert(a);
        });
    }


</script>

<script>

</script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script>

    $(document).on('submit', '#signupform', function (e) {
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
                $('#btn_reg22').html('Processing...');
            },
            success: function (response) {
                if ((response.status == 'success')) {
                    $('#signupform')[0].reset();
                    $('#signup').modal('hide');
                    toastr.success(response.msg);

                }
                else {
                    printErrorMsg(response.error);

                }
            },
            complete:function (data){
                $('#btn_reg22').html('Register');
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

        $('select').on('click', function () {
            var key = $(this).attr('name');
            if ($(this).val() === '') {
                $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
            } else {
                $('#' + key + '_err').hide();
            }
        })
        $('select').on('click', function () {
            var key = $(this).attr('name');
            if ($(this).val() === '') {
                $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
            } else {
                $('#' + key + '_err').hide();
            }
        })
    
    
    }
</script>
<script type="text/javascript">
        $(function () {
            $('#primaryphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
    </script>

<script type="text/javascript">
        $(function () {
            $('#secondaryphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
    </script>
    
    <script type="text/javascript">
        $(function () {
            $('#mainphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
    </script>

<script type="text/javascript">
        $(function () {
            $('#propenqphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
    </script>

</body>
</html>
