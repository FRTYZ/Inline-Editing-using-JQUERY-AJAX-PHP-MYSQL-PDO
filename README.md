# Inline Editing using JQUERY AJAX | PHP MYSQL (PDO)

## Hello there,
In this Project, you can update your instant data with Inline Editing using JQUERY AJAX.

#### Our Project Content
* Instant Data Update with JQUERY AJAX


## İndex.php
![alt text](https://github.com/FRTYZ/Inline-Editing-using-JQUERY-AJAX-PHP-MYSQL-PDO/blob/main/img/inline-home.png?raw=true)

#### Show Errors and Success states
* Writes Success and Error messages in <span> tag
* Inline color changes according to Error and Success states.   
![alt text](https://github.com/FRTYZ/Inline-Editing-using-JQUERY-AJAX-PHP-MYSQL-PDO/blob/main/img/inline-edit.png?raw=true)
![alt text](https://github.com/FRTYZ/Inline-Editing-using-JQUERY-AJAX-PHP-MYSQL-PDO/blob/main/img/inline-error.png?raw=true)

## Database Data
* As can be seen, the changed data is updated instantly in the database.
![alt text](https://github.com/FRTYZ/Inline-Editing-using-JQUERY-AJAX-PHP-MYSQL-PDO/blob/main/img/inline-database-data.png?raw=true)

#### Database
![alt text](https://github.com/FRTYZ/Inline-Editing-using-JQUERY-AJAX-PHP-MYSQL-PDO/blob/main/img/inline-database.png?raw=true)

## Source Codes
* Related explanations are in the source code

#### .fonc.php (Database Settings)
```
<?php
$host = '127.0.0.1';
$dbname = 'pdoinlinedit';
$username = 'root';
$password = '';
$charset = 'utf8';
//$collate = 'utf8_unicode_ci';
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate"
];
try {
    $connect = new PDO($dsn, $username, $password, $options);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection error: ' . $e->getMessage();
    exit;
}
?>
```

#### index.php
* It makes the input editable with contenteditable="true".
* With the function onBlur="inlineData(this,'title','<?= $result['id']?>' we POST the data with AJAX and send it to the database.
* onClick="inlineEdit(this);" we make the selected cell change its color with (optional)
```
   <tbody>
                        <?php
                        include('fonc.php'); // We include our database in our index.php page

                        $query = $connect->prepare('Select * from article'); // We pull all the data from the "article" table in the database

                        $query->execute(); // We run our query

                        while($result=$query->fetch()) // We return our Data with While Loop
                        
                        {  // While Start

                            ?>
                            <tr>
                                <th scope="row"><?= $result['id']?></th>
                                 <td contenteditable="true" onBlur="inlineData(this,'title','<?= $result['id']?>')"
                                    onClick="inlineEdit(this);"><?= $result['title']?></td>

                                    <td contenteditable="true" onBlur="inlineData(this,'content','<?= $result['id']?>')"
                                    onClick="inlineEdit(this);"><?= $result['content']?></td>
                            </tr>
                    <?php
                        }  // While End

                        ?>
                        
                    </tbody>
```



#### index.php
* Writes Success and Error messages in <span> tag           

```
                <span style="text-align:center; color:red;" id="errorstatus"></span>
                <span style="text-align:center; color:green;" id="successfulresult"></span>
```

#### index.php
* We provided the data written in the line to be updated by POSTing it with AJAX and sending it to our "inline Edit.php" file
* Don't forget to include the "js" file of the JQUERY in our page
```
<script src="js/jquery-3.4.1.min.js"></script>


    <script>
    function inlineEdit(value) {
        $(value).css("background", "#b3d7ff");
        //we change the color of the selected cell
    }

    function inlineData(value, inline, id) {
        $(value).css("background", "#FFF url(img/loading.gif) no-repeat right");
      
        $.ajax({
            url: "inlineEdit.php", //ur we will send the data to
            type: "POST", //will be sent by post
            data: 'inline=' + inline + '&value=' + value.innerHTML.split('+').join('{0}')+ '&id=' + id, 
            // we send the data as "inline" "value and id"             
            success: function (data) {
                if (data == true) {
                    $(value).css("background", "#28a74582");
                     $("#successfulresult").text("Status = Successful, Data Updated");
                    //if the data is written to the database we change the background color of the cell back to light blue (you can choose any color you want.)
                }

                else {
                    $(value).css("background", "#f00");
                    $("#errorstatus").text("Status = Error , There is something wrong , Please Check");

                    //If there is an error, we print the cell color red and the error message in the <span> tag under the table.
                }
            }
        });
    }
</script>   
```

#### inlineEdit.php
* The php code where the data POSTed with AJAX is sent to the database
```
<?php 
include("fonc.php"); // We include our database connection on our page.
if ($_POST) { // We check if there is a post.
   
   $inline = $_POST['inline']; // We check if there is a post. aktarıyoruz

   $value = $_POST['value'];

   //Since we cannot post the + (plus) value, we send it with {0} and convert it back to + here.
   $value = str_replace('{0}','+',$value); 
    
   $id = $_POST['id'];

      if ($connect->query("UPDATE article SET $inline = '$value' WHERE id =$id")) // We write our query to update the data.
      {
         echo true; // If the update query is working we return true
      }
      else
      {
         echo false; // We return false if the id is not found or there is an error in the query
      }
}

?>
```

#### Source and Thanks 
* Someone shared this project as mysqli before, so I convert this project to PDO and share it with you.
* If you are looking for the MYSQLI version of this project, you can find it from this [link](https://mesutd.com/jquery-ajax-kullanarak-php-mysql-satir-ici-duzenleme/)


Good Encodings
