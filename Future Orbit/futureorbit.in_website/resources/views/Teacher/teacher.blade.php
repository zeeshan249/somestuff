@extends('layout.mainlayout')
@section('content')
<div class="inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="instructor-wrap border-bottom-0 m-0">
                    <div class="about-instructor align-items-center">
                        <div class="abt-instructor-img">
                        @if($instructors->lms_staff_profile_image=='' || $instructors->lms_staff_profile_image=="undefined")
                        <img class="img-fluid" alt="" src="{{ URL::asset('/assets/img/user-love.jpg')}}">
                        @else
                        <a href="#"><img src="{{$staffImagePath}}{{$instructors->lms_staff_profile_image??''}}" alt="img" class="img-fluid"></a>
                        @endif
                          
                        </div>
                        <div class="instructor-detail me-3">
                            <h5><a href="">{{$instructors->lms_staff_full_name??''}}</a></h5>
                            <p>{{$instructors->lms_staff_qualification??''}}</p>
                            <p>{{$instructors->lms_department_name??''}} Department</p>
                        </div>
                        <div class="rating mb-0">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                            <span class="d-inline-block average-rating"><span>4.5</span> (15)</span>
                        </div>
                    </div>
                    <!-- <span class="web-badge mb-3">WEB DEVELPMENT</span> -->
                </div>
                <!-- <h2>{{$coursedetails->lms_child_course_name??''}}</h2>
                <p>{{$coursedetails->lms_child_course_description??''}}</p> -->
                <div class="course-info d-flex align-items-center border-bottom-0 m-0 p-0">
                    <div class="cou-info">
                        <img src="{{ URL::asset('/assets/img/icon/icon-01.svg')}}" alt="">
                        <p>{{$instructors->lms_staff_work_experience??''}}</p>
                    </div>
                    <div class="cou-info">
                        <img src="{{ URL::asset('/assets/img/icon/timer-icon.svg')}}" alt="">
                        <!-- <p>{{$coursedetails->lms_child_course_duration??''}}+ months</p> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Inner Banner -->

<!-- Course Content -->
<section class="page-content course-sec">
    <div class="container">

        <div class="row">
            <div class="col-lg-8">

                <!-- Overview -->
                <div class="card overview-sec">
                    <div class="card-body">
                        <h5 class="subs-title">Overview</h5>
                        <h6>Course Description</h6>

                     
                        <h6>What you'll learn</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                             
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- /Overview -->

                <!-- Course Content -->
                <!-- <div class="card content-sec">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="subs-title">Course Content</h5>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6>92 Lectures 10:56:11</h6>
                            </div>
                        </div>
                        <div class="course-card">
                            <h6 class="cou-title">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">In which areas do you operate?</a>
                            </h6>
                            <div id="collapseOne" class="card-collapse collapse" style="">
                                <ul>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.1 Introduction to the User Experience Course</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.2 Exercise: Your first design challenge</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.5 How to use text layers effectively</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="course-card">
                            <h6 class="cou-title">
                                <a class="collapsed" data-bs-toggle="collapse" href="#course2" aria-expanded="false">The Brief</a>
                            </h6>
                            <div id="course2" class="card-collapse collapse" style="">
                                <ul>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.1 Introduction to the User Experience Course</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.2 Exercise: Your first design challenge</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.5 How to use text layers effectively</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="course-card">
                            <h6 class="cou-title">
                                <a class="collapsed" data-bs-toggle="collapse" href="#course3" aria-expanded="false">Wireframing Low Fidelity</a>
                            </h6>
                            <div id="course3" class="card-collapse collapse" style="">
                                <ul>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.1 Introduction to the User Experience Course</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.2 Exercise: Your first design challenge</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture1.5 How to use text layers effectively</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="course-card">
                            <h6 class="cou-title mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#coursefour" aria-expanded="false">Type, Color & Icon Introduction</a>
                            </h6>
                            <div id="coursefour" class="card-collapse collapse" style="">
                                <ul>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture4.1 Introduction to the User Experience Course</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture4.2 Exercise: Your first design challenge</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture4.3 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture4.4 How to solve the previous exercise</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p><img src="{{ URL::asset('/assets/img/icon/play.svg')}}" alt="" class="me-2">Lecture4.5 How to use text layers effectively</p>
                                        <div>
                                            <a href="javascript:;">Preview</a>
                                            <span>02:53</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- /Course Content -->


            </div>

         
        </div>
    </div>
</section>

@endsection
