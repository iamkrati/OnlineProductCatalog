<?php

include_once('conn.php');
$query = "SELECT id,name, description,price,image_url FROM Products";
$res = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/81831682c9.js" crossorigin="anonymous"></script>
    
</head>

<body>
    <header>
        <h1>Product Listing</h1>
    </header>
    <div class="filtering-box">
        <div class="filters">

            <h3>Filter</h3>
            <p><input type="checkbox" id="cbox1" onclick="myFunction1('Books')">Books</p>
            <p><input type="checkbox" id="cbox2" onclick="myFunction1('Electronics')">Electronics</p>
            <p><input type="checkbox" id="cbox3" onclick="myFunction1('Clothing')">Clothing</p>
            <div class="searcher">
                <img src="searchicon.png">
                <input type="text" id="myInput" onkeyup="myFunction()"
                    placeholder="type categories name like (Mens,Womens,Kitchen...)" title="Type in a name">

            </div>
        </div>


    </div>

    <main>
        <div class="product-grid ">
            <?php
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="product-card">
                    <img src="<?php echo $row['image_url'] ?>" alt="Product 1">
                    <h2>
                        <?php echo $row['name'] ?>
                    </h2>
                    <p>
                        <span style="float: left;">About</span>
                        <i onclick="opener(this)" style="float: right;" data-target="p<?php echo $row['id'] ?>"
                            class="fa-sharp fa-solid fa-arrow-down"></i>
                    </p>
                    <br>
                    <p class="content" id="p<?php echo $row['id'] ?>">
                        <?php echo $row['description'] ?>
                    </p>
                    <span class="price"> $
                        <?php echo $row['price'] ?>
                    </span>
                    <?php
                    $id = $row['id'];
                    $qu = "SELECT name from Categories where id='$id' limit 1";
                    $resu = mysqli_query($conn, $qu);
                    while ($crow = mysqli_fetch_assoc($resu)) {
                        ?>
                        <span class="Category-Name" style="float:right;"><?php echo strtoupper($crow['name'])?></span>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <!-- Repeat the product-card div for additional products -->
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Product Listing</p>
    </footer>
    <script>
        
        //this function is used to  hide/unhide the about of products
        function opener(e) 
        {
            const targetId = e.getAttribute('data-target');
            const ele = document.getElementById(targetId);
            if (ele.style.display == "none") {
                ele.style.display = "block";
            }
            else {
                ele.style.display = "none";
            }

        }
        var cat=document.getElementsByClassName("Category-Name");

        // this function is used to show/hide products of suggested categories
        function myFunction1(e)
        {
            var filter="";
            var txtValue,a;
            var checkBox1 = document.getElementById("cbox1");
            var checkBox2 = document.getElementById("cbox2");
            var checkBox3 = document.getElementById("cbox3");
            for(i=0;i<cat.length;i++)
            {
                a=cat[i];
                a.parentElement.style.display="display";
            }
            if (checkBox1.checked) 
            {
                 filter=filter+"BOOKS";
            }
            if(checkBox2.checked) 
            {
                filter = filter+"ELECTRONICS";
            }
            if (checkBox3.checked) 
            {
               filter = filter+"CLOTHING";
            }
            for(i=0;i<cat.length;i++)
            {
                a=cat[i];
                txtValue = a.textContent || a.innerText;
                console.log(txtValue.toUpperCase());
                if(txtValue.toUpperCase().indexOf(filter)!=-1 || filter.toUpperCase().indexOf(txtValue.toUpperCase())!=-1)
                {
                    a.parentElement.style.display="block";
                }
                else
                {
                    a.parentElement.style.display="none";
                }
            }
        }

        // this function is used to show/hide products of string which you will type in searchbar
        function myFunction()
        {
            var filter="";
            var input,txtValue,a;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            for(i=0;i<cat.length;i++)
            {
                a=cat[i];
                txtValue = a.textContent || a.innerText;
                if(txtValue.toUpperCase().indexOf(filter)!=-1 || filter.toUpperCase().indexOf(txtValue.toUpperCase())!=-1)
                {
                    a.parentElement.style.display="block";
                }
                else
                {
                    a.parentElement.style.display="none";
                }
            }
        }
    </script>
</body>

</html>