let response_html = '';
let phones = [];
let current_page = 1;
let records_per_page = 10;

function formattedState(valid) {
  if (valid) {
    return 'OK';
  }
  return 'NOK';
}

function formattedRow(phone) {
  if (!phone)
    return '';

  html  = '<tr>';
  html += '<td>'+phone.country+'</td>';
  html += '<td>'+formattedState(phone.valid)+'</td>';
  html += '<td>'+'+'+phone.code+'</td>';
  html += '<td>'+phone.number+'</td>';
  html += '</tr>';

  return html;
}

function queryParams() {
  let country = $('#country-filter').val();
  let state   = $('#state-filter').val();

  return jQuery.param({ country: country, state: state });
}

function fetchPhonesData() {
  $.get({
    url: 'phones.php?'+queryParams(),
    success: function(data) {
      response_html = '';
      phones = JSON.parse(data);
    },
    complete: function() {
      changePage(1);
    }
  });
}

function previousPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage()
{
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    }
}
    
function changePage(page)
{
    var btnNext = document.getElementById("btn-next");
    var btnPrevious = document.getElementById("btn-previous");
    var phonesTable = document.getElementById("phones-data");
 
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

    phonesTable.innerHTML = "";

    for (var i = (page-1) * records_per_page; i < (page * records_per_page); i++) {
        phonesTable.innerHTML += formattedRow(phones[i]);
    }

    if (page == 1) {
        btnPrevious.disabled = "disabled";
    } else {
        btnPrevious.disabled = "";
    }

    if (page == numPages()) {
        btnNext.disabled = 'disabled';
    } else {
        btnNext.disabled = "";
    }
}

function numPages()
{
    return Math.ceil(phones.length / records_per_page);
}

document.addEventListener("DOMContentLoaded", function() {
  $('#country-filter').on('change', function() { fetchPhonesData() });
  $('#state-filter').on('change', function() { fetchPhonesData() });

  fetchPhonesData();
});
