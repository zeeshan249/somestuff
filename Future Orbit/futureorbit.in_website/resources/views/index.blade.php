<!-- Home Banner -->
@extends('layout.mainlayout')
@section('content')
<section class="home-slide d-flex align-items-center">
    <div class="container" id="headbanner" >
        <div class="row ">
            <div class="col-md-7">
                <div class="home-slide-face aos" data-aos="fade-up">
                    <div class="home-slide-text ">
                        <h5>Classroom & Online Learning</h5>
                        <ul>
                        <li>
                       <h2 style="font-size: 20px;"> Providing the confidence to your child in every subject from standard III to VIII.</h2>
                        </li> 
                        <br> 
                        <li>
                       <h2 style="font-size: 20px;"> Specialised coaching from class IX to XII in Physics, Chemistry, Mathematics & Biology to crack JEE/NEET in first attempt.</h2>
                        </li>       
                    </ul>
                       
                    </div>
                
                    <div class="trust-user">
                    
                        <p>Trusted by Students <br>& Teachers since 2019</p>
                        <div class="trust-rating d-flex align-items-center">
                            <!-- <div class="rate-head">
                                <h2><span>500</span>+</h2>
                            </div>
                            <div class="rating d-flex align-items-center">
                                <h2 class="d-inline-block average-rating">4.4</h2>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-center">
                <div class="girl-slide-img aos" data-aos="fade-up">
                    <img src="{{ URL::asset('/assets/img/banner-new.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Home Banner -->
<section class="section student-course">
    <div class="container">
        <div class="course-widget">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="course-full-width">
                        <div class="blur-border course-radius align-items-center aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/assets/img/pencil-icon.svg')}}" alt="">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>14</span>+</h4>
                                    <p>Classroom Courses</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/assets/img/cources-icon.svg')}}" alt="">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>21</span>+</h4>
                                    <p>Expert Tutors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/assets/img/certificate-icon.svg')}}" alt="">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>9</span>+</h4>
                                    <p>Classrooms</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/assets/img/gratuate-icon.svg')}}" alt="">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>245</span>+</h4>
                                    <p>School Students</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home Banner -->

<!-- Top Categories -->
<section class="section how-it-works">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head">
          
                <h2>Our Streams</h2>
            </div>
         
        </div>
        <div class="section-text aos" data-aos="fade-up">
            <p>Our classroom courses divided in multiple streams for School Students & JEE-NEET aspirants</p>
        </div>
        <div class="owl-carousel mentoring-course owl-theme aos" data-aos="fade-up">

            @foreach($stream as $stream)

            <div class="feature-box text-center " >
                <div class="feature-bg" >
                    <div class="feature-header">
                        <div class="feature-icon">
                            <img src="{{$storagePath}}{{$stream->lms_course_image??''}}" alt="">
                        </div>
                        <div class="feature-cont">
                            <div class="feature-text">{{$stream->lms_course_name}}</div>
                        </div>
                    </div>
                    <!-- <p>{{$stream->totalStudentsEnrolled}} Students</p> -->
                </div>
            </div>
            @endforeach









        </div>
    </div>



    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head">
          
                <h2>Our Courses</h2>
            </div>
         
        </div>
        <div class="section-text aos" data-aos="fade-up">
           
        </div>
        <div class="owl-carousel mentoring-course1 owl-theme aos" data-aos="fade-up">

         

            <div class="feature-box text-center " >
                <div class="feature-bg" >
                    <div class="feature-header">
                        <div class="feature-icon">
                            <img src="{{ URL::asset('/assets/img/categories-icon.png')}}" alt="">
                        </div>
                        <div class="feature-cont">
                            <div class="feature-text">3 to 5</div>
                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="feature-box text-center " >
                <div class="feature-bg" >
                    <div class="feature-header">
                        <div class="feature-icon">
                            <img src="{{ URL::asset('/assets/img/categories-icon.png')}}" alt="">
                        </div>
                        <div class="feature-cont">
                        <div class="feature-text">9 to 4</div>
                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="feature-box text-center " >
                <div class="feature-bg" >
                    <div class="feature-header">
                        <div class="feature-icon">
                            <img src="{{ URL::asset('/assets/img/categories-icon.png')}}" alt="">
                        </div>
                        <div class="feature-cont">
                            <div class="feature-text">11 to 12</div>
                        </div>
                    </div>
                   
                </div>
            </div>
         









        </div>
    </div>
  
    
