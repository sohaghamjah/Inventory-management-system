// =============== Dropify ===============
$('.dropify').dropify();
// =============== Select two ===============
$('.selectpicker').selectpicker({
    dropupAuto: false
});
// =================== Modal Show ==================

function showFormModal(modal_title,btn_text){
    $('#store_or_update_form')[0].reset();
    $('#store_or_update_form #update_id').val('');
    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
    $('#store_or_update_form').find('.error').remove();
    $('.dropify-clear').trigger('click');
    $('#store_or_update_form .selectpicker').selectpicker('refresh');
    $('#store_or_update_modal').modal('show');
    $('#store_or_update_modal table tbody').find("tr:gt(0)").remove();

    $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square"></i> '+modal_title);
    $('#store_or_update_modal #save_btn').text(btn_text);
}

// ====================== Table select all data ================
function selectAll()
{
    if($('#select_all:checked').length == 1){
        $('.select_data').prop('checked',true);
        if($('.select_data:checked').length >= 1){
            $('.delete_btn').removeClass('d-none');
        }
    }else{
        $('.select_data').prop('checked',false);
        $('.delete_btn').addClass('d-none');
    }
    // $('.select_data').is(':checked') ? $('.select_data').closest('tr').addClass('bg-warning') : $('.select_data').closest('tr').removeClass('bg-warning');
}

// =============== Table select single item =====================
function selectSingleItem(id){
    var totalRow = $('.select_data').length; //Count total row
    var totalCheck = $('.select_data:checked').length; //Count total checked row
    // $('#checkBox'+id+'').is(':checked') ? $('#checkBox'+id+'').closest('tr').addClass('bg-warning') : $('#checkBox'+id+'').closest('tr').removeClass('bg-warning');
    (totalRow == totalCheck) ? $('#select_all').prop('checked',true) : $('#select_all').prop('checked',false);
    (totalCheck > 0) ? $('.delete_btn').removeClass('d-none') :  $('.delete_btn').addClass('d-none');
}

// =============== Store form data ======================
function storeOrUpdateFormData(table,url,method,formData){
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(){
            $('#save_btn').addClass('kt-spinner kt-spinner--mid kt-spinner--light');
        },
        complete: function(){
            $('#save_btn').removeClass('kt-spinner kt-spinner--mid kt-spinner--light');
        },
        success: function (data) {
            // validation form
            $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#store_or_update_form').find('.error').remove();
            if(data.status == false){
                $.each(data.errors, function (key, value) {
                    $('#store_or_update_form input#'+key).addClass('is-invalid');
                    $('#store_or_update_form textarea#'+key).addClass('is-invalid');
                    $('#store_or_update_form select#'+key).parent().addClass('is-invalid');
                    $('#store_or_update_form #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');
                 });
            }else{
                notification(data.status, data.message);
                if(data.status == 'success'){
                    if(method == 'update'){
                        table.ajax.reload(null,false);
                    }else{
                        table.ajax.reload();
                    }
                    $('#store_or_update_modal').modal('hide');
                }
            }
        },
        error: function(xhr, ajaxOption, thrownError){
            console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
            console.log('errors');
        },
    });
}

// =============== Delete Data ======================
function deleteData(id,url,table,row,name){
    Swal.fire({
    title: 'Are you sure to delete '+name+' data?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                    _token: _token,
                },
                dataType: "json",
            }).done(function(response){
                if(response.status == 'success'){
                    swal.fire('Deleted',response.message,"success").then(function(){
                        table.row(row).remove().draw(false);
                        $('.delete_btn').addClass('d-none');
                    });
                }
                if(response.status == 'error'){
                    swal.fire('Ooops...',response.message, response.status);
                }
            }).fail(function(){
                swal.fire('Ooops...',"Something went wrong!", "error");
            });
        }
    });
}

// ===================== Bulk Action Delete ========================
function bulkDelete(ids,url,table,rows){
    Swal.fire({
    title: 'Are you sure to delete all checked data?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete all!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    ids: ids,
                    _token: _token,
                },
                dataType: "json",
            }).done(function(response){
                if(response.status == 'success'){
                    swal.fire('Deleted',response.message,"success").then(function(){
                        $('#select_all').prop('checked', false);
                        table.rows(rows).remove().draw(false);
                        $('.delete_btn').addClass('d-none');
                    });
                }
                if(response.status == 'error'){
                    swal.fire('Oppos',response.message,"error");
                }
            }).fail(function(){
                swal.fire('Ooops...',"Something went wrong!", "error");
            });
        }
    });
}

// ================= flashMessage ====================
function notification(status, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      Toast.fire({
        icon: status,
        title: message
      });
}

