$(document).ready(function () {
    // Function to show loader
    function showLoader() {
        document.getElementById('submitLoader').style.display = 'flex';
    }
    
    // Function to hide loader
    function hideLoader() {
        document.getElementById('submitLoader').style.display = 'none';
    }
    const urlParams = new URLSearchParams(window.location.search);
    const requestId = urlParams.get('request_id');
    const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

    // If the request_id exists, trigger the change event on the dropdown
    setTimeout(() => {
        $('.lock-overlay').fadeIn(1500);
        console.log(requestId);
        var $dropdown = $('#validatePaymentID');
        var optionExists = $dropdown.find('option[value="' + requestId + '"]').length > 0;
        
        if (requestId) {
            if (optionExists) {
                $dropdown.val(requestId).trigger('change');
            } else {
                // Display an error message if the requestId is not found in the dropdown
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid request ID',
                });
            }
        }
    }, 1000);

    $('.datatable').each(function() {
        var table = $(this);
    
        var options = {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details for Registration ID : ' + data[0] + ', ' + data[1];
                        }
                    }),
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col) {
                            var cell = api.cell(rowIdx, col.columnIndex).node();
                            if (col.title === 'Register Date') {
                                var fullDateTime = $(cell).data('full-datetime');
                                return '<tr data-dt-row="' + rowIdx + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td>' + col.title + ':' + '</td> ' +
                                    '<td>' + fullDateTime + '</td>' +
                                    '</tr>';
                            } else {
                                return '<tr data-dt-row="' + rowIdx + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td>' + col.title + ':' + '</td> ' +
                                    '<td>' + col.data + '</td>' +
                                    '</tr>';
                            }
                        }).join('');
    
                        return $('<table/>').append(data);
                    }
                }
            }
        };
    
        if (table.attr('id') === 'registrationListTable') {
            options["columnDefs"] = [{
                "targets": 9, 
                "type": "date",
                "render": function(data, type, row, meta) {
                    if (type === 'display' || type === 'filter') {
                        return $(meta.settings.aoData[meta.row].anCells[meta.col]).data('full-datetime').split(' ')[0];
                    }
                    return data;
                },
            }];
            options["order"] = [[9, 'desc']];
        }
    
        table.DataTable(options);
    });    
    
    $('.select2').select2();
    // Handle change event on select dropdown
    $('#validatePaymentID').on('change', function() {
        var paymentId = $(this).val();
        showLoader();

        // Make AJAX request to get payment details
        $.ajax({
            url: appUrl + '/admin/get-payment-details/' + paymentId,
            type: 'GET',
            dataType: "json",
            beforeSubmit:function() {
            },
            success: function(response) {
                console.log(response);

                if (response.success) {
                    // Fill form fields with payload data
                    var payload = JSON.parse(response.data.payload);
                    $('#created_at').val(response.data.created_at);
                    $('#updated_at').val(response.data.updated_at);
                    $('#name').val(payload.name);
                    $('#email').val(payload.email);
                    for (let i = 1; i <= 7; i++) {
                        let activityField = '#activity_' + i;
                        let activityValue = payload['activity_' + i];
                    
                        if (activityValue !== 'local' && activityValue !== 'foreign') {
                            $(activityField).val('');
                        } else {
                            $(activityField).val(activityValue);
                        }
                    }
                    $('#honorific').val(payload.honorific);
                    $('#name').val(payload.name);
                    $('#designation').val(payload.designation);
                    $('#company').val(payload.company);
                    $('#email').val(payload.email);
                    $('#address').val(payload.address);
                    $('#payment_letter').val(payload.payment_letter);
                    $('#payment_method').val(payload.payment_method);
                    $('#total').val(payload.total);
                    $('#currency').val(payload.currency);
                    $('#items').val(payload.items);
                    $('#phone').val(payload.phone);
                    $('#fax').val(payload.fax);
                    $('#fee').val(payload.fee);

                    // Show payment details card
                    $('#paymentDetailsCard').show();
                }
                else
                {
                    swal.fire({
                        icon : 'error',
                        title : 'error',
                        text : response.error,
                    });
                }
                hideLoader();
            },
            error: function(xhr, status, error) {
                hideLoader();
                console.error();
                swal.fire({
                    icon : 'error',
                    title : 'error',
                    text : xhr.responseText,
                });
            }
        });
    });
    
    $('#paymentValidationForm').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission
        showLoader();
    
        var requestID = $('#validatePaymentID').val();
    
        $.ajax({
            url: appUrl + '/registration/validate-payment/' + requestID,
            type: 'GET',
            beforeSend: function () {
                // Show loader or perform any pre-submission tasks
            },
            success: function (response) {
                hideLoader();
                if (response.success) {
                    swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.message,
                    });
                } else {
                    var msg = response.message;
                    if (response.error) {
                         msg+= '<br><br><small>'+ response.error +'</small>';
                    } else {
                        
                    }
                    var swalOptions = {
                        icon: 'error',
                        title: 'Error',
                        html: msg,
                    };
    
                    if (response.removeable) {
                        swalOptions.showCancelButton = true;
                        swalOptions.cancelButtonText = 'Cancel';
                        swalOptions.confirmButtonText = 'Delete this transaction';
    
                        swalOptions.preConfirm = function () {
                            return $.ajax({
                                url: appUrl + '/admin/registration/remove/' + requestID,
                                type: 'GET',
                                dataType: 'json',
                            });
                        };
    
                        swalOptions.allowOutsideClick = () => !Swal.isLoading();
    
                        swalOptions.confirmButtonColor = '#d33';
                    }
    
                    Swal.fire(swalOptions).then((result) => {
                        if (result.isConfirmed) {
                            swal.fire({
                                icon: 'warning',
                                title: 'Confirmation',
                                text: 'Are you sure you want to delete this transaction?',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                            }).then((confirmResult) => {
                                showLoader();
                                if (confirmResult.isConfirmed) {
                                    hideLoader();
                                    swal.fire({
                                        icon: 'info',
                                        title: 'Info',
                                        html: result.value.message || result.value.error,
                                    }).then(() => {
                                        const urlParams = new URLSearchParams(window.location.search);
                                        urlParams.delete('request_id');
                                        window.history.replaceState({}, document.title, "?" + urlParams.toString());
                                        location.reload();
                                    });
                                }
                                else
                                {
                                    hideLoader();
                                }
                            });
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire('Error', xhr.responseText, 'error');
                hideLoader();
            }
        });        
    });
    
    $('#mailResendForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data

        showLoader();
        $.ajax({
            url: appUrl + '/admin/registration/mail-resend', // URL to your resendMail method
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Handle success response
                if (response.success) {
                    hideLoader();
                    // Display success message using SweetAlert
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        button: 'OK',
                    }).then((value) => {
                        location.reload();
                    });
                } else {
                    hideLoader();
                    // Display error message using SweetAlert
                    swal.fire({
                        title: 'Error',
                        html: response.message + '<br><br><small>' + response.error + '</small>',
                        icon: 'error',
                        button: 'OK',
                    });
                }
            },
            error: function(xhr, status, error) {
                hideLoader();
                // Handle error response
                swal.fire({
                    title: 'Error',
                    text: 'An error occurred while processing your request. Please try again later.',
                    icon: 'error',
                    button: 'OK',
                });
            }
        });
    });
    
});