</section>
<!-- /Top Categories -->
<!-- New section added 27th Dec -->

<!-- Feature Course -->
<section class="section new-course">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head">
                <span>School Courses</span>
                <h2>CBSE | ICSE | WB</h2>
            </div>
            <div class="all-btn all-category d-flex align-items-center">
                <a href="{{route('allcourses')}}" class="btn btn-primary">All Courses</a>
            </div>
        </div>
        <div class="section-text aos" data-aos="fade-up">
            <p class="mb-0">Our classroom enriched coaching includes all subjects covers boards like CBSE | ICSE | WB</p>
        </div>
        <div class="course-feature">
            <div class="row">
                @foreach($courses as $featuredcourses)
                @if($featuredcourses->lms_child_course_name !="Scholarship")
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="course-box d-flex aos" data-aos="fade-up">
                        <div class="product">
                            <div class="product-img">
                                <a href="{{route('coursedetails',$featuredcourses->lms_child_course_id)}}">
                                    <img class="img-fluid" alt="" src="{{$storagePath}}{{$featuredcourses->lms_child_course_image??''}}">
                                </a>
                                <div class="price">
                                    <h3>₹ {{$featuredcourses->lms_child_course_fees}}</h3>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="course-group d-flex">
                                    <div class="course-group-img d-flex">
                                        <a href="{{route('coursedetails',$featuredcourses->lms_child_course_id)}}"><img src="{{$storagePath}}{{$featuredcourses->lms_child_course_image??''}}" alt="" class="img-fluid"></a>
                                        <div class="course-name">
                                            <h4><a href="{{route('coursedetails',$featuredcourses->lms_child_course_id)}}">{{$featuredcourses->lms_child_course_name}}</a></h4>
                                            <p>{{$featuredcourses->lms_course_name}}</p>
                                        </div>
                                    </div>
                                    <div class="course-share d-flex align-items-center justify-content-center">
                                        <a href="#"><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <h3 class="title instructor-text"><a href="{{route('coursedetails',$featuredcourses->lms_child_course_id)}}">{{$featuredcourses->lms_child_course_description}}</a></h3>
                                <div class="course-info d-flex align-items-center">
                                    <div class="rating-img d-flex align-items-center">
                                    <img src="assets/img/icon/icon-01.svg" alt="">
                                        <p>12+ Lesson</p>
                                    </div>
                                    <div class="course-view d-flex align-items-center">
                                    <img src="assets/img/icon/icon-02.svg" alt="">
                                        <p>{{$featuredcourses->lms_child_course_duration}} months</p>
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
                @else
                @endif
                @endforeach


            </div>
        </div>
    </div>
</section>
<!-- /Feature Course -->

<!-- Master Skill -->
<section class="section master-skill">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="section-header aos" data-aos="fade-up">
                    <div class="section-sub-head">
                        <span>Why Future Orbit</span>
                        <h2>Master the skills to drive your career</h2>
                    </div>
                </div>
                <div class="section-text aos" data-aos="fade-up">
                    <p>To prepare the aspirants in such a way, that they can grab and master in every subject, which ensure success in the first attempt.</p>
                </div>
                <div class="career-group aos" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="certified-group blur-border d-flex">
                                <div class="get-certified d-flex align-items-center">
                                    <div class="blur-box">
                                        <div class="certified-img ">
                                            <img src="{{ URL::asset('/assets/img/icon/icon-1.svg')}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    <p>Subject wise specialized teacher</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="certified-group blur-border d-flex">
                                <div class="get-certified d-flex align-items-center">
                                    <div class="blur-box">
                                        <div class="certified-img ">
                                            <img src="{{ URL::asset('/assets/img/icon/icon-2.svg')}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    <p>Regular Online & Offline exam</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="certified-group blur-border d-flex">
                                <div class="get-certified d-flex align-items-center">
                                    <div class="blur-box">
                                        <div class="certified-img ">
                                            <img src="{{ URL::asset('/assets/img/icon/icon-3.svg')}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    <p>Affordable and lowest fees assurance</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="certified-group blur-border d-flex">
                                <div class="get-certified d-flex align-items-center">
                                    <div class="blur-box">
                                        <div class="certified-img ">
                                            <img src="{{ URL::asset('/assets/img/icon/icon-4.svg')}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    <p>Competitive environment for your child’s growth</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 d-flex align-items-end">
                <div class="career-img aos" data-aos="fade-up">
                    <img src="{{ URL::asset('/assets/img/banner-3.png')}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Master Skill -->

