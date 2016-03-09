fileUploadInput = document.querySelector('#fileUploadInput');
folderUploadInput = document.querySelector('#folderUploadInput');
selDiv = document.querySelector("#previewList");
shareSelect = document.querySelector("#shareSelect");
document.querySelector('#viewProgressButton').disabled = true;

fileUploadInput.addEventListener('change', handleFileSelect, false);
folderUploadInput.addEventListener('change', handleFolderSelect, false);
folderToUpload = "";
filesToUpload = "";
draggedToUpload = "";
draggedItemList = "";
paths = "";












// Submitting uploads with button

document.querySelector("#submit").onclick = function() {	
	var user = "";	
	if(shareSelect.value=="Public")
		user = "public";
	else if(shareSelect.value=="Users")
		user = document.querySelector("#sharedUsersModal .sharedUsername").value;
	var expiry = document.querySelector("#expirySelect").value;
	var password = document.querySelector("#uploadPassword").value;
	var numoffiles = 1;
	if(filesToUpload!="")
		numoffiles = filesToUpload.length;
	else if(draggedItemList!="")
		numoffiles = draggedItemList.length;
	$.when($.ajax("ajax/generateurl.php?count="+numoffiles)).done( function(data){
		if(data=="")
			alert('Sorry. The upload request cannot be processed');
		else
		{
			shortLinkList = data.split('#');
			// console.log(shortLinkList);
			if(filesToUpload!="")
				uploadFiles(filesToUpload,user,expiry,password,shortLinkList);
			if(folderToUpload!="")
				uploadFolder(folderToUpload,user,expiry,password,shortLinkList);
			if(draggedToUpload!="")
				uploadDragged(draggedToUpload,user,expiry,password,shortLinkList);
		}
	});
}






















// File input handle
function handleFileSelect(e)
{
	if(!e.target.files)
		return;     
	selDiv.innerHTML = "";
	filesToUpload = "";
	folderToUpload = "";
	draggedToUpload = "";
	folderUploadInput = "";
	var items = e.target.files;
	filesToUpload = items;
	for(var i=0; i<items.length; i++)
	{
		console.log(items[i]);
		folderName = items[i].name;
		var elem = document.createElement("LI");
		var textnode = document.createTextNode(folderName);
		elem.appendChild(textnode);
		selDiv.appendChild(elem);
	}
}
function uploadFiles(files,user,expiry,password,shortLinkList)
{
	xhr = new XMLHttpRequest();
	data = new FormData();
	paths = "";	
	for(i=0;i<files.length;i++)
	{
		paths += files[i].name+"###";
		data.append(i, files[i]);
	};
	var jsonurl = JSON.stringify(shortLinkList);
	data.append('paths', paths);
	data.append('jsonurl', jsonurl);
	data.append('sharedwith',user);
	data.append('expiry',expiry);
	data.append('password',password);
	xhr.open('POST', "ajax/uploadFile.php", true);
	xhr.send(this.data);

	// var path = [location.host, location.pathname].join('');
	// if( path.substring(path.length-9,path.length) == 'index.php' )
	// 	path = path.substring(0,path.length-9);
	
	document.querySelector('#viewProgressButton').disabled = false;
	$('#progressModal').modal('show');
	$('#progressModal #progressBody h3').html("Upload in progress");
	var progressList = document.querySelector('#progressList');
	for(var uploadFileListItr=0;uploadFileListItr<files.length;uploadFileListItr++)
	{
		row = document.createElement('DIV'); row.className = 'row';
		col1 = document.createElement('DIV'); col1.className = 'col-md-3 textcenter status'; row.appendChild(col1);
		col2 = document.createElement('DIV'); col2.className = 'col-md-3 textcenter'; row.appendChild(col2);
		col3 = document.createElement('DIV'); col3.className = 'col-md-6 textcenter'; row.appendChild(col3);
		progressList.appendChild(row);
		col1.innerHTML = "Uploading";
		col2.innerHTML = files[uploadFileListItr].name;
		col3.innerHTML = location.host+"/uploader/u/"+shortLinkList[uploadFileListItr];	
	}

	xhr.onreadystatechange = function(ev){
		console.log(xhr.responseText);
		$('#progressModal #progressBody h3').html("Upload finished");
		$('#progressList .status').html("Uploaded");
	};
}




















