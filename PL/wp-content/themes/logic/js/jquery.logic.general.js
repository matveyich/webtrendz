jq(document).ready(function() {
// FOR search form 
jq("#s").attr('value', 'Search');
jq("#s").focus(function() {jq(this).attr('value', '');});
jq("#s").blur(function() {jq(this).attr('value', 'Search');});
jq("#slidemenu ul").children(':eq(6)').addClass("last");
////// search  form end

});