<!-- Trending Course -->
<section class="section trend-course">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head">
                <span>Competitive Exams</span>
                <h2>JEE(Main & Advanced) and NEET</h2>
            </div>
            <div class="all-btn all-category d-flex align-items-center">
                <a href="{{route('allexams')}}" class="btn btn-primary">All Exams</a>
            </div>
        </div>
        <div class="section-text aos" data-aos="fade-up">
            <p class="mb-0">To lay strong foundation, which not only helps an aspirant to crack the exam but also to get success in any dream ambition.</p>
        </div>
        <div class="owl-carousel trending-course owl-theme aos" data-aos="fade-up">
            @foreach($trendingcourses as $trend)
            <div class="course-box trend-box">
                <div class="product trend-product">
                    <div class="product-img">
                        <a href="{{route('coursedetails',$trend->lms_child_course_id)}}">
                            <img class="img-fluid" alt="" src="{{$storagePath}}{{$trend->lms_child_course_image??''}}">
                        </a>
                        <div class="price">
                        <h3>₹&nbsp;{{$trend->lms_child_course_fees}}</h3>
                        </div>
                    </div>
                    <div class="product-content">
                        <div class="course-group d-flex">
                            <div class="course-group-img d-flex">
                                <a href="{{route('coursedetails',$trend->lms_child_course_id)}}"><img src="{{$storagePath}}{{$trend->lms_child_course_image??''}}" alt="" class="img-fluid"></a>
                                <div class="course-name">
                                    <h4><a href="{{route('coursedetails',$trend->lms_child_course_id)}}">{{$trend->lms_child_course_name??''}} </a></h4>
                                    <p>{{$trend->lms_course_name??''}}</p>
                                </div>
                            </div>
                            <div class="course-share d-flex align-items-center justify-content-center">
                                <a href="#"><i class="fa-regular fa-heart"></i></a>
                            </div>
                        </div>
                        <h3 class="title"><a href="{{route('coursedetails',$trend->lms_child_course_id)}}"> {{$trend->lms_child_course_description??''}} </a></h3>
                        <div class="course-info d-flex align-items-center">
                            <div class="rating-img d-flex align-items-center">
                                <img src="{{ URL::asset('/assets/img/icon/icon-01.svg')}}" alt="" class="img-fluid">
                                <p>13+ Lesson</p>
                            </div>
                            <div class="course-view d-flex align-items-center">
                                <img src="{{ URL::asset('/assets/img/icon/icon-02.svg')}}" alt="" class="img-fluid">
                                <p>{{$trend->lms_child_course_duration??''}}  Months </p>
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
                            <a href="{{route('contactus')}}" class="btn btn-primary">Enquire NOW</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Feature Instructors -->
        <div class="feature-instructors">
            <div class="section-header aos" data-aos="fade-up">
                <div class="section-sub-head feature-head text-center">
                    <h2>Experienced Instructor</h2>
                    <div class="section-text aos" data-aos="fade-up">
                        <p class="mb-0">All our faculties have a vast experience in JEE & NEET & School Students coaching.</p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel instructors-course owl-theme aos" data-aos="fade-up">
                @foreach($instructors as $instructors)
                <div class="instructors-widget">
                    <div class="instructors-img">
                    <!-- {{route('teacher',$instructors->lms_staff_id)}} -->
                        <a href="#">
                            @if($instructors->lms_staff_profile_image=='' || $instructors->lms_staff_profile_image=="undefined")
                            <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/default.png')}}">
                            @else
                            <img class="img-fluid" style="width:70%; height:70%;margin:auto;"  alt="" src="{{$staffImagePath}}{{$instructors->lms_staff_profile_image??''}}">
                      
                            @endif
                        </a>
                    </div>
                    <div class="instructors-content text-center">
                        <h5><a href="#">{{$instructors->lms_staff_full_name}}</a></h5>
                        <p>{{$instructors->lms_staff_qualification}}</p>
                         <p>{{$instructors->lms_staff_about??''}}</p>
                        <div class="student-count d-flex justify-content-center">
                            <i class="fa-solid fa-user-group"></i>
                            <span>{{$instructors->lms_staff_work_experience}}</span>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
        </div>
        <!-- /Feature Instructors -->

    </div>
