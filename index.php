<!DOCTYPE html>
<html>
<head>
	<title>PDO CRUD</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/all.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-8">	
				<br>
			<h2 style="text-align:center;">İnline Edit | PHP MYSQL(PDO)</h2>			
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">ID</th>							
							<th scope="col">Title</th>
							<th scope="col">Content</th>						
						</tr>
					</thead>
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
				</table>
				<span style="text-align:center; color:red;" id="errorstatus"></span>
				<span style="text-align:center; color:green;" id="successfulresult"></span>
				


			</div>
		</div>
	</div>
	<script src="js/bootstrap.min.js"></script>
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
	
</body>
</html>