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

Igitur.LogicalConnective.GetAllSymbols = function() {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=get_all_symbols");
};
Igitur.LogicalConnective.AddPhrase = function(phrase) {
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=phrases_add&phrase=" + phrase;
    return Igitur.Util.GET_AJAX_JSON(url);
};
Igitur.LogicalConnective.SearchPhrases = function(searchTerm, categoryId) {
    if (categoryId === null)
        categoryId = 0;
    var url = Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=phrases_search&exclude_category=" + categoryId + "&search_term=" + searchTerm;
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
Igitur.LogicalConnective.AddPhraseToCategory = function(categoryId, phraseId) {
    Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_add_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.RemovePhraseFromCategory = function(categoryId, phraseId) {
    Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=category_remove_phrase&phrase_id=" + phraseId + "&category_id=" + categoryId);
};
Igitur.LogicalConnective.GetPhrasesFromCategory = function(categoryId) {
    return Igitur.Util.GET_AJAX_JSON(Igitur.Util.LOGICAL_CONNECTIVE_URL + "?type=json&request=phrases_from_category&category_id=" + categoryId);
};
//below to be removed  