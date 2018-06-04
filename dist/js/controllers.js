 //angular controller
        angular.module("nhc").controller("profileController", function($scope, user) {
            $scope.user = user;
        });
        
        
        
        
        
        
        
        
        
        
//angular controlelrs

        angular.module("nhc").controller("postController", function($scope, $interval, postService) {
            $scope.posts = [];
            $scope.showLike = false;
            $scope.showDelete = false;
            $scope.showEdit = false;
            $scope.isLiked = false;
            $scope.showComments = false;
            $scope.dateTime = moment().utc().format("YYYY-MM-DD HH:mm:ss");
            
            // $scope.live = function() {
            //     var stop = $interval(function() {
                    
            //         postService.listPostsByDateTime($scope.dateTime)
            //         .then(function(res) {
            //             console.log(res);
            //             $scope.dateTime = moment().utc().format("YYYY-MM-DD HH:mm:ss");
            //             if(res.length>0 && res!='0'){
            //               for(var i = 0; i<res.length; i++){
            //                 var isInArray = false;
            //                 var t = {};
            //                 t= res[i];
            //                 for(var x = 0; x<$scope.posts.length; x++){
            //                     if($scope.posts[x].USER_POST_ID == t.USER_POST_ID){
            //                         isInArray = true;
            //                         break;
            //                     }
            //                     else{
                                    
            //                     }
            //                 }
            //                 if(!isInArray){
            //                     $scope.posts.unshift(t);
            //                 }
                            
            //             }  
            //             }
                        
            //             // $scope.getAllPosts();
            //     });
            //     }, 5000);  
            // };
            
            $scope.liveProfile = function(userID) {
                // var userID = userID;
                var stop = $interval(function() {
                    
                    postService.listProfilePostsByDateTime(userID, $scope.dateTime)
                    .then(function(res) {
                        console.log(res);
                        $scope.dateTime = moment().utc().format("YYYY-MM-DD HH:mm:ss");
                        if(res.length>0 && res!='0'){
                            
                           for(var i = 0; i<res.length; i++){
                            var isInArray = false;
                            var t = {};
                            t= res[i];
                            for(var x = 0; x<$scope.posts.length; x++){
                                if($scope.posts[x].USER_POST_ID == t.USER_POST_ID){
                                    isInArray = true;
                                    break;
                                }
                                else{
                                    
                                }
                            }
                            if(!isInArray){
                                $scope.posts.unshift(t);
                            }
                            
                        } 
                        }
                        
                        // $scope.getAllPosts();
                });
                }, 5000);  
                
            };
            
            $scope.getAllPosts = function() {
                postService.listPosts().then(function(posts) {
                    $scope.posts = posts;    
                });
            };
            
            $scope.postContent = "";
            $scope.createPost = function() {
                var content = $scope.postContent;
                postService.createPost(content)
                .then(function(res) {
                    console.log(res);
                    var t = {};
                    t.EMAIL = _EMAIL;
                    t.POST = content;
                    $scope.posts.push(t);
                    
                    $scope.getAllPosts();
                });
                
            };
            
            
            $scope.updatePost = function(updatedContent, updatePostID){
                var content = updatedContent;
                var postID = updatePostID;
                for(var i = 0; i<$scope.posts.length; i++){
                        if($scope.posts[i].USER_POST_ID == updatePostID){
                            if(_EMAIL == $scope.posts[i].EMAIL){
                                postService.updatePost(postID, content)
                                .then(function(res){
                                     console.log(res);
                                     var posts = $scope.posts;
                                     
                                     for(var i = 0; i<posts.length; i++){
                                        if($scope.posts[i].USER_POST_ID == updatePostID){
                                            $scope.posts[i].POST=updatedContent; 
                                        }
                                    }
                                    $scope.getAllPosts();    
                                });
                            }
                        }
                    }
                
                
            };
            
            
            $scope.deletePost = function(deletePostID){
                  var postID = deletePostID;
                  for(var i = 0; i<$scope.posts.length; i++){
                        if($scope.posts[i].USER_POST_ID == deletePostID){
                            if(_EMAIL == $scope.posts[i].EMAIL){
                                postService.deletePost(postID)
                                  .then(function(res){
                                    console.log(res);
                                    var posts = $scope.posts;
                                    
                                    for(var i = 0; i<posts.length; i++){
                                        if($scope.posts[i].USER_POST_ID == deletePostID){
                                            delete $scope.posts[i];
                                        }
                                    }
                                   $scope.getAllPosts();
                                });
                            }
                        }
                    }
                  
                 
            };
            
            $scope.likePost = function (post){
                var postID = post.USER_POST_ID;
                var userID = _USERID;

                post.IS_LIKED = true;
                post.LIKES++;
                postService.likePost(postID, userID)
                .then(function(res){
                     console.log(res);
                    //   $scope.getLikes(likePostID);

                });
               
            };
            
            $scope.unlikePost = function (post){
                var postID = post.USER_POST_ID;
                var userID = _USERID;
                post.IS_LIKED = false;
                post.LIKES--;
                postService.unlikePost(postID, userID)
                .then(function(res){
                     console.log(res);
                     //$scope.getLikes(unlikePostID);
            
                     
                });
                
            };
            
            $scope.commentOnPost = function (post, comment){
                var postID = post.USER_POST_ID;
                var userID = _USERID;
                var comment = comment;
                var firstname = _FIRSTNAME;
                var lastname = _LASTNAME;
                var likes =0;
                postService.commentOnPost(postID, userID, comment, firstname, lastname)
                .then(function(res){
                     console.log(res);
                     if(!post.COMMENTS){
                         post.COMMENTS = [];
                     }
                     var temp = {};
                     temp.USER_ID = userID;
                     temp.USER_POST_ID = postID;
                     temp.USER_COMMENT = comment;
                     temp.USER_FIRST_NAME = firstname;
                     temp.USER_LAST_NAME = lastname;
                     temp.COMMENT_ID = res;
                     temp.LIKES = likes;
                     post.COMMENTS.push(temp);
                     
                     
                });
                
            }
            
            $scope.likeComment = function (comment){
                var commentID = comment.COMMENT_ID;
                var userID = _USERID;
                comment.IS_COMMENT_LIKED = true;
                comment.LIKES++;
                
                postService.likeComment(commentID, userID)
                .then(function(res){
                   console.log(res); 
                    
                });
            }
            
            $scope.unlikeComment = function (comment){
                var commentID = comment.COMMENT_ID;
                var userID = _USERID;
                comment.IS_COMMENT_LIKED = false;
                comment.LIKES--;
                
                postService.unlikeComment(commentID, userID)
                .then(function(res){
                   console.log(res); 
                    
                });
            }
            
            // $scope.liveComments = function(){
            //     var stop = $interval(function() {
            //         postService.getCommentsByDateTime($scope.dateTime)
            //         .then(function(res) {
            //             console.log(res);
            //             $scope.dateTime = moment().utc().format("YYYY-MM-DD HH:mm:ss");
                        
            //             if(res.length>0 && res!='0'){
            //                 for(var i = 0; i<res.length; i++){
            //                     var t = {};
            //                     t= res[i];
            //                     var len = angular.copy($scope.posts).length;
            //                     var isInArray = false;
            //                     for(var x = 0; x<len; x++){
            //                         if($scope.posts[x].USER_POST_ID == t.USER_POST_ID){
            //                             if(!$scope.posts[x].COMMENTS){
            //                                  $scope.posts[x].COMMENTS = [];
            //                             }
            //                             var comments = angular.copy($scope.posts[x].COMMENTS);
            //                             for(var y = 0; y<comments.length; y++){
            //                                 console.log(t.COMMENT_ID + ": " + comments[y].COMMENT_ID);
            //                                 if(t.COMMENT_ID == comments[y].COMMENT_ID){
                                                
            //                                     isInArray = true;
            //                                     break;
            //                                 }
            //                             } 
                                        
            //                             if(!isInArray){
            //                                 $scope.posts[x].COMMENTS.push(t);
            //                             }
            //                         }
                                    
                                    
            //                     }
                                
                                
                                
                            
            //             } 
            //             }
                        
            //             // $scope.getAllPosts();
            //     });
            //     }, 5000);
            // }
            
            $scope.livePostsAndComments = function(){
                var stop = $interval(function() {
                    postService.livePostsAndComments($scope.dateTime)
                    .then(function(res) {
                        console.log(res);
                        $scope.dateTime = moment().utc().format("YYYY-MM-DD HH:mm:ss");
                        
                        //beginning of getting live comments
                        if(res.comments.length>0 && res!='0'){
                            for(var i = 0; i<res.comments.length; i++){
                                var t = {};
                                t= res.comments[i];
                                var len = angular.copy($scope.posts).length;
                                var isInArray = false;
                                for(var x = 0; x<len; x++){
                                    if($scope.posts[x].USER_POST_ID == t.USER_POST_ID){
                                        if(!$scope.posts[x].COMMENTS){
                                             $scope.posts[x].COMMENTS = [];
                                        }
                                        var comments = angular.copy($scope.posts[x].COMMENTS);
                                        for(var y = 0; y<comments.length; y++){
                                            console.log(t.COMMENT_ID + ": " + comments[y].COMMENT_ID);
                                            if(t.COMMENT_ID == comments[y].COMMENT_ID){
                                                
                                                isInArray = true;
                                                break;
                                            }
                                        } 
                                        
                                        if(!isInArray){
                                            $scope.posts[x].COMMENTS.push(t);
                                        }
                                    }
                                    
                                    
                                }
                            } 
                        }//end of getting live comments
                        
                        //beginning of live posts
                        if(res.posts.length>0 && res!='0'){
                           for(var i = 0; i<res.posts.length; i++){
                            var isInArray = false;
                            var t = {};
                            t= res.posts[i];
                            for(var x = 0; x<$scope.posts.length; x++){
                                if($scope.posts[x].USER_POST_ID == t.USER_POST_ID){
                                    isInArray = true;
                                    break;
                                }
                                else{
                                    
                                }
                            }
                            if(!isInArray){
                                $scope.posts.unshift(t);
                            }
                            
                        }  
                        }//end of live posts
                        
                });
                }, 5000);
            }


            
        })
        