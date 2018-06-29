<script>
	function makeSorty(table) {
		//Make the titles clickable to sort
		var tableBody = table.children[0];
		var firstRow = tableBody.children[0];

		for (var i = 0; i < firstRow.children.length; i++) {
			var th = firstRow.children[i];
			var div = document.createElement("div");
			var text = document.createTextNode(th.innerText);
			th.innerText = "";
			div.appendChild(text);
			div.className="myClass";
			div.onclick = (function(t,c){return function(){sortTable(t,c);};})(table,i);
			th.appendChild(div);
		}
	}
	
	function sortTable(table,column) {
		var tableBody = table.children[0];
		var all = "";
		while (true) {
			var sorted = true;	//true until otherwise false
			
			//Look at rows i and i-1 (start at i=2 so we look at the first 2 data rows and ignore headers)
			for (var i = 2; i < tableBody.children.length; i++) {
				var prevValue = getValue(table,i-1,column).toLowerCase();
				var value = getValue(table,i,column).toLowerCase();
				
				//Locale compare is a modern way to have your browser compare alpha-numeric strings
				if (value.localeCompare(prevValue, undefined, {numeric: true, sensitivity: 'base'}) < 0) {
					moveUpOneRow(table,i);
					sorted = false;
				}
		
			}
			
			if (sorted) { return; }
		}
	}
	
	function getValue(table,rowIndex,columnIndex) {
		var tableBody = table.children[0];
		var row = tableBody.children[rowIndex];
		return row.children[columnIndex].innerText;
	}
	
	function moveUpOneRow(table,row) {
		var tableBody = table.children[0];
		tableBody.insertBefore(tableBody.children[row],tableBody.children[row-1]);
	}

</script>

<style>
.myClass:hover {
	cursor: pointer;
}
</style>