</section>
<!-- /Trending Course -->

<!-- Leading Companies -->
<section class="section lead-companies">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center">
                <span>Trusted By</span>
                <h2>15+ Leading Private And Govt. Schools & Colleges</h2>
            </div>
        </div>
        <div class="lead-group aos" data-aos="fade-up">
            <div class="lead-group-slider owl-carousel owl-theme">
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-01.png')}}">
                    </div>
                </div>
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-02.png')}}">
                    </div>
                </div>
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-03.png')}}">
                    </div>
                </div>
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-04.png')}}">
                    </div>
                </div>
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-05.png')}}">
                    </div>
                </div>
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/lead-06.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Leading Companies -->

<!-- Share Knowledge -->
<section class="section share-knowledge">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="knowledge-img aos" data-aos="fade-up">
                    <img src="{{ URL::asset('/assets/img/share.png')}}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="join-mentor aos" data-aos="fade-up">
                    <h2>Want to share your knowledge? Join us a Mentor</h2>
                  
                    <ul class="course-list">
                        <li><i class="fa-solid fa-circle-check"></i>Best Infrastructure:</li>
                        <li><i class="fa-solid fa-circle-check"></i>Intensive Study Material</li>
                        <li><i class="fa-solid fa-circle-check"></i>Pre-Designed Classrom Program</li>
                    </ul>
                    <div class="all-btn all-category d-flex align-items-center">
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Share Knowledge -->

<!-- Users Love -->
<section class="section user-love">
    <div class="container">
        <div class="section-header white-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center">
                <span>Check out these real reviews</span>
            
            </div>
        </div>
    </div>
</section>
<!-- /Users Love -->

