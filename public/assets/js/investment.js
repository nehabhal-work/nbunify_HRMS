function loadSchemeData() {

    let selected = $('#scheme_id').find(':selected');

    // READ DATA ATTRIBUTES
    let tenureType = selected.data('tenure-type');
    let minTenure = parseInt(selected.data('min-tenure'));
    let maxTenure = parseInt(selected.data('max-tenure'));
    let frequencies = selected.data('frequencies');
    let minRoi = parseFloat(selected.data('min-roi'));
    let maxRoi = parseFloat(selected.data('max-roi'));
    let addiMin = parseFloat(selected.data('addi-roi-min'));
    let addiMax = parseFloat(selected.data('addi-roi-max'));

    let lockInPeriod = selected.data('lock-in-period');
    let lockInType = selected.data('lock-in-period-type');

    let minInvAmt = Number(selected.data('min-investment'));
    let maxInvAmt = Number(selected.data('max-investment'));
    let invDenom = Number(selected.data('investment-denomination'));

    let invType = selected.data('investment_type'); // "single" or "joint"

    console.log('Scheme data loaded:', invType);
    if (invType === 'single') {
        $('#investment_type').val('single').trigger('change');
    }
    else if (invType === 'joined') {
        $('#investment_type').val('joined').trigger('change');
    }

    // SET TENURE TYPE
    $('#tenure_type').val(tenureType);

    // LOAD TENURE OPTIONS
    let tenureSelect = $('#tenure_count');
    tenureSelect.empty().append(`<option value="">Select</option>`);
    for (let i = minTenure; i <= maxTenure; i++) {
        tenureSelect.append(`<option value="${i}">${i}</option>`);
    }

    // LOAD FREQUENCY OPTIONS
    // let freqSelect = $('#frequency');
    // freqSelect.empty().append(`<option value="">Select Frequency</option>`);
    // frequencies.forEach(f => {
    //     freqSelect.append(`<option value="${f}">${f}</option>`);
    // });
    if (frequencies.length > 0) {
        $('#frequency').val(frequencies[0]);
    }



    // ROI RANGE
    // $('#roi_percent').val('');
    // $('#roi-message').html(
    //     `<small class="text-primary fw-bold">Allowed ROI Range: ${minRoi}% to ${maxRoi}%</small>`
    // );
    // $('#roi_percent').data('min', minRoi);
    // $('#roi_percent').data('max', maxRoi);
    // $('#roi_percent').data('maxlength', maxRoi);
    // ROI RANGE / FIXED LOGIC
    $('#roi-wrapper').removeClass('d-none');

    if (minRoi === maxRoi) {
        // 🌿 fixed ROI
        $('#roi_percent')
            .val(minRoi)
            .prop('readonly', true)
            .addClass('bg-secondary-subtle');

        $('#roi-message').html(
            `<small class="text-success  fw-bold">Fixed ROI: ${minRoi}%</small>`
        );

    } else {
        // 🌾 variable ROI
        $('#roi_percent')
            .val('')
            .prop('readonly', false)
            .removeClass('bg-secondary-subtle')
            .data('min', minRoi)
            .data('max', maxRoi);

        $('#roi-message').html(
            `<small class="text-primary fw-bold">
            Allowed ROI Range: ${minRoi}% to ${maxRoi}%
         </small>`
        );
    }


    // Additional ROI RANGE
    if (addiMin > 0) {
        $('#addi_roi_box').removeClass('d-none');
    } else {
        $('#addi_roi_box').addClass('d-none');
    }

    $('#addi_roi').val('');
    $('#addi-roi-message').html(
        `<small class="text-primary fw-bold">Allowed Additional ROI: ${addiMin}% to ${addiMax}%</small>`
    );

    $('#addi_roi').data('min', addiMin);
    $('#addi_roi').data('max', addiMax);



    // Auto-fill + lock
    $('#lock_in_period')
        .val(lockInPeriod)
        .prop('readonly', true)
        .addClass('bg-secondary-subtle');

    $('#lock_in_period_type')
        .val(lockInType)
        .prop('readonly', true)
        .addClass('bg-secondary-subtle');

    $('#investment_amount')
        .val(minInvAmt)
        .attr({
            min: minInvAmt,
            max: maxInvAmt,
            step: invDenom
        })
        .removeClass('is-invalid')
        .find('.errmsg').text('');

    calculateROI();
}


