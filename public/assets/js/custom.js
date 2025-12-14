$(".onlydigit").keypress(function (e) {
    var charCode = (e.which) ? e.which : e.keyCode;

    // Allow digits (0-9), backspace, and decimal point
    if (charCode != 8 && charCode != 0 && charCode != 46 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
        return false;
    }

    // Allow only one decimal point
    var inputValue = $(this).val();
    if (charCode == 46 && inputValue.indexOf('.') !== -1) {
        e.preventDefault();
        return false;
    }
});

$(".onlyphone").on("keypress", function (e) {
    var charCode = (e.which) ? e.which : e.keyCode;

    // Allow only digits (0–9) and backspace
    if (charCode < 48 || charCode > 57) {
        if (charCode !== 8) {
            e.preventDefault();
        }
    }

    // Restrict length to 10 digits
    if ($(this).val().length >= 10 && charCode !== 8) {
        e.preventDefault();
    }
});


$(".onlyalpha").on("keydown", function (event) {
    // Allow controls such as backspace, tab etc.
    var arr = [8, 9, 16, 17, 20, 32, 35, 36, 37, 38, 39, 40, 45, 46];
    // Allow letters
    for (var i = 65; i <= 90; i++) {
        arr.push(i);
    }
    // Prevent default if not in array
    if (jQuery.inArray(event.which, arr) === -1) {
        event.preventDefault();
    }
});


function confirmDelete() {

    return confirm('Are you sure you want to delete this item? This action cannot be undone.');
}

// *************************
//   previewImage
// *************************
function previewImage(input, previewId) {
    const previewBox = document.getElementById(previewId);
    previewBox.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewBox.innerHTML = `
          <div class="position-relative d-inline-block me-2">
            <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;" onclick="openFullImage('${e.target.result}')">
            <button type="button" class="btn-close position-absolute top-0 end-0" onclick="removeImage('${input.id}', '${previewId}')"></button>
          </div>
        `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(inputId, previewId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewId).innerHTML = '';
}

function openFullImage(src) {
    const win = window.open();
    win.document.write(`<img src="${src}" style="max-width:100%; height:auto;">`);
}
//  --------------END /previewImage ------------------



// *************************
//   IFSC Validation
// *************************

$(document).ready(function () {
    $(document).on('blur', '.ifsc_code', function () {
        const input = $(this); // current IFSC field
        const parent = input.closest('.bank-details-row'); // row wrapper
        const errmsg = parent.find('.errmsg'); // error span for this row
        const ifsc = input.val().trim();

        // Reset previous state
        errmsg.text('').removeClass('d-block');
        input.removeClass('is-invalid');
        parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');

        // ✅ Validation check
        if (ifsc === '') return; // skip if empty

        // if (ifsc.length !== 11) {
        //     // ❌ Invalid length
        //     input.addClass('is-invalid');
        //     parent.find('.errmsg').text('IFSC Code must be 11 characters long.');
        //     // errmsg.text('')
        //     //     .addClass('d-block')
        //     //     .show();
        //     return;
        // }


        // ✅ Call API
        if (ifsc.length === 11) {
            $.ajax({
                url: '/api/validate-ifsc',
                type: 'POST',
                data: { ifsc: ifsc },
                beforeSend: function () {
                    parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('Fetching...');
                },
                success: function (response) {
                    if (response.status === true && response.data) {
                        // ✅ Valid IFSC
                        parent.find('.micrcode').val(response.data.MICR || '');
                        parent.find('.bank_name').val(response.data.BANK || '');
                        parent.find('.branch_name').val(response.data.BRANCH || '');
                        parent.find('.bank_code').val(response.data.BANKCODE || '');
                    } else {
                        // ❌ Invalid IFSC
                        input.addClass('is-invalid');
                        parent.find('.errmsg').text('Invalid IFSC Code. Please check again.');
                        // errmsg.text('Invalid IFSC Code. Please check again.')
                        //     .addClass('d-block')
                        //     .show();
                        parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
                    }
                },
                error: function () {
                    // ❌ API Error
                    input.addClass('is-invalid');
                    errmsg.text('Error fetching IFSC details. Please try again.')
                        .addClass('d-block')
                        .show();
                    parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
                }
            });

        } else if (ifsc !== '') {
            parent.find('.bank_name, .branch_name, .bank_code').val('');
            $this.addClass('is-invalid');
            errmsg.text('Invalid IFSC. It must be 11 characters..').show();
        } else {
            parent.find('.bank_name, .branch_name, .bank_code').val('');
        }
    });
});
//  --------------END /IFSC Validation ------------------




