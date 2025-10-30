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


$(".alpha-only").on("keydown", function (event) {
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

