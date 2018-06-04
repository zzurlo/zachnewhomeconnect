<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Login Page</title>
        
    </head>
    
    <body id = "container">
        <style type="text/css">
            #myList{
                list-style-type: none;
            }
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
        
        <div id ="wrapper">
           <h2>
            Login to Zach New Home Connect
            </h2>
        
            <ul id = "myList">
                
                <li>
                    <a href  = "<?php echo base_url();?>Auth/register">Register</a>
                </li>
                
            
            </ul>
            
            <?php echo form_open('Auth/loginUser'); ?>
            <table>
                
                <tr>
                    <td>Email: </td>
                    <td><input type="text" name="email"/></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="text" name="password"/></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="login" value = "Login"/>
                    </td>
                </tr>
            </table> 
        </div>
            
            
        
        
        
    </body>
</html>