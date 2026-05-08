<html>

<head>
    <title>Penanganan Form - ListBox</title>
</head>

<body>
    <form action="Proses_ListBox.php" method="post" name="input">
        Pilih warna :<br>
        <select name="color[]" size="6" multiple>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
            <option value="red">Red</option>
            <option value="yellow">Yellow</option>
            <option value="white">White</option>
        </select><br>
        <input type="submit">
    </form>
</body>

</html>