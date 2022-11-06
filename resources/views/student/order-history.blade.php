@extends('layouts.layout')
@section('title', 'Student | All My Past Orders')
@section('content')
    <form id="checkout-address" class="list-view product-checkout">
        <!-- Checkout Customer Address Left starts -->
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-md-8 col-xs-12">
                <div class="checkout-items">
                    @foreach ($orders as $item)
                        <div class="card ecommerce-card">
                            <div class="row">
                                <div class="col-lg-3 col-xs-12 col-sm-12 col-md-3 py-1">
                                    <div class="item-img">
                                        <a href="app-ecommerce-details.html">
                                            <img src="{{ asset('storage/products/' . $item->cartproduct->image) }}"
                                                alt="img-placeholder">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-sm-12 col-md-6 py-1">
                                    <div class="item-name">
                                        <h6 class="mb-0"><a href="app-ecommerce-details.html"
                                                class="text-body">{{ $item->cartproduct->product_name }}</a></h6>
                                        <span class="item-company">By <a href="#"
                                                class="company-name">{{ $item->cartseller->name }}</a></span>
                                        <div class="item-rating">
                                            <ul class="unstyled-list list-inline">
                                                <li class="ratings-list-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-star filled-star">
                                                        <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                        </polygon>
                                                    </svg></li>
                                                <li class="ratings-list-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-star filled-star">
                                                        <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                        </polygon>
                                                    </svg></li>
                                                <li class="ratings-list-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-star filled-star">
                                                        <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                        </polygon>
                                                    </svg></li>
                                                <li class="ratings-list-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-star filled-star">
                                                        <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                        </polygon>
                                                    </svg></li>
                                                <li class="ratings-list-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-star unfilled-star">
                                                        <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                        </polygon>
                                                    </svg></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <span class="text-success mb-1">In Stock</span>
                                    <div class="item-quantity">
                                        <span class="quantity-title">Qty:</span>
                                        <div class="quantity-counter-wrapper">
                                            <div class="input-group bootstrap-touchspin">
                                                <span class="input-group-btn bootstrap-touchspin-injected"><button
                                                        class="btn btn-primary bootstrap-touchspin-down"
                                                        type="button">-</button></span><input type="text"
                                                    class="quantity-counter form-control" value="1"><span
                                                    class="input-group-btn bootstrap-touchspin-injected"><button
                                                        class="btn btn-primary bootstrap-touchspin-up"
                                                        type="button">+</button></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-xs-12 col-sm-12 col-md-3 py-1">
                                    <div class="item-options text-center">
                                        <div class="item-wrapper">
                                            <div class="item-cost">
                                                <h4 class="item-price">$ {{ $item->cartproduct->price }}</h4>
                                                <p class="card-text shipping">
                                                    <span class="badge rounded-pill badge-light-success">Free
                                                        Shipping</span>
                                                </p>
                                            </div>
                                        </div>
                                        <form action="{{ route('student.removecart') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="product_name"
                                                value="{{ $item->cartproduct->slug }}">
                                            <button type="submit"
                                                class="btn btn-light mt-1 remove-wishlist waves-effect waves-float waves-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-x align-middle me-25">
                                                    <line x1="18" y1="6" x2="6" y2="18">
                                                    </line>
                                                    <line x1="6" y1="6" x2="18" y2="18">
                                                    </line>
                                                </svg>
                                                <span>Remove</span>
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>



                        </div>
                    @endforeach

                </div>

            </div>
            <div class="col-lg-4 col-xs-12 col-sm-12">
                <div class="customer-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="price-details">
                                <h6 class="price-title">Price Details</h6>
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title">Total Products</div>
                                        <div class="detail-amt">$ {{ $orders->count() }}</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title"> Discount</div>
                                        <div class="detail-amt discount-amt text-success">$ 00</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title">Estimated Tax</div>
                                        <div class="detail-amt">$ 00</div>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title">Products Cost</div>
                                        <a href="#" class="detail-amt text-primary">$ {{ $totalcost }}</a>
                                    </li>
                                    <li class="price-detail">
                                        <div class="detail-title">Delivery Charges</div>
                                        <div class="detail-amt discount-amt text-success">Free</div>
                                    </li>
                                </ul>
                                <hr>
                                <ul class="list-unstyled">
                                    <li class="price-detail">
                                        <div class="detail-title detail-total">Total</div>
                                        <div class="detail-amt fw-bolder">$ {{ $totalcost }}</div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Checkout Customer Address Left ends -->

        <!-- Checkout Customer Address Right starts -->

        <!-- Checkout Customer Address Right ends -->
    </form>
@endsection