// Folder input handle
function handleFolderSelect(e)
{
	if(!e.target.files)
		return;     
	selDiv.innerHTML = "";
	filesToUpload = "";
	folderToUpload = "";
	draggedToUpload = "";
	fileUploadInput = "";
	var items = e.target.files;
	folderToUpload = items;
	for (var i=0; i<items.length; i++)
	{
		console.log(items[i]);
		newFolder = true;
		folderName = items[i].webkitRelativePath.split("/")[0];
		$("#previewList li").each(function(){
			if($(this).text()==folderName)
				newFolder = false;
		});
		if(newFolder==true)
		{
			var elem = document.createElement("LI");
			var textnode = document.createTextNode(folderName);
			elem.appendChild(textnode);
			selDiv.appendChild(elem);			
		}
	}
}

function uploadFolder(files,user,expiry,password,shortLinkList)
{
	// shortLink = randomString();
	// console.log(shortLinkList);
	var shortLink = shortLinkList[0];
	xhr = new XMLHttpRequest();
	data = new FormData();
	paths = "";	
	for (var i in files)
	{
		paths += files[i].webkitRelativePath+"###";
		data.append(i, files[i]);
	};
	data.append('paths', paths);
	data.append('url', shortLink);
	data.append('sharedwith',user);
	data.append('expiry',expiry);
	data.append('password',password);
	xhr.open('POST', "ajax/uploadFolder.php", true);
	xhr.send(this.data);

	// var path = [location.host, location.pathname].join('');
	// if( path.substring(path.length-9,path.length) == 'index.php' )
	// 	path = path.substring(0,path.length-9);
	
	// $('#progressModal #progressBody .row div.col-md-2').html("Uploading");
	// $('#progressModal #progressBody .row div.col-md-3').html(selDiv.querySelectorAll('li')[0].innerHTML);
	// $('#progressModal #progressBody .row div.col-md-7').html(path+"u/"+shortLink);

	document.querySelector('#viewProgressButton').disabled = false;
	$('#progressModal').modal('show');
	$('#progressModal #progressBody h3').html("Upload in progress");
	var progressList = document.querySelector('#progressList');
	row = document.createElement('DIV'); row.className = 'row';
	col1 = document.createElement('DIV'); col1.className = 'col-md-3 textcenter'; row.appendChild(col1);
	col2 = document.createElement('DIV'); col2.className = 'col-md-3 textcenter'; row.appendChild(col2);
	col3 = document.createElement('DIV'); col3.className = 'col-md-6 textcenter'; row.appendChild(col3);
	progressList.appendChild(row);
	col1.innerHTML = "Uploading";
	col2.innerHTML = selDiv.querySelectorAll('li')[0].innerHTML;
	col3.innerHTML = location.host+"/uploader/u/"+shortLink;	

	xhr.onreadystatechange = function(ev){
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			console.log(xhr.responseText);
			$('#progressModal #progressBody h3').html("Upload finished");
			col1.innerHTML = "Uploaded";
		}
	};
}
























