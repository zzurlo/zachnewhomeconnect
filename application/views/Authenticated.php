<!DOCTYPE html>
<html ng-app="nhc">
    <head>
        <meta charset = "utf-8">
        <title>Authenticated Page</title>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js"></script>
        <script src="//unpkg.com/@uirouter/angularjs/release/angular-ui-router.min.js"></script>
        <script> var _EMAIL = "<?php echo $_SESSION['EMAIL']; ?>";</script>
        <script> var _USERID = "<?php echo $_SESSION['USER_ID']; ?>";</script>  
        <script> var _FIRSTNAME = "<?php echo $_SESSION['FIRST_NAME']; ?>";</script>  
        <script> var _LASTNAME = "<?php echo $_SESSION['LAST_NAME']; ?>";</script>  
        <script type="text/javascript" src="/LoginProject/dist/js/app.js"></script>
        <script type="text/javascript" src="/LoginProject/dist/js/routes.js"></script>
        <script type="text/javascript" src="/LoginProject/dist/js/controllers.js"></script>
        <script type="text/javascript" src="/LoginProject/dist/js/services.js"></script>
        <script type="text/javascript" src="/LoginProject/dist/js/directives.js"></script>
       
    </head>
    
    <body id="container">
        
        
        <style>
            *{
                margin:0px;
                padding:0px;
                list-style-type: none;
            }
            
            body{
                background-color: lightgrey;
            }
            
            #wrapper{
                width:100%;
                margin: 0 auto;
            }
            
            header{
                width:100%;
                height: 50px;
                background-color: steelblue;
            }
            
            #welcome{
                padding:10px;
                color:white;
                
            }
            
            #navbar{
                width:auto;
                height: 30px;
                background-color: white;
                
                padding-top: 5px;
            }
            
            #navbar li{
                display: inline;
                float: right;
                padding-right: 20px;
                color: black;
            }
            
            #navbar a{
                color: black;
                text-decoration: none;
            }
            

            #content{
                width:100%;
                height: 100%;
                background-color: lightgrey;
            }
            #userPosts{
                overflow: hidden;
                width:750px;
                height:auto;
                background-color:white;
                
                position: relative;
                left: 50%;
                transform: translate(-50%);
            }
            
            #postBar{
                position: relative;
                left: 50%;
                transform: translate(-50%);
                
            }
            
            #commentBar{
                display: block;
            }
            #profiles{
                margin: 20px;
                background-color:white;
                width: 500px;
                height: auto;
                position: relative;
                left: 50%;
                transform: translate(-50%);
            }


            
        </style>
        
        
        
        <div id = "wrapper">
            
            <header>
                <center>
                    <h2 id = "welcome">
                        Welcome to Zach New Home Connect
                     </h2>
                </center>
                 
                
            </header>
            
            <ul id="navbar">
                <li>
                    <a href = "<?php echo base_url();?>Auth/logout">Logout</a>
                </li>
                <li>
                    <a ng-href="#/">Feed</a>
                </li>
                <li>
                    <a ng-href="#/profile/<?php echo $_SESSION['USER_ID'] ?>">My Profile</a>
                </li>
            </ul>
            
                <div id="content">
                    <div ui-view></div>
                </div>
            
        </div>
    </body>

</html>