// *************************
//   Add More Bank Details
// *************************
$(document).ready(function () {

    // Set correct initial index based on existing rows
    let bankIndex = $('.bank-details-row').length - 1;

    // -------------------------------
    // ✅ Add New Bank Row
    // -------------------------------
    $('#addMoreBank').on('click', function () {
        bankIndex++;

        let clone = $('.bank-details-row:first').clone();

        // Reset all input values
        clone.find('input[type="text"]').val('');
        clone.find('.errmsg').text('').hide();
        clone.find('.removeBankRow').removeClass('d-none');
        clone.find('.setPrimary').prop('checked', false);

        // Update input names with new index
        clone.find('input').each(function () {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr(
                    'name',
                    name.replace(/\[\d+\]/, `[${bankIndex}]`)
                );
            }
        });

        $('#bankDetailsWrapper').append(clone);
    });

    // -------------------------------
    // ✅ Remove Bank Row
    // -------------------------------
    $(document).on('click', '.removeBankRow', function () {
        $(this).closest('.bank-details-row').remove();

        // Re-index all remaining rows
        $('#bankDetailsWrapper .bank-details-row').each(function (i, row) {
            $(row)
                .find('input')
                .each(function () {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr(
                            'name',
                            name.replace(/\[\d+\]/, `[${i}]`)
                        );
                    }
                });
        });
    });

    // -------------------------------
    // ✅ Only one "Primary" checkbox allowed
    // -------------------------------
    $(document).on('change', '.setPrimary', function () {
        if ($(this).is(':checked')) {
            $('.setPrimary').not(this).prop('checked', false);
        }
    });

    // -------------------------------
    // ✅ IFSC Validation + Autofill
    // -------------------------------
    $(document).on('blur', '.ifsc_code', function () {
        const $this = $(this);
        const ifsc = $this.val().trim();
        const parent = $this.closest('.bank-details-row');
        const errmsg = parent.find('.errmsg');

        errmsg.text('').hide();
        $this.removeClass('is-invalid');

        // Validation: IFSC must be 11 chars
        if (ifsc.length === 11) {

            $.ajax({
                url: "/api/validate-ifsc",
                type: "POST",
                data: { ifsc: ifsc },

                beforeSend: function () {
                    parent.find('.micrcode, .bank_name, .branch_name, .bank_code')
                        .val('Fetching...');
                },

                success: function (response) {
                    console.log("MICR from API:", response);

                    if (response.status === true && response.data) {

                        parent.find('.micrcode').val(response.data.MICR || '');
                        parent.find('.bank_name').val(response.data.BANK || '');
                        parent.find('.branch_name').val(response.data.BRANCH || '');
                        parent.find('.bank_code').val(response.data.BANKCODE || '');

                    } else {
                        parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
                        $this.addClass('is-invalid');
                        errmsg.text('Invalid IFSC Code. Please check again.').show();
                    }
                },

                error: function () {
                    parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
                    $this.addClass('is-invalid');
                    errmsg.text('Error fetching IFSC details. Please try again.').show();
                }
            });

        } else if (ifsc !== "") {
            parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
            $this.addClass('is-invalid');
            errmsg.text('IFSC Code must be 11 characters long.').show();

        } else {
            // Empty IFSC → clear fields
            parent.find('.micrcode, .bank_name, .branch_name, .bank_code').val('');
        }
    });

});

