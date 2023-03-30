@extends('layout.mainlayout')
@section('content')
<div class="breadcrumb-bar">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<div class="breadcrumb-list">
								<nav aria-label="breadcrumb" class="page-breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item" aria-current="page">Courses</li>
										<li class="breadcrumb-item active" aria-current="page">All Courses</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
            			<!-- Course -->
			<section class="course-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-9">
						
							<!-- Filter -->
							<div class="showing-list">
								<div class="row">
									<div class="col-lg-6">
										<div class="d-flex align-items-center">
											<div class="view-icons">
												<!-- <a href="course-grid.html" class="grid-view"><i class="feather-grid"></i></a>
												<a href="course-list.html" class="list-view active"><i class="feather-list"></i></a> -->
											</div>
											<div class="show-result">
											
										
												<h4>Showing {{$courses->currentPage()}}-{{count($courses)}} of {{$courses->total()}} results</h4>
										
											</div>
										</div>
									</div>
									<div class="col-lg-6">	
										<div class="show-filter add-course-info ">
											<form action="#">
												<div class="row gx-2 align-items-center">	
													<div class="col-md-6 col-item">
														<div class=" search-group">
															<i class="feather-search"></i>
															<input type="text" class="form-control" placeholder="Search our courses" >
														</div>
													</div>
													<div class="col-md-6 col-lg-6 col-item">
														<div class="form-group select-form mb-0">
															<select class="form-select select"  name="sellist1">
															  <option>Newly published </option>
															  <option>published 1</option>
															  <option>published 2</option>
															  <option>published 3</option>
															</select>
														</div>
													</div>						
												</div>
											</form>
										</div>	
									</div>
								</div>
							</div>
							<!-- /Filter -->
							
							<div class="row">
						
								@foreach($courses as $courses1)
								<div class="col-lg-12 col-md-12 d-flex">
									<div class="course-box course-design list-course d-flex">
										<div class="product">
											<div class="product-img">
												<a href="{{route('coursedetails',$courses1->lms_child_course_id)}}">
											
													<img class="img-fluid" alt="" src="{{$storagePath}}{{$courses1->lms_child_course_image}}">
												</a>
												<div class="price">
													<h3>₹ {{$courses1->lms_child_course_fees}}</span></h3>
												</div>
											</div>
											<div class="product-content">
												<div class="head-course-title">
													<h3 class="title"><a href="{{route('coursedetails',$courses1->lms_child_course_id)}}">{{$courses1->lms_child_course_name}}</a></h3>
													<div class="all-btn all-category d-flex align-items-center">
														<a href="{{route('contactus')}}" class="btn btn-primary">Enquire Now</a>
													</div>
												</div>
												<div class="course-info border-bottom-0 pb-0 d-flex align-items-center">
													<div class="rating-img d-flex align-items-center">
														<img src="assets/img/icon/icon-01.svg" alt="">
														<p>12+ Lesson</p>
													</div>
													<div class="course-view d-flex align-items-center">
														<img src="assets/img/icon/icon-02.svg" alt="">
														<p>{{$courses1->lms_child_course_duration}} months</p>
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
												<div class="course-group d-flex mb-0">
													<div class="course-group-img d-flex">
														<a href="#"><img src="{{$storagePath}}{{$courses1->lms_child_course_image}}" alt="" class="img-fluid"></a>
														<div class="course-name">
															<h4><a href="#">{{$courses1->lms_child_course_description}}</a></h4>
															<p>{{$courses1->lms_course_name}} </p>
														</div>
													</div>
													<div class="course-share d-flex align-items-center justify-content-center">
														<a href="#rate"><i class="fa-regular fa-heart"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								@endforeach
							
							
							</div>
							<!-- {!! $courses->links() !!} -->
						
							<!-- /pagination -->
							{{ $courses->links('Course.custompagination') }}
							<!-- /pagination -->
							
						</div>
						<div class="col-lg-3 theiaStickySidebar">
							<div class="filter-clear">
								<div class="clear-filter d-flex align-items-center">
									<h4><i class="feather-filter"></i>Filters</h4>
									<div class="clear-text">
										<p>CLEAR</p>
									</div>
								</div>
								
								<!-- Search Filter -->
								<!-- <div class="card search-filter categories-filter-blk">
									<div class="card-body">
										<div class="filter-widget mb-0">
											<div class="categories-head d-flex align-items-center">
												<h4>Course categories</h4>
												<i class="fas fa-angle-down"></i>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" >
													<span class="checkmark"></span> Backend (3)

												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" >
													<span class="checkmark"></span>  CSS (2)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist">
													<span class="checkmark"></span>  Frontend (2)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" checked>
													<span class="checkmark"></span> General (2)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" checked>
													<span class="checkmark"></span> IT & Software (2)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist">
													<span class="checkmark"></span> Photography (2)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist">
													<span class="checkmark"></span>  Programming Language (3)
												</label>
											</div>
											<div>
												<label class="custom_check mb-0">
													<input type="checkbox" name="select_specialist">
													<span class="checkmark"></span>  Technology (2)
												</label>
											</div>
										</div>
									</div>
								</div> -->
								<!-- /Search Filter -->
								
								<!-- Search Filter -->
								<!-- <div class="card search-filter">
									<div class="card-body">
										<div class="filter-widget mb-0">
											<div class="categories-head d-flex align-items-center">
												<h4>Instructors</h4>
												<i class="fas fa-angle-down"></i>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" >
													<span class="checkmark"></span> Keny White (10)

												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist" >
													<span class="checkmark"></span>  Hinata Hyuga (5)
												</label>
											</div>
											<div>
												<label class="custom_check">
													<input type="checkbox" name="select_specialist">
													<span class="checkmark"></span>  John Doe (3)
												</label>
											</div>
											<div>
												<label class="custom_check mb-0">
													<input type="checkbox" name="select_specialist" checked>
													<span class="checkmark"></span> Nicole Brown
												</label>
											</div>
										</div>
									</div>
								</div> -->
								<!-- /Search Filter -->
								
								<!-- Search Filter -->
								<!-- <div class="card search-filter ">
									<div class="card-body">
										<div class="filter-widget mb-0">
											<div class="categories-head d-flex align-items-center">
												<h4>Price</h4>
												<i class="fas fa-angle-down"></i>
											</div>
											<div>
												<label class="custom_check custom_one">
													<input type="radio" name="select_specialist" >
													<span class="checkmark"></span> All (18)

												</label>
											</div>
											<div>
												<label class="custom_check custom_one">
													<input type="radio" name="select_specialist" >
													<span class="checkmark"></span>  Free (3) 

												</label>
											</div>
											<div>
												<label class="custom_check custom_one mb-0">
													<input type="radio" name="select_specialist" checked>
													<span class="checkmark"></span>  Paid (15)
												</label>
											</div>
										</div>
									</div>
								</div> -->
								<!-- /Search Filter -->
								
								<!-- Latest Posts -->
								<div class="card post-widget ">
									<div class="card-body">
										<div class="latest-head">
											<h4 class="card-title">Latest Courses</h4>
										</div>
										<ul class="latest-posts">
											@foreach($latestcourses as $latestcourses)
											<li>
												<div class="post-thumb">
													<a href="{{route('coursedetails',$latestcourses->lms_child_course_id)}}">
														<img class="img-fluid" src="{{$storagePath}}{{$latestcourses->lms_child_course_image}}" alt="">
													</a>
												</div>
												<div class="post-info">
													<h4>
														<a href="{{route('coursedetails',$latestcourses->lms_child_course_id)}}">{{$latestcourses->lms_child_course_name}}</a>
													</h4>
													<p>₹ {{$latestcourses->lms_child_course_fees}}</p>
												</div>
											</li>
							               @endforeach
								
								
								
										</ul>
									</div>
								</div>
								<!-- /Latest Posts -->
							
							</div>
						</div>
					</div>
				</div>
			</section>

@endsection