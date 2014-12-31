$(function () {   
    $('.dtpicker').each( function () {
        $(this).datetimepicker(
            {format: "YYYY-MM-DD H:m"}
        );

    });

    $('.dpicker').each( function () {
        $(this).datetimepicker({
            pickTime: false,
            format: "YYYY-MM-DD"
        });
    });

    $('.tpicker').each( function () {
        $(this).datetimepicker({
            pickDate: false,
            format: "H:m"
        });
    });
});