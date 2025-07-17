<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @include('admin.flash-message')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
        <div class="col">
            <div class="card radius-10">
                  @php
    $totalbooking = \DB::table('bookings')->get();
    @endphp
                <div class="card-body">
                    <a href="{{ route('admin.bookingHistory') }}">
                    <div class="d-flex align-items-center">
                         
        
                        <div>
                            <p class="mb-0 text-secondary">Total Bookings</p>
                            <h4 class="my-1">{{ count($totalbooking) }}</h4>
                            <p class="mb-0 font-13 text-success">&nbsp;</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-calendar3"></i></div>
                    </div>
                     </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <a href="{{ route('admin.user') }}">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Users</p>
                            <h4 class="my-1">{{ count($users) }}</h4>
                            <p class="mb-0 font-13 text-success">&nbsp;</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <a href="{{ route('admin.provider') }}">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Providers</p>
                            <h4 class="my-1">{{ count($providers) }}</h4>
                            <p class="mb-0 font-13 text-danger">&nbsp;</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Cancel Rate</p>
                            <h4 class="my-1">49.2%</h4>
                            <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 12.2% from last week</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col">
            <div class="card radius-10">
                @php
    $service = \DB::table('services')->get();
    @endphp
                <a href="{{ route('admin.service.serviceList') }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Services</p>
                                <h4 class="my-1 text-dark">{{ count($service) }}</h4>
                                <p class="mb-0 font-13 text-success">&nbsp;</p>
                            </div>
                            <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-gear-fill"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                  @php
    $subservice = \DB::table('sub_services')->get();
    @endphp
                <a href="{{ route('admin.service.subServiceList') }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Sub Services</p>
                                <h4 class="my-1 text-dark">{{ count($subservice) }}</h4>
                                <p class="mb-0 font-13 text-success">&nbsp;</p>
                            </div>
                            <div class="widget-icon-large bg-gradient-warning text-white ms-auto"><i class="bi bi-gear-wide-connected"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div><!--end row-->
    
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Booking Figures</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Cancel</span></div>
                                <div class="font-13"><i class="bi bi-circle-fill text-success"></i><span class="ms-2">Completed</span></div>
                            </div>
                        </div>
                    </div>
                    <div id="chart1"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Bookings</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart2"></div>
                </div>
                <ul class="list-group list-group-flush mb-0">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">New Booking<span class="badge bg-primary badge-pill">25%</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Completed<span class="badge bg-orange badge-pill">65%</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Pending<span class="badge bg-success badge-pill">10%</span></li>
                </ul>
            </div>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-12 col-lg-6 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-lg-flex align-items-center justify-content-center gap-2">
                         
                        <div id="chart3"></div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="bi bi-circle-fill text-purple me-1"></i> New Booking:<span class="me-1">30</span></li>
                            <li class="list-group-item"><i class="bi bi-circle-fill text-info me-1"></i> Complete Booking:<span class="me-1">17</span></li>
                            <li class="list-group-item"><i class="bi bi-circle-fill text-pink me-1"></i> Pending Booking:<span class="me-1">14</span></li>
                            <li class="list-group-item"><i class="bi bi-circle-fill text-success me-1"></i> Cancelled Booking:<span class="me-1">9</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Product Actions</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Views</span></div>
                                <div class="font-13"><i class="bi bi-circle-fill text-pink"></i><span class="ms-2">Clicks</span></div>
                            </div>
                        </div>
                    </div>
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
    </div><!--end row-->
        
    <!--<div class="row">
        <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Top Categories</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i></a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;">Action</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Another action</a>
                          </li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>
               <div class="card-body">
                 <div class="categories">
                    <div class="progress-wrapper">
                      <p class="mb-2">Electronic <span class="float-end">85%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-purple" role="progressbar" style="width: 85%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Furniture <span class="float-end">70%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 70%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Fashion <span class="float-end">66%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 66%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Mobiles <span class="float-end">76%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 76%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Accessories <span class="float-end">80%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 80%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Watches <span class="float-end">65%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-voilet" role="progressbar" style="width: 65%;"></div>
                      </div>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="progress-wrapper">
                      <p class="mb-2">Sports <span class="float-end">45%</span></p>
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-gradient-royal" role="progressbar" style="width: 45%;"></div>
                      </div>
                    </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-header bg-transparent">
                <div class="row g-3 align-items-center">
                  <div class="col">
                    <h5 class="mb-0">Best Products</h5>
                  </div>
                  <div class="col">
                    <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                      <div class="dropdown">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;">Action</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Another action</a>
                          </li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>
              <div class="card-body p-0">
                 <div class="best-product p-2 mb-3">
                   <div class="best-product-item">
                     <div class="d-flex align-items-center gap-3">
                       <div class="product-box border">
                          <img src="assets/images/products/01.png" alt="">
                       </div>
                       <div class="product-info">
                         <h6 class="product-name mb-1">White Polo T-Shirt</h6>
                         <div class="product-rating mb-0">
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                         </div>
                       </div>
                       <div class="sales-count ms-auto">
                         <p class="mb-0">245 Sales</p>
                       </div>
                     </div>
                   </div>
                   <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/02.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Formal Coat Pant</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">325 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/03.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Blue Shade Jeans</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">189 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/04.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Yellow Winter Jacket</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill"></i>
                         <i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">102 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/05.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Men Sports Shoes</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">137 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/06.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Fancy Home Sofa</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">453 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/07.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Sports Time Watch</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">198 Sales</p>
                      </div>
                    </div>
                  </div>
                  <div class="best-product-item">
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box border">
                         <img src="assets/images/products/08.png" alt="">
                      </div>
                      <div class="product-info">
                        <h6 class="product-name mb-1">Women Blue Heals</h6>
                        <div class="product-rating mb-0">
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill text-warning"></i>
                         <i class="bi bi-star-fill"></i>
                         <i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                      <div class="sales-count ms-auto">
                        <p class="mb-0">98 Sales</p>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-12 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-header bg-transparent">
                <div class="row g-3 align-items-center">
                  <div class="col">
                    <h5 class="mb-0">Top Sellers</h5>
                  </div>
                  <div class="col">
                    <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                      <div class="dropdown">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;">Action</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Another action</a>
                          </li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>
              <div class="top-sellers-list p-2 mb-3">
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                   <img src="assets/images/avatars/avatar-1.png" class="rounded-circle" width="50" height="50" alt="">
                   <div>
                     <h6 class="mb-1">Thomas Hardy</h6>
                     <p class="mb-0 font-13">Customer ID #84586</p>
                   </div>
                    <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                      <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                    </div>
                 </div>
                 <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-2.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Pauline Bird</h6>
                    <p class="mb-0 font-13">Customer ID #86572</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-3.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Ralph Alva</h6>
                    <p class="mb-0 font-13">Customer ID #98657</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">4.8 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-4.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">John Roman</h6>
                    <p class="mb-0 font-13">Customer ID #78542</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">4.7 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-5.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">David Buckley</h6>
                    <p class="mb-0 font-13">Customer ID #68574</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-6.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Maria Anders</h6>
                    <p class="mb-0 font-13">Customer ID #86952</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">4.8 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-7.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Martin Loother</h6>
                    <p class="mb-0 font-13">Customer ID #83247</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">5.0 <i class="bi bi-star-fill text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-8.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Victoria Hardy</h6>
                    <p class="mb-0 font-13">Customer ID #67523</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">3.9 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-9.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">David Buckley</h6>
                    <p class="mb-0 font-13">Customer ID #94256</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">3.5 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-3 sellers-list-item">
                  <img src="assets/images/avatars/avatar-10.png" class="rounded-circle" width="50" height="50" alt="">
                  <div>
                    <h6 class="mb-0">Victoria Hardy</h6>
                    <p class="mb-0 font-13">Customer ID #48759</p>
                  </div>
                  <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                    <p class="mb-0">3.4 <i class="bi bi-star-half text-warning"></i></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>--><!--end row-->
        
        <!--<div class="card radius-10">
           <div class="card-body">
             <div class="row g-3">
               <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card mb-0 radius-10 border shadow-none w-100">
                  <div class="card-body">
                    <h5 class="card-title">Top Sales Locations</h5>
                    <h4 class="mt-4">$36.2K <i class="flag-icon flag-icon-us rounded"></i></h4>
                    <p class="mb-0 text-secondary font-13">Our Most Customers in US</p>
                    <ul class="list-group list-group-flush mt-3">
                      <li class="list-group-item border-top">
                        <div class="d-flex align-items-center gap-2">
                           <div><i class="flag-icon flag-icon-us"></i></div>
                           <div>United States</div>
                           <div class="ms-auto">289</div>
                        </div>
                      </li>
                      <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-au"></i></div>
                          <div>Malaysia</div>
                          <div class="ms-auto">562</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-in"></i></div>
                          <div>India</div>
                          <div class="ms-auto">354</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-ca"></i></div>
                          <div>Indonesia</div>
                          <div class="ms-auto">147</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-ad"></i></div>
                          <div>Turkey</div>
                          <div class="ms-auto">652</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-cu"></i></div>
                          <div>Netherlands</div>
                          <div class="ms-auto">287</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-is"></i></div>
                          <div>Italy</div>
                          <div class="ms-auto">634</div>
                       </div>
                     </li>
                     <li class="list-group-item">
                       <div class="d-flex align-items-center gap-2">
                          <div><i class="flag-icon flag-icon-ge"></i></div>
                          <div>Canada</div>
                          <div class="ms-auto">524</div>
                       </div>
                     </li>
                    </ul>
                  </div>
                </div>
               </div>
               <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card mb-0 radius-10 border shadow-none w-100">
                  <div class="card-body">
                    <div class="" id="geographic-map"></div>
                   </div>
                  </div>
              </div>
             </div>
           </div>
        </div>-->
        
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="row g-3 align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Recent Booking</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User&nbsp;Name</th>
                                <th>Booking&nbsp;Id</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Booking&nbsp;Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking as $key=>$row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td style="text-transform: capitalize;">{{ $row->first_name }} {{ $row->last_name }}</td>
                                <td>{{ $row->booking_id }}</td>
                                <td>{{ $currency->currency_symbol }}{{ $row->amount }}</td>
                                <td><span class="badge @if($row->status == 'CANCELLED') bg-danger @elseif($row->status == 'COMPLETED') bg-success @else bg-primary @endif badge-pill">{{ $row->status }}</span></td>
                                <td>{{ $row->created_at->diffForHumans() }}</td>
                                <td><a href="{{ route('admin.bookingDetail',$row->id) }}">View Ride Details</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

 <script>
    var map;
    var users;
    var providers;
    var ajaxMarkers = [];
    var googleMarkers = [];
    var mapIcons = {
        user: 'http://towfin.com/asset/img/marker-user.png',
        active: 'http://towfin.com/asset/img/marker-car.png',
        riding: 'http://towfin.com/asset/img/marker-home.png',
        offline: 'http://towfin.com/asset/img/marker-home.png',
        unactivated: 'http://towfin.com/asset/img/marker-plus.png',
        banned: 'http://towfin.com/asset/img/marker-plus.png'
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 32.1656, lng: -83.441162},
            zoom: 5,
            minZoom: 1
        });

        setInterval(ajaxMapData, 3000);

        var legend = document.getElementById('legend');

        var div = document.createElement('div');
        div.innerHTML = '<img src="' + mapIcons['user'] + '"> ' + 'User';
        legend.appendChild(div);

        var div = document.createElement('div');
        div.innerHTML = '<img src="' + mapIcons['offline'] + '"> ' + 'Unavailable Provider';
        legend.appendChild(div);
        
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + mapIcons['active'] + '"> ' + 'Available Provider';
        legend.appendChild(div);
        
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + mapIcons['unactivated'] + '"> ' + 'Unactivated Provider';
        legend.appendChild(div);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
        
        google.maps.Map.prototype.clearOverlays = function() {
            for (var i = 0; i < googleMarkers.length; i++ ) {
                googleMarkers[i].setMap(null);
            }
            googleMarkers.length = 0;
        }

    }

    function ajaxMapData() {
        map.clearOverlays();
        $.ajax({
            url: '/admin/map/ajax',
            dataType: "JSON",
            headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken },
            type: "GET",
            success: function(data) {
                console.log('Ajax Response', data);
                ajaxMarkers = data;
            }
        });

        ajaxMarkers ? ajaxMarkers.forEach(addMarkerToMap) : '';
    }

    function addMarkerToMap(element, index) {
        
        marker = new google.maps.Marker({
            position: {
                lat: parseFloat(element.latitude),
                lng: parseFloat(element.longitude)
            },
            id: element.id,
            map: map,
            title: element.first_name + " " +element.last_name,
            icon : mapIcons[element.service ? element.service.status : element.status],
        });

        googleMarkers.push(marker);

        google.maps.event.addListener(marker, 'click', function() {
            alert(element.service ? element.service.status : element.status);
            var aLink = '';
            if(element.status  === "user"){
                aLink = 'user';
            }else{
                aLink = 'provider';
            }
           //window.location.href = '/admin/' + aLink + '/' + element.id + '/edit';
        });
    }
