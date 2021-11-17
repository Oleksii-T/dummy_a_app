$(document).ready(function () {
    var $ = jQuery.noConflict();

    let table = $('#subscription-plans-table').DataTable({
        //processing: true,
        order: [[ 0, "desc" ]],
        serverSide: true,
        ajax: window.location.href,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'interval', name: 'interval' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('click', '#subscription-plans-table .delete-resource', function (e) {
        e.preventDefault();
        deleteResource(table, $(this).data('link'));
    });

    $("select[multiple='multiple']").select2({
        tags: true
    });

    $('input[name=free_plan]').change(function(){
        if ($(this).is(':checked')) {
            $('input[name=price]').val(0);
            $('input[name=price]').attr('readonly', true);
        } else {
            $('input[name=price]').attr('readonly', false);
        }
    })

    $('select[name=interval]').change(function(){
        let val = $(this).val();
        if (val == 'endless') {
            $('input[name=number_intervals]').val('').attr('disabled','disabled');
        } else {
            $('input[name=number_intervals]').removeAttr('disabled');
        }
    })
});