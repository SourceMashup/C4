# C4
A simple PHP development framework that works similariy to Jekyll

Start by navigating to /dbCreate.php to add in mysql database information

## How to use
Create pages in the database in the __URLS__ table
* URL = the page url you want users to navigate to
* REFERENCE_URL = another url you want users to nagatage to the page
* REDIRECT_URL = a url that you want the users to be redirected to if they try to access either the URL or REFERENCE_URL
* FILE = a file located in the __Pages__ directory to use instead of just a default page template with the title and content

If the FILE field is not filled out, the program will try to access the data for that pages name in the __CONTENT__ table.  
* NAME = the name of the page
* CONTENT = The content of that page name

You will be able to access the data by typing in:

#### EX1 adding the content for the about page
```PHP
//contentExists() will parse for the data so if the content data is not used in the page, it will not try to load it
if($site->contentExists())
{
	echo excerpt($site->content["about"]);
}
```
You reference any page data from any page.

You can also declare data as JSON in the __SITE__ table.  
* CONFIG = JSON data like the site title, etc.

Each variable will be able to be access via
#### EX2 adding in the title variable from the SITE table
```PHP
//dataExists() will load the data for the site, if it is not used then it is not loaded
if($site->dataExists())
		echo $site->data->title;
```

### Extras
If a user tries to access a url that is not in the URLS table, it will be redirected to the 404 page.  
A good use for the REDIRECT_URL field is to redirect people to an underconstruction page while the page you work on is being updated.


##Templating
You can add a template for all pages, not includes, by providing

```PHP
$_layout = "default";
```

somewhere on the page.  You can also provide a $_title parameter as well.  Any other variables that you want to carry over to the next template will need to be declared as follows

```PHP
$_parm = '{ "title": "Home Page" }';
```

These can then be referenced at on any template you add as well as in any includes you have.  

```PHP
echo $page->parm->title;
```

Templates can be nested.  Example, you can have your page use a page template, which uses the default template.  


##Additional
This runs on PHP 5
This also needs the Apache2 Mod_rewrite module as well as htaccess files enabled.  
