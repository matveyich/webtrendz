<script>
function edToolbar_wtz(canvas_name)
	{
	document.write('<div id="ed_toolbar">');
	for(var a=0;a<edButtons.length;a++)
	{
	edShowButton_wtz(edButtons[a],a,canvas_name); 
	}
	document.write('<input type="button" id="ed_spell" class="ed_button" onclick="edSpell('+canvas_name+');" title="'+quicktagsL10n.dictionaryLookup+'" value="'+quicktagsL10n.lookup+'" />');
	document.write('<input type="button" id="ed_close" class="ed_button" onclick="edCloseAllTags_wtz('+canvas_name+');" title="'+quicktagsL10n.closeAllOpenTags+'" value="'+quicktagsL10n.closeTags+'" />');
	document.write("</div>")
	}
function edCloseAllTags_wtz(canvas_name)
	{
	var a=edOpenTags.length,b;
	for(b=0;b<a;b++)
		{
		edInsertTag(canvas_name,edOpenTags[edOpenTags.length-1])
		}
	}	
function edShowButton_wtz(b,a,canvas_name)
	{
	if(b.id=="ed_img")
	{
		document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertImage('+canvas_name+');" value="'+b.display+'" />')
	}else{
		if(b.id=="ed_link")
		{
			document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertLink('+canvas_name+', '+a+');" value="'+b.display+'" />')
		}else{
		document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertTag('+canvas_name+', '+a+');" value="'+b.display+'"  />')
		}
		}
	}
</script>