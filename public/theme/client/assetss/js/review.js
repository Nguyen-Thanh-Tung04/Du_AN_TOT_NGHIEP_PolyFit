$("#imgUpload").change(function () {
    var numFiles = $(this)[0].files.length;
    if (numFiles < 2) {
        $('#filesel').text(numFiles + ' file selected');
    } else {
        $('#filesel').text(numFiles + ' files selected');
    }
});

$("#imgUpload_3").change(function () {
    var numFiles = $(this)[0].files.length;
    if (numFiles < 2) {
        $('#filesel_3').text(numFiles + ' file selected');
    } else {
        $('#filesel_3').text(numFiles + ' files selected');
    }
});