 //ui-router
       
        angular.module("nhc").config(function($stateProvider,
        $urlRouterProvider, $locationProvider) {
            $locationProvider.hashPrefix('');
            var views = "/LoginProject/dist/views/";
            
            $stateProvider
            .state('feed', {
                url: "/",
                controller: "postController",
                templateUrl: views + "feed.html"
            })
            .state('userProfile', {
                url: "/profile/:user_id/",
                controller: "profileController",
                resolve: {
                    user: function($stateParams, postService) {
                        var user_id = $stateParams.user_id;
                        var json = postService.getProfile(user_id);
                        
                        return (json);
                    }
                },
                templateUrl: views + "user.html"
            });
            
            // Trailing slash fix
            $urlRouterProvider.rule(function ($injector, $location) {
                var path = $location.url();
                // check to see if the path already has a slash where it should be
                if (path[path.length - 1] === '/' || path.indexOf('/?') > -1) { return; }
                if (path.indexOf('?') > -1) 
                { return path.replace('?', '/?'); }
                return path + '/';
            });
        });
        
        