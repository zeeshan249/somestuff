@extends('layout.mainlayout')
@section('content')
	<!-- Breadcrumb -->
    <div class="breadcrumb-bar">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<div class="breadcrumb-list">
								<nav aria-label="breadcrumb" class="page-breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="index.html">Home</a></li>
										<li class="breadcrumb-item" aria-current="page">About Us</li>
									
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Breadcrumb -->
			<!-- Breadcrumb -->
			<div class="page-banner">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<h1 class="mb-0">About Us</h1>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->	
			
			<!-- Course Content -->
			<section class="page-content course-sec">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
						
							<!-- Overview -->
							<div class="card overview-sec">
								<div class="card-body">
									<h5 class="subs-title">About Us</h5>
								
									<p style="text-align: justify;"><strong>Future Orbit</strong> is conceived and nurtured with a vision to see educated and empowered mankind, especially to make quality education.<br />Swami Vivekananda said, &ldquo;<em><strong>Education is the manifestation of the perfection already in man</strong></em>&rdquo;. At <strong>Future Orbit</strong> we are here to manifest the educational capability of a student to the level best of excellence.</p>
<p style="text-align: justify;"><br />We are also committed to inspire and inform the aspirants in such a way to realize their true potential. Now a days only hard work can not lead an aspirant to the peak of success. To achieve the desired goal, proper guidance, methodical and focused learning are the most powerful parameters.</p>
<p style="text-align: justify;">We believe that the success of an individual, organization, country depends on the quality of its human resources. The team <strong>Future Orbit</strong> is also enriched with most experienced and dedicated faculty members.<br /><strong>Future Orbit</strong> wishes to provide high quality education with affordable fees structure and focus will be on the areas which may not be on the road map of many educational service providers.</p>
<p style="text-align: justify;"><br />As an educational institute, we aim at developing a three dimensional personality in our students, viz (1) Pursuit of knowledge (2) Commitment to economic, social and cultural upliftment of masses and (3) Cultivation of creative mind.The permanent members of the faculty are with exceptional academic records and industry experience. They divide their time among four complementary activities: Research, Course development, Teaching and Consulting. We also ensure to educate our students in such a way, so that they can face with confidence the emerging global challenge</p>
								</div>
							</div>
							<!-- /Overview -->
							
							<!-- Education Content -->
							<div class="card education-sec">
								<div class="card-body">									
									<h5 class="subs-title">Why Future Orbit</h5>
									<div class="edu-wrap">
										<div class="edu-name">	
											<span>B</span>
										</div>
										<div class="edu-detail">	
											<h6>Institute Infrastructure:</h6>
											<ul>
<li style="text-align: justify;">Air conditioned classrooms.</li>
<li style="text-align: justify;">Complete CCTV surveillance.</li>
<li style="text-align: justify;">Separate sanitation for Girls and Boys.</li>
<li style="text-align: justify;">Purified drinking water.</li>
<li style="text-align: justify;">Computer room with internet connection for online exams and study.</li>
</ul>
											
										</div>
									</div>
									<div class="edu-wrap">
										<div class="edu-name">	
											<span>I</span>
										</div>
										<div class="edu-detail">	
											<h6>Intensive Study Material:</h6>
											
											<ul>
<li style="text-align: justify;">Highly systematic and research based own study materials. With solved examples and chapter wise analysis.</li>
</ul>
										</div>
									</div>
									<div class="edu-wrap">
										<div class="edu-name">	
											<span>D</span>
										</div>
										<div class="edu-detail">	
											<h6>Doubt Removal Session:</h6>
											
											<ul>
