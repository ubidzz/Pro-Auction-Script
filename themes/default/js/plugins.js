$(document).ready(function() {
    function toggleNavbarMethod() {
        if ($(window).width() > 768) {
            $('.navbar .dropdown').on('mouseover', function(){
                $('.dropdown-toggle', this).trigger('click');
            }).on('mouseout', function(){
                $('.dropdown-toggle', this).trigger('click').blur();
            });
        }
        else {
            $('.navbar .dropdown').off('mouseover').off('mouseout');
        }
    }
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);
    var adjust_size = function () {
        windowsize = $(window).width();
		//truncate if window width < 480
        if (windowsize < 480) {
            $('.list-title a, .truncate-table').truncate({
                width: '200',
                token: '&hellip;',
                center: false,
                multiline: false
            });
            $('#sub-cats').removeClass('in');
            $('#sub-cats-btn').show();
        } else {
            $('#sub-cats').addClass('in');
            $('#sub-cats-btn').hide();
        };
    };
    adjust_size();
    $(window).resize(adjust_size);
    $(".table-row-click").click(function () {
        window.location.href = $(this).find(".list-title a").attr("href");
    });
    //end ready
	jQuery('[rel=popover]').popover();
});
function toggleNavbarMethod() {
    if ($(window).width() > 768) {
        $('.navbar .dropdown').on('mouseover', function(){
            $('.dropdown-toggle', this).trigger('click');
        }).on('mouseout', function(){
            $('.dropdown-toggle', this).trigger('click').blur();
        });
    }
    else {
        $('.navbar .dropdown').off('mouseover').off('mouseout');
    }
}

function LoginAlertModal() {
    $("#SMSLoginAlertModal").modal('show');
    $('#SMSLoginAlertModal').modal({
	  	backdrop: 'static',
	 	keyboard: false
	});
}
