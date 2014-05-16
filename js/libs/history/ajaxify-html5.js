// Ajaxify
// v1.0.1 - 30 September, 2012
// https://github.com/browserstate/ajaxify
var Ajaxify;
(function(window, undefined) {

    // Prepare our Variables
    var
            History = window.History,
            $ = window.jQuery,
            document = window.document;

    // Check to see if History.js is enabled for our Browser
    if (!History.enabled) {
        return false;
    }
    Ajaxify = {
        Callback: null, FadeDuration: 600
    };
    // Wait for Document
    $(function() {
        // Prepare Variables
        var
                /* Application Specific Variables */
                contentSelector = '#main-container',
                $content = $(contentSelector).filter(':first'),
                contentNode = $content.get(0),
                $menu = $('#side-nav').filter(':first'),
                activeClass = 'youarehere',
                activeSelector = 'youarehere',
                //activeClass = 'active selected current youarehere',
                //activeSelector = '.active,.selected,.current,.youarehere',
                menuChildrenSelector = ' #side-nav-nav ul, #side-nav-nav li',
                completedEventName = 'statechangecomplete',
                /* Application Generic Variables */
                $window = $(window),
                $body = $(document.body),
                rootUrl = History.getRootUrl();

        // Ensure Content
        if ($content.length === 0) {
            $content = $body;
        }

        // Internal Helper
        $.expr[':'].internal = function(obj, index, meta, stack) {
            // Prepare
            var
                    $this = $(obj),
                    url = $this.attr('href') || '',
                    isInternalLink;

            // Check link
            isInternalLink = url.substring(0, rootUrl.length) === rootUrl || url.indexOf(':') === -1;

            // Ignore or Keep
            return isInternalLink;
        };

        // HTML Helper
        var documentHtml = function(html) {
            // Prepare
            var result = String(html)
                    .replace(/<\!DOCTYPE[^>]*>/i, '')
                    .replace(/<(html|head|body|title|meta|script)([\s\>])/gi, '<div class="document-$1"$2')
                    .replace(/<\/(html|head|body|title|meta|script)\>/gi, '</div>')
                    ;

            // Return
            return $.trim(result);
        };

        // Ajaxify Helper
        $.fn.ajaxify = function() {
            // Prepare
            var $this = $(this);

            // Ajaxify
            $this.find('a:not(.no-ajaxy)').click(function(event) {
                // Prepare
                var
                        $this = $(this),
                        url = $this.attr('href'),
                        title = $this.attr('title') || null;

                // Continue as normal for cmd clicks etc
                if (event.which == 2 || event.metaKey) {
                    return true;
                }

                // Ajaxify this link
                History.pushState(null, title, url);
                event.preventDefault();
                return false;
            });

            // Chain
            return $this;
        };

        // Ajaxify our Internal Links
        $body.ajaxify();

        // Hook into State Changes
        $window.bind('statechange', function() {
            // Prepare Variables
            var
                    State = History.getState(),
                    url = State.url,
                    relativeUrl = url.replace(rootUrl, '');

            // Set Loading
            $body.addClass('loading');

            // Start Fade Out
            // Animating to opacity to 0 still keeps the element's height intact
            // Which prevents that annoying pop bang issue when loading in new content

            $content.animate({opacity: 0}, {duration: Ajaxify.FadeDuration, complete: function() {
                    if (typeof (Ajaxify.Callback) === 'function') {
                        Ajaxify.Callback();
                        Ajaxify.Callback = null;
                    }
                }});

            function AfterRequest(data) {

                // Prepare
                var
                        $data = $(documentHtml(data)),
                        $dataBody = $data.find('.document-body:first'),
                        $dataContent = $dataBody.find(contentSelector).filter(':first'),
                        $menuChildren, contentHtml, $scripts;

                // Fetch the content
                contentHtml = $dataContent.html() || $data.html();
                if (!contentHtml) {
                    document.location.href = url;
                    return false;
                }

                // Update the menu
                $menuChildren = $menu.find(menuChildrenSelector);
                $menuChildren.filter(activeSelector).removeClass(activeClass);
                $menuChildren = $menuChildren.has('a[href^="' + relativeUrl + '"],a[href^="/' + relativeUrl + '"],a[href^="' + url + '"]');
                if ($menuChildren.length === 1) {
                    $menuChildren.addClass(activeClass);
                }

                // Update the content 
                $content.html(contentHtml).ajaxify().animate({'opacity': '100'}, {duration: Ajaxify.FadeDuration}); /* you could fade in here if you'd like */

                // Update the title
                document.title = $data.find('.document-title:first').text();
                try {
                    document.getElementsByTagName('title')[0].innerHTML = document.title.replace('<', '&lt;').replace('>', '&gt;').replace(' & ', ' &amp; ');
                }
                catch (Exception) {
                }

                // Refresh nav
                var shouldRefresh = $dataBody.find("#ui-data").data('loggedin') !== $("#ui-data").data('loggedin');
                if (shouldRefresh) {
                    $("#side-nav #opatable").animate({opacity: '0'}, {queue: false, duration: 600, complete: function() {
                            $("#side-nav #opatable").replaceWith($dataBody.find("#side-nav #opatable")).animate({opacity: '1'}, {duration: 400});
                        }});

                    //fetch scripts (nav)
                    $scripts = $dataBody.find("#side-nav #opatable").find('.document-script');
                    $scripts.each(function() {
                        var parent = this.parentNode, sibling = this.nextSibling;

                        var $script = $(this), scriptText = $script.text(), scriptNode = document.createElement('script');
                        $script.detach();
                        if ($script.attr('src')) {
                            if (!$script[0].async) {
                                scriptNode.async = false;
                            }
                            scriptNode.src = $script.attr('src');
                        }
                        scriptNode.appendChild(document.createTextNode(scriptText));
                        parent.insertBefore(scriptNode, sibling);
                    });
                }
                // Fetch the scripts (content)
                $scripts = $content.find('.document-script');
                if ($scripts.length) {
                    $scripts.detach();
                }
                // Add the scripts (content)
                $scripts.each(function() {
                    console.log(contentNode);
                    var $script = $(this), scriptText = $script.text(), scriptNode = document.createElement('script');
                    if ($script.attr('src')) {
                        if (!$script[0].async) {
                            scriptNode.async = false;
                        }
                        scriptNode.src = $script.attr('src');
                    }
                    scriptNode.appendChild(document.createTextNode(scriptText));
                    contentNode.appendChild(scriptNode);
                });

                $body.removeClass('loading');
                $window.trigger(completedEventName);

                // Inform Google Analytics of the change
                if (typeof window._gaq !== 'undefined') {
                    window._gaq.push(['_trackPageview', relativeUrl]);
                }

                // Inform ReInvigorate of a state change
                if (typeof window.reinvigorate !== 'undefined' && typeof window.reinvigorate.ajax_track !== 'undefined') {
                    reinvigorate.ajax_track(url);
                    // ^ we use the full url here as that is what reinvigorate supports
                }
            }

            // Ajax Request the Traditional Page
            $.ajax({
                url: url,
                success: function(data) {
                    if (Ajaxify.Callback === null) {
                        Ajaxify.Callback = function() {
                            AfterRequest(data);
                        };
                    } else if (Ajaxify.Callback === true) {
                        AfterRequest(data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    document.location.href = url;
                    return false;
                }
            }); // end ajax

        }); // end onStateChange

    }); // end onDomLoad

})(window); // end closure
