@extends('layout')

@section('content')


<div ng-app="LoginManagement" ng-controller="LoginController">

    <div>
        <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
    </div>


    <span us-spinner="{radius:30, width:8, length: 16}"></span>

    <div id="login-form">

        <form ng-submit="submitForm()" class="form-horizontal" role="form" action="/login" method="post">
            <formset>
                <?php echo Form::token(); ?>
                <div class="form-group">
                    <label for="login-email" class="col-sm-2 control-label">email</label>
                    <div class="col-sm-5">
                        <input ng-model="login.email" type="text" class="form-control" name="email" placeholder="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="login-password" class="col-sm-2 control-label">password</label>
                    <div class="col-sm-5">
                        <input ng-keyup="$event.keyCode == 13 ? submitForm() : null" ng-model="login.password" type="password" name="password" class="form-control" placeholder="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-5">
                        <button type="button" ng-click="submitForm()" class="btn btn-primary">Submit</button>
                        <button ng-click="closeForm()" type="button" class="btn btn-default">Cancel</button>
                    </div>
                </div>
            </formset>
        </form>
    </div>

@stop


@section('js')


<script type="text/javascript">

    var app = angular.module('LoginManagement',['ngLoadingSpinner','ui.bootstrap']);

    app.controller('LoginController', function ($scope,$timeout,$http,$window) {
        console.log("LoginController Start...");

        $scope.login = {};

        $scope.submitForm = function(){
            $http({
                method : 'post',
                url : '/login',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data : $.param($scope.login)
            }).success(function(response){
                console.log(response);
                if(response.success == true){
                    $window.location='/admin';
                }else {
                    $scope.addAlert('Username or Password is invalid.','danger');
                }

            })
            //
        }

        $scope.closeForm = function(){
            $scope.login = {};

        }

        $scope.alerts = [];
        $scope.closeAlert = function(index) {
            $scope.alerts.splice(index, 1);
        }

        $scope.addAlert = function(msg,type) {
            $scope.alerts.push({msg: msg,type : type});
            $timeout(function(){
                $scope.alerts.splice(0, 1);
            }, 3000);
        };

    });


</script>


@stop
