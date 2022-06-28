<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" ></script>

<div class="p-3 mb-4" style="background-color: white; border-radius: 7px; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
      <label for="">Tanggal </label>
      <div class="form d-flex justify-content-between align-items-center">
        <input class="col-sm-5" type="text" type="form-control form-date" id="income-per_date_start" style="border: 3px solid #e91e63; border-radius: 4px;">
        <label for=""> Sampai </label>
        <input class="col-sm-5" type="text" type="form-control form-date" id="income-per_date_end" style="border: 3px solid #1A73E8; border-radius: 4px;" disabled>
      </div>
    </div>

let minDates, endDates;
$("#income-per_date_start").datepicker({
    format: 'yyyy-mm-dd',
    todayBtn:  1,
    autoclose: true,
}).change(function (selected) {
  minDates = new Date($(this).val());
  endDates = new Date(new Date().setDate(minDates.getDate() + 7));
  console.log(endDates);
  $('#income-per_date_end').prop('disabled', false);
  $('#income-per_date_end').val("").datepicker("update");
});

console.log(minDates)

$('#income-per_date_end').datepicker({
  format: 'yyyy-mm-dd',
  startDate: minDates,
  endDate: endDates,
});