// Drag and drop
var uploadDragArea = document.querySelector('#uploadDragArea');
uploadDragArea.ondragover = function (e) { 
	e.stopPropagation();
	this.className = 'hover';
	return false;
};
uploadDragArea.ondragleave = function (e) {
	e.stopPropagation();
	this.className = '';
	return false;
};
uploadDragArea.ondrop = function (e) {
	e.stopPropagation();
	e.preventDefault && e.preventDefault();
	this.className = '';
	readDroppedItems(e);
	return false;
};
function readDroppedItems(event)
{   
	selDiv.innerHTML = "";
	filesToUpload = "";
	folderToUpload = "";
	fileUploadInput = "";
	folderUploadInput = "";
	draggedItemList = [];
	var items = event.dataTransfer.items;
	draggedToUpload = [];
	for (var i=0; i<items.length; i++)
	{
		var item = items[i].webkitGetAsEntry();
		if (item)
		{    
			// console.log(item);
			traverseFileTree(item);
			draggedItemList.push(item.name);
			var elem = document.createElement("LI");
			var textnode = document.createTextNode(item.name);
			elem.appendChild(textnode);
			selDiv.appendChild(elem);
		}
	}
	console.log(draggedItemList);
	// var files = event.dataTransfer.files;
	// for(var i=0;i<files.length;i++)
	// 	alert(      files[i]["name"]
	// 		+ ',' + files[i]["type"]
	// 		+ ',' + files[i]["lastModifiedDate"].toLocaleDateString()
	// 		+ ',' + files[i]["lastModifiedDate"].toLocaleTimeString()
	// 		+ ',' + files[i]["size"] );	
}
function traverseFileTree(item, path)
{
	path = path || "";
	if (item.isFile)
	{
		// draggedToUpload.push(item);
		item.file(function(file) {
			// file['webkitRelativePath']		 = path+file.name;
			paths += path+file.name+"###";
			// console.log(file);
			draggedToUpload.push(file);
		});
		// console.log(item["fullPath"]);
		// item.file(function(file) {
		// 	console.log( path + file.name + ',' + file.size );
		// });
	}
	else if (item.isDirectory)
	{
		var dirReader = item.createReader();
		dirReader.readEntries(function(entries) {
			for (var i=0; i<entries.length; i++)
			{
				traverseFileTree(entries[i], path + item.name + "/");
			}
		});
	}

}
function uploadDragged(files,user,expiry,password,shortLinkList)
{
	// console.log(paths);
	// console.log(shortLinkList);
	console.log(draggedItemList);
	xhr = new XMLHttpRequest();
	data = new FormData();
	for (var i in files)
	{
		// console.log(files[i]);
		// currentfilename = files[i]["fullPath"];
		// currentfilenamelen = currentfilename.length;
		// currentfilename = currentfilename.substr(1,currentfilenamelen-1);
		// paths += currentfilename+"###";
		data.append(i, files[i]);
	};
	// var jsonfiles = JSON.stringify(files);
	// data.append('jsonfiles', jsonfiles);
	var jsonurl = JSON.stringify(shortLinkList);
	data.append('files',files);
	data.append('paths', paths);
	data.append('url', jsonurl);
	data.append('sharedwith',user);
	data.append('expiry',expiry);
	data.append('password',password);
	data.append('rootList',draggedItemList);
	xhr.open('POST', "ajax/uploadDragged.php", true);
	xhr.send(this.data);

	// var path = [location.host, location.pathname].join('');
	// if( path.substring(path.length-9,path.length) == 'index.php' )
	// 	path = path.substring(0,path.length-9);	

	document.querySelector('#viewProgressButton').disabled = false;
	$('#progressModal').modal('show');
	$('#progressModal #progressBody h3').html("Upload in progress");
	var progressList = document.querySelector('#progressList');
	for(var uploadDraggedListItr=0;uploadDraggedListItr<draggedItemList.length;uploadDraggedListItr++)
	{
		row = document.createElement('DIV'); row.className = 'row';
		col1 = document.createElement('DIV'); col1.className = 'col-md-3 textcenter status'; row.appendChild(col1);
		col2 = document.createElement('DIV'); col2.className = 'col-md-3 textcenter'; row.appendChild(col2);
		col3 = document.createElement('DIV'); col3.className = 'col-md-6 textcenter'; row.appendChild(col3);
		progressList.appendChild(row);
		col1.innerHTML = "Uploading";
		col2.innerHTML = draggedItemList[uploadDraggedListItr];
		col3.innerHTML = location.host+"/uploader/u/"+shortLinkList[uploadDraggedListItr];	
	}

	xhr.onreadystatechange = function(ev){
		console.log(xhr.responseText);
		$('#progressModal #progressBody h3').html("Upload finished");
		$('#progressList .status').html("Uploaded");
	};
}


































// Username share select
$('#sharedUsersAlert').hide();
shareSelect.onchange = function() {
	if(shareSelect.value=="Users")
		$('#sharedUsersModal').modal({ backdrop: 'static', keyboard: false });
}
function selectUser()
{
	$('#sharedUsersAlert').hide();
	$('#sharedUsersModal').modal('hide');
	return false;
}




































// Random string is now generated by PHP. No need of this fxn

// function randomString()
// {
// 	var text = "";
// 	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
// 	for( var i=0; i < 5; i++ )
// 		text += possible.charAt(Math.floor(Math.random() * possible.length));
// 	return text;
// }


// Copying text to clipboard

// shortLinkText = document.querySelector('#progressModal #progressBody .row div.col-md-7');
// // shortLinkText.onclick = copyTextToClipboard(shortLinkText.innerHTML);
// // shortLinkText.onclick = copyTextToClipboard('testtext');
// shortLinkText.addEventListener('click',function(event){copyTextToClipboard(shortLinkText.innerHTML);});
// function copyTextToClipboard(text)
// {
// 	console.log(text);
//   var textArea = document.createElement("TEXTAREA");
//   textArea.style.background = 'transparent';
//   textArea.value = text;
//   document.body.appendChild(textArea);
//   textArea.select();
//   try {
//     var successful = document.execCommand('copy');
//     var msg = successful ? 'successful' : 'unsuccessful';
//     console.log('Copying text command was ' + msg);
//   } catch (err) {
//     console.log('Oops, unable to copy');
//   }
//   document.body.removeChild(textArea);
// }