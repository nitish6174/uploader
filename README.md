# File folder uploader
###### This is a PHP based file folder uploader with the following features:
  - Multiple file upload simultaneously
  - Folder upload as zip
  - Uploading multiple file and folders via Drag n' drop (Partially implemented)
  - Share via link (shortened URL)
  - Share to public repository
  - Sharing with existing user
  - File expiry
  - Option to set password on file
  - List of file/folder names about to be uploaded
  - Upload progress modal
  - User account to manage uploaded and shared files
  - Download file from link / public repository / account

  
### Setting up

1. Your machine needs to have **PHP and mySQL installed**
2. Clone the repository.  Make sure the root folder contains 'uploads' folder which further contains an empty 'public' folder (except for .gitignore file)  
3. Set your **mySQL credentials** in database/dbconf.php file : 

	```php
	<?php
		$db_username = "root";  // Your mySQL username here
		$db_password = "";      // Your mySQL password here
		$db_name = "uploader";  // Database name here
	?>
	```
4. Use the database/dbinit.php file to **setup the database tables** for you.  
Run this PHP file by executing ```php database/dbinit.php``` in terminal **OR** open the path of this file in browser

  > **Note:** The following line in .htaccess file disallows directory traversal  
  > 
	> ```
  >   Options -Indexes +FollowSymLinks
  > ```
    
  Thus, for the second option, you need to comment out this line to access the PHP file in browser.  (If this doesn't work, this suggests that you might have            disabled indexing through Apache configuration file)  
5. Further, you must modify the suitable variables in your **php.ini** file as the default values allow only small uploads.
6. Cool! Now that you have your database structure ready and settings done, open up the home page and **start uploading**!


### Using the features
* **Uploading**
    * Use the "Choose file" button to upload multiple files at once
    * To upload a folder, use the "Choose folder" button
    * Currently, Drag n' drop uploads the files to the hosting machine but does not store the record in database hence the files uploaded by this mode cannot be downloaded.
    * The box on the right shows which files are going to be uploaded.
    * Choose the appropriate "Share with" option:
        * Public: The file will be visible in the public repository (however you can password to restrict access)
        * Users: Choose the username (must exist) you want to share the file/folder with.
        * Only via link: The option is descriptive enough.
    * Choose for how much time do you want the file to be available?
    * Also, you can set a password on the file
    * Once the 'Upload' button is clicked, the files start uploading and a modal pops up showing 'Uplaod in progress' and when the upload is finished, changes to 'Upload finished'. The modal also shows the generated short URL for the file.
    * You can close the modal, select more files to upload and see the progress anytime using the 'View progress' button. The list is emptied only when you close the browser tab or window.
* **User account**
    * Create an account to keep track of uploaded files and let other users share files with you.
    * Once you login, two extra options can be seen in the Navigation bar under "View files" menu:
        * Uploaded by me
        * Shared with me
* **Viewing and downloading files**
    * You can view a file if:
        * you have the link to it
        * the file is available in the public repository
        * it was uploaded by you from your account
        * it was shared with you by another user
    * **Note :** In case the file was password protected, you will be asked to enter the password in order to download it.

## Contributing to the project
* The motivation for this project was to build a file sharing application for local network as it saves precious bandwidth and is times faster than any file transfer over internet.  
* Hence, for simplification, I havn't implemented security features and validations.  
* I would love to hear about more features that would be useful and suggestions on how to improve the quality of the project.

## About the project author
#### Nitish Garg
B.Tech undergraduate (Computer Science & Engineering)  
IIT Guwahati  
India  

nitish.garg.6174@gmail.com  
www.linkedin.com/in/nitish6174


