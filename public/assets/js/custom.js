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
        parent.find('.bank_name, .branch_name, .bank_code').val('');

        // ✅ Validation check
        if (ifsc === '') return; // skip if empty

        if (ifsc.length !== 11) {
            // ❌ Invalid length
            input.addClass('is-invalid');
            parent.find('.errmsg').text('IFSC Code must be 11 characters long.');
            // errmsg.text('')
            //     .addClass('d-block')
            //     .show();
            return;
        }

        // ✅ Call API
        $.ajax({
            url: '/api/validate-ifsc',
            type: 'POST',
            data: { ifsc: ifsc },
            beforeSend: function () {
                parent.find('.bank_name, .branch_name, .bank_code').val('Fetching...');
            },
            success: function (response) {
                if (response.status === true && response.data) {
                    // ✅ Valid IFSC
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
                    parent.find('.bank_name, .branch_name, .bank_code').val('');
                }
            },
            error: function () {
                // ❌ API Error
                input.addClass('is-invalid');
                errmsg.text('Error fetching IFSC details. Please try again.')
                    .addClass('d-block')
                    .show();
                parent.find('.bank_name, .branch_name, .bank_code').val('');
            }
        });
    });



}); //  --------------END /IFSC Validation ------------------








// *************************
//   Add More Bank Details
// *************************

$(document).ready(function () {
    // let bankIndex = 0;
    let bankIndex = $('.bank-details-row').length - 1;

    // ✅ Add new bank row
    $('#addMoreBank').on('click', function () {
        bankIndex++;
        let clone = $('.bank-details-row:first').clone();

        // Reset all values
        clone.find('input[type="text"]').val('');
        clone.find('.errmsg').text('').hide();
        clone.find('.removeBankRow').removeClass('d-none');
        clone.find('.setPrimary').prop('checked', false);

        // Update input names with new index
        clone.find('input').each(function () {
            let name = $(this).attr('name');
            if (name) $(this).attr('name', name.replace(/\[\d+\]/, `[${bankIndex}]`));
        });

        $('#bankDetailsWrapper').append(clone);
    });

    // ✅ Remove row
    $(document).on('click', '.removeBankRow', function () {
        $(this).closest('.bank-details-row').remove();

        // Re-index all rows
        $('#bankDetailsWrapper .bank-details-row').each(function (i, row) {
            $(row).find('input').each(function () {
                let name = $(this).attr('name');
                if (name) $(this).attr('name', name.replace(/\[\d+\]/, `[${i}]`));
            });
        });
    });

    // ✅ Allow only one primary checkbox
    $(document).on('change', '.setPrimary', function () {
        if ($(this).is(':checked')) {
            $('.setPrimary').not(this).prop('checked', false);
        }
    });

    // ✅ IFSC AJAX Validation (per row)
    $(document).on('blur', '.ifsc_code', function () {
        let $this = $(this);
        let ifsc = $this.val().trim();
        let parent = $this.closest('.bank-details-row');
        let errmsg = parent.find('.errmsg');

        errmsg.text('').hide();
        $this.removeClass('is-invalid');

        if (ifsc.length === 11) {
            $.ajax({
                url: "/api/validate-ifsc",
                type: "POST",
                data: { ifsc: ifsc },
                beforeSend: function () {
                    parent.find('.bank_name, .branch_name, .bank_code').val('Fetching...');
                },
                success: function (response) {
                    if (response.status === true && response.data) {
                        parent.find('.bank_name').val(response.data.BANK || '');
                        parent.find('.branch_name').val(response.data.BRANCH || '');
                        parent.find('.bank_code').val(response.data.BANKCODE || '');
                    } else {
                        parent.find('.bank_name, .branch_name, .bank_code').val('');
                        $this.addClass('is-invalid');
                        errmsg.text('Invalid IFSC Code. Please check again.').show();
                    }
                },
                error: function () {
                    parent.find('.bank_name, .branch_name, .bank_code').val('');
                    $this.addClass('is-invalid');
                    errmsg.text('Error fetching IFSC details. Please try again.').show();
                }
            });
        } else if (ifsc !== '') {
            parent.find('.bank_name, .branch_name, .bank_code').val('');
            $this.addClass('is-invalid');
            errmsg.text('IFSC Code must be 11 characters long.').show();
        } else {
            parent.find('.bank_name, .branch_name, .bank_code').val('');
        }
    });
});

//  --------------END /Add More Bank Details ------------------