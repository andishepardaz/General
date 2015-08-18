<html>
<head>
</head>
<body>
<center class="s">
<form method="post" action="register2.php">
<table width="50%"border="0">
<tr><td width="30%"><font color="black">Code Meli:</font></td><td><input type="text"maxlength="10"name="codemelli"></td></tr>
<tr><td width="30%"><font color="black">First Name:</font></td><td><input type="text" name="firstname"></td></tr><td width="30%"><font color="black">Last Name:</font></td><td><input type="text" name="lastname"></td></tr>
<tr><td width="30%">Father Name:</font></td><td><input type="text"name="father"></td></tr>
<tr><td width="30%">Birth Day:</font></td><td><input type="text"name="date" maxlength="4"size="5"><input type="text"name="date2"maxlength="2"size="5"><input type="text"name="date3"maxlength="2"size="5"></td></tr>
<tr><td width="30%">Your Sex:</td><td><input type="radio" name="male"value="male"><font color="white">malen</font>
<input type="radio"name="female"value="female"><font color="white">Female</font></tr></td>
<tr><td width="30%">Password:</td><td><input type="password"name="password"/></td></tr>
<tr><td width="30%">Confirm Password:</td><td><input type="password"name="cpassword"/></tr></td>
<tr><td width="30%">Choose your question:</td><td><select name="soal"><option value="Your Favorite car?">Your Favorite car?</option><option value="Your Favorite color?">Your Favorite color?</option><option value="Where did you born?">Where did you born?</option><option value="What Was the name of your high school?">What Was the name of your high school?</option></select></tr></td>
<tr><td width="30%">Your Answer:</td><td><input type="text"name="javab"maxlength="50"/></tr></td>
    <tr><td><input type="file" name="scansh"><br><br></td></tr>
    <tr><td><input type="file" name="scancm"><br><br></td></tr>
</table>
    <p>
        <input type="submit"name="submit"value="send"/>;
    </p>
    </form>
</center>

</body>
</html>