<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gakeslab GHWP Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet"
        href="{{ asset('wizard-10/fonts/material-design-iconic-font/css/material-design-iconic-font.css') }}">

    <!-- DATE-PICKER -->
    <link rel="stylesheet" href="{{ asset('wizard-10/vendor/date-picker/css/datepicker.min.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('wizard-10/css/style.css') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@22.0.2/build/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src="{{ asset('wizard-10/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- JQUERY STEP -->
    <script src="{{ asset('wizard-10/js/jquery.steps.js') }}"></script>

    <!-- DATE-PICKER -->
    <script src="{{ asset('wizard-10/vendor/date-picker/js/datepicker.js') }}"></script>
    <script src="{{ asset('wizard-10/vendor/date-picker/js/datepicker.en.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@22.0.2/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('wizard-10/js/main.js') }}"></script>
</head>
<body>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="{{route('prepare_payment')}}" id="wizard" autocomplete="off">

            <input type="hidden" id="csrf-token" name="_token" value="{{ csrf_token() }}">
            <!-- SECTION 1 -->
            <h4></h4>
            <section class="section-2"style="background:white">
                <img src="{{ asset('banner.jpg') }}" alt="">
                <h1 style="text-align:center;vertical-alignment:middle;padding-top:10px; font-weight:bolder; text-decoration: underline;">REGISTRATION FORM</h1>
                <h4 style="padding:20px; padding-top:10px; text-align:center;vertical-alignment:middle; padding-bottom:0px;">
                    Capacity Building For Medical Device Industries Back to Back Session with <br>
                    Global Harmonization Working Party (GHWP)
                    TC Leaders Meeting <br>
                    In Coordination with The Ministry of Health of The Republic of Indonesia
                    <br><br>
                    Excellence In Medical Device Regulation And Innovation
                </h4>
                <br>
                <div class="inner" style="padding-top:10px">
                    <h2 style="color: grey">Activities </h2>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Activities</th>
                                        <th scope="col">Local Participants</th>
                                        <th scope="col">Foreign Participants</th>
                                        <th scope="col">Package Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>Opening Ceremony</li>
                                                <li>TC Open Meeting</li>
                                                <li>Day 1 Capacity Building for Industries <sub>(Limited Seats - first come first serve)</sub></li>
                                            </ul>
                                        </td>
                                        <td>IDR 2,000,000.-</td>
                                        <td>USD 250.-</td>
                                        <td rowspan="2">
                                            IDR 3,750,000.- <br>
                                            USD 500.-
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 2 Capacity Building For Industries</td>
                                        <td>IDR 2,000,000.-</td>
                                        <td>USD 250</td>
                                    </tr>
                                    <tr>
                                        <td>Day 1 Capacity Building for Industries <sub>(Half-Day Session)</sub></td>
                                        <td>IDR 1,000,000.-</td>
                                        <td>USD 125</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Halal Awareness by IHATEC</td>
                                        <td>IDR 2,600,000.-</td>
                                        <td>USD 250</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            GDPMD (CDAKB) for Technical Responsible Person (PJT)
                                            <ul>
                                                <li>2 days session</li>
                                                <li>Attendance Certificate is provided</li>
                                            </ul>
                                        </td>
                                        <td>IDR 4,000,000.-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Gala Dinner</td>
                                        <td>IDR 750,000.-</td>
                                        <td>USD 100</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>                            
                            <br><br>
                        </div>
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Wednesday, June 12, 2024</h4>
                            <p>- Opening Ceremony</p>
                            <p>- TC Open Meeting</p>
                            <p>- Day 1 Capacity Building for Industries</p>
                            <p><sub>(Limited Seats - first come first serve) <sub></p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_1" value="local" data-price="IDR2000000" data-activity="Day 1 Session(Inc. Opening Ceremony + TC Open Meeting ) - Local Participant"> Local Participants (IDR 2.000.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_1" value="foreign" data-price="USD250" data-converted-price="4075000" data-activity="Day 1 Session (Inc. Opening Ceremony + TC Open Meeting )  - Foreign Participant"> Foreign Participants (USD 250,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_1">Revert Selection</button>
                            <br>
                        </div>
                        
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Wednesday, June 12, 2024</h4>
                            <p>- Day 1 Capacity Building for Industries</p>
                            <p>- Half-Day Session</p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_2" value="local" data-price="IDR1000000" data-activity="Day 1 Half Day Session - Local Participant"> Local Participants (IDR 1.000.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_2" value="foreign" data-price="USD125" data-converted-price="2037500" data-activity="Day 1 Half Day Session - Foreign Participant"> Foreign Participants (USD 125,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_2">Revert Selection</button>
                            <br>
                        </div>
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Thursday, June 13, 2024</h4>
                            <p>Day 2 Capacity Building for Industries</p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_3" value="local" data-price="IDR2000000" data-activity="Day 2 Session - Local Participant"> Local Participants (IDR 2.000.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_3" value="foreign" data-price="USD250" data-converted-price="4075000" data-activity="Day 2 Session - Foreign Participant"> Foreign Participants (USD 250,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_3">Revert Selection</button>
                            <br>
                        </div>
                        
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Wednesday - Thursday, June 12-13, 2024</h4>
                            <p><b>Package Price </b>for CB only</p>
                            <p> - 2 Days Capacity Building, half day session at 1st day + full session day at 2nd day <small>(does not include Opening Ceremony and TC Open Meeting)</small></p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_4" value="local" data-price="IDR3000000" data-activity="2 Days Package (Half day session at 1st day and full day session at 2nd day not including Opening Ceremony and TC Open Meeting) - Local Participant"> Local Participants (IDR 3.000.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_4" value="foreign" data-price="USD375" data-converted-price="6112500" data-activity="2 Days Package (Half day session at 1st day and full day session at 2nd day not including Opening Ceremony and TC Open Meeting) - Foreign Participant"> Foreign Participants (USD 375,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_4">Revert Selection</button>
                            <br>
                        </div>
                        
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Thursday, June 13, 2024</h4>
                            <p><sub>(Limited Seats - first come first serve) <sub></p>
                            <p>- Halal Awareness by IHATEC</p>
                            <p>- 1 Day Training</p>
                            <p>- Attendance certificate is provided by IHATEC</p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_5" value="local" data-price="IDR2600000" data-activity="Halal Awareness by IHATEC + Attendance certificate - Local Participant"> Local Participants (IDR 2.600.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_5" value="foreign" data-price="USD250" data-converted-price="4075000" data-activity="Halal Awareness by IHATEC + Attendance certificate - Foreign Participant"> Foreign Participants (USD 250,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_5">Revert Selection</button>
                            <br>
                        </div>
                        
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Wednesday - Thursday, June 12-13, 2024</h4>
                            <p><sub>(Limited Seats - first come first serve) <sub></p>
                            <p>- GDPMD (CDAKB) for Technical Responsible Person (PJT)</p>
                            <p>- 2 days session</p>
                            <p>- Certificate provided and issued by Ministry of Health Republic of Indonesia</p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_6" value="local" data-price="IDR4000000" data-activity="2 days GDPMD (CDAKB) for Technical Responsible Person + Certificate by Ministry of Health Republic of Indonesia"> Local Participants (IDR 4.000.000,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_6">Revert Selection</button>
                            <br>
                        </div>
                        
                        <div class="form-holder col-5-5 col-sm-11 activity">
                            <h4>Wednesday, June 12, 2024</h4>
                            <p>Gala Dinner</p>
                            <br>
                            <div class="radio">
                                <label><input type="radio" name="activity_7" value="local" data-price="IDR750000" data-activity="Gala Dinner - Local Participant"> Local Participants (IDR 750.000,-)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="activity_7" value="foreign" data-price="USD100" data-converted-price="1630000" data-activity="Gala Dinner - Foreign Participant"> Foreign Participants (USD 100,-)</label>
                            </div>
                            <button type="button" class="revert-btn" data-target="activity_7">Revert Selection</button>
                            <br><br>
                        </div>
                                                
                    </div>
            </section>
            <section class="section-1" style="background:white">
                <img src="{{ asset('banner.jpg') }}" alt="">
                <div class="inner offset-3 col-6 col-sm-12" style="padding-top:10px">

                    <h2 style="color: grey">Registration Details </h2>
                    <br>
                    <div class="row">
                        <div class="form-row form-group col-11">
                            <div class="form-holder col-3">
                                <select name="honorific" class="form-control default-option" id="input-honorific">
                                    <option selected disabled style="color:grey">Title</option>
                                    <option value="Mr">Mr.</option>
                                    <option value="Mrs">Mrs.</option>
                                    <option value="Ms">Ms.</option>
                                    <option value="Dr">Dr.</option>
                                </select>
                                <span class="asterisk dm-65">*</span>
                            </div>
                            <div class="form-holder col-8">
                                <input type="text" class="form-control" placeholder="Participant Name" autocomplete="off"
                                    name="name" id="input-name">
                                <span class="asterisk dm-120">*</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <input type="text" class="form-control" placeholder="Designation" name="designation" id="input-designation">
                                <span class="asterisk dm-275">*</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <input type="text" class="form-control" placeholder="Company/Organization" name="company" id="input-company">
                                <span class="asterisk dm-200">*</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <input type="text" class="form-control" placeholder="Email" name="email" id="input-email">
                                <i class="zmdi zmdi-email small"></i>
                                <span class="asterisk dm-315">*</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <textarea name="address" class="form-control" cols="30" rows="100" placeholder="Full Address"id="input-address"></textarea>
                                <i class="zmdi zmdi-map small"></i>
                                <span class="asterisk asterisk-ta dm-275">*</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <input type="text" class="form-control phone" placeholder="Telephone/Mobile No."id="input-phone" >
                                <i class="zmdi zmdi-smartphone-android"></i>
                                <span class="asterisk dm-plus-195">*</span>
                                <span class="subscript">(Country Code - Number)</span>
                            </div>
                        </div>
                        <div class="form-row col-11">
                            <div class="form-holder">
                                <input type="text" class="form-control phone" placeholder="Fax No. " id="input-fax">
                                <i class="zmdi zmdi-phone-ring"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 2 -->
            <h4></h4>

            <!-- SECTION 3 -->
            <h4></h4>
            <section class="section-3">
                <img src="{{ asset('banner.jpg') }}" alt="">
                <div class="inner">
                        <h2 style="color: grey">Payment </h2>
                        <div class="row">
                            <div class="col-12">
                                <br><br>
                                <div id="shopping-cart">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Activity</th>
                                                <th>Price (IDR)</th>
                                                <th>Price (USD)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Shopping cart items will be appended here -->
                                        </tbody>
                                        <tfoot>
                                            <!-- Subtotal will be inserted here -->
                                        </tfoot>
                                    </table>
                                </div>
                                <br>
                                <div class="form-holder col-5-5 col-sm-11">
                                    <h4 style="margin-bottom:10px">Do you need invitation letter for Visa Application?<sup style="color: red">*</sup></h4>
                                    <div class="radio">
                                        <label><input type="radio" name="payment_letter" value="true"> Yes</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="payment_letter" value="false" checked> No</label>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-holder col-md-6 col-sm-11">
                                    <h4 style="margin-bottom:10px">Payment Option<sup style="color: red">*</sup></h4>
                                    <div class="radio">
                                        <label><input type="radio" name="payment_method" value="doku" checked> Credit Card</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="payment_method" value="transfer"> Bank Transfer (IDR only)</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="payment_method" value="letter"> Pay with Guarantee Letter (for manual bank transfer, payment with term and pay using CC onsite)</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-12">
                                <button id="checkout-button" type="button" style="display: none" onclick="payment()">Checkout Now</button>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <input type="hidden" name="total" id="total_amount">
            <input type="hidden" name="currency" id="total_currency">
            <input type="hidden" name="items" id="items_count">
            <input type="hidden" name="phone" id="formatted-phone"> 
            <input type="hidden" name="fax" id="formatted-fax">
            <input type="hidden" name="fee" id="fee_amount">
            {{-- <input type="hidden" name="guarantee_letter_id" id="guarantee_letter_id"> --}}
        </form>
    </div>
    <script>
        $(document).ready(function() {

            $(document).on("submit", "#wizard", function(e) {
                e.preventDefault();
                console.log('submit hold');
                if ($('#total_currency').val() === "") {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "You can only choose one participant type!"
                    });
                } else {

                    console.log('submit serialize');
                    var formData = $("#wizard").serialize();

                    var actionUrl = $("#wizard").attr("action");

                    var paymentType = $("input[name='payment_method']:checked").val();
                    console.log(paymentType);

                    $.ajax({
                            url: actionUrl, // Use the same URL for both payment methods
                            type: "POST",
                            dataType: "json",
                            data: formData,
                            async: true,
                            success: function(response) {
                                // Handle response based on payment method
                                if (response.success) {
                                    if (paymentType === "doku" || paymentType === "transfer") {
                                        payment(response);
                                    } else {
                                        if (response.success) {
                                            // Registration successful
                                            Swal.fire({
                                                icon: "success",
                                                title: "Success",
                                                text: response.message
                                            });
                                        } else {
                                            // Registration failed
                                            Swal.fire({
                                                icon: "error",
                                                title: "Error",
                                                html: response.message + (response.error ? "<br><small>" + response.error + "</small>" : "")
                                            });
                                        }
                                    }
                                }
                                else
                                {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        html: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // AJAX request failed
                                console.error(error);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "Failed to submit the form. Please try again later."
                                });
                            }
                        });
                }
            });
            $('#csrf-token').val($('meta[name="csrf-token"]').attr('content'));

            var shoppingCart = [];

            $('.form-holder input').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $(this).siblings('.asterisk').hide();
                    $(this).siblings('.subscript').hide();
                } else {
                    $(this).siblings('.asterisk').show();
                    $(this).siblings('.subscript').show();
                }
            });
            $('.form-holder textarea').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $(this).siblings('.asterisk').hide();
                    $(this).siblings('.subscript').hide();
                } else {
                    $(this).siblings('.asterisk').show();
                    $(this).siblings('.subscript').show();
                }
            });

            $(window).on('resize', function() {
                var screenWidth = $(window).width();
                var start = 5;
                var end = 300;
                var step = 5;

                for (var i = start; i <= end; i += step) {
                    var className = '.dm-' + i;
                    var newClassName = '.dm-' + i + 'x';

                    if (screenWidth < 768) {
                        $(className).removeClass(className.slice(1)).addClass(newClassName.slice(1));
                    } else {
                        $(newClassName).removeClass(newClassName.slice(1)).addClass(className.slice(1));
                    }
                }
            });

            $('.phone').on('input', function() {

                $(this).val(function(index, value) {
                    return value.replace(/[^0-9+\-\s]/g, '');
                });
            });

            $('select.form-control').change(function() {
                if ($(this).val() === "") {
                    $(this).addClass('default-option');
                    $(this).siblings('.asterisk').show();
                    $(this).siblings('.subscript').show();
                } else {
                    $(this).removeClass('default-option');
                    $(this).siblings('.asterisk').hide();
                    $(this).siblings('.subscript').hide();
                }
            });

            $('.revert-btn').click(function() {
                var target = $(this).data('target');
                $('input[name="' + target + '"]').prop('checked', false);
                $(this).fadeToggle();
                $(this).closest('.activity').removeClass('light-blue-bg');

                var checkedRadio = $(this).closest('.activity').find('input[type="radio"]:checked');
                var value = 'local'; 

                if (checkedRadio.length > 0) {

                    var price = checkedRadio.data('price');
                    value = price.includes('USD') ? 'foreign' : 'local';
                }

                $(this).val(value);

                updateCart(); 
            });

            $('.activity input[type="radio"]').change(function() {
                var target = $(this).attr('name');
                var anyChecked = $('input[name="' + target + '"]:checked').length > 0;
                $(this).closest('.activity').toggleClass('light-blue-bg', anyChecked);
                $('.revert-btn[data-target="' + target + '"]').fadeToggle(anyChecked);
            });

            $('.radio input[type="radio"]').change(function() {
                updateCart();
            });
            $(document).on('click','.zmdi-pin-help',function() {
                Swal.fire({
                        icon: 'info',
                        title: 'About Currency Conversion',
                        html: '<small>Due to regulation, all payments from outside the country needs to be converted before transaction. The exchange rate we use are fixed at USD $1 = Rp. 16,300.00 for this transaction</small>'
                    });
            });

            function updateCart() {
                
                $('#shopping-cart tbody').empty();

                var subtotalIDR = 0;
                var subtotalUSD = 0;
                var latestCheckedRadio = null;
                var itemsCount = 0;
                var subtotalCurrency = 'IDR'; // Currency is always IDR
                var hasFullActivity = false;
                var fullActivity = null;
                
                $('.activity .radio input[type="radio"]').each(function() {
                    if ($(this).is(':checked')) {
                        var selectedActivity = $(this).attr('name');
                        if (selectedActivity === 'activity_1') {
                            // Mark that a full activity was found
                            hasFullActivity = true;
                            fullActivity = selectedActivity;
                        } else {
                            var activityName = $(this).data('activity');
                            var activityPrice = $(this).data('price');
                            var convertedPrice = $(this).data('converted-price');
                            var currency = activityPrice.includes('IDR') ? 'IDR' : 'USD';
                            activityPrice = activityPrice.replace(currency, '').trim();

                            $('#shopping-cart tbody').append(
                                '<tr>' +
                                '<td>' + activityName + '</td>' +
                                '<td>' + (currency === 'IDR' ? 'IDR ' + activityPrice.replace(/\d(?=(\d{3})+\.)/g, '$&,') : '') + '</td>' +
                                '<td>' + (currency === 'USD' ? 'USD ' + activityPrice.replace(/\d(?=(\d{3})+\.)/g, '$&,') : '') + '</td>' +
                                '</tr>'
                            );

                            

                            if (currency === 'IDR') {
                                subtotalIDR += parseFloat(activityPrice);
                            } else {
                                subtotalIDR += parseFloat(convertedPrice);
                                subtotalUSD += parseFloat(activityPrice);
                                subtotalCurrency = 'USD'; 
                            }

                            itemsCount++;
                            latestCheckedRadio = $(this); // Move this line here
                        }
                    }
                });

                if (hasFullActivity) {
                    var swalMessage;
                            // Display a warning using Swal.fire
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: "We're sorry, but this activity is fully booked. Please choose another activity."
                            }).then((result) => {
                                // Trigger click event for activity_2 button
                                $('.revert-btn[data-target="'+fullActivity+'"]').trigger('click');
                            });
                            return false; // Exit the loop early
                        }

                var paymentType = $("input[name='payment_method']:checked").val();

                // Check if multiple currencies are selected
                if (latestCheckedRadio) {
                    var selectedCurrency = latestCheckedRadio.val();
                    var allSameCurrency = true;

                    $('.activity .radio input[type="radio"]').each(function() {
                        if ($(this).is(':checked') && $(this).val() !== selectedCurrency) {
                            allSameCurrency = false;
                            return false; // Exit the loop early
                        }
                    });

                    if (!allSameCurrency) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You can only choose one currency.'
                        }).then((result) => {
                            var target = latestCheckedRadio.attr('name');
                            $('.revert-btn[data-target="' + target + '"]').trigger('click');
                        });
                        return false;
                    }
                }
            
                var fee = 0;
                var total = subtotalIDR; // Total is always based on IDR subtotal

                if (paymentType === 'doku') {
                    fee = subtotalIDR * 0.04;
                    total += fee;
                } else if (paymentType === 'transfer') {
                    fee = 4000;
                    total += fee;
                }
                
                var feeRow = '<tr>' +
                    '<td style="text-align:right" class="subtotal">Admin Fee' + (paymentType === 'doku' ? '(4%)' : '') + ':</td>' +
                    '<td style="text-align:right" colspan="2" class="subtotal">IDR ' + fee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>' +
                    '</tr>';

                // Display subtotal in USD if the selected radios are 'foreign'
                var subtotalDisplay = subtotalCurrency === 'USD' ? subtotalUSD : subtotalIDR;

                $('#shopping-cart tfoot').html(
                    '<tr>' +
                    '<td style="text-align:right" class="subtotal">Subtotal:</td>' +
                    '<td style="text-align:right" colspan="2" class="subtotal">' + (subtotalCurrency === 'IDR' ? 'IDR ' : 'USD $') + subtotalDisplay.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>' +
                    '</tr>' +
                    (subtotalCurrency === 'USD' ? '<tr><td style="text-align:right" class="subtotal">Exchange rate <i class="zmdi zmdi-pin-help small" style="color:#17a2b8; cursor:pointer"></i> :</td><td style="text-align:right" colspan="2" class="subtotal">USD $1 = Rp. 16.300</td></tr>' : '') + 
                    (paymentType === 'doku' || paymentType === 'transfer' ? feeRow : '') +
                    '<tr>' +
                    '<td style="text-align:right" class="total">Total:</td>' +
                    '<td style="text-align:right" colspan="2" class="total">IDR ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>' +
                    '</tr>'
                );

                $('#items_count').val(itemsCount);
                $('#total_amount').val(total.toFixed(2));
                $('#total_currency').val(subtotalCurrency);
                $('#fee_amount').val(fee.toFixed(2));
            }

            const events = ["countrychange", "keyup", "keydown", "change", "focus", "focusout", "blur", "input"];
            const input_phone = intlTelInput( document.querySelector("#input-phone"), {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@22.0.2/build/js/utils.js",
            });
            const inputPhone = document.querySelector("#input-phone");
            const input_fax = intlTelInput( document.querySelector("#input-fax"), {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@22.0.2/build/js/utils.js",
            });
            const inputFax = document.querySelector("#input-fax");

            events.forEach(event => {
                inputPhone.addEventListener(event, function() {
                    const phone_number = input_phone.getNumber();

                    document.getElementById("formatted-phone").value = phone_number;
                });
                inputFax.addEventListener(event, function() {
                    const fax_number = input_fax.getNumber();

                    document.getElementById("formatted-fax").value = fax_number;
                });
            });
            $(".iti").css('width','100%');
            
            window.bottomPosition = parseFloat($('.actions ul').css('bottom'));
            window.bottomPosition = parseFloat($('.steps').css('bottom'));

            $('input[name="payment_method"]').on('change', function() {
                var paymentMethod = $(this).val();

                if (paymentMethod === 'letter') {
                    // openUploadModal();
                    $('.actions ul').css('bottom', window.actionsBottom).css('bottom', '-=19px');
                    $('.steps').css('bottom', window.stepsBottom).css('bottom', '-=19px');
                } else {
                    $('.actions ul').css('bottom', window.actionsBottom).css('bottom', '-=39px');
                    $('.steps').css('bottom', window.stepsBottom).css('bottom', '-=39px');
                }
            });
        });
    </script>
    <script>

        var invoice;
        var requestDate;
        var clientId;
        var requestTarget;

        function uuidv4() {
            return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
                (+c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +c / 4).toString(16)
            );
        }

        function generateSignature(jsonBody, clientId, requestId, requestTimestamp, secretKey) {
            const digestSHA256 = CryptoJS.SHA256(CryptoJS.enc.Utf8.parse(jsonBody));
            const digestBase64 = CryptoJS.enc.Base64.stringify(digestSHA256);

            const signatureComponents = `Client-Id:${clientId}\n` +
                `Request-Id:${requestId}\n` +
                `Request-Timestamp:${requestTimestamp}\n` +
                'Request-Target:/checkout/v1/payment\n' +
                `Digest:${digestBase64}`;

            const signatureHmacSha256 = CryptoJS.HmacSHA256(signatureComponents, secretKey);
            const signatureBase64 = CryptoJS.enc.Base64.stringify(signatureHmacSha256);

            return `HMACSHA256=${signatureBase64}`;
        }

    function createHeaders(requestId, requestBody, clientId, secretKey) {
        // const requestId = uuidv4();
        const requestTimestamp = new Date().toISOString().slice(0, 19) + 'Z';
        const signature = generateSignature(requestBody, clientId, requestId, requestTimestamp, secretKey);

        return {
            'Request-Id': requestId,
            'Client-Id': clientId,
            'Request-Timestamp': requestTimestamp,
            'Signature': signature
        };
    }

    function payment(responseData) {
        const clientId = '{{ env("DOKU_CLIENT_ID") }}';
        const secretKey = '{{ env("DOKU_CLIENT_SECRET") }}';

        var headers = createHeaders(responseData.request_id, JSON.stringify(responseData.body), clientId, secretKey);

        var requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...headers,
            },
            body: JSON.stringify(responseData.body),
        };

        var environmentUrl = '{{ env("DOKU_API_IPG") }}';

        fetch(environmentUrl + '/checkout/v1/payment', requestOptions)
            .then((response) => {
                console.log(response);
                response.json().then((data) => {
                    if (response.status !== 200) {
                        return catchFailed(JSON.stringify(data.error.message));
                    }

                    // Extract the session ID from the response
                    var sessionId = data.response.payment.token_id;

                    // AJAX request to update the session ID in the backend
                    $.ajax({
                        url: '{{route("update_session_id")}}',
                        type: 'PUT',
                        data: {
                            session_id: sessionId,
                            request_id: responseData.request_id, // Pass the request_id
                        },
                        success: function (response) {
                            console.log('Session ID updated successfully.');
                            // Load Jokul Checkout after updating the session ID
                            loadJokulCheckout(data.response.payment.url);
                        },
                        error: function (xhr, status, error) {
                            console.error('Failed to update session ID:', error);
                            catchFailed('');
                        }
                    });
                }).catch(error => {
                    catchFailed("");
                });
            });
    }

        function createHeader(invoice, clientId, requestDate,signature) {
            var headers = new Headers();
            headers.append("Content-Type", "application/json");
            headers.append("Signature", 'HMACSHA256='+signature); 
            headers.append("Request-Id", invoice);
            headers.append("Client-Id", clientId);
            headers.append("Request-Timestamp", requestDate);

            return headers;
        }

        function catchFailed(error) {
            Swal.fire({
                title: "Order Failed",
                text: error,
                icon: "error",
                button: "Close",
            });
        }

        function openUploadModal() {
            Swal.fire({
                title: 'Upload Guarantee Letter',
                html: '<input type="file" id="guarantee-letter" accept=".docx, .pdf" onchange="uploadGuaranteeLetter()">',
                showCancelButton: true,
                confirmButtonText: 'Upload',
                preConfirm: () => {
                    // Handle file upload in uploadGuaranteeLetter() function
                    return false; // Prevent closing the modal here
                }
            });
        }

        function uploadGuaranteeLetter() {
            // Fetch CSRF token from meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Get the file from input
            var file = document.getElementById('guarantee-letter').files[0];

            // Check if file is selected
            if (!file) {
                Swal.showValidationMessage('Please select a file');
                return;
            }

            // Validate file size
            if (file.size > 5 * 1024 * 1024) {
                Swal.showValidationMessage('File size exceeds 5MB limit');
                return;
            }

            // Create FormData object and append the file input
            var formData = new FormData();
            formData.append('_token', csrfToken); // Append CSRF token
            formData.append('guarantee_letter', file);

            // Perform AJAX upload
            $.ajax({
                url: "{{ route('submit_guarantee_letter') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#guarantee_letter_id').val(response.id);
                    Swal.fire('Success', 'Guarantee letter uploaded successfully', 'success');
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to upload guarantee letter', 'error');
                }
            });
        }
    </script>
    @if(Session::has('response'))
        <script>
            swal.fire({
                title: '{{ Session::get('response')['success'] ? "Success" : "Error" }}',
                html: '{!! Session::get('response')['message'] !!}',
                icon: '{{ Session::get('response')['success'] ? "success" : "error" }}'
            });
        </script>
    @endif
</body>

</html>