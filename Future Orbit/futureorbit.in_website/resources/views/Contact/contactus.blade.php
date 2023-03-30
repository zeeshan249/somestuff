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
										<li class="breadcrumb-item">Pages</li>
										<li class="breadcrumb-item">Contact Us</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Breadcrumb -->
			<div class="page-banner">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<h1 class="mb-0">Course Enquiry</h1>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Help Details -->
			<div class="page-content">
				
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-8 mx-auto">
							<div class="support-wrap">
								<h5>Enquiry Form</h5>
								<form action="{{route('enquirySubmit')}}" data-toggle="submit" method="POST">
                                    @csrf
									<div class="form-group">
										<label>School</label>
                                          <select name="school" class="form-control" id="school">
                                          <option value="">Select an Option</option>
                                          @foreach($schools as $school)   
                                          <option value="{{$school->lms_school_id}}">{{$school->lms_school_name}}</option>
                                          @endforeach 
                                        </select>
                                        <i class="mdi mdi-check-circle-outline" id="school_err"></i>
									</div>
									<input type="hidden" value="{{route('fetchCourses')}}" id="routeurl" >
									<div class="form-group">
										<label>Class</label>
                                          <select name="classname" class="form-control" id="classname">
                                          <option value="">Select an Option</option>
                                          @foreach($streams as $streams)   
                                          <option value="{{$streams->lms_course_id}}">{{$streams->lms_course_name}}</option>
                                          @endforeach 
                                        </select>
                                        <i class="mdi mdi-check-circle-outline" id="classname_err"></i>
									</div>
									<div class="form-group">
                                    <label>Course Name</label>
										<select name="course" class="form-control" id="course" >
										<option value="">Select an Option</option>
                                        <!-- <option value="">Select an Option</option>
                                          @foreach($courses as $courses)   
                                         <option value="{{$courses->lms_child_course_name}}">{{$courses->lms_child_course_name}}</option>
                                          @endforeach  -->
                                        </select>
                                        <i class="mdi mdi-check-circle-outline" id="course_err"></i>
									</div>
                                    <div class="form-group">
										<label>First Name</label>
										<input type="text" class="form-control"  name="firstname" placeholder="Enter your First Name">
                                        <i class="mdi mdi-check-circle-outline" id="firstname_err"></i>
									</div>
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" class="form-control"  name="lastname" placeholder="Enter your Name">
                                        <i class="mdi mdi-check-circle-outline" id="lastname_err"></i>
									</div>
                                    <div class="form-group">
										<label>Fathers's Name</label>
										<input type="text" class="form-control"  name="fathersname" placeholder="Enter your Fathers Name">
                                        <i class="mdi mdi-check-circle-outline" id="fathersname_err"></i>
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="text" class="form-control"  name="email" placeholder="Enter your Email">
                                        <i class="mdi mdi-check-circle-outline" id="email_err"></i>
									</div>
									<div class="form-group">
										<label>Mobile No</label>
										<input type="text" class="form-control"  name="mobile" placeholder="Enter your Mobile No">
                                        <i class="mdi mdi-check-circle-outline" id="mobile_err"></i>
									</div>
                                    <div class="form-group">
										<label>Address</label>
                                        <textarea class="form-control"  name="address" placeholder="Write down here" rows="4"></textarea>
                                        <i class="mdi mdi-check-circle-outline" id="address_err"></i>
									</div>
									
									<button type="submit" class="btn btn-submit animate-up-2" disabled="disabled">Submit</button>
                                   
								</form>
							</div>
						</div>
					</div>
					
				</div>
			</div>
	  
@endsection
