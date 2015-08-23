<html>
<head>
    <title>LogIn</title>
</head>

<body>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
        <form name="form1" method="post" action="checklogin.php">
            <td>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                    <tr>
                        <td colspan="3"><strong>Member Login </strong></td>
                    </tr>
                    <tr>
                        <td width="78">Username </td>
                        <td width="6">:</td>
                        <td width="294"><input name="myusername" type="text" id="myusername"></td>
                    </tr>
                    <tr>
                        <td>Pasword</td>
                        <td>:</td>
                        <td><input name="mypassword" type="text" id="mypassword"></td>
                    </tr>
                    <tr>

                        <td>ID_CodeMeli</td>
                        <td>:</td>
                        <td><input name="id" type="radio" value="idcodemelli" checked="on"></td>

                        <td>ID_Company</td>
                        <td>:</td>
                        <td><input name="id" type="radio" value="idcompany"></td>

                    </tr>
					 <tr>
                        <td></td>
                        <td>:</td>
                        <td> <img src="captcha.php" /></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>input captcha</td>
                        <td>:</td>
                        <td> <input type="text" name="captcha" /></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="Submit" value="Login"></td>
                    </tr>
					
					
                </table>
            </td>
        </form>
    </tr>
</table>

</body>
</html>