<?php
	
	include_once "util.php";
	
		
	/************************************************************************
	* For security purposes, each query must be manually made here.
	* We can't just allow arbitrary searching of our database, sorry hackers
	*************************************************************************/
	$autocompleteQueries = array();
	$autocompleteQueries['users'] = "SELECT user FROM users WHERE user LIKE \"{0}%\" LIMIT 5";
	//$autocompleteQueries['example1'] = "SELECT user FROM users WHERE user LIKE \"{0}%\" LIMIT 5";
	//$autocompleteQueries['example2'] = "SELECT user FROM users WHERE user LIKE \"{0}%\" LIMIT 5";
	
	
	$q = get("q");
	$text = get("text");
	if ($q) {
		echo "<style>
		.autocompleteOption {
			margin: 0px;
		}
		</style>";
		
		$query = str_replace("{0}",$text,$autocompleteQueries[$q]);
		if (!$query) { echo "ERROR: $q is not valid"; exit(); }
		$resultSet = $conn->query($query);
		$id = 0;
		while ($row = $resultSet->fetch_array()) {
			echo "<div id='autoCompleteResults$id' class='autocompleteOption' onMouseOver='autoCompleteMouseOver($id)' onMouseDown='useSelected()'>$row[0]</div>";
			$id++;
		}
		exit();
	}

	//Generate a textbox with autocomplete functionality
	//$params = The properties of the textbox, such as name, class, etc
	//$queryIndex = The index of the array at the top of this file (search for $autocompleteQueries)
	function autoCompleteTextbox($queryIndex,$params) {
		return "<input type='text' $params onBlur='autoCompleteBlur()' onKeyDown='autoCompleteNavigate(event,this)' onKeyUp='autoComplete(this,\"$queryIndex\")' onMouseDown='enableAutoComplete(this,\"$queryIndex\")'>";
	}
	
	echo "<script>
			var selectedIndex = -1;
			var dontQuery = false;
			var currentTextbox;
	
			function autoComplete(textbox,q) {
				currentTextbox = textbox;	//Allow global use of this textbox
				if (!dontQuery) {
					var text = escape($(textbox).val());
					$('#autoCompleteResults').load('autocomplete.php?q=' + q + '&text=' + text, function() {
						var pos = $(textbox).offset();
						pos.top += $(textbox).outerHeight();
						var width = $(textbox).width();
						$('#autoCompleteResults').css({left:pos.left,top:pos.top,width:width});
						highlightEntry();
						$('#autoCompleteResults').show(100);
					});
				}
			}
			
			function autoCompleteNavigate(event,textbox) {
				var k = event.keyCode;
				dontQuery = false;	//Allow the query unless we decide it's not needed
				
				//Intercept up/down arrow keys, enter, and tab
				if (k == 13 || k == 38 || k == 40 || k == 9) {
					dontQuery = true;	//Special keys don't warrany another load
					event.preventDefault();
					if (k == 38) {
						selectedIndex--;
						if (selectedIndex < 0) { selectedIndex = 0; }
					}
					if (k == 40) {
						selectedIndex++;
						if (document.getElementById('autoCompleteResults' + selectedIndex) == null) {
							selectedIndex--;
						}
					}
					if (k == 13 || k == 9) {
						useSelected();
					}
										
					highlightEntry();
				} else {
					selectedIndex = -1;
				}
				
			}
			
			function useSelected() {
				if (selectedIndex == -1) { selectedIndex = 0;}
				$(currentTextbox).val($('#autoCompleteResults' + selectedIndex).text());
				$('#autoCompleteResults').hide(100);
				$(currentTextbox).blur();
			}
			
			function autoCompleteMouseOver(id) {
				selectedIndex = id;
				highlightEntry();
			}
			
			function autoCompleteBlur() {
				$('#autoCompleteResults').hide(100);
			}
			
			function enableAutoComplete(textbox,q) {
				//When the user clicks on an already active autocomplete box, show results
				if (document.activeElement === textbox) {
					autoComplete(textbox,q);
				}
			}
			
			function highlightEntry() {
				var i = 0;
				while (true) {
					var bgColor = '#fff';
					var textColor = '#000';
					if (i == selectedIndex) {
						bgColor = '#00f';
						textColor = '#fff';
					}
					
					if (document.getElementById('autoCompleteResults' + i)) {
						document.getElementById('autoCompleteResults' + i).style.backgroundColor 	= bgColor;
						document.getElementById('autoCompleteResults' + i).style.color 				= textColor;
					} else {
						break;
					}
					i++;
				}
			}
		</script>
		<div id='autoCompleteResults' style='position: absolute; border: 1px solid black;display:none'>Loading</div>";
?>