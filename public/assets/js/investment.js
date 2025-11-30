$('#scheme_id').on('change', function () {

    let selected = $(this).find(':selected');

    // --- READ ALL DATA ATTRIBUTES ---
    let tenureType = selected.data('tenure-type');
    let minTenure = parseInt(selected.data('min-tenure'));
    let maxTenure = parseInt(selected.data('max-tenure'));
    let frequencies = selected.data('frequencies'); // array
    let minRoi = parseFloat(selected.data('min-roi'));
    let maxRoi = parseFloat(selected.data('max-roi'));
    let addiMin = parseFloat(selected.data('addi-roi-min'));
    let addiMax = parseFloat(selected.data('addi-roi-max'));

    // *** SET TENURE TYPE ***
    $('#tenure_type').val(tenureType);

    // *** LOAD TENURE OPTIONS ***
    let tenureSelect = $('#tenure');
    tenureSelect.empty().append(`<option value="">Select</option>`);

    for (let i = minTenure; i <= maxTenure; i++) {
        tenureSelect.append(`<option value="${i}">${i}</option>`);
    }

    // *** LOAD FREQUENCY OPTIONS ***
    let freqSelect = $('#frequency'); // make sure you have a frequency select!
    if (freqSelect.length) {
        freqSelect.empty().append(`<option value="">Select Frequency</option>`);
        frequencies.forEach(f => {
            freqSelect.append(`<option value="${f}">${f}</option>`);
        });
    }

    // *** SET ROI RULES ***
    $('#roi').val('');
    $('#roi-message').html(
        `<small class="text-primary fw-bold">Allowed ROI Range: ${minRoi}% to ${maxRoi}%</small>`
    );

    $('#roi').data('min', minRoi);
    $('#roi').data('max', maxRoi);

    // SET ADDITIONAL ROI RANGE

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

});

$('#roi').on('input', function () {
    let min = parseFloat($(this).data('min'));
    let max = parseFloat($(this).data('max'));
    let val = parseFloat($(this).val());

    if (!val) {
        $('#roi-message').html(
            `<small class="text-primary fw-bold">Allowed ROI Range: ${min}% to ${max}%</small>`
        );
        return;
    }

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