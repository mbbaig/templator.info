@extends('layouts.main')
@section('content')

<h1>Frequently Asked Questions</h1><hr>

	<h2>Deletion</h2>
    <div class="panel-group" id="accordion">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q1">
              Once I delete a template from my account is there a way I can get it back? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q1" class="panel-collapse collapse">
          <div class="panel-body">
          	No. Delete actions permanently remove the template data and cannot be undone.   
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q2">
              I deleted my account by accident. Is there a way I can retrieve it? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q2" class="panel-collapse collapse">
          <div class="panel-body">
            Unfortunately there is not. After an account has been deleted the templates and all the data associated with that account are also deleted. Be careful when you perform this action. 
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q3">
              How do I delete my account and all my information from the system? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q3" class="panel-collapse collapse">
          <div class="panel-body">
            To delete an account, you must first click on your login name on the top right corner. You will then be taken to your account page. On the top right of the page you should see a red button marked, “Delete Account”.  If you click this you will be prompted to delete your account. If you accept all data connected to your account, including your templates and profile itself will be deleted.
          </div>
        </div>
      </div>

      <br><br>
      <h2>Editing</h2>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q4">
              There are many problems in one of the templates I found online. How do I edit another person’s template? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q4" class="panel-collapse collapse">
          <div class="panel-body">
            You cannot edit or delete a template that does not belong to you. However, you can make a copy of it and release it as a different version of the original. To edit a template that is not yours you must first make a copy of it. Find the template from the list that you want to copy and click on it. On the template page you will see several options. Click the copy button. Next go to your account page by clicking your name.  Find the template and click on it. You can now edit it by either updating the template information itself or the tasks.  If you set the visibility of the template to public then others can see this new version of the template. 
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q5">
              What is he difference between the copying a template and downloading it? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q5" class="panel-collapse collapse">
          <div class="panel-body">
            Copying a template will save a version of it to your account. You then have access to modify the template from your account page. Downloading a template will save a version of it to your local machine. 
          </div>
        </div>
      </div>

      <br><br>
	  <h2>Searching and Privacy</h2>
	  <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q6">
              How do I make my template private, so only I can see it? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q6" class="panel-collapse collapse">
          <div class="panel-body">
            When creating a template or editing it set the privacy option to private. 
          </div>
        </div>
      </div>
    <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q7">
              Why can’t I find the template I just created on the front page? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q7" class="panel-collapse collapse">
          <div class="panel-body">
            The reason for this could be that the template privacy option is not set to public. If it is set to private it will not be shown in the public lists on the site. Do not worry though; your template will be saved into your own account template list.
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q8">
              I am working on my templates in parts and do not want others to see it until it is done.<br>When I finished the first part I saw that my template was available to others. How can I prevent others from seeing it until I am finished? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q8" class="panel-collapse collapse">
          <div class="panel-body">
            Templates have the option to be either set as public or private. If you do not set a privacy status it is by default public. You have the option of changing this at any time by clicking on your desired template and updating its status. A status of private prevents other users from seeing it.
          </div>
        </div>
      </div>
	  <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q9">
              I want to find my template on the public list to see if it posted correctly. How can I do so? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q9" class="panel-collapse collapse">
          <div class="panel-body">
            The site currently provides three ways to search for public templates. 
The first is by sorting templates in a specific order. These sort options can be found on the left side of the templates list on all pages. You can sort the featured templates by the latest date posted, alphabetically by template name or alphabetically by author name. 
The second is by using the categories and subcategories at the top.  If you know under which of these specifications your template lays you can use this method to find it. Additionally, if you make a mistake you can use the bread crumb layout to backtrack through your options. 
The third way is by using the search box at the top of the site. Providing a keyword will filter out templates that do not match it, resulting in a list of templates featuring the specified keyword. Note that the search option is global and not case sensitive.

          </div>
        </div>
      </div>
	<br><br>

  <h2>Downloading and Importing</h2>
    <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q10">
              How do I import a template into my project application? (e.g. Microsoft Projects)<small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q10" class="panel-collapse collapse">
          <div class="panel-body">
            <ol>
              <li>Firstly, find the template that you want to import and click on it. After doing so there should be a download button under the template content that looks like this <br> <img src="{{asset('images/download.png')}}" alt="download"> <br><br></li>
              <li>Once you have downloaded a template, open up Microsoft Projects. Select the option to make a new project from an excel workbook. The button should look like this <br> <img src="{{asset('images/projectOption.png')}}" alt="projectOption"> <br><br></li>
              <li>When the explorer window opens up, change the file type displayed to excel workbook, select the file and click open. <br><img src="{{asset('images/fileType.png')}}" alt="fileType"> <br><br></li>
              <li>Click next until you reach the screen shown and select new map and then click next.<br> <img src="{{asset('images/newMap.png')}}" alt="newMap" width="350px" height="300px"> <br><br></li>
              <li>On the following screen select "As a new project" and click next.<br> <img src="{{asset('images/newProject.png')}}" alt="newProject" width="350px" height="300px"> <br><br></li>
              <li>From the options of the "types of data to import", check off Tasks only. The window should look like the following before clicking next.<br> <img src="{{asset('images/tasks.png')}}" alt="tasks" width="350px" height="300px"> <br><br></li>
              <li>From the "Source worksheet name:" dropdown select tasks. The window should look like the following.<br> <img src="{{asset('images/worksheetName.png')}}" alt="worksheetName" width="350px" height="300px"> <br><br></li>
              <li>Finally, click next or finish and you are done. <br><br></li>
            </ol>
          </div>
        </div>
      </div>
    <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#Q11">
              I downloaded a template, but I cannot find it on my account. Where do I find my downloads? <small class="pull-right">Click to expand</small>
            </a>
          </h4>
        </div>
        <div id="Q11" class="panel-collapse collapse">
          <div class="panel-body">
            Downloading a template transfers it to your local machine. Copying is what transfers a copy of a template to your templator account. If you downloaded a template, check your downloads folder or what ever destination you have set to hold your downloads.  
          </div>
        </div>
      </div>

      <br><br>
    </div>
@stop