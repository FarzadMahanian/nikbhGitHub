var NIK = {
    responsive: {
        mobile: 320,
        tablet: 768,
        computer: 992,
        large_screen: 1200,
        wide_screen: 1920
    }
};
paceOptions = {
    ajax: false
};
Pace.on('done', function() {
    console.log('done!');
    setTimeout(function() {
        jQuery('.mask-all').css('z-index', '-10');
    }, 1000);
});
jQuery(function() {
    var dir = 'ltr';
    var isRtl = false;
    if (jQuery('html').attr('dir') == 'rtl') {
        dir = 'rtl';
        isRtl = true;
    }
    NIK.direction = dir;
    NIK.isRTL = isRtl;
});