<!-- Say testimonial Four -->
<section class="testimonial-four">
				<div class="review">
					<div class="container">
						<div class="testi-quotes">
							<img src="assets/img/qute.png" alt="" >
						</div>
						<div class="mentor-testimonial lazy slider aos" data-aos="fade-up" data-sizes="50vw ">
                        @foreach($testimonials as $testimonials)
							<div class="d-flex justify-content-center">
								<div class="testimonial-all d-flex justify-content-center">
									<div class="testimonial-two-head text-center align-items-center d-flex">
										<div class="testimonial-four-saying ">
											<div class="testi-right">
												<img src="assets/img/qute-01.png" alt="">
											</div>
											<p>{{$testimonials->testimonials_description}}</p>
											<div class="four-testimonial-founder">
                                            <div class="fount-about-img">
                                        <a href="#"><img src="{{$testimonialsImagePath}}{{$testimonials->testimonials_image}}" alt="" class="img-fluid"></a>
                                    </div>
                                    <h3><a href="#">{{$testimonials->testimonials_name}}</a></h3>
                                    <span>{{$testimonials->testimonials_designation}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
                        @endforeach
							<!-- <div class="d-flex justify-content-center">
								<div class="testimonial-all d-flex justify-content-center">
									<div class="testimonial-two-head text-center align-items-center d-flex">
										<div class="testimonial-four-saying ">
											<div class="testi-right">
												<img src="assets/img/qute-01.png" alt="">
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
											<div class="four-testimonial-founder">
												<div class="fount-about-img">
													<a href="instructor-profile.html"><img src="assets/img/user/user3.jpg" alt="" class="img-fluid"></a>
												</div>
												<h3><a href="instructor-profile.html">john smith</a></h3>
												<span>Founder of Awesomeux Technology</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<div class="testimonial-all d-flex justify-content-center">
									<div class="testimonial-two-head text-center align-items-center d-flex">
										<div class="testimonial-four-saying ">
											<div class="testi-right">
												<img src="assets/img/qute-01.png" alt="">
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
											<div class="four-testimonial-founder">
												<div class="fount-about-img">
													<a href="instructor-profile.html"><img src="assets/img/user/user2.jpg" alt="" class="img-fluid"></a>
												</div>
												<h3><a href="instructor-profile.html">David Lee</a></h3>
												<span>Founder of Awesomeux Technology</span>
											</div>
										</div>
									</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</section>
<!-- /Say testimonial Four -->

<!-- Become An Instructor -->
<section class="section become-instructors aos" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 d-flex">
                <div class="student-mentor cube-instuctor ">
                    <h4>Download Our Android App</h4>
                    <div class="row">
                        <div class="col-lg-7 col-md-12">
                            <div class="top-instructors">
                                <p>Download our Android App from play store and access 1000+ Online Mock Test & Regular Test</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="mentor-img">
                                <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/become-02.png')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 d-flex">
                <div class="student-mentor yellow-mentor">
                    <h4>Transform Access To Education</h4>
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="top-instructors">
                                <p>Create an account to receive our newsletter, course recommendations and promotions.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="mentor-img">
                                <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/become-01.png')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Become An Instructor -->

<!-- Latest Blog -->
<section class="section latest-blog">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center mb-0">
                <h2>Latest Activitits </h2>
                <div class="section-text aos" data-aos="fade-up">
                    <p class="mb-0"> Activities & News updates</p>
                </div>
            </div>
        </div>
        <div class="owl-carousel blogs-slide owl-theme aos" data-aos="fade-up">
            @foreach($gallery as $gallery)
            <div class="instructors-widget blog-widget">
                <div class="instructors-img">
                    <a href="#">
                        <img class="img-fluid" alt="" src="{{$testimonialsImagePath}}{{$gallery->lms_gallery_image}}">
                    </a>
                </div>
                <div class="instructors-content text-center">
                    <h5><a href="#">{{$gallery->lms_gallery_name}}</a></h5>
                    <p>{{$gallery->lms_gallery_description}}</p>
                  
                </div>
            </div>
            @endforeach
        </div>
        <div class="enroll-group aos" data-aos="fade-up">
            <div class="row ">
                <div class="col-lg-4 col-md-6">
                    <div class="total-course d-flex align-items-center">
                        <div class="blur-border">
                            <div class="enroll-img ">
                                <img src="{{ URL::asset('/assets/img/icon/icon-07.svg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="course-count">
                            <h3><span class="counterUp" >{{$totalstudents}}</span></h3>
                            <p>STUDENTS ENROLLED</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="total-course d-flex align-items-center">
                        <div class="blur-border">
                            <div class="enroll-img ">
                                <img src="{{ URL::asset('/assets/img/icon/icon-08.svg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="course-count">
                            <h3><span class="counterUp" >{{$totalcourses}}</span></h3>
                            <p>TOTAL COURSES</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="total-course d-flex align-items-center">
                        <div class="blur-border">
                            <div class="enroll-img ">
                                <img src="{{ URL::asset('/assets/img/icon/icon-09.svg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="course-count">
                            <h3><span class="counterUp" >{{$totalstreams}}</span></h3>
                            <p>Streams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lab-course">
            <div class="section-header aos" data-aos="fade-up">
                <div class="section-sub-head feature-head text-center">
                    <h2>Unlimited access to 360+ courses <br>and 1,600+ hands-on labs</h2>
                </div>
            </div>
            <div class="icon-group aos" data-aos="fade-up">
                <div class="offset-lg-1 col-lg-12">
                    <div class="row">
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-09.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-10.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-16.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-12.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-13.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-14.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-15.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-16.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-17.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-3">
                            <div class="total-course d-flex align-items-center">
                                <div class="blur-border">
                                    <div class="enroll-img ">
                                        <img src="{{ URL::asset('/assets/img/icon/icon-18.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Latest Blog -->
@endsection
