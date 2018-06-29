<script>
	function makeSorty(table) {
		//Make the titles clickable to sort
		var tableBody = table.children[0];
		tableBody.sortedColumn = -1;
		tableBody.sortedAsc = true;
		var firstRow = tableBody.children[0];

		for (var i = 0; i < firstRow.children.length; i++) {
			var th = firstRow.children[i];
			var div = document.createElement("div");
			var text = document.createTextNode(th.innerText);
			th.innerText = "";
			div.appendChild(text);
			div.className="sortyHeader";
			div.onclick = (function(t,c){return function(){sortTable(t,c);};})(table,i);
			th.appendChild(div);
			
			//Add the glyphicons span
			var span = document.createElement("span");
			div.appendChild(span);
		}
	}
	
	function sortTable(table,column) {
		var tableBody = table.children[0];
		var firstRow = tableBody.children[0];
		
		//hide the arrows from the last sort
		if (tableBody.sortedColumn > -1) {
			firstRow.children[tableBody.sortedColumn].children[0].children[0].className = "";	//Remove the glyphicon
		}
		
		//Decide if we're sorting ASC or DESC
		if (tableBody.sortedColumn == column) {
			tableBody.sortedAsc = !tableBody.sortedAsc;
		} else {
			tableBody.sortedColumn = column;
			tableBody.sortedAsc = true;
		}
		
		//Add the up/down arrows to signify sort type
		if (tableBody.sortedAsc) {
			firstRow.children[tableBody.sortedColumn].children[0].children[0].className = "glyphicon glyphicon-chevron-up sortyArrow"
		} else {
			firstRow.children[tableBody.sortedColumn].children[0].children[0].className = "glyphicon glyphicon-chevron-down sortyArrow"
		}
		
		while (true) {
			var sorted = true;	//true until otherwise false
			
			//Look at rows i and i-1 (start at i=2 so we look at the first 2 data rows and ignore headers)
			for (var i = 2; i < tableBody.children.length; i++) {
				var prevValue = getValue(table,i-1,column).toLowerCase();
				var value = getValue(table,i,column).toLowerCase();
				
				//Locale compare is a modern way to have your browser compare alpha-numeric strings
				var comp = compareTo(value,prevValue);
				if ((tableBody.sortedAsc && comp < 0) || (!tableBody.sortedAsc && comp > 0)) {
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
	
	//NEEDED: Date sorting
	function compareTo(a,b) {
		return a.localeCompare(b, undefined, {numeric: true, sensitivity: 'base'});
	}

</script>

<style>
.sortyHeader:hover {
	cursor: pointer;
}

.sortyArrow {
	float: right;
}
</style>