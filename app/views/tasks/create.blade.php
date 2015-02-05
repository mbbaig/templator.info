@extends('layouts.main')
@section('content')
{{ HTML::script('js/jquery.handsontable.full.js') }}
{{ HTML::style('css/jquery.handsontable.full.css') }}
{{ HTML::style('css/samples.css') }}
{{ HTML::script('js/jquery.handsontable.removeRow.js') }}
{{ HTML::style('css/jquery.handsontable.removeRow.css') }}
<h2>Add Tasks to {{ $template->title }}</h2>
<div class="handsontable" id="example"></div>
<a id="de-indent" class="btn btn-default">&lt;--</a>
<a id="indent" class="btn btn-default">--&gt;</a>
<a id="save" class="btn btn-default">Save Tasks</a>
<div id="values"></div>
<script type="text/javascript">
	$(document).ready(function () {
		//This holds the true and false values for predecessors
		var predecessorsCorrect = [];
		var container = $('#example');
		//Row start and end respectively
		var row1;
		var row2;
		//Previous duration of the summary task
		var previousDuration;
		var isChecked;
		var dur = "Duration <br><input type='checkbox' class='checker' ";
		dur += isChecked ? 'checked="checked"' : '';
		dur += "> hours";
		var savedData;

		var data = [];

		function updateDuration() {
			var table = container.handsontable('getInstance');
			var data = table.getData();
			var taskData = table.getDataAtCol(0);
			var predData = table.getDataAtCol(2);
			var indentSearch = /indent/i, boldSearch = /\bb/i;
			var summaryDuration = 0, highestValue = 0, preds = [];

			$('#values').html('');
			$('#values').removeClass("text-danger");

			if (table.isEmptyCol(2)) {
				for (var i = taskData.length - 2; i > 0; i--) {
					if(taskData[i].search(boldSearch) == -1 && summaryDuration < data[i][1]) {
						summaryDuration = data[i][1];
					} else if (taskData[i].search(boldSearch) != -1 && taskData[i].search(indentSearch) == -1 && i != 0) {
						data[i][1] = summaryDuration;
						summaryDuration = table.getDataAtCell(i - 1, 1);
					} else if(taskData[i].search(boldSearch) != -1) {
						data[i][1] = summaryDuration;
					}
				}
				if (taskData[0].search(boldSearch) != -1) {
					data[0][1] = summaryDuration;
				}
			} else if (checkPredecessors()) {
				summaryDuration = table.getDataAtCell(taskData.length - 2, 1);
				for (var i = taskData.length - 2; i > 0; i--) {
					if (predData[i] != null && predData[i] != '') {
						preds[i] = predData[i].split(",");
						$.each(preds[i], function (key, value) {
							if(taskData[i].search(boldSearch) == -1) {
								summaryDuration += data[parseInt(value)-1][1];
							}
						});
					} else if (taskData[i].search(boldSearch) != -1 && taskData[i].search(indentSearch) == -1 && i != 0) {
						data[i][1] = summaryDuration;
						summaryDuration = table.getDataAtCell(i - 1, 1);
					} else if(taskData[i].search(boldSearch) != -1) {
						data[i][1] = summaryDuration;
					}
				}
				if (taskData[0].search(boldSearch) != -1) {
					data[0][1] = summaryDuration;
				}
			} else {
				$('#values').html('PREDECESSORS data not valid');
				$('#values').addClass("text-danger");
				return;
			}
			table.loadData(data);
		}

		function updateTaskNames(changes) {
			if (changes[0][2] !== undefined && changes[0][2] !== null && changes[0][2] != '') {
				var table = container.handsontable('getInstance');
				var data = table.getData();
				var indent = changes[0][2].match(/\<indent\>/g);
				var bold = changes[0][2].match(/\<b\>/g);

				data[changes[0][0]][0] = changes[0][3];

				if (bold !== null) {
					//bold summary task
					data[changes[0][0]][0] = '<b>' + data[changes[0][0]][0] + '</b>';
				}
				if (indent !== null) {
					var indentCount = indent.length;
					for(var h = 0; h < indentCount; h++){
						data[changes[0][0]][0] = '<indent>' + data[changes[0][0]][0] + '</indent>';
					}
				}

				table.loadData(data);
			}
		}

		function strip_tags(input, allowed) {
			// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
			allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
			var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi, commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
			return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
				return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
			});
		}

		var tasksRenderer = function (instance, td, row, col, prop, value, cellProperties) {
			var escaped = Handsontable.helper.stringify(value);
			escaped = strip_tags(escaped, '<b><indent>'); //be sure you only allow certain HTML tags to avoid XSS threats (you should also remove unwanted HTML attributes)
			td.innerHTML = escaped;
			$(td).has("indent").css("text-indent", $(td).find("indent").length + "em");
			return td;
		};

		//Check the predecessors have the correct dependencies
		function checkPredecessors(){
			var table = container.handsontable('getInstance'); 
			var predecessors = table.getDataAtCol(2);
			var ids = table.getRowHeader();
			var taskData = table.getDataAtCol(0);
			var preds = [], formatedPreds = [], i = 0, j = 0, realPreds = [], boldSearch = /\bb/i;
			//Array of predecessors
			jQuery.each(predecessors, function(key, value) {
				if (value != "" && value != null) {
					preds[key] = value.split(",");
					$.each(preds[key], function(key, value) {
						//console.log(parseInt(value));
						formatedPreds[i] = parseInt(value);
						i++;
					});
				} else {
					preds[key] = value;
				}
			});
			var validPreds = true;
			$.each(formatedPreds, function(key, value) {
				if($.inArray(value, ids) != -1) {
					validPreds = true;
				} else {
					validPreds = false;
				}
			});
			if (validPreds) {
				//Check if the first predecessor is empty or negative
				if(preds[0] === '' || preds[0] == null) {
					validPreds = true;
				} else {
					validPreds = false;
				}
				for(var i = 1; i < ids.length-1; i++) {
					if (preds[i] != null && preds[i] != '') {
						$.each(preds[i], function (key, value) {
							if ((parseInt(value) < ids[i]) && taskData[parseInt(value - 1)].search(boldSearch) == -1) {
								realPreds[j] = true;
							} else {
								realPreds[j] = false;
							}
							j++;
						});
					} else {
						validPreds = false;
					}
				}
				for (var i = 0; i < realPreds.length; i++) {
					if (!realPreds[i]) {
						return false;
					}
				};
				return true;
			} else {
				return validPreds;
			}
		}

		container.on('mouseup', 'input.checker', function (event) {
			isChecked = !$(this).is(':checked');
		});

		container.handsontable({
			data: data,
			minSpareRows: 1,
			manualColumnResize: true,
			persistentState: true,
			contextMenu: false,
			rowHeaders: true,
			removeRowPlugin: true,
			columns: [
				{type: 'text', renderer: tasksRenderer},
				{type: 'numeric'},
				{type: 'text'},
				{type: 'text'},
				{type: 'numeric',readOnly: true}
			],
			colWidths: [150, 80, 130, 200, 150],
			autoWrapRow: true,
			colHeaders: [
				'Task Name',
				dur,
				'Predecessors',
				'Note',
				'Summary Task ID'
			],
			//Callback event after anything is changed in the cells.
			//Only impleted "edit" event for now
			afterChange: function(changes, source) {
				if(source == "edit") {
					updateDuration();
					//console.log(changes);
					if (changes[0][1] == 0) {
						updateTaskNames(changes);
					}
				}
			},
			afterRemoveRow: function(index, amount) {
				updateDuration();
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
			var table = container.handsontable('getInstance');
			var taskData = table.getDataAtCol(0);
			var durationData = table.getDataAtCol(1);
			var predecessorsData = table.getDataAtCol(2);
			var validData = true;

			if(validData){
				//Return false if nothing entered
				//No more checks needed
				for (var i = 0; i < taskData.length - 1; i++) {
					if(taskData[i] === '' || taskData[i] == null) {
						//alert('TASK NAME data not valid');
						$('#values').html('TASK NAME data not valid');
						$('#values').addClass("text-danger");
						validData = false;
						break;
					}
				}
				
			}
			
			if(validData){
				//Return false if nothing entered and value is negative
				//No more checks needed
				for (var i = 0; i < durationData.length - 1; i++) {
					if(durationData[i] === '' || durationData[i] < 0 || durationData[i] == null) {
						//alert('DURATION data not valid');
						$('#values').html('DURATION data not valid');
						$('#values').addClass("text-danger");
						validData = false;
						break;
					}
				}
			}

			//Only save if data is valid
			if (validData){
				var data = table.getData();
				var unformatedData = [];
				$.each(data, function(key, value){
					var str = Handsontable.helper.stringify(value[0]);
					str = str.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi, '');
					unformatedData[key] = [
						str,
						value[1],
						(value[2] == undefined || value[2] == null) ? null : value[2],
						(value[3] == undefined || value[3] == null) ? null : value[3],
						(value[4] == undefined || value[4] == null) ? null : value[4]
					];
				});
				$.ajax({
					url: "/tasks/create/{{ $template->id }}",
					data: {"_token": "{{ csrf_token(); }}", "data": unformatedData, "durationType": isChecked}, //returns all cells' data
					dataType: 'json',
					type: 'POST',
					success: function (res) {
						$('#values').html('Tasks saved successfully');
						$('#values').addClass("text-success");
						window.location.href = "{{ URL::to('/templates/show/' . $template->id) }}";
					},
					error: function () {
						$('#values').html('There was an error while saving');
						$('#values').addClass("text-danger");
					},
					beforeSend: function () {
						$('#values').html('Saving...');
					}
				});
			}
		});
		
		//Indent function
		$( "#indent" ).click( function(){
			//Nothing selected
			if(row1 == null || row2 == null){
				//alert("Sorry, no operation can be performed." +
					//"\nTry selecting a task first.");
				$('#values').html("Sorry, no operation can be performed. Try selecting a task first.");
				$('#values').addClass("text-danger");
			}
			//First selected only
			else if(row1 == 0 && row2 == 1){
				//alert("Sorry, the first task cannot be a sub-task." +
					  //"\nTry excluding the first task from the selection.");
				$('#values').html("Sorry, the first task cannot be a sub-task.  Try excluding the first task from the selection.");
				$('#values').addClass("text-danger");
			}
			else{
				var summaryTask, currentIndent, indentValue, newIndent, summaryDuration;
				var table = container.handsontable('getInstance');
				var data = table.getData();
				var selectedTasks= new Array();

				for(var i= row1; i <= row2; i++){
					selectedTasks[i]= table.getCell(i, 0);
				}

				//Selected many
				if(row2-row1 >= 1){
					//Update the duration for the summary task
					previousDuration = table.getDataAtCell(row1, 1);
					for(var m= row1 + 1; m <= row2; m++){
						//set summary task ids
						data[m][4] = table.getRowHeader(row1);
						//If first and another is selected end is offset by 1
						if(row1 == 0 && (row2 - m) == 1){
							m= row2; //Reapeat the loop one less times     
						}
					}
					//bold summary task
					var boldData = table.getDataAtCell(row1, 0);
					data[row1][0] = '<b>' + boldData + '</b>';
					
					for(var h= row1 + 1; h <= row2; h++){
						var indentData = table.getDataAtCell(h, 0);
						data[h][0] = '<indent>' + indentData + '</indent>';
						
						//If first and another is selected end is offset by 1
						if(row1 == 0 && (row2 - h) == 1){
							h= row2; //Reapeat the loop one less times     
						}
					}
				}
				//If only 1 item is selected
				else if((row2 - row1) == 0){
					//Update the duration for the summary task
					previousDuration= table.getDataAtCell((row1 - 1), 1);
					data[row1 - 1][1] = table.getDataAtCell((row1), 1);
					data[row1][4] = table.getRowHeader((row1-1));
				
					//Get the Table Data value before the selected task
					var boldData = table.getDataAtCell(row1 - 1, 0);
					data[row1 - 1][0] = '<b>' + boldData + '</b>';
					
					//currentIndent= summaryTask.style.textIndent;
					var indentData = table.getDataAtCell(row1, 0);
					data[row1][0] = '<indent>' + indentData + '</indent>';
				}
			}

			table.loadData(data);
			updateDuration();
			//Reset row vars incase of no selection for next time
			row1= null;
			row2= null;
		});
		//De-indent function
		$( "#de-indent" ).click( function(){
			//Nothing selected
			if(row1 ==null || row2 == null){
				//alert("Sorry, no operation can be performed." +
					//"\nTry selecting a task first.");
				$('#values').html("Sorry, no operation can be performed. Try selecting a task first.");
				$('#values').addClass("text-danger");
			}
			//First selected only
			else if(row1 == 0 && row2 == 1){
				//alert("Sorry, the first task cannot be a sub-task." +
					//"\nTry excluding the first task from the selection.");
				$('#values').html("Sorry, the first task cannot be a sub-task.  Try excluding the first task from the selection.");
				$('#values').addClass("text-danger");
			}
			else{
				var summaryTask, currentIndent, indentValue, newIndent;
				var table = container.handsontable('getInstance');
				var data = table.getData();
				var selectedTasks= new Array();
				for(var i= row1; i <= row2; i++){
					selectedTasks[i]= table.getCell(i, 0);
				}

				//Selected many
				if(row2-row1 >= 1){
					//Update the duration for the summary task to previous
					var boldData = selectedTasks[row1].innerHTML;
					boldData = boldData.replace('<b>', '');
					boldData = boldData.replace('</b>', '');
					//table.setDataAtCell(row1, 0, boldData);
					data[row1][0] = boldData;
					
					for(var h= row1 + 1; h <= row2; h++){
						//change predecessors back to null
						//table.setDataAtCell(h, 4, table.getDataAtCell(row1, 4));
						data[h][4] = table.getDataAtCell(row1, 4);

						var indentData = selectedTasks[h].innerHTML;
						indentData = indentData.replace('<indent>', '');
						indentData = indentData.replace('</indent>', '');
						//table.setDataAtCell(h, 0, indentData);
						data[h][0] = indentData;
						
						//If first and another is selected end is offset by 1
						if(row1 == 0 && (row2 - h) == 1){
							h= row2; //Reapeat the loop one less times
						}
					}
				}
				//If only 1 item is selected
				else if((row2 - row1) == 0){
					//Update the duration for the summary task to previous
					//table.setDataAtCell(row1 - 1, 1, previousDuration);
					data[row1 - 1][1] = previousDuration;

					//Get the Table Data value before the selected task
					var boldData = table.getCell(row1 - 1, 0).innerHTML;
					boldData = boldData.replace('<b>', '');
					boldData = boldData.replace('</b>', '');
					//table.setDataAtCell(row1 - 1, 0, boldData);
					data[row1 - 1][0] = boldData;

					//table.setDataAtCell(row1, 4, table.getDataAtCell(row1 - 1, 4));
					data[row1][4] = table.getDataAtCell(row1 - 1, 4);

					var indentData = table.getCell(row1, 0).innerHTML;
					indentData = indentData.replace('<indent>', '');
					indentData = indentData.replace('</indent>', '');
					//table.setDataAtCell(row1, 0, indentData);
					data[row1][0] = indentData
				}
			}
			table.loadData(data);
			updateDuration();
			//Reset row vars incase of no selection for next time
			row1= null;
			row2= null;
		});
	});
</script>
@stop