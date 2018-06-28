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
		//while (true) {
			var sorted = true;	//true until otherwise false
			for (var i = 1; i < tableBody.children.length; i++) {
				all += getValue(table,i,column) + "\n";
			}
		//}
		alert(all);
	}
	
	function getValue(table,rowIndex,columnIndex) {
		var tableBody = table.children[0];
		var row = tableBody.children[rowIndex];
		return row.children[columnIndex].innerText;
	}
</script>

<style>
.myClass:hover {
	cursor: pointer;
}
</style>