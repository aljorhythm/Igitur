var Igitur = {};
Igitur.Util = {};
Igitur.Util.LOGICAL_CONNECTIVE_URL = "LogicalConnective.php";
Igitur.Util.PROPOSITION_URL = "Proposition.php";
Igitur.Util.GET_AJAX_JSON = function(url, callback) {
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
            if (callback)
                callback(data);
        }
    });
    if (!callback)
        return ret;
};
Igitur.LogicalConnective = {};
Igitur.LogicalConnective.GetCategory = function(categoryId) {
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_get&category_id=" + categoryId;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.AddCategory = function(categoryName) {
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_add&category_name=" + categoryName;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.RemoveCategory = function(categoryId) {
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove&category_id=" + categoryId;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.GetAllCategories = function() {
    var categories = Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_all");
    return categories;
};
Igitur.LogicalConnective.AddPhrase = function(phrase) {
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=phrase_add&phrase=" + phrase;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.SearchPhrases = function(searchTerm, categoryId) {
    if (categoryId === null)
        categoryId = 0;
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=phrase_search&exclude_category=" + categoryId + "&search_term=" + searchTerm;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.AddPhraseToCategory = function(categoryId, phraseId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_add_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.RemovePhraseFromCategory = function(categoryId, phraseId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.GetPhrasesFromCategory = function(categoryId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_phrases&category_id=" + categoryId);
};
Igitur.LogicalConnective.GetAllSymbols = function(excludeCategoryId) {
    if (typeof excludeCategoryId === "undefined")
        excludeCategoryId = 0;
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=symbol_get&exclude_category=" + excludeCategoryId);
};
Igitur.LogicalConnective.AddSymbolToCategory = function(categoryId, symbolId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_add_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.RemoveSymbolFromCategory = function(categoryId, symbolId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.GetSymbolsFromCategory = function(categoryId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_symbols&category_id=" + categoryId);
};
Igitur.Proposition = function(id, p, q, connective) {
    this.id = id;
    this.p = p;
    this.q = q;
    this.connective = connective;
};
Igitur.Proposition.GetProposition = function(propositionId) {
    var proposition = Igitur.Proposition.GetPropositionRaw(propositionId);
    proposition.prototype = new Igitur.Proposition();
    return proposition;
};
Igitur.Proposition.GetPropositionRaw = function(propositionId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.PROPOSITION_URL + "?type=json&request=category_symbols&proposition_id=" + propositionId);
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