$(document).ready(function(){
	$("img.add-line", "form").live("click", function() {
		var self = $(this);
		var parentTr = self.parents("tr:first");
		var newName = parentTr.find(":input").attr('name').replace(/\[([0-9]*)\]/, function(m, n){
			return '['+(parseInt(n)+1)+']';
		});
		
		if(self.closest("table").find("tbody tr").size() < 10) {
			parentTr.clone().insertAfter($(this).parents("tr:first")).find(":input").attr('name', newName).val('');
			self.parents("td:first").remove();
		}
		else {
			// Max
			self.parents("td:first").remove();
			parentTr.clone().insertAfter($(this).parents("tr:first")).find(":input").attr('name', newName).val('');
		}
		
	});
});
