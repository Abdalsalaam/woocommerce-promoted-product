(function( $ ) {
    // Add Color Picker to all inputs that have 'wcpp-settings-color' class
    $(function() {
        $('.wcpp-settings-color').wpColorPicker();
    })

    /*
    Date picker : product edit
     */
    $("#_wcpp_expire_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        allowInput: true
    });
})( jQuery );