var Igitur = {};
Igitur.Util = {};
Igitur.Util.LOGICAL_CONNECTIVE_URL = "LogicalConnective.php";
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
    return  Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId);
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
    return   Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_add_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.RemoveSymbolFromCategory = function(categoryId, symbolId) {
    return  Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove_symbol&symbol_id=" + symbolId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.GetSymbolsFromCategory = function(categoryId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_symbols&category_id=" + categoryId);
};