<div class="wrapper" id="uploadWrapper">

<h3>Upload and share files and folders</h3>
<hr>

<div class="container">
<div class="row">

	<div class="col-sm-6" id="uploadSection">
		<div id="uploadDragArea">
		</div>
		<br><strong>------------------ OR ------------------</strong><br><br>
		<div class="form-group">
			<label>Upload files</label>
			<input type="file" name="fileUploadInput[]" id="fileUploadInput" multiple="">
		</div>
		<div class="form-group">
			<label>Upload folders</label>
			<input type="file" name="folderUploadInput[]" id="folderUploadInput" multiple="" webkitdirectory="">
		</div>
	</div>

	<div class="col-sm-5 col-sm-offset-1" id="previewSection">
		<div id="previewBox">
			<h4>Selected files/folders</h4>
			<hr>
			<div id="previewList">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-inline">
					<label for="shareSelect">Share with : </label>
					<select class="form-control" id="shareSelect">
						<option>Only via link</option>
						<option>Users</option>
						<option>Public</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group form-inline">
					<label for="expirySelect">File(s) expiry : </label>
					<select class="form-control" id="expirySelect">
						<option>Never</option>
						<option>1 min</option>
						<option>1 hour</option>
						<option>1 day</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<label for="uploadPassword">Password for selected files(optional)</label>
			<input type="password" class="form-control" id="uploadPassword" placeholder="********">
		</div>
		<div class="form-group">
			<button type="button" id="viewProgressButton" class="btn btn-warning" data-toggle="modal" data-target="#progressModal">View progress</button>
			<input type="submit" class="btn btn-success" value="Upload" id="submit">
		</div>
	</div>

</div>
</div>


<div class="modal fade" id="sharedUsersModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<strong>Select users to share share the file with</strong>
				<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			</div>

			<div class="modal-body">
				<form role="form">
					<div class="form-group">
						<input type="text" class="form-control sharedUsername" placeholder="Type a username">
					</div>
				</form>
				<div class="alert alert-danger" role="alert" id="sharedUsersAlert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					<span class="msg"></span>
				</div>
			</div>

			<div class="modal-footer" style="text-align: center;">
				<button class="btn btn-primary" onclick="return selectUser()">DONE</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="progressModal" tabindex='-1'>
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<strong>Upload progress</strong>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body" id="progressBody">
				<h3></h3>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-3"></div>
					<div class="col-md-7"></div>
				</div>
				<div id="progressList"></div>		
			</div>

			<div class="modal-footer" style="text-align: center;">
				<button class="btn btn-primary" onclick="$('#progressModal').modal('hide');">Hide</button>
			</div>

		</div>
	</div>
</div>

</div>


<link rel="stylesheet" type="text/css" href="css/views.css">
<script type="text/javascript" src="js/upload.js"></script>