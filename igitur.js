var Igitur = {};
Igitur.Util = {
    URL_LOGICAL_CONNECTIVE: "LogicalConnective.php",
    URL_PROPOSITION: "Proposition.php",
    URL_CONTEXT: "Context.php",
    URL_UAC: "UAC.php",
    GET_AJAX_JSON: function(url, callback) {
        var ret;
        var async = false;
        if (callback) {
            async = true;
        }
        $.ajax({
            url: url,
            dataType: 'json',
            async: async,
            success: function(data) {
                ret = data;
                if (callback) {
                    callback(data);
                }
            }
        });
        if (!callback)
            return ret;
    }, POST_AJAX_JSON: function(url, dataArgs, callback) {
        var ret;
        var async = false;
        if (callback) {
            async = true;
        }
        $.ajax({
            data: dataArgs,
            type: 'post',
            url: url,
            dataType: 'json',
            async: async,
            success: function(data) {
                ret = data;
                if (callback)
                    callback(data);
            }
        });
        if (!callback)
            return ret;
    }
};
Igitur.LogicalConnective = {
    GetCategory: function(categoryId, callback) {
        var url = Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_get&category_id=" + categoryId;
        return Igitur.Util.GET_AJAX_JSON(url, callback);
    }, AddCategory: function(categoryName, callback) {
        var url = Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_add&category_name=" + categoryName;
        return Igitur.Util.GET_AJAX_JSON(url, callback);
    }, RemoveCategory: function(categoryId, callback) {
        var url = Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_remove&category_id=" + categoryId;
        return Igitur.Util.GET_AJAX_JSON(url, callback);
    }, GetAllCategories: function(callback) {
        var categories = Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_all", callback);
        return categories;
    }, AddPhrase: function(phrase, callback) {
        var url = Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=phrase_add&phrase=" + phrase;
        return Igitur.Util.GET_AJAX_JSON(url, callback);
    }, SearchPhrases: function(searchTerm, categoryId, callback) {
        if (categoryId === null)
            categoryId = 0;
        var url = Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=phrase_search&exclude_category=" + categoryId + "&search_term=" + searchTerm;
        return Igitur.Util.GET_AJAX_JSON(url, callback);
    }, AddPhraseToCategory: function(categoryId, phraseId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_add_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId, callback);
    }, RemovePhraseFromCategory: function(categoryId, phraseId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_remove_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId, callback);
    }, GetPhrasesFromCategory: function(categoryId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_phrases&category_id=" + categoryId, callback);
    }, GetAllSymbols: function(excludeCategoryId, callback) {
        if (typeof excludeCategoryId === "undefined")
            excludeCategoryId = 0;
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=symbol_get&exclude_category=" + excludeCategoryId, callback);
    }, AddSymbolToCategory: function(categoryId, symbolId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_add_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId, callback);
    }, RemoveSymbolFromCategory: function(categoryId, symbolId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_remove_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId, callback);
    }, GetSymbolsFromCategory: function(categoryId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_LOGICAL_CONNECTIVE + "?type=json&request=category_symbols&category_id=" + categoryId, callback);
    }
};
Igitur.Proposition = {
    GetProposition: function(propositionId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_PROPOSITION + "?class=proposition&request=proposition_get&propositionId=" + propositionId, callback);
    }, GetPropositionsUser: function(userId, callback) {
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_PROPOSITION + "?class=proposition&request=proposition_get_user&userId=" + userId, callback);
    }
};
Igitur.Context = {
    GetAll: function(userId, rangeX, rangeY, callback) {
        rangeX = (rangeX) === 0 ? "&rangeX=" + rangeX : "";
        rangeY = (rangeX) === 0 ? "&rangeY=" + rangeY : "";
        return Igitur.Util.GET_AJAX_JSON(Igitur.Util.URL_CONTEXT + "?class=context&request=getAll&userId=" + userId + rangeX + rangeY, callback);
    }, SetDescription: function(contextId, description, callback) {
        return Igitur.Util.POST_AJAX_JSON(Igitur.Util.URL_CONTEXT, {
            'class': 'context',
            'request': 'setDescription',
            'contextId': contextId,
            'description': description
        }, callback);
    }
};
Igitur.UAC = {
    Login: function(username, password, callback) {
        return Igitur.Util.POST_AJAX_JSON(Igitur.Util.URL_UAC, {
            'class': 'uac',
            'request': 'login',
            'username': username,
            'password': password

        }, callback);
    }, Logout: function(callback) {
        return Igitur.Util.POST_AJAX_JSON(Igitur.Util.URL_UAC, {
            'class': 'uac',
            'request': 'logout'
        }, callback);
    }
};
Igitur.Parser = {};
Igitur.Parser.parse = function(str) {
    switch (str) {
    }
};
Igitur.Parser.Split = function(str) {
    return str.split(":");
};
Igitur.Parser.toHtml = function(v) {
    if (v instanceof String) {
        var arr = Igitur.Parser.Split(v);
        var html = $("<span>");
        switch (arr[1]) {
            case "p":
                html.addClass("prop-span");
                break;
            case "s":
                html.addClass("statement-span");
                break;
            case "ph":
                html.addClass("phrase-span");
                break;
            case "c":
                html.addClass("connective-span");
                break;
        }
        html.append(arr[0]);
    } else {
        if (v instanceof Igitur.Proposition) {
        }
        else if (v instanceof Igitur.Phrase) {
        }
        else if (v instanceof Igitur.Category) {
        }
        else if (v instanceof Igitur.Proposition) {
        }
    }
};
Igitur.Parser.RemoveMeta = function(str) {
    if (str.indexOf(":") > 0) {
        return str.split(":")[0];
    }
    else {
        return str;
    }
};
Igitur.Parser.RemoveAllMeta = function(str) {
    var arr = str.split(" ");
    str = "";
    $.each(arr, function(key, val) {
        str += " " + Igitur.Parser.RemoveMeta(val);
    });
    return str;
};