$('#investment_amount').on('input', function () {

    let value = Number($(this).val());
    let min = Number($(this).attr('min'));
    let max = Number($(this).attr('max'));
    let step = Number($(this).attr('step'));

    let errorMsg = '';

    if (value < min) {
        errorMsg = `Minimum investment is ₹${min}`;
    }
    else if (value > max) {
        errorMsg = `Maximum investment is ₹${max}`;
    }
    else if ((value - min) % step !== 0) {
        errorMsg = `Investment must be in multiples of ₹${step}`;
    }

    if (errorMsg) {
        $('.errorMsg').text(errorMsg);
    } else {

        $('.errorMsg').text('');
    }
});



$('#scheme_id').on('change', function () {
    loadSchemeData();
});

// -----------1st , 2nd , 3rd, 4th holder select  validation----------


$(document).ready(function () {

    function updateHolderOptions() {
        let selectedValues = [];

        $('#first_client_id, #second_client, #third_client, #fourth_client').each(function () {
            if ($(this).val()) {
                selectedValues.push($(this).val());
            }
        });

        $('#first_client_id, #second_client, #third_client, #fourth_client').each(function () {
            let currentSelect = $(this);

            currentSelect.find('option').each(function () {
                let optionVal = $(this).val();
                if (optionVal === "") return;

                if (
                    selectedValues.includes(optionVal) &&
                    optionVal !== currentSelect.val()
                ) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        $('.select2').trigger('change.select2');
    }

    // 🔥 NEW: reset joined holders when switching to single
    $('#investment_type').on('change', function () {
        if ($(this).val() === 'single') {

            // clear joined holder values
            $('#second_client, #third_client, #fourth_client')
                .val('')
                .trigger('change');

            // hide joined holder section
            $('#div_other_holders').addClass('d-none');

        } else {
            // show joined holder section
            $('#div_other_holders').removeClass('d-none');
        }

        updateHolderOptions();
    });

    // holder change
    $(document).on(
        'change',
        '#first_client_id, #second_client, #third_client, #fourth_client',
        function () {
            updateHolderOptions();
        }
    );

    // page load safety
    updateHolderOptions();

});

// -----------------end-------------------
// -------------------lock in period on tenure------------
$(document).ready(function () {

    // when tenure changes
    // $('#tenure_count').on('change', function () {

    //     let tenure = parseInt($(this).val(), 10);

    //     if (!tenure) {
    //         $('#lock_in_period')
    //             .prop('disabled', true)
    //             .removeAttr('max')
    //             .val('');
    //         return;
    //     }

    //     // enable + set limits
    //     $('#lock_in_period')
    //         .prop('disabled', false)
    //         .attr('max', tenure)
    //         .val('');
    // });

    // block typing beyond max + limit to 2 digits
    // $('#lock_in_period').on('input', function () {

    //     let max = parseInt($(this).attr('max'), 10);
    //     let val = this.value.replace(/\D/g, '');

    //     // enforce 2 digits
    //     if (val.length > 2) {
    //         val = val.slice(0, 2);
    //     }

    //     let num = parseInt(val, 10);

    //     // enforce max
    //     if (num > max) {
    //         val = max.toString();
    //     }

    //     this.value = val;
    // });
    function updateLockInMax() {

        let tenureCount = parseInt($('#tenure_count').val(), 10);
        let tenureType = $('#tenure_type').val(); // years / months
        let lockType = $('#lock_in_period_type').val(); // years / months

        if (!tenureCount || !tenureType || !lockType) {
            $('#lock_in_period')
                .prop('disabled', true)
                .removeAttr('max')
                .val('');
            return;
        }

        // Convert tenure to months
        let tenureInMonths = tenureType === 'years'
            ? tenureCount * 12
            : tenureCount;

        // Decide max lock-in
        let maxLockIn = lockType === 'years'
            ? Math.floor(tenureInMonths / 12)
            : tenureInMonths;

        $('#lock_in_period')
            .prop('disabled', false)
            .attr('max', maxLockIn)
            .val('');
    }

    /* ---------- EVENTS ---------- */
    // $('#tenure_count, #lock_in_period_type').on('change', updateLockInMax);


    $('#lock_in_period').on('input', function () {

        let max = parseInt($(this).attr('max'), 10);
        let val = this.value.replace(/\D/g, '');

        if (!val) {
            this.value = '';
            return;
        }

        let num = parseInt(val, 10);

        if (num > max) {
            this.value = max;
        } else {
            this.value = num;
        }
    });


});
// -----------------end------------------------


$('#roi_percent').on('input', function () {

    let min = parseFloat($(this).data('min'));
    let max = parseFloat($(this).data('max'));
    let val = parseFloat($(this).val());

    // If empty → show allowed range
    if (isNaN(val)) {
        $('#roi-message').html(
            `<small class="text-primary fw-bold">Allowed ROI Range: ${min}% to ${max}%</small>`
        );
        return;
    }

    // Validation
    if (val < min || val > max) {
        $('#roi-message').html(
            `<small class="text-danger fw-bold">ROI must be between ${min}% and ${max}%</small>`
        );
        $('#btnSubmit').prop('disabled', true);
        $('#errSubmit').text('Please enter valid ROI before submitting.');
    } else {
        $('#roi-message').html(
            `<small class="text-success fw-bold">Valid ROI</small>`
        );
        $('#btnSubmit').prop('disabled', false);
        $('#errSubmit').text('');
    }
});


$('#addi_roi').on('input', function () {

    let min = parseFloat($(this).data('min'));
    let max = parseFloat($(this).data('max'));
    let val = parseFloat($(this).val());

    if (!val) {
        $('#addi-roi-message').html(
            `<small class="text-primary fw-bold">Allowed Additional ROI: ${min}% to ${max}%</small>`
        );
        return;
    }

    if (val < min || val > max) {
        $('#addi-roi-message').html(
            `<small class="text-danger fw-bold">Additional ROI must be between ${min}% and ${max}%</small>`
        );
    } else {
        $('#addi-roi-message').html(
            `<small class="text-success fw-bold">Valid Additional ROI</small>`
        );
    }
});


// Function to toggle holder sections single/double
// 

$(document).ready(function () {

    let currentHolder = 2; // Always start from 2nd holder

    function resetHolders() {
        $('#holder_3, #holder_4').addClass('d-none')
            .find('select').val(null).trigger('change');

        currentHolder = 2;
        $('#removeHolderBtn').addClass('d-none');
        $('#addHolderBtn').show();
    }

    function toggleInvestmentHolders() {

        let type = $('#investment_type').val();

        if (type === 'single') {
            $('#div_other_holders').addClass('d-none');
            resetHolders();
        } else {
            $('#div_other_holders').removeClass('d-none');
            $('#holder_2').removeClass('d-none');

            // Restore old values
            if ($('#third_client').val()) {
                $('#holder_3').removeClass('d-none');
                currentHolder = 3;
                $('#removeHolderBtn').removeClass('d-none');
            }

            if ($('#fourth_client').val()) {
                $('#holder_4').removeClass('d-none');
                currentHolder = 4;
                $('#removeHolderBtn').removeClass('d-none');
                $('#addHolderBtn').hide();
            }
        }
    }

    toggleInvestmentHolders();

    $('#investment_type').on('change', toggleInvestmentHolders);

    // ADD HOLDER
    $('#addHolderBtn').on('click', function () {

        if (currentHolder === 2) {
            $('#holder_3').removeClass('d-none');
            currentHolder = 3;
            $('#removeHolderBtn').removeClass('d-none');

        } else if (currentHolder === 3) {
            $('#holder_4').removeClass('d-none');
            currentHolder = 4;
            $('#addHolderBtn').hide();
        }
    });

    // REMOVE HOLDER (Rollback)
    $('#removeHolderBtn').on('click', function () {

        if (currentHolder === 4) {
            $('#holder_4').addClass('d-none')
                .find('select').val(null).trigger('change');
            currentHolder = 3;
            $('#addHolderBtn').show();

        } else if (currentHolder === 3) {
            $('#holder_3').addClass('d-none')
                .find('select').val(null).trigger('change');
            currentHolder = 2;
            $('#removeHolderBtn').addClass('d-none');
        }
    });

});




// -------------------------------
// LOAD FAMILY & BANKS ON CLIENT CHANGE
// -------------------------------
$('#first_client_id').on('change', function () {

    let selected = $(this).find(':selected');

    let families = selected.data('families');
    let banks = selected.data('banks');

    if (typeof families === "string") families = JSON.parse(families);
    if (typeof banks === "string") banks = JSON.parse(banks);

    // Load nominees into ALL nominee dropdowns
    $('.nominee_name').each(function () {
        let dd = $(this);
        dd.empty().append(`<option value="">Select Holder</option>`);
        families.forEach(f => {
            dd.append(`<option value="${f.id}" data-dob="${f.dob}">${f.name}</option>`);
        });
        dd.trigger('change');
    });

    // Load client banks


});
// Load client multiple  banks to outward bank amd Client Output Bank dropdown
function populateAllClientBanks() {

    let selectors = [
        '#first_client_id',
        '#second_client',
        '#third_client',
        '#fourth_client'
    ];

    let allBanks = [];

    selectors.forEach(sel => {
        let opt = $(sel).find(':selected');
        if (!opt.val()) return;

        let clientName = opt.text().trim();
        let banks = opt.data('banks') || [];

        banks.forEach(b => {
            allBanks.push({
                id: b.id,
                label: `${clientName} — ${b.bank_name} (${b.account_number})`
            });
        });
    });

    // Apply to BOTH dropdown types
    $('.clientOutputBank, .to_client_bank').each(function () {

        let dd = $(this);
        dd.empty().append(`<option value="">Select Bank</option>`);

        allBanks.forEach(b => {
            dd.append(`<option value="${b.id}">${b.label}</option>`);
        });
    });
}

$('#first_client_id, #second_client, #third_client, #fourth_client')
    .on('change', populateAllClientBanks);

// $('#investment_type').on('change', populateAllClientBanks);

$('#investment_type').on('change', function () {

    if ($(this).val() === 'joined') {
        $('#div_other_holders').removeClass('d-none');
    } else {
        $('#div_other_holders').addClass('d-none');
    }

    populateClientBanks();
});
// End Load client multiple  banks to outward bank dropdown

// -------------------------------
// When nominee is selected
// -------------------------------
$(document).on('change', '.nominee_name', function () {

    let row = $(this).closest('.nomineeRow');
    let guardianBox = row.find('.guardian_box');
    let guardianSelect = row.find('.guardian_select');

    let selected = $(this).find(':selected');
    let dobRaw = selected.data('dob');

    guardianBox.addClass('d-none');
    guardianSelect.empty().append(`<option value="">Select Guardian</option>`);

    if (!dobRaw) return;

    let dob = dobRaw.split('T')[0];
    let age = getAge(dob);

    if (age >= 1 && age < 18) {
        guardianBox.removeClass('d-none');
        loadGuardians(selected.val(), guardianSelect);
    }
});


// -------------------------------
// Calculate age
// -------------------------------
function getAge(dob) {
    let birth = new Date(dob);
    let today = new Date();
    let age = today.getFullYear() - birth.getFullYear();
    let m = today.getMonth() - birth.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
}


// -------------------------------
// Load guardians (exclude minor)
// -------------------------------
function loadGuardians(minorId, dropdown) {

    let selectedClient = $('#first_client_id').find(':selected');
    let families = selectedClient.data('families');

    if (typeof families === "string") {
        families = JSON.parse(families);
    }

    dropdown.empty().append(`<option value="">Select Guardian</option>`);

    families.forEach(f => {
        if (f.id != minorId) {
            dropdown.append(
                `<option value="${f.id}">${f.name}</option>`
            );
        }
    });
}


// -------------------------------
// REMOVE ROW
// -------------------------------
$(document).on('click', '.removeNomineeRow', function () {
    if ($('.nomineeRow').length > 1) {
        $(this).closest('.nomineeRow').remove();
    }
});







// ******************************************************
// Investment Scheme JS
// ******************************************************


// { { -- ----------create min max tenure------------- --} }
$(document).ready(function () {
    $('#tenure_type').on('change', function () {
        let type = $(this).val();

        if (type === 'days') {
            $('#min_tenure_label').text('Min Tenure (in days)');
            $('#max_tenure_label').text('Max Tenure (in days)');
            $('#min_tenure').attr('placeholder', 'e.g. 30 days').val('');
            $('#max_tenure').attr('placeholder', 'e.g. 365 days').val('');
        } else if (type === 'months') {
            $('#min_tenure_label').text('Min Tenure (in months)');
            $('#max_tenure_label').text('Max Tenure (in months)');
            $('#min_tenure').attr('placeholder', 'e.g. 6 months').val('');
            $('#max_tenure').attr('placeholder', 'e.g. 24 months').val('');
        } else if (type === 'years') {
            $('#min_tenure_label').text('Min Tenure (in years)');
            $('#max_tenure_label').text('Max Tenure (in years)');
            $('#min_tenure').attr('placeholder', 'e.g. 1 year').val('');
            $('#max_tenure').attr('placeholder', 'e.g. 5 years').val('');
        }
    });
});



// { { -- ----------edit min max tenure------------- --} }
$(document).ready(function () {
    function updateTenureLabels(modalId, type) {
        if (type === 'days') {
            $('#min_tenure_label_' + modalId).text('Min Tenure (in days)');
            $('#max_tenure_label_' + modalId).text('Max Tenure (in days)');
        } else if (type === 'months') {
            $('#min_tenure_label_' + modalId).text('Min Tenure (in months)');
            $('#max_tenure_label_' + modalId).text('Max Tenure (in months)');
        } else {
            $('#min_tenure_label_' + modalId).text('Min Tenure (in years)');
            $('#max_tenure_label_' + modalId).text('Max Tenure (in years)');
        }
    }

    // On modal show → initialize labels
    $('.modal').on('shown.bs.modal', function () {
        let modalId = $(this).find('select[name="tenure_type"]').attr('id').split('_').pop();
        let type = $('#tenure_type_' + modalId).val();
        updateTenureLabels(modalId, type);

        // On change inside modal
        $('#tenure_type_' + modalId).off('change').on('change', function () {
            updateTenureLabels(modalId, $(this).val());
        });
    });
});

//-------------END Investment Scheme JS--------------------------





//--------------------------------------
// ===== Generic clone function=====
// ------------------------------------------
$(document).ready(function () {
    function handleClone(container, rowClass, addBtn, removeBtn) {

        // ADD New Row
        $(document).on("click", addBtn, function () {

            let $lastRow = $(container).find(rowClass).last();
            let $newRow = $lastRow.clone(false, false); // clone simple

            // REMOVE existing Select2 wrappers from clone
            $newRow.find(".select2-container").remove();

            // RESET select fields to blank
            $newRow.find("select").each(function () {
                $(this).val("");              // reset value
                $(this).removeClass("select2-hidden-accessible"); // remove old select2 markers
                $(this).removeAttr("data-select2-id");            // remove old select2 instance id
            });

            // RESET input fields
            $newRow.find("input").val("");

            // Append new row
            $(container).append($newRow);

            // Re-initialize Select2 ONLY inside the new row
            $newRow.find("select").select2();
        });

        // REMOVE Row
        $(document).on("click", removeBtn, function () {
            let $rows = $(container).find(rowClass);
            if ($rows.length > 1) {
                $(this).closest(rowClass).remove();
            } else {
                alert("At least one nominee must remain.");
            }
        });
    }

    handleClone("#nomineeContainer", ".nomineeRow", "#addNomineeRow", ".removeNomineeRow");
    handleClone("#instrumentContainer", ".instrumentRow", ".addInstrumentRow", ".removeInstrumentRow");


    // ------------------------------
    //     nominee PERCENTAGE CALCULATION
    // ------------------------------

    // function recalcPercentages() {
    //     let total = 0;

    //     $(".nominee_percentage").each(function () {
    //         let v = parseFloat($(this).val());
    //         if (!isNaN(v)) total += v;
    //     });

    //     // Prevent more than 100%
    //     if (total > 100) {
    //         alert("Total percentage cannot exceed 100%");
    //         return false;
    //     }

    //     // Enable/Disable Add Button
    //     if (total >= 100) {
    //         $("#addNomineeRow").prop("disabled", true);
    //     } else {
    //         $("#addNomineeRow").prop("disabled", false);
    //     }

    //     return total;
    // }

    // // Auto-update after user enters value
    // $(document).on("keyup change", ".nominee_percentage", function () {
    //     let total = recalcPercentages();

    //     if (total > 100) {
    //         $(this).val("");
    //         recalcPercentages();
    //         return;
    //     }

    //     // Auto-fill remaining for NEXT row only when user finishes typing
    //     if (total < 100) {
    //         let remaining = 100 - total;

    //         let $rows = $(".nominee_percentages");
    //     }
    // });
    function recalcPercentages(currentInput = null) {
        let total = 0;

        $(".nominee_percentage").each(function () {
            let v = parseFloat($(this).val()) || 0;
            total += v;
        });

        // Prevent more than 100%
        if (total > 100 && currentInput) {
            let entered = parseFloat($(currentInput).val()) || 0;
            let allowed = entered - (total - 100);

            $(currentInput).val(allowed > 0 ? allowed : '');
            total = 100;
        }

        // Enable / Disable Add button
        $("#addNomineeRow").prop("disabled", total >= 100);

        // Status message
        if (total === 100) {
            $("#nomineePercentageMsg")
                .removeClass("text-danger")
                .addClass("text-success")
                .text("✔ Total nominee percentage is 100%");
            $('#nomineePerentageSum').val(100);
        } else {
            $("#nomineePercentageMsg")
                .removeClass("text-success")
                .addClass("text-danger")
                .text("Remaining percentage: " + (100 - total) + "%");
            $('#nomineePerentageSum').val(100 - total);
        }

        return total;
    }

    // Input listener
    $(document).on("input", ".nominee_percentage", function () {
        recalcPercentages(this);
    });

    // After row add/remove
    $(document).on("click", "#addNomineeRow, .removeNomineeRow", function () {
        setTimeout(() => recalcPercentages(), 50);
    });

});




function calculateROI() {

    let amount = parseFloat($('#investment_amount').val()) || 0;
    let roi = parseFloat($('#roi_percent').val()) || 0;
    let frequency = $('#frequency').val();

    if (!amount || !roi || !frequency) {
        $('#roi_amount').val('');
        return;
    }

    let yearlyInterest = (amount * roi) / 100;
    let finalAmount = 0;

    switch (frequency) {
        case 'monthly':
            finalAmount = yearlyInterest / 12;
            break;

        case 'quarterly':
            finalAmount = yearlyInterest / 4;
            break;

        case 'half-yearly':
            finalAmount = yearlyInterest / 2;
            break;

        case 'yearly':
            finalAmount = yearlyInterest;
            break;
        default:
            finalAmount = yearlyInterest;
    }

    $('#roi_amount').val(Math.ceil(finalAmount));

}

$('#investment_amount, #roi_percent, #frequency').on('keyup change', function () {
    console.log("investment_amount")
    calculateROI();
});

// Trigger on investment date change
$(document).on('change', '.invDate', function () {
    let $row = $(this).closest('.row');
    // Only calculate if tenure & type are already selected
    if ($row.find('.tenure').val() && $row.find('.tenure_type').val()) {
        calculateMaturity($row);
    }
});

$(document).on('change', '.tenure, .tenure_type', function () {
    let $row = $(this).closest('.row');
    calculateMaturity($row);
});

function calculateMaturity($row) {
    let invDate = $row.find('.invDate').val();
    let tenure = parseInt($row.find('.tenure').val());
    let tenureType = $row.find('.tenure_type').val()?.toLowerCase();

    // console.log('Calculating maturity for:', { invDate, tenure, tenureType });
    // if tenure or type not set yet, we can skip or set default
    if (!invDate || !tenure || !tenureType) {
        $row.find('.matdate').val(''); // clear if incomplete
        return;
    }

    let dateObj = new Date(invDate);

    if (tenureType === "months") {
        dateObj.setMonth(dateObj.getMonth() + tenure);
    } else if (tenureType === "years") {
        console.log('Adding years:', tenure);
        dateObj.setFullYear(dateObj.getFullYear() + tenure);
    } else if (tenureType === "days") {
        dateObj.setDate(dateObj.getDate() + tenure);
    }

    // always minus 1 day
    dateObj.setDate(dateObj.getDate() - 1);

    let yyyy = dateObj.getFullYear();
    let mm = String(dateObj.getMonth() + 1).padStart(2, '0');
    let dd = String(dateObj.getDate()).padStart(2, '0');

    $row.find('.matdate').val(`${yyyy}-${mm}-${dd}`);
}



// instrumentSelect change - Auto set dates from Investment Date
$(document).on("change", ".instrumentSelect", function () {
    let $row = $(this).closest(".instrumentRow"); // current row
    let instrument = $(this).val();
    let investmentDate = $(".invDate").val();

    let $instrumentDate = $row.find("input[name='instrument_date[]']");
    let $creditDate = $row.find("input[name='effective_date[]']");
    let $refNo = $row.find("input[name='reference_no[]']");
    let $companyRef = $row.find("input[name='company_reference_no[]']");

    /* ===============================
       Auto set dates from Investment Date
    =============================== */
    if (investmentDate) {
        $instrumentDate.val(investmentDate).attr("max", investmentDate);;
        $creditDate.val(investmentDate).attr("max", investmentDate);;
    }


    /* ===============================
       Sync dates on instrument change
    =============================== */
    // syncInstrumentDates($row);

    /* ===============================
       CHEQUE LOGIC
    =============================== */
    if (instrument === "cheque") {

        // Reference no length
        $refNo.attr("maxlength", 6);

        // Lock company bank ref
        $companyRef
            .prop("readonly", true)
            .addClass("bg-secondary-subtle");

        // Sync reference → company reference
        $refNo.off("input.syncRef").on("input.syncRef", function () {
            $companyRef.val($(this).val());
        });

        // Sync immediately if value exists
        if ($refNo.val()) {
            $companyRef.val($refNo.val());
        }

    } else {

        // Reset for other instruments
        $refNo.removeAttr("maxlength");

        $companyRef
            .prop("readonly", false)
            .removeClass("bg-secondary-subtle")
            .val("");

        // Remove listener
        $refNo.off("input.syncRef");
    }
});






// ------------------------------
//     nominee PERCENTAGE CALCULATION
// ------------------------------

function calculateNomineePercentage() {
    let total = 0;

    $('.nominee_percentage').each(function () {
        let val = parseFloat($(this).val()) || 0;
        total += val;
    });

    if (total === 100) {
        $('#nomineePercentageMsg')
            .removeClass('text-danger')
            .addClass('text-success')
            .text('✔ Total nominee percentage is 100%');
    } else {
        $('#nomineePercentageMsg')
            .removeClass('text-success')
            .addClass('text-danger')
            .text('✖ Total nominee percentage must be exactly 100% (Current: ' + total + '%)');
    }
}

// On change/input
$(document).on('input', '.nominee_percentage', calculateNomineePercentage);

// After row add/remove
$(document).on('click', '#addNomineeRow, .removeNomineeRow', function () {
    setTimeout(calculateNomineePercentage, 100);
});



// ------------------------------
//     INSTRUMENT AMOUNT VALIDATION
// ------------------------------

function calculateRemainingBalance() {

    let investmentAmount = parseFloat($('#investment_amount').val()) || 0;
    let used = 0;

    $('.client_instrument_amt').each(function () {
        used += parseFloat($(this).val()) || 0;
    });

    let remaining = investmentAmount - used;

    let msg = `
        Investment Amount: ₹${investmentAmount}
        | Entered Amount: ₹${used}
        | Balance Amount: ₹${remaining}
    `;

    if (remaining === 0 && investmentAmount > 0) {
        $('#remainingBalanceMsg')
            .removeClass('text-danger')
            .addClass('text-success')
            .text('✔ Fully Allocated | ' + msg);
    } else if (remaining > 0) {
        $('#remainingBalanceMsg')
            .removeClass('text-success')
            .addClass('text-danger')
            .text(msg);
    } else {
        $('#remainingBalanceMsg')
            .removeClass('text-success')
            .addClass('text-danger')
            .text('✖ Allocation exceeds investment amount | ' + msg);
    }


    return remaining;
}


$(document).on('input', '#investment_amount', function () {

    let investmentAmount = parseFloat($(this).val()) || 0;

    let firstRow = $('.instrumentRow').eq(0);

    firstRow.find('.client_instrument_amt').val(investmentAmount);
    firstRow.find('.company_instrument_amt').val(investmentAmount);

    calculateRemainingBalance();
});


$(document).on('input', '.client_instrument_amt', function () {

    let rowIndex = $(this).closest('.instrumentRow').index();
    let remaining = calculateRemainingBalance();

    // If editing FIRST row → auto-fill SECOND row
    if (rowIndex === 0 && remaining > 0) {

        let secondRow = $('.instrumentRow').eq(1);

        if (secondRow.length) {
            secondRow.find('.client_instrument_amt').val(remaining);
            secondRow.find('.company_instrument_amt').val(remaining);
        }
    }
});




$(document).on('input', '.client_instrument_amt', function () {

    let value = $(this).val();

    // Find the current instrument row
    let row = $(this).closest('.instrumentRow');

    // Set value only for company instrument amount in the SAME row
    row.find('.company_instrument_amt').val(value);

});

$(document).on('input', '.client_instrument_amt, .company_instrument_amt', function () {

    let value = $(this).val();

    // Find current row
    let row = $(this).closest('.instrumentRow');

    // Decide direction
    if ($(this).hasClass('client_instrument_amt')) {
        row.find('.company_instrument_amt').val(value);
    } else {
        row.find('.client_instrument_amt').val(value);
    }

});


// ******************************************************



