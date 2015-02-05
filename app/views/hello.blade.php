<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Templator</title>
	{{ HTML::script('js/jquery-1.11.0.min.js') }}
	{{ HTML::script('js/jquery.handsontable.full.js') }}
	{{ HTML::style('css/jquery.handsontable.full.css') }}
	{{ HTML::style('css/samples.css') }}
</head>
<body>
	<h2>Basic usage</h2>
	<div class="handsontable" id="example"></div>
	<fieldset style="margin: 10px;">
		<legend>Actions</legend>
		<button id="de-indent">&lt;--</button>
		<button id="indent">--></button>
		<button id="save">Save</button>
	</fieldset>
	<div class="handsontable" id="values"></div>
	<script type="text/javascript">
		//This holds the true and false values for predecessors
		var predecessorsCorrect = [];

		//Check the predecessors have the correct dependencies
		function checkPredecessors(){
			var table = $('#example').handsontable('getInstance'); 
			var predecessors = table.getDataAtCol(3);
			var ids = table.getDataAtCol(0);
			//Array of predecessors
			var preds = jQuery.each(predecessors, function(i, val) {
				return val;
			});
			//Array of ids
			var id = jQuery.each(ids, function(i, val) {
				return val;
			});
			for(var i = 0; i < id.length; i++) {
				//Check if the first predecessor is empty or negative
				if(preds[i] === '' || preds[i] <= 0) {
					predecessorsCorrect[i] = false;
				}else {
					predecessorsCorrect[i] = (preds[i] < id[i]);
				}
			}
		}
		$(document).ready(function () {
			//Row start and end respectively
			var row1;
			var row2;
			//Previous duration of the summary task
			var previousDuration;
			
			var isChecked;
			var savedData;
			var data = [
				[1, "Code model", 2, , ""],
				[2, "Code view", 2, 1, "Make sure design is consistent"],
				[3, "Code controller", 2, 2, ""],
				[4, "Create database", 2, 3, "make sure to check dependencies"]
			];
			var columns = [
				{type: 'numeric', readOnly: true},
				{type: 'text'},
				{type: 'numeric'},
				{type: 'numeric'},
				{type: 'text'}
			];
			$('#example').handsontable({
				data: data,
				contextMenu: true,
				columns: columns,
				autoWrapRow: true,
				colHeaders: function(col) {
					switch(col) {
						case 0:
							return "TASK ID";
						case 1:
							return "TASK NAME";
						case 2:
							return "DURATION";
						case 3:
							return "PREDECESSORS";
						case 4:
							return "NOTE";
					}
				},
				//Callback event after anything is changed in the cells.
				//Only impleted "edit" event for now
				afterChange: function(changes, source) {
					if(source === 'edit'){
						checkPredecessors();
					}
				},
				afterSelectionEnd: function(x1, y1, x2, y2){
					
					//add this because of bug
					if( (x1 <= x2 && y1 < y2) || (x1 < x2 && y1 <= y2) || (x1 == x2 && y1 == y2)) {
						row1 = x1;
						if(x1 == 0)
							row2 = parseInt(x2 + 1);
						  else
							row2 = x2;
					}
					else if( (x1 >= x2 && y1 > y2) || (x1 > x2 && y1 >= y2)) {
						row1 = x2;
						if(x2 == 0)
							row2 = parseInt(x1 + 1);
						  else
							row2 = x1;
					}
					else if(x1 < x2 && y1 > y2) {
						row1 = x1;
						row2 = x2;
					}
					else if(x1 > x2 && y1 < y2) {
						row1 = x2;
						row2 = x1;
					}
				}
			});
			$('#save').click(function() {
				console.log("click ran");
				var table = $('#example').handsontable('getInstance');
				var taskData = table.getDataAtCol(1);
				var durationData = table.getDataAtCol(2);
				var predecessorsData = table.getDataAtCol(3);
				var validData = true;

				console.log("valid data",validData,taskData);

				if(validData){
					console.log("data was valid");
					$.each(taskData, function(key, value) {
						//Return false if nothing entered
						//No more checks needed
						if(value === '') {
							alert('TASK NAME data not valid');
							validData = false;
							return;
						}
					});
				}
				
				if(validData){
					$.each(durationData, function(key, value) {
						//Return false if nothing entered and value is negative
						//No more checks needed
						if(value === '' || value < 0) {
							alert('DURATION data not valid');
							validData = false;
							return;
						}
					});
				}

				if(validData) {
					//Check the first row for special case of no predecessors required
					if((predecessorsData[0] == null || predecessorsData[0] === '') && predecessorsCorrect[0] == false) {
						validData = true;
					} else{
						validData = false;
					}
					for(var i = 1; i < predecessorsCorrect.length; i++) {
						//Return false if any values in the predecessors array is false
						//No more checks needed
						if(!predecessorsCorrect[i]) {
							validData = false;
							break;
						} 
					}
					if(!validData) {
						alert('PREDECESSORS data not valid');
					}
				}
				//Only save if data is valid
				if (validData){

					console.log("data cmpletely valid and is being sent")
					/*window.localStorage.setItem('data', JSON.stringify(table.getData()));
					savedData = JSON.parse(window.localStorage.getItem('data'));
					$('#values').handsontable({
						data: savedData,
						readOnly: true
					});*/
					$.ajax({
						url: "hello",//"/tasks/create",
						data: {"data": table.getData()}, //returns all cells' data
						dataType: 'json',
						type: 'POST',
						success: function (res) { 
							console.log("data was sent and server recieved data");
							console.log(res); alert(res); 
						},
						error: function () {
							console.log("this is an error the message is the following");
							console.log(arguments);
						}
					});
				}
			});
			
			//Indent function
			$( "#indent" ).click( function(){
				
				var summaryTask, currentIndent, indentValue, newIndent, summaryDuration;
				
				var table = $('#example').handsontable('getInstance');
				//Nothing selected
				if(row1 ==null || row2 == null){
					alert("Sorry, no operation can be performed." +
						  "\nTry selecting a task first.");
				}
				//First selected only
				else if(row1 == 0 && row2 == 1){
					alert("Sorry, the first task cannot be a sub-task." +
						  "\nTry excluding the first task from the selection.");
				}
				else{
					var selectedTasks= new Array();
					for(var i= row1; i <= row2; i++){
						selectedTasks[i]= table.getCell(i, 1);
					}

					//Selected many
					if(row2-row1 >= 1){
						//Update the duration for the summary task
						previousDuration= table.getDataAtCell(row1, 2);
						summaryDuration= 0;
						for(var m= row1 + 1; m <= row2; m++){
							summaryDuration= summaryDuration + table.getDataAtCell(m, 2);

							//If first and another is selected end is offset by 1
							if(row1 == 0 && (row2 - m) == 1){
								m= row2; //Reapeat the loop one less times     
							}
						}
						//Update the value
						table.getCell((row1), 2).innerHTML= summaryDuration;
					
						selectedTasks[row1].style.fontWeight="bold";
						
						for(var h= row1 + 1; h <= row2; h++){
							currentIndent= selectedTasks[h].style.textIndent;
							indentValue= currentIndent.substring(0, currentIndent.length-2);
							
							//Not a number into a number or string to number
							indentValue= parseInt( indentValue.replace(/\D/g,""), 10 );
							if(isNaN(indentValue)){
							   indentValue= 10; 
							}else{
							   indentValue= indentValue + 10;
							}
							
							newIndent= indentValue + "px";
							selectedTasks[h].style.textIndent= newIndent;
							
							//If first and another is selected end is offset by 1
							if(row1 == 0 && (row2 - h) == 1){
								h= row2; //Reapeat the loop one less times     
							}
						}
					}
					//If only 1 item is selected
					else if((row2 - row1) == 0){
						//Update the duration for the summary task
						previousDuration= table.getDataAtCell((row1 - 1), 2);
						table.getCell((row1 - 1), 2).innerHTML= table.getDataAtCell((row1), 2);						
					
						//Get the Table Data value before the selected task
						summaryTask= table.getCell((row1 - 1), 1);
						summaryTask.style.fontWeight="bold";
						
						currentIndent= summaryTask.style.textIndent;
						indentValue= currentIndent.substring(0, currentIndent.length-2);
						
						//Change not a number into a number or string to number
						indentValue= parseInt( indentValue.replace(/\D/g,""), 10 );
						if(isNaN(indentValue)){
						   indentValue= 10; 
						}else{
							indentValue= indentValue + 10;
						}
						
						newIndent= indentValue + "px";
						selectedTasks[row1].style.textIndent= newIndent;
					}
				}
				//Reset row vars incase of no selection for next time
				row1= null;
				row2= null;
			});
			
			//De-indent function
			$( "#de-indent" ).click( function(){        
				var summaryTask, currentIndent, indentValue, newIndent;
				
				var table = $('#example').handsontable('getInstance');
				//Nothing selected
				if(row1 ==null || row2 == null){
					alert("Sorry, no operation can be performed." +
						  "\nTry selecting a task first.");
				}
				//First selected only
				else if(row1 == 0 && row2 == 1){
					alert("Sorry, the first task cannot be a sub-task." +
						  "\nTry excluding the first task from the selection.");
				}
				else{
					var selectedTasks= new Array();
					for(var i= row1; i <= row2; i++){
						selectedTasks[i]= table.getCell(i, 1);
					}

					//Selected many
					if(row2-row1 >= 1){
						//Update the duration for the summary task to previous
						table.getCell((row1), 2).innerHTML= previousDuration;
					
					
						selectedTasks[row1].style.fontWeight="normal";
						
						for(var h= row1 + 1; h <= row2; h++){
							currentIndent= selectedTasks[h].style.textIndent;
							indentValue= currentIndent.substring(0, currentIndent.length-2);
							
							//Not a number into a number or string to number
							indentValue= parseInt( indentValue.replace(/\D/g,""), 10 );
							if(isNaN(indentValue)){
							   indentValue= 0; 
							}else{
								if(indentValue != 0){  //Don't go past zero
									indentValue= indentValue - 10;
								}
							}
							
							newIndent= indentValue + "px";
							selectedTasks[h].style.textIndent= newIndent;
							
							//If first and another is selected end is offset by 1
							if(row1 == 0 && (row2 - h) == 1){
								h= row2; //Reapeat the loop one less times
							}
						}        
					}
					//If only 1 item is selected
					else if((row2 - row1) == 0){
						//Update the duration for the summary task to previous
						table.getCell((row1 - 1), 2).innerHTML= previousDuration;
					
						//Get the Table Data value before the selected task
						summaryTask= table.getCell((row1 - 1), 1);
						summaryTask.style.fontWeight="normal";
						
						currentIndent= table.getCell(row1, 1).style.textIndent;
						indentValue= currentIndent.substring(0, currentIndent.length-2);
						
						//Change not a number into a number or string to number
						indentValue= parseInt( indentValue.replace(/\D/g,""), 10 );
						
						if(isNaN(indentValue)){
						   indentValue= 0; 
						}else{
							if(indentValue != 0){  //Don't go past zero
								indentValue= indentValue - 10;
							}
						}
						newIndent= indentValue + "px";
						selectedTasks[row1].style.textIndent= newIndent;
					}
				}
				//Reset row vars incase of no selection for next time
				row1= null;
				row2= null;
			});
		});
		$(window).load(function() {
			  //alert("window load occurred!");
			  checkPredecessors();
		});
	</script>
</body>
</html>