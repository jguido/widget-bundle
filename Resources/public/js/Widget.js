var Widget = {
    refresh: function (id, callback, start, end) {
        var $el = $('#' + id);
        var $spinner = $('#spinner-' + id);
        if ($el.attr('data-loaded') === 'false') {
            $el.html('');
            $spinner.fadeIn(50);
            var route = $el.attr('data-src') + "?v=1";
            if (start) {
                route += "&startDate=" + start;
            }
            if (end) {
                route += "&endDate=" + end;
            }
            $.get(route, function (res) {
                try {
                    $el.attr('data-loaded', 'true');
                    $spinner.hide();
                    $el.html(res);
                } catch (e) {
                    console.error(e);
                    $el.html('<p class="alert alert-danger">' + errorDomLoading + '</p>' + $el.html())
                }
            }).fail(function () {
                $spinner.hide();
                $el.html('<p class="alert alert-danger">' + errorLoading + '</p>');
            })
        }
    }
};