<?php include 'common.php'; ?>
<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>

<script src="assets/js/misc.js"></script>

		
<script>
$(document).ready(function () {
    var ul = $('#typecho-message ul'), cache = window.sessionStorage,
        html = cache ? cache.getItem('feed') : '',
        update = cache ? cache.getItem('update') : '';

    if (!!html) {
        ul.html(html);
    } else {
        html = '';
        $.get('<?php $options->index('/action/ajax?do=feed'); ?>', function (o) {
            for (var i = 0; i < o.length; i ++) {
                var item = o[i];
                html += '<li><span>' + item.date + '</span> <a href="' + item.link + '" target="_blank">' + item.title
                    + '</a></li>';
            }

            ul.html(html);
            cache.setItem('feed', html);
        }, 'json');
    }

    function applyUpdate(update) {

    }

    if (!!update) {
        applyUpdate($.parseJSON(update));
    } else {
        $.get('<?php $options->index('/action/ajax?do=checkVersion'); ?>', function (o, status, resp) {
            applyUpdate(o);
            cache.setItem('update', resp.responseText);
        }, 'json');
    }
});

</script>
