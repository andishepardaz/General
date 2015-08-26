<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<center class="s">
<form method="post" action="register2.php">
<table width="50%"border="0">
<tr><td width="30%"><font color="black">کد ملی:</font></td><td><input type="text"maxlength="10"name="codemelli"></td></tr>
<tr><td width="30%"><font color="black">نام:</font></td><td><input type="text" name="firstname"></td></tr><td width="30%"><font color="black">نام خانوادگی:</font></td><td><input type="text" name="lastname"></td></tr>
<tr><td width="30%">نام پدر:</font></td><td><input type="text"name="father"></td></tr>
<tr><td width="30%">تاریخ تولد:</font></td><td><input type="text"name="year" maxlength="4"size="5"><input type="text"name="month"maxlength="2"size="5"><input type="text"name="day"maxlength="2"size="5"></td></tr>
<tr><td width="30%">جنسیت:</td><td><input type="radio" name="sex"value="male"><font color="black">مرد</font>
<input type="radio"name="sex"value="female"><font color="black">زن</font></tr></td>
<tr><td width="30%">رمز:</td><td><input type="password"name="password"/></td></tr>
<tr><td width="30%">تکراررمز:</td><td><input type="password"name="cpassword"/></tr></td>
<tr><td width="30%">سوال امنیتی:</td><td><select name="soal"><option value="Your Favorite car?">؟ماشین مورد علاقه شما</option><option value="Your Favorite color?">رنگ مورد علاقه شما</option><option value="Where did you born?">محل تولد</option><option value="What Was the name of your high school?">نام دبیزستان دوره تحصیل شما</option></select></tr></td>
<tr><td width="30%">پاسخ شما:</td><td><input type="text"name="javab"maxlength="50"/></tr></td>
</table><br/><br/>
    
    
    <p>
        <input type="submit"name="submit"value="ارسال"/>
    </p>
    </form>
</center>

</body>
</html>