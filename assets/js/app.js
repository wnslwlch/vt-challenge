$(document).ready(function () {
    var $cache = {
        window: $(window),
        document: $(document)
    };

    function initializeCache() {
        $cache.iconLikes = $cache.document.find('.icon-likes');
    }

    $cache.document.ready(function ($) {

        $cache.iconLikes.click(function () {
            $("i", this).toggleClass("fas far");
        });
    })

    initializeCache();
});