</script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCu-gEfhthbqjZ3sZaWnVchOcETweUfoKc&libraries=places&callback=initMap" async defer></script>
</x-admin-layout>
<script>
    $(function() {
	    "use strict";
	    
	    // chart 1
        var options = {
            series: [{
                name: "Cancel",
                data: [1, 2]
            },{
                name: "Complete",
                data: [3, 1]
            }],
            chart: {
                foreColor: '#9a9797',
                type: "area",
                //width: 130,
                height: 370,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: .12,
                    color: "#3461ff"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#3461ff", "#12bf24"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "35%",
                    endingShape: "rounded"
                }
            },
        	legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'left',
                offsetX: -20
            },
            dataLabels: {
                enabled: !1
            },
            grid: {
                show: true,
                // borderColor: '#eee',
                // strokeDashArray: 4,
            },
            stroke: {
                show: !0,
                width: 3,
                curve: "smooth"
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#3461ff", "#12bf24"],
                    inverseColors: true,
                    opacityFrom: 0.8,
                    opacityTo: 0.2,
                    //stops: [0, 50, 100],
                    //colorStops: []
                }
            },
            colors: ["#3461ff", "#12bf24"],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();
	    
        // chart 2
        var newbook = {{ count($newbook) }};
        var complete = {{ count($complete) }};
        var cancel = {{ count($cancel) }};
        var process = {{ count($process) }};
        var options = {
            series: [newbook, process, complete, cancel],
            chart: {
                height: 250,
                type: 'pie',
            },
            labels: [ 'New Booking', 'Pending', 'Completed', 'Cancelled'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#00c6fb", "#ff6a00", "#98ec2d", "#bf95ea"],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    //stops: [0, 50, 100],
                    //colorStops: []
                }
            },
            colors: ["#005bea", "#ee0979", "#17ad37", "#7928ca"],
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'left',
                offsetX: -20
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 270
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart2"), options);
        chart.render();
    });
    </script>