//  --------------END /Add More Bank Details ------------------



$(document).on('input', '#est_date', function () {
    let value = $(this).val();
    let year = value.split('-')[0];
    let errorDiv = $('#est_date_error');

    if (year && year.length > 4) {
        $(this).addClass('is-invalid');
        errorDiv.removeClass('d-none');
        $(this).val(''); // clear invalid value
    } else {
        $(this).removeClass('is-invalid');
        errorDiv.addClass('d-none');
    }
});



// ****************************************
// Image Temporary Upload
// ****************************************

function uploadTempFile(input, fieldName) {

    let file = input.files[0];
    if (!file) return;

    let formData = new FormData();
    formData.append("file", file);
    formData.append("field_name", fieldName);

    $.ajax({
        url: "/api/upload-temp-file",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            console.log('image temp = ', response);
            console.log('image fieldName = ', fieldName);

            if (response.success) {

                // Set hidden/text input
                $("#" + fieldName + "_url").val(response['url']);
                $("#" + fieldName).val(response['url']);
            }
        },

        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

function removeImage(fieldName) {

    // Clear the main file input
    $("#" + fieldName).val("");

    // Clear the hidden URL field
    $("#" + fieldName + "_url").val("");

    // Clear the preview wrapper (image + button)
    $("#" + fieldName + "_preview").html("");
    $("#" + fieldName + "_previews").html("");
}



// ------------------- End Image Temporary Upload END -----------------------

// -------------------  Datepicker -----------------------

$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
    todayHighlight: true,
    clearBtn: true,
    endDate: new Date()   // disallow future dates
});
// ------------------- End Datepicker END -----------------------




$(document).ready(function () {

    // Firm WhatsApp same as mobile
    $('.chkbox_fwapp_same_as_mobile').on('change', function () {
        if ($(this).is(':checked')) {
            $('#whatsapp_no').val($('#phone').val());
        } else {
            $('#whatsapp_no').val('');
        }
    });

    // Proprietor WhatsApp same as mobile
    $('.chkbox_prop_wa_same_as_mobile').on('change', function () {
        if ($(this).is(':checked')) {
            $('#proprietor_whatsapp').val($('#proprietor_phone').val());
        } else {
            $('#proprietor_whatsapp').val('');
        }
    });

});



// ------------------------------------------------------
// UNIVERSAL FUNCTION FOR ANY ADDRESS SECTION
// ------------------------------------------------------

// $(document).ready(function () {

//     /* ================================
//        Res: COUNTRY → STATE
//     ================================= */
//     $('#res_country_code').on('change', function () {
//         let countryCode = $(this).val();

//         let stateSelect = $('#res_state_code');
//         let citySelect = $('#res_city_code');

//         // ✅ set hidden country name
//         let countryName = $(this).find(':selected').data('country-name') || '';
//         $('#res_country').val(countryName);


//         stateSelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Loading states...</option>');

//         citySelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Select City</option>');

//         if (!countryCode) return;

//         $.ajax({
//             url: `/api/get-states/${countryCode}`,
//             type: 'GET',
//             success: function (states) {

//                 stateSelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Select State</option>');

//                 $.each(states, function (index, state) {
//                     stateSelect.append(
//                         `<option value="${state.iso2}" data-state-name="${state.name}">
//                             ${state.name}
//                         </option>`
//                     );
//                 });

//                 stateSelect.trigger('change.select2');
//             },
//             error: function () {
//                 stateSelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Failed to load states</option>');
//             }
//         });
//     });

//     /* ================================
//        Res: STATE → CITY
//     ================================= */
//     $('#res_state_code').on('change', function () {
//         let stateCode = $(this).val();

//         let countryCode = $('#res_country_code option:selected').val();
//         let citySelect = $('#res_city_code');

