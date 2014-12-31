function addCommas(nStr){
    return nStr.replace('.', ',');
}

function addDots(nStr){
    return parseFloat(nStr.replace(',', '.'));
}

function printTable(e){
    e.preventDefault();
    console.log('print that shit');
    window.print();
}

$( document ).ready(function() {
    $('body').on('click', '.btn-print', printTable)
    $('.nav > li.dropdown').hover(function () {
        $(this).addClass('open');
    }, function(){
        $(this).removeClass('open');
    });
});

/*
function htmlspecialchars(string){
    return $('<input>').val(string).html();
}*/
