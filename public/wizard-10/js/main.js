$(function(){
	$("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 300,
        labels: {
            next: "Next",
            previous: "Back"
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            // Step 1 validation
            if (newIndex === 1) {
                var selectedRadios = $('input[name^="activity_"]:checked').length;
                if (selectedRadios === 0) {
                    // Show SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select at least one activity.',
                    });
                    return false;
                }
            }
        
            // Step 2 validation
            if (newIndex === 2) {
                var emptyInputs = []; // Array to store the placeholders of empty inputs
                var inputs = ['#input-name', '#input-designation', '#input-company', '#input-email', '#input-phone'];
            
                // Check if the honorific dropdown is set to the default option
                var $honorific = $('#input-honorific');
                if ($honorific.val() === null) {
                    emptyInputs.push("Honorific");
                }
            
                // Function to check if the ITI phone dropdown is empty
                function isPhoneITIEmpty() {
                    return $('.iti__selected-country').first().attr('title') === 'Unknown';
                }
            
                // Function to check if the ITI fax dropdown is empty
                function isFaxITIEmpty() {
                    return $('.iti__selected-country').last().attr('title') === 'Unknown';
                }
            
                // Add input-phone and input-fax to the list of inputs
                inputs.push('#input-phone');
            
                inputs.forEach(function(input) {
                    var $input = $(input);
                    console.log("Checking input:", input);
                    if (!$input.val() || !$input.val().trim()) { // Adjusted condition to check if input is empty
                        emptyInputs.push($input.attr('placeholder')); // Store the placeholder of the empty input
                    }
                });
            
                // Check if the ITI phone dropdown is empty
                if (isPhoneITIEmpty()) {
                    emptyInputs.push("Please provide the country code for your phone number");
                }
            
                // Check if the fax input is filled but the ITI fax dropdown is not selected
                if ($('#input-fax').val().trim() && isFaxITIEmpty()) {
                    emptyInputs.push("Please select the country for your fax number or leave it blank");
                }
            
                if (emptyInputs.length > 0) {
                    // Create a message for empty inputs
                    var emptyInputsMessage = emptyInputs.join(', ');
                    // Show SweetAlert error message with custom HTML description
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'Please fill in the following required fields: <br><br><div style="font-size: smaller; font-weight: 300;"> ' + emptyInputsMessage + '</div>', // Custom HTML description with smaller and thinner fonts
                    });
                    return false;
                }
            }
            
        
            // Step transition effect
            if (newIndex === 1) {
                $('.steps').addClass('step-2').css('bottom', '-100px');
                $('.actions ul').css('bottom', '-120px');
            } else {
                $('.steps').removeClass('step-2').css('bottom', '-240px');
                $('.actions ul').css('bottom', '-300px');
            }

            if (newIndex === 2) {
                $('.steps').addClass('step-3');
                var itemsCount = parseInt($('#items_count').val());
                var bottomPosition = itemsCount * (-29); // Adjusted by 29px for better visibility
            
                // Check if "activity_6" is selected and adjust the bottom position accordingly
                if ($('input[name="activity_6"]').is(':checked')) {
                    bottomPosition -= 29; // Subtract 29px for the special case
                }
            
                $('.actions ul').css('bottom', '-260px').css('bottom', '+=' + bottomPosition + 'px');
                $('.steps').css('bottom', '-240px').css('bottom', '+=' + bottomPosition + 'px');
            
                // Adjust height based on items_count and the special case
                var height = 706 + (itemsCount * 29); //28.57 rounded to 29
                if ($('input[name="activity_6"]').is(':checked')) {
                    height += 29; // Add extra 29px for the special case
                }
                $('.section-3 .inner').css('height', height + 'px');
            } else {
                $('.steps').removeClass('step-3');
            }
            
        
            return true; // Allow navigation to the next step
        },        
        onFinishing: function (event, currentIndex) {
            event.preventDefault();
                console.log('submit hold');
                if ($('#total_currency').val() === "") {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "You can only choose one participant type!"
                    });
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Proceeding to payment ... ",
                        html: "please confirm your registration after the payment by pressing the <strong>&quot;Back to Merchant&quot;</strong> ",
                        showDenyButton: true,
                        confirmButtonText: "OK",
                        denyButtonText: `Cancel`
                    }).then((result) => {
                        // Serialize form data
                        console.log('submit serialize');
                        var formData = $("#wizard").serialize();
                        
                        // Extract the action URL from the form
                        var actionUrl = $("#wizard").attr("action");
                        
                        // Get the value of the payment type
                        var paymentType = $("input[name='payment_method']:checked").val();
                        console.log(paymentType);
                        
                        // Send AJAX request
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
                    })
                }
        }
        
    });
    // Custom Jquery Steps
    $('.forward').click(function(){
    	$("#wizard").steps('next');
    })
    $('.backward').click(function(){
        $("#wizard").steps('previous');
    })
    // Select
    $('html').click(function() {
        $('.select .dropdown').hide(); 
    });
    $('.select').click(function(event){
        event.stopPropagation();
    });
    $('.select .select-control').click(function(){
        $(this).parent().next().toggle().toggleClass('active');
    })
    $('.select .dropdown li').click(function(){
        $(this).parent().toggle();
        var text = $(this).attr('rel');
        $(this).parent().prev().find('div').text(text);
    })
    // Payment
    $('.payment-block .payment-item').click(function(){
        $('.payment-block .payment-item').removeClass('active');
        $(this).addClass('active');
    })
    // Date Picker
    var dp1 = $('#dp1').datepicker().data('datepicker');
})
