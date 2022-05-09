<!DOCTYPE html>
<html>
<head>
    <title>To do</title>
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script>

        $(document).ready(function(){
            $.get("/bakalarkaBrlej/JSONSERVICE.php", function(data,status){
                console.log(data);
                var toDoItems = JSON.parse(data);
                for(var i  = 0; i < toDoItems.length; i++){
                    var item = "id: " + toDoItems[i].itemId +
                        " " + toDoItems[i].itemDescription +
                        " priority: " + toDoItems[i].itemPriority +
                        " due: " + toDoItems[i].itemDueDate;
                    item = "<li>" + item + "<li>";
                    $("#myitems").append(item);
                }
            });
            $("#saveitem").click(function(){
                var description = $("#desc").val();
                var dueDate = $("#duedate").val();
                var priority = $("#priority").val();

                var item = {
                    itemDescription : description,
                    itemDueDate : dueDate,
                    itemPriority : priority
                };
                $.post("/bakalarkaBrlej/JSONSERVICE.php", item, function(data){
                    console.log(data);
                });
            });
        });
    </script>
</head>
<body>
<div>
    <h1>To Do list Items</h1>
    <ol id="myitems">

    </ol>
</div>
<div>
    <h2>Add New Item</h2>
    <label>Item Description:</label>
    <input type="text" id="desc" /><br>
    <label> Item Due Date:</label>
    <input type="text" id="duedate" placeholder="yyyy-mm-dd"/><br>
    <label>Item Priority:</label>
    <input type="text" id="priority" /> <br>
    <input type="button" id="saveItem" value="Save Item" />
</div>
</body>
</html>