<li style="text-align: justify;">For each and every topic doubt removal classes are conducted regularly to ensure complete preparation of all subjects.</li>
</ul>
										</div>
									</div>
								</div>
							</div>
							<!-- /Education Content -->
							
							<!-- Experience Content -->
							<div class="card education-sec">
								<div class="card-body">									
									<h5 class="subs-title">Objective of the institute</h5>
									<div class="edu-wrap">
										<div class="edu-name">	
											<span>C</span>
										</div>
										<div class="edu-detail">	
											<h6>Competitive Exams</h6>
										
											<p>Preparing the aspirants for JEE(Main & Advanced)and  NEET</p>
										</div>
									</div>
									<div class="edu-wrap">
										<div class="edu-name">	
											<span>C</span>
										</div>
										<div class="edu-detail">	
											<h6>Classroom Coaching</h6>
											
											<p>Provide classroom coaching for all subjects for School students with specialized faculties across all boards.</p>
										</div>
									</div>
								</div>
							</div>
							<!-- /Experience Content -->	

							<!-- Courses Content -->
							<div class="card education-sec">
								<div class="card-body pb-0">									
									<h5 class="subs-title">Courses</h5>
									<div class="row">
										 @foreach($latestcourses as $latestcourses)
										<div class="col-lg-6 col-md-6 d-flex">
											<div class="course-box course-design d-flex " >
												<div class="product">
													<div class="product-img">
														<a href="course-details.html">
															<img class="img-fluid" alt="" src="{{$storagePath}}{{$latestcourses->lms_child_course_image}}">
														</a>
														<div class="price">
															<h3>Rs {{$latestcourses->lms_child_course_fees}} </h3>
														</div>
													</div>
													<div class="product-content">
														<div class="course-group d-flex">
															<div class="course-group-img d-flex">
																<a href="#"><img src="{{$storagePath}}{{$latestcourses->lms_child_course_image}}" alt="" class="img-fluid"></a>
																<div class="course-name">
																	<h4><a href="#">{{$latestcourses->lms_child_course_description}}</a></h4>
																	<p>{{$latestcourses->lms_course_name}}</p>
																</div>
															</div>
															<div class="course-share d-flex align-items-center justify-content-center">
																<a href="#rate"><i class="fa-regular fa-heart"></i></a>
															</div>
														</div>
														<h3 class="title instructor-text"><a href="course-details.html.html">{{$latestcourses->lms_child_course_name}}</a></h3>
														<div class="course-info d-flex align-items-center border-0 m-0">
															<div class="rating-img d-flex align-items-center">
																<img src="assets/img/icon/icon-01.svg" alt="">
																<p>12+ Lesson</p>
															</div>
															<div class="course-view d-flex align-items-center">
																<img src="assets/img/icon/icon-02.svg" alt="">
																<p>{{$latestcourses->lms_child_course_duration}} months</p>
															</div>
														</div>
														<div class="rating">							
															<i class="fas fa-star filled"></i>
															<i class="fas fa-star filled"></i>
															<i class="fas fa-star filled"></i>
															<i class="fas fa-star filled"></i>
															<i class="fas fa-star"></i>
															<span class="d-inline-block average-rating"><span>4.0</span> (15)</span>
														</div>
														<div class="all-btn all-category d-flex align-items-center">
															<a href="{{route('contactus')}}" class="btn btn-primary">Enquire Now</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									     @endforeach
									</div>
								</div>
							</div>
							<!-- /Courses Content -->	
														
						
							
						
							
						</div>	
						
						<div class="col-lg-4">

							<!-- Right Sidebar Tags Label -->
							<div class="card overview-sec">
								<div class="card-body overview-sec-body">
									<h5 class="subs-title">Offline & Online Courses</h5>
									<div class="sidebar-tag-labels">
										<ul class="list-unstyled">
											<li><a href="javascript:;" class="">CBSE</a></li>
											<li><a href="javascript:;">ICSE</a></li>
											<li><a href="javascript:;">State Board</a></li>
											<li><a href="javascript:;">JEE & NEET</a></li>
											<li><a href="javascript:;">Competitive Exams</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- /Right Sidebar Tags Label -->

							<!-- Right Sidebar Profile Overview -->
							<div class="card overview-sec">
								<div class="card-body">
									<h5 class="subs-title">Profile Overview</h5>
									<div class="rating-grp">
										<div class="rating">							
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating"><span>4.0</span> (15)</span>
										</div>
										<div class="course-share d-flex align-items-center justify-content-center">
											<a href="#rate"><i class="fa-regular fa-heart"></i></a>
										</div>
									</div>
									<div class="profile-overview-list">
									  <div class="list-grp-blk d-flex">
										  <div class="flex-shrink-0">
											<img src="assets/img/instructor/courses-icon.png" alt="Courses" >
										  </div>
										  <div class="list-content-blk flex-grow-1 ms-3">
											<h5>32</h5>
											<p>Courses</p>
										</div>
									  </div>
									  <div class="list-grp-blk d-flex">
										  <div class="flex-shrink-0">
											<img src="assets/img/instructor/ttl-stud-icon.png" alt="Total Students" >
										  </div>
										  <div class="list-content-blk flex-grow-1 ms-3">
											<h5>528</h5>
											<p>Total Students</p>
										</div>
									  </div>
									  <div class="list-grp-blk d-flex">
										  <!-- <div class="flex-shrink-0">
											<img src="assets/img/instructor/review-icon.png" alt="Reviews" >
										  </div>
										  <div class="list-content-blk flex-grow-1 ms-3">
											<h5>12,230</h5>
											<p>Reviews</p>
										</div> -->
									  </div>
									</div>
								</div>
							</div>
							<!-- /Right Sidebar Profile Overview -->

							<!-- Right Contact Details -->
							<div class="card overview-sec">
								<div class="card-body">
									<h5 class="subs-title">Contact Details</h5>
									<div class="contact-info-list">
										<div class="edu-wrap">
											<div class="edu-name">	
												<span><img src="assets/img/instructor/email-icon.png" alt="Address"></span>
											</div>
											<div class="edu-detail">	
												<h6>Email</h6>
												<p><a href="javascript:;">futureorbit.edu@gmail.com</a></p>
											</div>
										</div>
										<div class="edu-wrap">
											<div class="edu-name">	
												<span><img src="assets/img/instructor/address-icon.png" alt="Address"></span>
											</div>
											<div class="edu-detail">	
												<h6>Address</h6>
												<p>Lalbazar, Bankura, W.B. - 722101
Landmark: Besides Malleswar Kali Temple, Near Hindu High School</p>
											</div>
										</div>
										<div class="edu-wrap">
											<div class="edu-name">	
												<span><img src="assets/img/instructor/phone-icon.png" alt="Address"></span>
											</div>
											<div class="edu-detail">	
												<h6>Phone</h6>
												<p> <a href="javascript:;">7319196192</a></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Right Contact Details -->							

						</div>
					</div>
				</div>
			</section>
 
	  
@endsection
