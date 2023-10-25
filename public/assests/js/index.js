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
    $('.closed_update').on('click', function(){
        $('#editAppointmentModal').modal('hide');
    });

    $("#update_appointment").submit(function(event) {
        event.preventDefault();
        // Obtém os dados do formulário
        var formData = {
            start_date: $("#start_date").val(),
            enabled: $("#enabled").val()
        };
        $.ajax({
            type: "PUT",
            url: "/apontamentos/"+$("#id_appointment").val(),
            data: formData,
            success: function(data) {
                console.log(data);
                window.location.href = "/apontamentos/"+$("#id_employee").val();
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
    
});

function editAppointment(id, startData, enable) {
    $('#editAppointmentModal').modal('show');
    $('#id_appointment').val(id);
    $('#start_date').val(startData);
    $('#enabled').val(enable);
    $('#update_appointment').attr('action', '/appointment/'+id);
}

$(document).ready(function() {
    setTimeout(function() {
        $("#error-alert").fadeOut("slow", function() {
            $(this).remove();
        });
    }, 3000);
});