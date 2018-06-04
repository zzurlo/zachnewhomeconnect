<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Login Page</title>
        
    </head>
    
    <body id = "container">

        <style>
            body{
                background-color:steelblue;
            }
            #wrapper{
                margin: 0;
                border-style: none;
                border-width: 5px;
                background: snow;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%)
            }
              
        </style>
        
        <div id = "wrapper">
           
                <h2 id = "headingTwo">
                Register to Zach New Home Connect
                </h2>
            
                <?php echo form_open('Auth/registerUser'); ?>
                <table id = "table">
                    
                    <tr>
                        <td>First Name: </td>
                        <td><input type="text" name="firstname"/></td>
                    </tr>
                    <tr>
                        <td>Last Name: </td>
                        <td><input type="text" name="lastname"/></td>
                    </tr>
                    <tr>
                        <td>Email: </td>
                        <td><input type="text" name="email"/></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="text" name="password"/></td>
                    </tr>
                    <tr>
                        <td >
                            <input type="submit" name="register" value = "Register"/>
                        </td>
                    </tr>
                </table>
            
            
        </div>
        
        
        
        
    </body>
</html>