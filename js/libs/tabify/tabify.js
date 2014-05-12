function Tabify($tabify) {
    $tabify.addClass('tabify');
    $tabify.children('ul').children('li').on('click', function() {
        $tabify.children('ul').children('li').removeClass('active');
        this.className = 'active';
        var index = $(this).index();
        var tabs = $tabify.children('div').children('div');
        tabs.removeClass('active');
        $(tabs.get(index)).addClass('active');
    });
    $tabify.children('ul').children('li:first-child').trigger('click');
}