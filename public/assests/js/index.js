$(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('#last_appointment').on('change', function(){
        // verifica se esta checado
        $('#end_date').hide();
        if($(this).is(':checked')){
            console.log('show');
            $('#end_date').show();
        }
        else {
    
            console.log('hide');
        }
    });
});