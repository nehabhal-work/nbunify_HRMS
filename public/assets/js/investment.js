// $('#scheme_id').on('change', function () {

//     let selected = $(this).find(':selected');

//     // READ DATA ATTRIBUTES
//     let tenureType = selected.data('tenure-type');
//     let minTenure = parseInt(selected.data('min-tenure'));
//     let maxTenure = parseInt(selected.data('max-tenure'));
//     let frequencies = selected.data('frequencies');
//     let minRoi = parseFloat(selected.data('min-roi'));
//     let maxRoi = parseFloat(selected.data('max-roi'));
//     let addiMin = parseFloat(selected.data('addi-roi-min'));
//     let addiMax = parseFloat(selected.data('addi-roi-max'));


//     // SET TENURE TYPE
//     $('#tenure_type').val(tenureType);

//     // LOAD TENURE OPTIONS into #tenure_count
//     let tenureSelect = $('#tenure_count');
//     tenureSelect.empty().append(`<option value="">Select</option>`);

//     for (let i = minTenure; i <= maxTenure; i++) {
//         tenureSelect.append(`<option value="${i}">${i}</option>`);
//     }

//     // LOAD FREQUENCY OPTIONS into #frequency
//     let freqSelect = $('#frequency');
//     freqSelect.empty().append(`<option value="">Select Frequency</option>`);

//     frequencies.forEach(f => {
//         freqSelect.append(`<option value="${f}">${f}</option>`);
//     });

//     // ROI RANGE
//     $('#roi_percent').val('');
//     $('#roi-message').html(
//         `<small class="text-primary fw-bold">Allowed ROI Range: ${minRoi}% to ${maxRoi}%</small>`
//     );

//     $('#roi_percent').data('min', minRoi);
//     $('#roi_percent').data('max', maxRoi);

//     // Additional ROI RANGE
//     if (addiMin > 0) {
//         $('#addi_roi_box').removeClass('d-none');
//     } else {
//         $('#addi_roi_box').addClass('d-none');
//     }

//     $('#addi_roi').val('');
//     $('#addi-roi-message').html(
//         `<small class="text-primary fw-bold">Allowed Additional ROI: ${addiMin}% to ${addiMax}%</small>`
//     );

//     $('#addi_roi').data('min', addiMin);
//     $('#addi_roi').data('max', addiMax);

// });

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

    // SET TENURE TYPE
    $('#tenure_type').val(tenureType);

    // LOAD TENURE OPTIONS
    let tenureSelect = $('#tenure_count');
    tenureSelect.empty().append(`<option value="">Select</option>`);
    for (let i = minTenure; i <= maxTenure; i++) {
        tenureSelect.append(`<option value="${i}">${i}</option>`);
    }

    // LOAD FREQUENCY OPTIONS
    let freqSelect = $('#frequency');
    freqSelect.empty().append(`<option value="">Select Frequency</option>`);
    frequencies.forEach(f => {
        freqSelect.append(`<option value="${f}">${f}</option>`);
    });

    // ROI RANGE
    $('#roi_percent').val('');
    $('#roi-message').html(
        `<small class="text-primary fw-bold">Allowed ROI Range: ${minRoi}% to ${maxRoi}%</small>`
    );
    $('#roi_percent').data('min', minRoi);
    $('#roi_percent').data('max', maxRoi);

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
}

$('#scheme_id').on('change', function () {
    loadSchemeData();
});




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
    } else {
        $('#roi-message').html(
            `<small class="text-success fw-bold">Valid ROI</small>`
        );
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


$(document).ready(function () {

    // Function to toggle holder sections
    function toggleInvestmentHolders() {
        let type = $('#investment_type').val();

        if (type === 'single') {
            $('#div_other_holders').addClass('d-none');
        } else {
            $('#div_other_holders').removeClass('d-none');
        }
    }

    // Run on page load (for old values)
    toggleInvestmentHolders();

    // Run on change
    $('#investment_type').on('change', function () {
        toggleInvestmentHolders();
    });

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
    //     PERCENTAGE CALCULATION
    // ------------------------------

    function recalcPercentages() {
        let total = 0;

        $(".nominee_percentage").each(function () {
            let v = parseFloat($(this).val());
            if (!isNaN(v)) total += v;
        });

        // Prevent more than 100%
        if (total > 100) {
            alert("Total percentage cannot exceed 100%");
            return false;
        }

        // Enable/Disable Add Button
        if (total >= 100) {
            $("#addNomineeRow").prop("disabled", true);
        } else {
            $("#addNomineeRow").prop("disabled", false);
        }

        return total;
    }

    // Auto-update after user enters value
    $(document).on("keyup change", ".nominee_percentage", function () {
        let total = recalcPercentages();

        if (total > 100) {
            $(this).val("");
            recalcPercentages();
            return;
        }

        // Auto-fill remaining for NEXT row only when user finishes typing
        if (total < 100) {
            let remaining = 100 - total;

            let $rows = $(".nominee_percentages");
        }
    });
});