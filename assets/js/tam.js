/**
 * TAM with jQuery
 *
 * @author David King, Jr. (http://www.davidkingjr.com)
 * @version 0.1
 * @updated 14-Jul-2011
 * 
 * Copyright 2011, David King
 * Released under the MIT, BSD, and GPL Licenses.
 */
var LI_LABEL_OPEN 	= "<li><label>", 
	LI_LABEL_CLOSE 	= "</label></li>";

var TAM = {
	version: "1.0",
	author: "David King, Jr.",
	
	/************************************
	 * Begin the main members
	 ************************************/

	/**
	 * goBack returns the user to the previous page
	 */	
	goBack: function() {
		location.href = document.referrer;
		return false;
	},
	
	/**
	 * centers a div in the middle of the browser window
	 */
	centerDiv: function(div) {
		$(div).css({
			position: 'absolute',
			left: ($(window).width() - $(div).outerWidth())/2,
			top: ($(window).height() - $(div).outerHeight())/2
		});		
	},
	
	/**
	 * saveData saves a specific set of data
	 */
	saveData: function(api, form, element) {
		// Save the form data to the database via the REST API
		$.ajax({
			type: 'POST',
			url: api,
			data: form.serialize(),
			dataType: 'json',
			success: function(data) {
				if (! data) {
					TAM.showMessage(element, "No data was returned from the server, but the data may have been saved.");
				} else {
					if (data.status == 'Success') {
						TAM.showMessage(element, "Saved.")				
					} else {
						TAM.showError(element, "Failed to save data!")									
					} // endif
				} // endif
				return true;
			}, // end success
			error: function(jqXHR, textStatus, errorThrown) {
				TAM.showAjaxMessage(element, jqXHR, textStatus, errorThrown);
				return false;
			} // end error
		}); // end $.ajax
	}, // end saveData
	
	/**
	 *  deleteData deletes some data from the backend
	 */
	deleteData: function(type, api, id, reloadApi, element) {
		// Make sure the user actually selected something
		if (id) {
			// Make sure the user wan't to delete the entry
			if (confirm("Are you sure you want to delete the selected " + type + "?")) {
				// Perform the ajax call using jQuery
				$.ajax({
					type: 'DELETE',
					url: CI.site_url + api,
					data: { id: id },
					dataType: 'json',
					success: function(data) {
						if (! data) {
							var text = "No data was returned from the server, but the data may have been deleted successfully.";
							TAM.showMessage(element, text);
						} else {
							if (data.status == 'Success') {
								TAM.showMessage($('#message'), type + " deleted.");
							} else {
								TAM.showError(element, "Failed to save data!")									
							} // endif
						}
						
						// Go ahead and reload the flexigrid
						$('#dataTable').flexReload({url: CI.site_url + reloadApi}); 
					},
					error: function(jqXHR, textStatus, errorThrown) {
						TAM.showAjaxMessage(element, jqXHR, textStatus, errorThrown);
					} // end error
				}); // end $.ajax
			} // end if
		} else {
			alert("Please select an item from the list to delete.");
		} // end if
	}, // end deleteData

	/**
	 * select data out of a flexigrid and open the correct screen
	 */
	editData: function(api) {
		var selected = this.getSelectedRows();
		if (selected) {
			var url = CI.site_url + api + selected[0][0];
			location.href = url;
		} else {
			alert("Please select an entry below.");
		}		
	},
			
	/**
	 * showMessage displays a "pretty" message on a screen
	 */
	showMessage: function(container, text) {
		var html = LI_LABEL_OPEN + text + LI_LABEL_CLOSE;
		
		// This is a message, not an error or debug
		container.toggleClass('message');
		container.append(html).fadeIn(0).pulse({
		    opacity: [.25, 1]
		}, {
		    duration: 750,
		    times: 3, 		
		    easing: 'linear',
		    complete: function() {
		        $(this).fadeOut(250, function(){
		        	$(this).html('');
		        	container.toggleClass('message');
		        });
		    }
		});		
	},
	
	/**
	 * showError is a simple error handler that can be called to provide
	 * more user-friendly error messages
	 */
	showError: function(container, text) {
		var html = LI_LABEL_OPEN + text + LI_LABEL_CLOSE;
		
		// This is a message, not an error or debug
		container.toggleClass('error');
		container.append(html).fadeIn(0).pulse({
		    opacity: [0, 1]
		}, {
		    duration: 1000, 		// duration of EACH individual animation
		    times: 3, 				// Will go three times through the pulse array [0,1]
		    easing: 'linear', 		// easing function for each individual animation
		    complete: function() {
		        $(this).fadeOut(3000, function(){
		        	$(this).html('');
		        	container.toggleClass('error');
		        });
		    }
		});		
	},

	/**
	 * showAjaxError will handle an AJAX call that "truly" fails.
	 */
	showAjaxError: function(container, xhr, status, error) {
		var html = LI_LABEL_OPEN + status.toUpperCase() + ' ' + xhr.status + ': ' + error + LI_LABEL_CLOSE;
		
		// We require the .error CSS definition
		container.toggleClass('error');
		
		// This is a jQuery call
		container.append(html).fadeIn(0).pulse({
		    opacity: [0, 1]
		}, {
		    duration: 1000, 		// duration of EACH individual animation
		    times: 3, 				// Will go three times through the pulse array [0,1]
		    easing: 'linear', 		// easing function for each individual animation
		    complete: function() {
		        $(this).fadeOut(3000, function(){
		        	$(this).html('');
		        });
		    }
		});
	},
	
	/**
	 * showPasswordSetDialog shows a dialog allowing a user to set or change their password
	 */
	showPasswordSetDialog: function(dialogElement, pwdField, pwdConfirmField, feedbackElement) {
		dialogElement.dialog({
			modal: true,
			title: "Change Password",
			width: 400,
			resizable: false,
			buttons: [
			    {
			        text: "Save",
			        click: function() { 
			        	var pwd = pwdField.val();
			        	var cfm = pwdConfirmField.val();
			        	
						// Do the passwords match?
						if (pwd == cfm) {
							// Get the data from the form
							dataString = $("#password-form").serialize();
							
							// Proceed with the save
							$.ajax({
								type: 'POST',
								url: CI.site_url + '/api/userpassword',
								data: dataString,
								dataType: 'json',
								success: function(data) {
									TAM.showMessage(feedbackElement, "Password saved.");
									dialogElement.dialog("close");
								}, // end success
								error: function(jqXHR, textStatus, errorThrown) {
									this.showAjaxMessage(feedbackElement, jqXHR, textStatus, errorThrown);
								} // end error
							}); // end $.ajax
						} else {
							// Passwords don't match
							TAM.showMessage(feedbackElement, "Passwords do not match!");
							pwdField.focus();
						} // endif   
			       } // end Save Button
			    },
			    {
			        text: "Cancel",
			        click: function() { 
						dialogElement.dialog("close");
					} // end click		    
			    } // end Cancel button
			], // end buttons
			close: function(event, ui) { 
				pwdField.text("");
				pwdConfirmField.text("");
			} // end close:
		}); // end dialog
	}, // end showPasswordSetDialog

	/**
	 * addComment shows the comment editing dialog
	 */
	addComment: function(container, feedbackContainer) {
		// Open the jQuery-UI dialog
		container.dialog({
			modal: true,
			title: "Comment",
			width: 600,
			resizable: false,
			buttons: [
			    {
			        text: "Save",
			        click: function() {
			        	// Get the data from the form
						dataString = $('#comment-form').serialize();
						
			        	// Post the comment
			        	$.ajax({
							type: 'POST',
							url: CI.site_url + '/api/comment',
							data: dataString,
							dataType: 'json',
							success: function(data) {
								TAM.showMessage(feedbackContainer, "Comment saved.");
								container.dialog("close");
							}, // end success
							error: function(jqXHR, textStatus, errorThrown) {
								TAM.showAjaxError(feedbackContainer, jqXHR, textStatus, errorThrown);
							} // end error			        		
			       		})
			       	} // end Save Button
			    },
			    {
			        text: "Cancel",
			        click: function() { 
						container.dialog("close");
					} // end click		    
			    } // end Cancel button
			] // end buttons
		}); // end dialog
	}, // end addComment
	
	/**
	 * This function will display a dialog box with comments for a specific
	 * object (e.g. asset, model, etc.)
	 */
	showComments: function(container) {
		var selected = TAM.getSelectedRows();
		if (selected) {
			// Open the jQuery-UI dialog
			container.dialog({
				modal: true,
				title: "Comments",
				width: 600,
				resizable: true,
				buttons: [
					{
				        text: "Close",
				        click: function() { 
							container.dialog("close");
						} // end click		    
				    } // end Cancel button
				],
			}); // end dialog
		} else {
			alert("Please select an entry below.");
		} // end if
	}, // end showComments
	
	/**
	 * This function will show the change history for a specific object
	 */
	showHistory: function(container) {
		var selected = TAM.getSelectedRows();
		if (selected) {
			// Open the jQuery-UI dialog
			container.dialog({
				modal: true,
				title: "History",
				width: 600,
				resizable: true,
				buttons: [
					{
				        text: "Close",
				        click: function() { 
							container.dialog("close");
						} // end click		    
				    } // end Cancel button
				],
			}); // end dialog
		} else {
			// Nothing selected
			alert("Please select an entry below.");
		} // end if
	}, // end showHistory

	/**
	 * The debug function will take a json return from the TAM system
	 * and determine if a logic error occurred.  This is not the same
	 * as an interpreter or AJAX error.  A logic error is one that TAM
	 * governs.  If an error didn't occur, then it will show a success
	 * message, otherwise detailed controller/model debug info is shown.
	 */
	debug: function(element, data) {
		var text = "DEBUG INFO";
		
		if (data.status == 'Failure') {
			text += LI_LABEL_OPEN + "Failed to perform " 	+ data.action.toLowerCase() 	+ " operation." + LI_LABEL_CLOSE;
			text += LI_LABEL_OPEN + 'id: ' 					+ data.id 										+ LI_LABEL_CLOSE;
			text += LI_LABEL_OPEN + 'table: ' 				+ data.table 									+ LI_LABEL_CLOSE;
			text += LI_LABEL_OPEN + 'rows_affected: ' 		+ data.rows_affected 							+ LI_LABEL_CLOSE;
			
			// Show the error
			TAM.showError(element, text);
		} else if (data.status == 'Success'){
			// Didn't error out, just show a success
			TAM.showMessage(element, "Successfully performed operation " + data.action);
		}
	},
	
	getSelectedRows: function() {
		var arrReturn   = []; 
		$('.trSelected').each(function() { 
			var arrRow = []; 
			$(this).find('div').each(function() { 
				arrRow.push( $(this).html() ); 
			}); 
			arrReturn.push(arrRow); 
		}); 
		return arrReturn;		
	},

	loadSelect: function(select, api, method, selectedIndex) {
		$.ajax({
			type: method,
			url: CI.site_url + '/api/' + api,
			dataType: 'json',
			success: function(j) {
				var options = '<option value="">Please select ...</option>';
				for (var i = 0; i < j.length; i++) {
					if (selectedIndex == j[i].optionValue) {
						options += '<option value="' + j[i].optionValue + '" selected=\"selected\">' + j[i].optionDisplay + '</option>';
					} else {
						options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
					}
				}
				
				// Apply the options to the slect
				select.html(options);
				
				// The jQuery Uniform library requires an update 
				// to be called to redraw the slected
				$.uniform.update(select);
			}
		});
	},

	/**
	 * dumpObject will output the contents of a javascript object
	 * in a "pretty" format
	 */
	dumpObject: function(object, name) {
	  	if (typeof object == "object") {
	     	var child = null;
	     	
	     	// Header
	     	var output = "<h3>" + name + "</h3>";
	     	
	     	// Begin the unordered list
	     	output += "<ul>";
	     	
	     	// Here we need to iterate the items inside the javascript object
	     	for (var item in object) {
	        	try {
	            	child = object[item];
	           	} catch (e) {
	            	child = "Unable to Evaluate";
	           	}
	
				// Begin the list item
				output += '<li>';
				
				// If we encounter another object inside the current object
				// we need to go down another level
	           	if (typeof child == "object") {
	           		// Go another level down
	           		output += dumpObj(child, item);
	           	} else {
	           		// Just output the item
	            	output += item + ": " + child + "\n";
	           	}
	           	
	           	// Close the list item
	           	output += '</li>';
	        }
	        
	        // Close the unordered list
	        output += '</ul>';
	        
	        // We are done
	        return output;
		} else {
			// Just return the object
	    	return obj;
	    }
	},
	
	/**
	 * dumpArray will output a javascript array into a "pretty" format
	 */
	dumpArray: function(arr, level) {
		var dumped_text = "";
		if(!level) level = 0;
		
		//The padding given at the beginning of the line.
		var level_padding = "";
		for(var j=0;j<level+1;j++) level_padding += "    ";
		
		if(typeof(arr) == 'object') { //Array/Hashes/Objects 
			for(var item in arr) {
				var value = arr[item];
				
				if(typeof(value) == 'object') { //If it is an array,
					dumped_text += level_padding + "'" + item + "' ...\n";
					dumped_text += dump(value,level+1);
				} else {
					dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
				}
			}
		} else { //Stings/Chars/Numbers etc.
			dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
		}
		return dumped_text;
	},

	/**
	 * This function creates a standard table with column/rows
	 * Parameter Information
	 * objArray = Anytype of object array, like JSON results
	 * theme (optional) = A css class to add to the table (e.g. <table class="<theme>">
	 * enableHeader (optional) = Controls if you want to hide/show, default is show
	 */	
	createTableView: function(objArray, theme, enableHeader) {
		// set optional theme parameter
		if (theme === undefined) {
			theme = 'mediumTable'; //default theme
		}
	
		if (enableHeader === undefined) {
			enableHeader = true; //default enable headers
		}
	
		// If the returned data is an object do nothing, else try to parse
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
	
		var str = '<table class="' + theme + '">';
	
		// table head
		if (enableHeader) {
			str += '<thead><tr>';
			for (var index in array[0]) {
				str += '<th scope="col">' + index + '</th>';
			}
			str += '</tr></thead>';
		}
	
		// table body
		str += '<tbody>';
		for (var i = 0; i < array.length; i++) {
			str += (i % 2 == 0) ? '<tr class="alt">' : '<tr>';
			for (var index in array[i]) {
				str += '<td>' + array[i][index] + '</td>';
			}
			str += '</tr>';
		}
		str += '</tbody>'
		str += '</table>';
		return str;
	},

	/**
	 * This function creates a details view table with column 1 as the header and column 2 as the details
	 * Parameter Information
	 * objArray = Anytype of object array, like JSON results
	 * theme (optional) = A css class to add to the table (e.g. <table class="<theme>">
	 * enableHeader (optional) = Controls if you want to hide/show, default is show
	 */
	createDetailView: function(objArray, theme, enableHeader) {	
		// set optional theme parameter
		if (theme === undefined) {
			theme = 'mediumTable';  //default theme
		}
	
		if (enableHeader === undefined) {
			enableHeader = true; //default enable headers
		}
	
		// If the returned data is an object do nothing, else try to parse
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
	
		var str = '<table class="' + theme + '">';
		str += '<tbody>';
	
		for (var i = 0; i < array.length; i++) {
			var row = 0;
			for (var index in array[i]) {
				str += (row % 2 == 0) ? '<tr class="alt">' : '<tr>';
	
				if (enableHeader) {
					str += '<th scope="row">' + index + '</th>';
				}
	
				str += '<td>' + array[i][index] + '</td>';
				str += '</tr>';
				row++;
			}
		}
		str += '</tbody>';
		str += '</table>';
		return str;
	}
};