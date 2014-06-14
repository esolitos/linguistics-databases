// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
RegExp.quote = function(str) {
    return (str+'').replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
};

jQuery().ready(function($) {
    $(document).foundation();
});
