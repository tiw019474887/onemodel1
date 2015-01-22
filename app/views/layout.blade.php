<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Starter Template for Bootstrap</title>

        <!-- Bootstrap core CSS -->
        <link href="/thirdparty/bootstrap3/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/thirdparty/bootstrap3/css/bootstrap-theme.min.css" rel="stylesheet">

        <style>
            body {
                padding-top: 60px;
            }
        </style>

        @yield('css')

    </head>

    <body>

    <span us-spinner="{radius:30, width:8, length: 16}"></span>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/admin/home">Admin Home</a></li>
                        <li><a href="/admin/user">User</a></li>
                        <li><a href="/admin/faculty">Faculty</a></li>
                        <li><a href="/admin/api">Api</a></li>
                        <li><a href="/admin/research-project">Research Project</a></li>
                        <li><a href="/admin/researcher">Researcher</a></li>
                        <li><a href="/admin/news">News</a></li>
                    </ul>
                    <div id="mainApp" ng-controller="currentUserController">
                    <ul class="nav navbar-nav navbar-right" ng-if="user!==null">

                         <li>
                         <a href="#" style="padding: 0px 0px 0px 0px;">
                            <img ng-if="user.profile_image" style="width:50px; height: 50px;" ng-src="{{user.profile_image.url}}"/>
                            <img ng-if="!user.profile_image" style="" data-src="holder.js/50x50" holder-fix/>
                         </a>
                         </li>
                         <li>
                         <a href="/logout">{{user.email}}</a>
                         </li>
                    </ul>
                    </div>

                </div><!--/.nav-collapse -->

            </div>
        </nav>

        <div class="container">

            @yield('content')
        </div><!-- /.container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/thirdparty/jquery/jquery-2.1.1.min.js"></script>
        <script src="/thirdparty/holderjs/holder.js"></script>

        <script src="/thirdparty/angularjs/angular.min.js"></script>
        <script src="/thirdparty/angular-loading-spinner/angular-loading-spinner.js"></script>
        <script src="/thirdparty/angular-loading-spinner/spin.js"></script>
        <script src="/thirdparty/angular-loading-spinner/angular-spinner.min.js"></script>
        <script src="/thirdparty/angular-base64-upload/dist/angular-base64-upload.min.js"></script>
        <script src="/thirdparty/angular-bootstrap/ui-bootstrap-tpls-0.12.0.min.js"></script>
        <script src="/thirdparty/bootstrap3/js/bootstrap.min.js"></script>
        <script src="/js/modules/AlertModule.js"></script>

        <script>

            var mainApp = angular.module('mainApp',['ngLoadingSpinner']);

            mainApp.controller('currentUserController',function($scope,$http) {

                $scope.user = null;

                $scope.init = function() {
                    $http.get('/current-user').success(function(response){
                        $scope.user = response.data;
                    })
                }

                $scope.init();
                });

            angular.bootstrap($("#mainApp"),['mainApp']);

        </script>


        @yield('js')



    </body>
</html>