//         // ✅ set hidden country name
//         let stateName = $(this).find(':selected').data('state-name') || '';
//         $('#res_state').val(stateName);

//         citySelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Loading cities...</option>');

//         if (!countryCode || !stateCode) return;
//         console.log('countryCode', countryCode);
//         console.log('stateCode', stateCode);
//         $.ajax({
//             url: `/api/get-cities/${countryCode}/${stateCode}`,
//             type: 'GET',
//             success: function (cities) {
//                 console.log('cities', cities)
//                 citySelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Select City</option>');

//                 $.each(cities, function (index, city) {
//                     citySelect.append(
//                         `<option value="${city.id}" data-city-name="${city.name}">
//                             ${city.name}
//                         </option>`
//                     );
//                 });

//                 citySelect.trigger('change.select2');
//             },
//             error: function () {
//                 citySelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Failed to load cities</option>');
//             }
//         });
//     });


//     /* ================================
//       Res: CITY
//    ================================= */
//     $('#res_city_code').on('change', function () {
//         let cityName = $(this).find(':selected').data('city-name') || '';
//         $('#res_city').val(cityName);
//     });



//     /* ================================
//        OFFICE : COUNTRY → STATE
//     ================================= */
//     $('#office_country_code').on('change', function () {

//         let countryCode = $(this).val();
//         let stateSelect = $('#office_state_code');
//         let citySelect = $('#office_city_code');

//         // ✅ set hidden country name
//         let countryName = $(this).find(':selected').data('country-name') || '';
//         $('#office_country').val(countryName);

//         stateSelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Loading states...</option>');

//         citySelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Select City</option>');

//         if (!countryCode) return;

//         $.ajax({
//             url: `/api/get-states/${countryCode}`,
//             type: 'GET',
//             success: function (states) {

//                 stateSelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Select State</option>');

//                 $.each(states, function (index, state) {
//                     stateSelect.append(
//                         `<option value="${state.iso2}" data-state-name="${state.name}">
//                             ${state.name}
//                         </option>`
//                     );
//                 });

//                 stateSelect.trigger('change.select2');
//             },
//             error: function () {
//                 stateSelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Failed to load states</option>');
//             }
//         });
//     });


//     /* ================================
//        OFFICE : STATE → CITY
//     ================================= */
//     $('#office_state_code').on('change', function () {

//         let stateCode = $(this).val();
//         let countryCode = $('#office_country_code').val();
//         let citySelect = $('#office_city_code');

//         // ✅ set hidden country name
//         let stateName = $(this).find(':selected').data('state-name') || '';
//         $('#office_state').val(stateName);

//         citySelect
//             .prop('disabled', true)
//             .empty()
//             .append('<option value="">Loading cities...</option>');

//         if (!countryCode || !stateCode) return;

//         $.ajax({
//             url: `/api/get-cities/${countryCode}/${stateCode}`,
//             type: 'GET',
//             success: function (cities) {

//                 citySelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Select City</option>');

//                 $.each(cities, function (index, city) {
//                     citySelect.append(
//                         `<option value="${city.id}" data-city-name="${city.name}">
//                             ${city.name}
//                         </option>`
//                     );
//                 });

//                 citySelect.trigger('change.select2');
//             },
//             error: function () {
//                 citySelect
//                     .prop('disabled', false)
//                     .empty()
//                     .append('<option value="">Failed to load cities</option>');
//             }
//         });

//     });

//     /* ================================
//      OFFICE: CITY
//   ================================= */
//     $('#office_city_code').on('change', function () {
//         let cityName = $(this).find(':selected').data('city-name') || '';
//         $('#office_city').val(cityName);
//     });


// });



