function toggleFilter(element) {
    $('#filterPanel_'+element).toggle();
}

function toggleEntry(entryId) {
    $('#'+entryId).children('div').eq(1).toggle();
    if ($('#'+entryId).children('div').eq(1).is(":visible")) {
        $('#'+entryId).children('div').eq(0).children('span').eq(0).removeClass('caret');
    } else {
        $('#'+entryId).children('div').eq(0).children('span').eq(0).addClass('caret')
    }
}