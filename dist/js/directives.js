// E <profile-info></profile-info>
// A <div profile-info></div>
// C <div class="profile-info"></div>

// <profile-info user="user[0]"></profile-info>
// <profile-info user-id=""></profile-info>

angular.module("nhc")
.directive("profileFeed", function(postService) {
   return{
       restrict: "E",
       scope: true,
       controller: "postController",
       template: "<ul ng-init='liveProfile(user[0].USER_ID);' ><li ng-repeat='post in posts' id = 'profilePosts'><h3 id ='profileEmail'> {{post.EMAIL}}: {{post.POST}}</h3>" + //lists the Users email and the post post in posts
                 "<input type='submit' name='submitLike' ng-show = '!post.IS_LIKED' ng-click='likePost(post);' value = 'Like'/> " + //like button
                 "<input type='submit' name='submitUnlike' ng-show = 'post.IS_LIKED' ng-click='unlikePost(post);' value = 'Unlike'/>" + //unlike button
                 "<input id = 'commentBar' type = 'text' name = 'commentonpost'  ng-model = 'commentedPost' placeholder = 'Enter a comment'/>" + //comment input
                 "<input type = 'submit' name = 'submitComment'  ng-click = 'commentOnPost(post, commentedPost);' value = 'Comment'/>" + //comment submit
                 "<comments id = 'comments' comments = 'post.COMMENTS'></comments></li></ul>", //comments
       link: function(scope, element, attrs) {
           var el = element;
           var user_id = attrs['userId'];
           
        //   scope.liveProfile(user_id);
           
          postService.listPostsByUser(user_id)
          .then(function(posts) {
                scope.posts = posts;
          });
           
       }
       
       
   } 
})
.directive("comments", function(postService) {
  return{
      restrict:"E",
      scope: {"comments": "="
      },
      controller: "postController",
      template: "<ul><li ng-repeat = 'comment in comments'><p>{{comment.USER_FIRST_NAME}} {{comment.USER_LAST_NAME}}: {{comment.USER_COMMENT}}</p>"+ //comment
                "<input type='submit' name='submitCommentLike' ng-show = '!comment.IS_COMMENT_LIKED' ng-click='likeComment(comment);' value = 'Like Comment'/>" + //like comment
                "<input type='submit' name='submitCommentUnlike' ng-show = 'comment.IS_COMMENT_LIKED' ng-click='unlikeComment(comment)' value = 'Unlike Comment'/> " + // unlike comment
                "<strong><p>Likes: {{comment.LIKES}}</p></strong> <li><ul>", //amount of likes
      link: function(scope, element, attrs) {
          var el = element;
          var post_id = attrs['postId'];
           
      }
  } 
});