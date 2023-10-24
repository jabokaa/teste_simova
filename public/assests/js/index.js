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
                // Ação a ser executada em caso de erro
                console.error(error); // Exemplo: Exibe o erro no console
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