$(document).ready(function () {

    function initAddress(prefix) {

        let countrySel = $('#' + prefix + '_country_code');
        let stateSel = $('#' + prefix + '_state_code');
        let citySel = $('#' + prefix + '_city_code');

        let countryHid = $('#' + prefix + '_country');
        let stateHid = $('#' + prefix + '_state');
        let cityHid = $('#' + prefix + '_city');

        let edit = window.editAddress?.[prefix] || null;

        /* ================================
           COUNTRY → STATE
        ================================= */
        countrySel.on('change', function () {

            let countryCode = $(this).val();
            let countryName = $(this).find(':selected').data('country-name') || '';

            countryHid.val(countryName);
            stateHid.val('');
            cityHid.val('');

            stateSel.prop('disabled', true).empty().append('<option>Loading states...</option>');
            citySel.prop('disabled', true).empty().append('<option>Select City</option>');

            if (!countryCode) return;

            $.ajax({
                url: `/api/get-states/${countryCode}`,
                type: 'GET',
                success: function (states) {

                    stateSel.prop('disabled', false).empty()
                        .append('<option value="">Select State</option>');

                    $.each(states, function (i, state) {
                        stateSel.append(
                            `<option value="${state.iso2}" data-state-name="${state.name}">
                            ${state.name}
                        </option>`
                        );
                    });

                    // ✅ EDIT AUTO SELECT STATE
                    if (edit?.state) {
                        stateSel.val(edit.state).trigger('change');
                    }

                    stateSel.trigger('change.select2');
                }
            });
        });

        /* ================================
           STATE → CITY
        ================================= */
        stateSel.on('change', function () {

            let stateCode = $(this).val();
            let countryCode = countrySel.val();
            let stateName = $(this).find(':selected').data('state-name') || '';

            stateHid.val(stateName);
            cityHid.val('');

            citySel.prop('disabled', true).empty().append('<option>Loading cities...</option>');

            if (!countryCode || !stateCode) return;

            $.ajax({
                url: `/api/get-cities/${countryCode}/${stateCode}`,
                type: 'GET',
                success: function (cities) {

                    citySel.prop('disabled', false).empty()
                        .append('<option value="">Select City</option>');

                    $.each(cities, function (i, city) {
                        citySel.append(
                            `<option value="${city.id}" data-city-name="${city.name}">
                            ${city.name}
                        </option>`
                        );
                    });

                    // ✅ EDIT AUTO SELECT CITY
                    if (edit?.city) {
                        citySel.val(edit.city).trigger('change');
                    }

                    citySel.trigger('change.select2');
                }
            });
        });

        /* ================================
           CITY
        ================================= */
        citySel.on('change', function () {
            cityHid.val($(this).find(':selected').data('city-name') || '');
        });

        /* ================================
           🔥 INIT EDIT MODE
        ================================= */
        if (edit?.country) {
            countrySel.val(edit.country).trigger('change');
        }
    }


    /* ================================
       INIT ADDRESSES
    ================================= */
    initAddress('res');
    initAddress('office');
    initAddress('registered');
    initAddress('additional');

});









// ------------------- End Address Dropdowns END -----------------------


// ------------------------------------------------------
// Client family section
// ------------------------------------------------------
$(document).ready(function () {

    function toggleDod() {
        if ($('#live_status').val() === 'deceased') {
            $('#dodBox').removeClass('d-none');
        } else {
            $('#dodBox').addClass('d-none');
        }
    }

    // Run on page load (handles old values)
    toggleDod();

    // Run on change
    $('#live_status').on('change', function () {
        toggleDod();
    });
});
// --------------------END Client family section -------------


function checkPanExists(pan) {
    pan = pan.trim().toUpperCase();

    $("#errpancardno").text("");

    if (pan.length !== 10) {
        $("#errpancardno").text("Invalid PAN number");
        return;
    }

    $.ajax({
        url: "/api/check-client-pan-exists",
        method: "POST",
        data: { pan_no: pan, },

        success: function (response) {
            if (response.data.exists) {
                $("#errpancardno").text("PAN already exists in the system!");
                $("#pan_no").addClass("is-invalid");
            } else {
                $("#pan_no").removeClass("is-invalid");
            }
        }
    });
}
