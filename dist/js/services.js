        //angular models
        angular.module("nhc").service("postService", function($http, $q) {
            var baseUrl = "/LoginProject/Feed/";
            return {
                livePostsAndComments: function(datetime){
                    var d = $q.defer();
                    var url = baseUrl + "postsAndComments_get/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            datetime: datetime
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                listPosts: function() {
                    var d = $q.defer();
                    var url = baseUrl + "posts_get/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "GET"
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    });
                    return d.promise;
                },
                // listPostsByDateTime: function(datetime) {
                //     var d = $q.defer();
                //     var url = baseUrl + "postByDatetime_get/";
                //     var r = $http({
                //         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                //         url: url,
                //         method: "POST",
                //         data: $.param({
                //             datetime: datetime
                //         })
                //     }).then(function(res) {
                //         if(res) {
                //             var data = res.data;
                //             d.resolve(data);
                //         }
                //     })
                //     return d.promise;
                // },
                listPostsByUser: function(userID) {
                    var d = $q.defer();
                    var url = baseUrl + "postByUser_get/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            listpostuserid: userID
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                listProfilePostsByDateTime: function(userID, datetime){
                    var d = $q.defer();
                    var url = baseUrl + "profileFeedByDateTime_get/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            datetime: datetime,
                            profileid: userID
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                getProfile: function(userID) {
                    var d = $q.defer();
                    var url = "/LoginProject/Profile/profileByUser_get/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            profileid: userID
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                createPost: function(content) {
                    var d = $q.defer();
                    var url = baseUrl + "createPost/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            createpost: content
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                updatePost: function(postID, content) {
                    var d= $q.defer();
                    var url = baseUrl + "updateUserPost/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            updatepostid: postID,
                            updatepostcontent: content
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                deletePost: function(postID){
                    var d= $q.defer();
                    var url = baseUrl + "deleteUserPost/";
                    $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            deletepostid: postID,
                           
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                    
                },
                
                likePost: function(postID, userID) {
                    var d= $q.defer();
                    var url = baseUrl + "likeUserPost/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            likeuserid: userID,
                            likepostid: postID
                           
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                unlikePost: function(postID, userID){
                    var d= $q.defer();
                    var url = baseUrl + "unlikeUserPost/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            unlikeuserid: userID,
                            unlikepostid: postID
                           
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                commentOnPost: function(postID, userID, comment, fname, lname) {
                    var d= $q.defer();
                    var url = baseUrl + "addComment/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            commentuserid: userID,
                            commentpostid: postID,
                            comment: comment,
                            firstname: fname,
                            lastname: lname
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                getComments: function(postID) {
                    var d= $q.defer();
                    var url = baseUrl + "getComments/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            commentpostid: postID

                           
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                // getCommentsByDateTime: function(datetime) {
                //     var d= $q.defer();
                //     var url = baseUrl + "getCommentsByDateTime/";
                //     var r = $http({
                //         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                //         url: url,
                //         method: "POST",
                //         data: $.param({
                //             datetime:datetime
                           
                //         })
                //     }).then(function(res) {
                //         if(res) {
                //             var data = res.data;
                //             d.resolve(data);
                //         }
                //     })
                //     return d.promise;
                // },
                
                likeComment:function(commentID, userID){
                    var d= $q.defer();
                    var url = baseUrl + "likeComment/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            likecommentid: commentID,
                            likecommentuserid: userID
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                },
                
                unlikeComment:function(commentID, userID){
                    var d= $q.defer();
                    var url = baseUrl + "unlikeComment/";
                    var r = $http({
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: url,
                        method: "POST",
                        data: $.param({
                            unlikecommentid: commentID,
                            unlikecommentuserid: userID
                        })
                    }).then(function(res) {
                        if(res) {
                            var data = res.data;
                            d.resolve(data);
                        }
                    })
                    return d.promise;
                }
                
                
                
                
            };
        });