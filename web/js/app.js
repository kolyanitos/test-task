$(function () {
    $(document).on('click', '#preview', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/preview',
            type: 'POST',
            data: new FormData(document.getElementById('task-form')),
            processData: false,
            contentType: false,
            success: function (r) {
                if (r.status) {
                    $('#preview-content').html(r.content).promise().done(function () {
                        $('#preview-modal').modal('show');
                    })
                }
                else {
                    alert('Fill in required fields');
                }
            }
        });
    })
});