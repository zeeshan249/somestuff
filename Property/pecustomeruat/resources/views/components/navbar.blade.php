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

                    <li class="active"><a href="{{route('index')}}">Home<span class="submenu-indicator"></span></a></li>
                    <li><a href="{{route('about')}}">About<span class="submenu-indicator"></span></a></li>

                    <li><a href="JavaScript:Void(0);">Property<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            @foreach($menu as $item)
                                <li><a href="JavaScript:Void(0);" >{{$item->property_type}}<span class="submenu-indicator"></span></a>
                                    @if ($item->submenu)

                                        <ul class="nav-dropdown nav-submenu">
                                            @foreach ($item->submenu as $subitem)

                                                <input type="hidden"   value="{{$subitem->product_category_name}}">
                                                <li><a href="{{route('propertylist')}}" id="a-{{$subitem->product_category_id}}"  >{{$subitem->product_category_name}}</a></li>
                                            @endforeach

                                        </ul>
                                    @endif
                                </li>
                            @endforeach

                        </ul>
                    </li>

                    <li><a href="{{route('blogs')}}">Blog<span class="submenu-indicator"></span></a></li>

                    <li><a href="{{route('agents')}}">Agents<span class="submenu-indicator"></span></a></li>

                    <li><a href="{{route('contact')}}">Contact<span class="submenu-indicator"></span></a></li>

                    <li><a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#signup">Sign Up</a></li>

                </ul>

                <ul class="nav-menu nav-menu-social align-to-right">
                    <li class="add-listing light">
                        <a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#login" class="text-success">
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
                <div class="login-form">
{{--                    <form  id="signupformk" method="POST" action="{{ route('signup') }}">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}

{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">--}}

{{--                                        <i class="ti-user"></i>--}}

{{--                                    </div>--}}
{{--                                    <i class="mdi mdi-check-circle-outline" id="firstname_err"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">--}}
{{--                                        <i class="ti-user"></i>--}}

{{--                                    </div>--}}
{{--                                    <i class="mdi mdi-check-circle-outline" id="lastname_err"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <input type="email" class="form-control" name="email" placeholder="Email">--}}
{{--                                        <i class="ti-email"></i>--}}

{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                            --}}{{--                                <div class="form-group">--}}
{{--                            --}}{{--                                    <div class="input-with-icon">--}}
{{--                            --}}{{--                                        <input type="text" class="form-control" placeholder="Username">--}}
{{--                            --}}{{--                                        <i class="ti-user"></i>--}}
{{--                            --}}{{--                                    </div>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <input type="password" name="password" class="form-control" placeholder="*******">--}}
{{--                                        <i class="ti-unlock"></i>--}}

{{--                                    </div>--}}
{{--                                    <i class="mdi mdi-check-circle-outline" id="password_err"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <input type="text" name="phone" class="form-control" placeholder="123 546 5847">--}}
{{--                                        <i class="lni-phone-handset"></i>--}}

{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @php--}}
{{--                                $role=DB::table('roles')->where('is_role_active',1)->get();--}}
{{--                            @endphp--}}
{{--                            <div class="col-lg-6 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-with-icon">--}}
{{--                                        <select class="form-control" name="role">--}}
{{--                                            @foreach($role as $name)--}}
{{--                                                <option value="{{$name->id}}">{{$name->name}}</option>--}}

{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <i class="ti-briefcase"></i>--}}
{{--                                        <i class="mdi mdi-check-circle-outline" id="role_err"></i>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <button id="btn_regdd" type="submit" class="btn btn-md full-width btn-theme-light-2 rounded">Sign Up</button>--}}
{{--                        </div>--}}

{{--                    </form>--}}
                </div>
                {{--                <div class="modal-divider"><span>Or login via</span></div>--}}
                {{--                <div class="social-login mb-3">--}}
                {{--                    <ul>--}}
                {{--                        <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>--}}
                {{--                        <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Google+</a></li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}
                <div class="text-center">
                    <p class="mt-5"><i class="ti-user mr-1"></i>Already Have An Account? <a href="#" class="link">Go For LogIn</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
