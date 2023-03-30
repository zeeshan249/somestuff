@extends('layout.mainlayout')
@section('content')
    <style>
        .btn-p {
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(180deg, rgb(45, 85, 255), rgba(2, 0, 36, 1));
            padding: 11px 10px 15px 11px;
            border: 2px solid #383CC1;
            font-weight: 100;
            text-transform: lowercase;
            border-radius: 20px;
        }
    </style>
	<!-- Breadcrumb -->
            <div class="breadcrumb-bar">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<div class="breadcrumb-list">
								<nav aria-label="breadcrumb" class="page-breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item">Pages</li>
										<li class="breadcrumb-item">Scholarship Test</li>
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
							<h1 class="mb-0">Future Orbit -  Scholarship Test 2022</h1>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
            <section class="page-content ">
				<div class="container">
					<div class="row">
						<div class="col-lg-10">

							<!-- Overview -->
							<div class="card overview-sec">
								<div class="card-body">
									<h5 class="subs-title">Future Orbit -  Scholarship Test</h5>

									<p style="text-align: justify;"> This scholarship test scheduled for the students of <strong>Future Orbit</strong></p>
<p style="text-align: justify;"><br />Exam Venue: Bankura Banga Vidyalaya, <strong>Machantala, Bankura</strong> </p>
<p style="text-align: justify;">Exam Date: <strong>18/12/2022</strong> , Sunday</p>

								</div>
							</div>
							<!-- /Overview -->

                            <div class="card ">

                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="support-wrap">
                                                <h5>Future Orbit -  Scholarship Test 2022 Form</h5>
                                                <form action="{{route('submitscholarship')}}" data-toggle="submit" method="POST">
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
                                                    <div class="form-group">
                                                        <label>Student Name</label>
                                                        <input type="text" class="form-control"  name="student" placeholder="Enter your Student Name">
                                                        <i class="mdi mdi-check-circle-outline" id="student_err"></i>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Fathers's Name</label>
                                                        <input type="text" class="form-control"  name="fathersname" placeholder="Enter your Fathers Name">
                                                        <i class="mdi mdi-check-circle-outline" id="fathersname_err"></i>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Roll No</label>
                                                        <input type="text" class="form-control"  name="rollno" placeholder="Enter your Roll No">
                                                        <i class="mdi mdi-check-circle-outline" id="rollno_err"></i>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Class</label>
                                                        <select name="classname" class="form-control" id="classname">
                                                            <option value="">Select an Option</option>
                                                            <option value="II">II</option>
                                                            <option value="III">III</option>
                                                            <option value="IV">IV</option>
                                                            <option value="V">V</option>
                                                            <option value="VI">VI</option>
                                                            <option value="VII">VII</option>
                                                            <option value="VIII">VIII</option>
                                                            <option value="IX">IX</option>
                                                            <option value="X">X</option>
                                                            <option value="XI">XI</option>
                                                            <option value="XII">XII</option>

                                                        </select>
                                                        <i class="mdi mdi-check-circle-outline" id="classname_err"></i>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Section</label>
                                                        <select name="section" class="form-control" id="section">
                                                            <option value="">Select an Option</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                            <option value="F">F</option>
                                                            <option value="G">G</option>
                                                        </select>
                                                        <i class="mdi mdi-check-circle-outline" id="section_err"></i>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea class="form-control"  name="address" placeholder="Write down here" rows="4"></textarea>
                                                        <i class="mdi mdi-check-circle-outline" id="address_err"></i>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mobile No</label>

                                                        <input type="text" class="form-control" id="primaryphone" maxlength="10"  name="mobile" placeholder="Enter your Mobile No">
                                                        <br>
                                                        {{--                                        <a class="btn-p" onClick="sendOTP();">Send OTP</a>--}}

                                                        <i class="mdi mdi-check-circle-outline" id="mobile_err"></i>
                                                    </div>
                                                    {{--                                    <div class="form-group">--}}
                                                    {{--                                        <label>OTP</label>--}}
                                                    {{--                                        <input type="number"  id="mobileOtp" class="form-control"  name="otp" placeholder="Enter your Otp">--}}

                                                    {{--                                        <i class="mdi mdi-check-circle-outline" id=""></i>--}}
                                                    {{--                                    </div>--}}



                                                    <button type="submit" class="btn btn-submit animate-up-2" disabled="disabled">Submit</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                            </div>
							<!-- Education Content -->
							<div class="card education-sec">
								<div class="card-body">
									<h5 class="subs-title">Scholarship
                                     Test 2022 Details</h5>
									<div class="edu-wrap">

										<div class="edu-detail">

											<ul>
<li style="text-align: left;">Up to 100% scholarship on Tuition Fees</li>
<li style="text-align: left;">Free JEE/NEET coaching classes for students of classes XI & XII.</li>

</ul>

										</div>
									</div>

								</div>
							</div>
							<!-- /Education Content -->

							<!-- Experience Content -->
                            <div class="card overview-sec">
                                <div class="card-body">
                                    <h5 class="subs-title">About Us</h5>

                                    <p style="text-align: justify;"><strong>Future Orbit</strong> is conceived and nurtured with a vision to see educated and empowered mankind, especially to make quality education.<br />Swami Vivekananda said, &ldquo;<em><strong>Education is the manifestation of the perfection already in man</strong></em>&rdquo;. At <strong>Future Orbit</strong> we are here to manifest the educational capability of a student to the level best of excellence.</p>
                                    <p style="text-align: justify;"><br />We are also committed to inspire and inform the aspirants in such a way to realize their true potential. Now a days only hard work can not lead an aspirant to the peak of success. To achieve the desired goal, proper guidance, methodical and focused learning are the most powerful parameters.</p>
                                    <p style="text-align: justify;">We believe that the success of an individual, organization, country depends on the quality of its human resources. The team <strong>Future Orbit</strong> is also enriched with most experienced and dedicated faculty members.<br /><strong>Future Orbit</strong> wishes to provide high quality education with affordable fees structure and focus will be on the areas which may not be on the road map of many educational service providers.</p>

                                </div>
                            </div>
							<!-- /Experience Content -->
                            <div class="card education-sec">
                                <div class="card-body">
                                    <h5 class="subs-title">Why Future Orbit</h5>
                                    <div class="edu-wrap">

                                        <div class="edu-detail">

                                            <ul>
                                                <li style="text-align: left;">All Subjects In One Place.</li>
                                                <li style="text-align: left;">Subject Wise Faculty.</li>
                                                <li style="text-align: left;">Online & Offline Exam.</li>
                                                <li style="text-align: left;">Competitive Environment.</li>
                                                <li style="text-align: left;">Affordable Monthly Fees.</li>
                                                <li style="text-align: left;">Extra guidance for school level competitive examination.</li>
                                                <li style="text-align: left;">Air Conditioned Class Room.</li>
                                                <li style="text-align: left;">Complete CCTV surveillance.</li>
                                                <li style="text-align: left;">Separate sanitation for Girls and Boys.</li>
                                                <li style="text-align: left;">Purified drinking water.</li>

                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
							<!-- Courses Content -->

							<!-- /Courses Content -->





						</div>


					</div>
				</div>
			</section>
			<!-- Help Details -->




@endsection
