let companyId,
    userId,
    baseUrl = 'http://whoami.co.id/pdms/',
    roleId,
    thisDay,
    companyName;

$.ajax({
    url: `${baseUrl}dashboard/getData`,
    type: 'GET',
    dataType: 'JSON',
    success: function(result) {
      if (result.responseCode === 200) {
        const datas = result.data;
        companyId = datas.companyId;
        userId = datas.userId;
        roleId = datas.roleId;
        companyName = datas.companyName;
        thisDay = datas.thisDay;
      };
    }
});

$(document).ready(async function() {
  $('#thisDay').html(`Tanggal hari ini : ${thisDay}`);
  const result = await getDataForDashboard();
  const data = result.data;
  domIncomeDayEnd(data.dataIncomePerDate);
  domIncomeWeekEnd(data.dataIncomePerWeek);
  domIncomeMonthEnd(data.dataIncomePerMonth);
  domIncomeYearEnd(data.dataIncomePerYear );

  // Expenditures
  domExpenditureDayEnd(data.dataExpenditurePerDate);
  domExpenditureWeekEnd(data.dataExpenditurePerWeek);
  domExpenditureMonthEnd(data.dataExpenditurePerMonth);
  domExpenditureYearEnd(data.dataExpenditurePerYear);
})

function getDataForDashboard() {
  $('#preloader').show();
  return Promise.resolve($.ajax({
    url: `${baseUrl}dashboard/getDataForDashboard`,
    type: 'GET',
    dataType: 'JSON',
    success: function(result) {
      $('#preloader').hide();
    },
    error : function(error) {
      $('#preloader').hide();
      swal({
        icon: "warning",
        title: "Failed",
        text: 'Ada ke salahan dalam sistem.',
        button: false,
      });
    }
  }));
}

function formatRupiah(value) {
  let	number_string = value.toString(),
      sisa 	= number_string.length % 3,
      rupiah 	= number_string.substr(0, sisa),
      ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

  if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
  }
  return rupiah;
}

function domIncomeDayEnd(data) {
  $('#income-per_day_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-income-per_day_end').html(`${data != null ? data.date : ''}`);
}

function domIncomeWeekEnd(data) {
  $('#income-per_week_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-income-per_week_end').html(`1 Minggu ini`);
}

function domIncomeMonthEnd(data) {
  $('#income-per_month_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-income-per_month_end').html(`1 Bulan ini`);
}

function domIncomeYearEnd(data) {
  $('#income-per_year_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-income-per_year_end').html(`1 Tahun ini`);
}

// Expenditures
function domExpenditureDayEnd(data) {
  $('#expenditure-per_day_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-expenditure-per_day_end').html(`${data.date != null ? data.date : ''}`);
}

function domExpenditureWeekEnd(data) {
  $('#expenditure-per_week_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-expenditure-per_week_end').html(`1 Minggu ini`);
}

function domExpenditureMonthEnd(data) {
  $('#expenditure-per_month_end').html(`Rp.${formatRupiah(data.total != null ? data.total : 0)}`);
  $('#date-expenditure-per_month_end').html(`1 Bulan ini`);
}

function domExpenditureYearEnd(data) {
  $('#expenditure-per_year_end').html(`Rp.${formatRupiah(data.total  != null ? data.total : 0)}`);
  $('#date-expenditure-per_year_end').html(`1 Tahun ini`);
}
