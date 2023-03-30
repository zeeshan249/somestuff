

@if(!Route::is(['index']))
<header class="header header-page">
@endif
@if(Route::is(['index']))
<header class="header">
@endif

		


<div class="header-fixed">
					<nav class="navbar navbar-expand-lg header-nav scroll-sticky">
						<div class="container header-border">
							<div class="navbar-header">
								<a id="mobile_btn" href="javascript:void(0);">
									<span class="bar-icon">
										<span></span>
										<span></span>
										<span></span>
									</span>
								</a>
                                <a href="{{route('index')}}" class="navbar-brand logo">
                              <img src="{{ URL::asset('/assets/img/logo/logo.png')}}" class="img-fluid" alt="Logo">
                                </a>
							</div>
							<div class="main-menu-wrapper">
								<div class="menu-header">
                                 <a href="{{url('index')}}" class="menu-logo">
                              <img src="{{ URL::asset('/assets/img/logo/logo.png')}}" class="img-fluid" alt="Logo">
                                 </a>
									<a id="menu_close" class="menu-close" href="javascript:void(0);">
										<i class="fas fa-times"></i>
									</a>
								</div>
								<ul class="main-nav">
                                <li class="{{ Request::is('index') ? 'active' : '' }}">
                                <a href="{{route('index')}}">Home</a>
                                </li>
								<li class="{{ Request::is('index') ? 'active' : '' }}">
                                <a href="{{route('allcourses')}}">Courses</a>
                                </li>
                                <li class="{{ Request::is('aboutus') ? 'active' : '' }}">
                            <a href="{{route('aboutus')}}">About Us</a>
                                </li>
                           <li class="{{ Request::is('contactus') ? 'active' : '' }}">
                            <a href="{{route('contactus')}}">Contact Us</a>
                             </li>
							
									<li class="login-link">
										<a href="#">Login / Signup</a>
									</li>
								</ul>		 
							</div>
							<ul class="nav header-navbar-rht">
								<li class="nav-item">
									<a class="nav-link header-sign" href="#">Signin</a>
								</li>
								<li class="nav-item">
									<a class="nav-link header-login" href="#">Signup</a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
			</header>