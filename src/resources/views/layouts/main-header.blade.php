<!-- main-header opened -->

			<div class="main-header sticky side-header nav nav-item">

				<div class="container-fluid">

					<div class="main-header-left ">

						<div class="responsive-logo">

							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>

							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>

                            <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>


							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>

						</div>

						<div class="app-sidebar__toggle" data-toggle="sidebar">

							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>

							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>

						</div>

					</div>

					<div class="main-header-right">
                        <ul class="nav">
							<li class="">
								<div class="dropdown  nav-itemd-none d-md-flex">
									<a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
										<span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img src="{{ asset('assets/img/world.svg') }}" alt=""></span>

										<div class="my-auto">
											<strong class="mr-2 ml-2 my-auto"></strong>
										</div>
									</a>
									<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
										<a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item d-flex ">
											<span class="avatar  ml-3 align-self-center bg-transparent"><i class="flag-icon flag-icon-us flag-icon-squared"></i></span>
											<div class="d-flex">
												<span class="mt-2">Egnlish</span>
											</div>
										</a>
										<a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="dropdown-item d-flex">
											<span class="avatar  ml-3 align-self-center bg-transparent"><i class="flag-icon flag-icon-eg flag-icon-squared"></i></span>
											<div class="d-flex">
												<span class="mt-2">العربية</span>
											</div>
										</a>

									</div>
								</div>
							</li>
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">

							<div class="nav-link" id="bs-example-navbar-collapse-1">

								<form class="navbar-form" role="search">

									<div class="input-group">

										<input type="text" class="form-control" placeholder="Search">

										<span class="input-group-btn">

											<button type="reset" class="btn btn-default">

												<i class="fas fa-times"></i>

											</button>

											<button type="submit" class="btn btn-default nav-link resp-btn">

												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>

											</button>

										</span>

									</div>

								</form>

							</div>

                            <div class="dropdown nav-item main-header-notification">

								<a class="new nav-link" href="#">

								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>

								<div class="dropdown-menu">

									<div class="menu-header-content bg-primary text-right">

										<div class="d-flex">

											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Notifications</h6>

											<span class="badge badge-pill badge-warning mr-auto my-auto float-left">Mark All Read</span>

										</div>

										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread Notifications</p>

									</div>

									<div class="main-notification-list Notification-scroll">

										<a class="d-flex p-3 border-bottom" href="#">

											<div class="notifyimg bg-pink">

												<i class="la la-file-alt text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">New files available</h5>

												<div class="notification-subtext">10 hour ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

										<a class="d-flex p-3" href="#">

											<div class="notifyimg bg-purple">

												<i class="la la-gem text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">Updates Available</h5>

												<div class="notification-subtext">2 days ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

										<a class="d-flex p-3 border-bottom" href="#">

											<div class="notifyimg bg-success">

												<i class="la la-shopping-basket text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">New Order Received</h5>

												<div class="notification-subtext">1 hour ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

										<a class="d-flex p-3 border-bottom" href="#">

											<div class="notifyimg bg-warning">

												<i class="la la-envelope-open text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">New review received</h5>

												<div class="notification-subtext">1 day ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

										<a class="d-flex p-3 border-bottom" href="#">

											<div class="notifyimg bg-danger">

												<i class="la la-user-check text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">22 verified registrations</h5>

												<div class="notification-subtext">2 hour ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

										<a class="d-flex p-3 border-bottom" href="#">

											<div class="notifyimg bg-primary">

												<i class="la la-check-circle text-white"></i>

											</div>

											<div class="mr-3">

												<h5 class="notification-label mb-1">Project has been approved</h5>

												<div class="notification-subtext">4 hour ago</div>

											</div>

											<div class="mr-auto" >

												<i class="las la-angle-left text-left text-muted"></i>

											</div>

										</a>

									</div>

									<div class="dropdown-footer">

										<a href="">VIEW ALL</a>

									</div>

								</div>

							</div>

							<div class="nav-item full-screen fullscreen-button">

								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>

							</div>

							<div class="dropdown main-profile-menu nav nav-item nav-link">

								<a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a>

								<div class="dropdown-menu">

									<div class="main-header-profile bg-primary p-3">

										<div class="d-flex wd-100p">

											<div class="main-img-user"><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}" class=""></div>

											<div class="mr-3 my-auto">

												<h6>{{ Auth::user()->name }}</h6><span>{{ Auth::user()->email }}</span>

											</div>

										</div>

									</div>
									<a class="dropdown-item" href="{{ route('profile.settings') }}"><i class="bx bx-slider-alt"></i>{{ __('main.account settings') }} </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="bx bx-log-out"></i>{{ __('main.logout')  }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                    </form>

								</div>

							</div>


						</div>

					</div>

				</div>

			</div>

<!-- /main-header -->

