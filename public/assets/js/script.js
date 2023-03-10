
// Ajax function
var ajaxCall = function (method, url, data, callback) {

    $("#ajaxloader").show();

    $.ajax({
        url: url,
        type: method,
        data: data,
        complete: function (response) {
            $("#ajaxloader").hide();

            var output = {
                "code": response.status,
                "json": response.responseJSON,
                "text": response.responseText,
                "raw": response,
            };

            callback(output);
        }
    });
};

// Auto Log Off
var autoLogoffCall = function () {
    var logoff = BASE_URL+"/logoff";
    var current_url = window.location.href;
    ajaxCall("GET", logoff, { current_url: current_url }, function (response) {
        window.location.replace(response.json.data);
    });
};

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": true,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "4000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "slideDown",
  "hideMethod": "fadeOut"
}
var fetchJobs = function (){
    $.ajax({
        url: BASE_URL+"/status/jobs",
        type: 'get',
        success: function(data){
            //console.log(data);
            if(data.status == 'inprogress'){
                toastr.success(''+data.message,"Processing...");
            }
            if(data.status == 'success'){
                if($('#running_jobs').length){
                    $('#running_jobs').remove();
                    toastr.options = {
                        closeButton: true,
                        timeOut: 0,
                        extendedTimeOut: 0
                    };
                    toastr.info('Assigned process has been completed.',"Finished!");        
                }
            }
        },
        complete:function(data){
            setTimeout(fetchJobs, 6000);
        }
    });
}

function displayValidationError(response)
{
    var errors = response.json.errors;

    $.each(errors, function (index, value) {
        $("#ve-" + index).html(value[0]);
    });

    return false;
}

$(document).ready(function (e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".alert-dialog").click(function (e) {

        e.preventDefault();

        var id = $(this).attr("data-id");
        var method = $(this).attr("data-method");

        if (typeof id === "undefined") {
            id = "";
        }

        if (typeof id === "undefined") {
            method = "POST";
        }

        var message = $(this).attr("data-message");
        
        $("#delete-alert-modal #deleteAlertFrm input[name='_method']").val(method);
        $("#delete-alert-modal #deleteAlertFrm").attr("action", $(this).attr("data-action"));
        $("#delete-alert-modal #deleteAlertFrm .modal-body").html(message);
        $("input[name=id]").val(id);
        $("input[name=metaData]").val($(this).attr("data-meta"));

        $("#delete-alert-modal").modal("show");
    });

    $(".select2").select2({
        placeholder: "--Select One--",
        allowClear: true
    });

    $(".datepicker").datepicker({
        autoclose: true,
        /*daysOfWeekDisabled: [5],*/
        format: JS_DATE_FORMAT
    });
    
    /*******************************************/
    // Date Ranges
    /*******************************************/
    $('.dateranges').daterangepicker({
        "alwaysShowCalendars": true,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'Y-MM-DD'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
        
    }); 

    $('input[name="search_date_range"]').on('apply.daterangepicker', function(ev, picker) {
        $('.search_from_date').val(picker.startDate.format('Y-MM-DD'));
        $('.search_to_date').val(picker.endDate.format('Y-MM-DD'));
        $(this).val(picker.startDate.format('Y-MM-DD') + ' - ' + picker.endDate.format('Y-MM-DD'));
    });

    $('input[name="search_date_range"]').on('cancel.daterangepicker', function(ev, picker) {
        $('.search_from_date').val('');
        $('.search_to_date').val('');
        $(this).val('');
    });

});