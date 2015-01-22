@extends('layout')

@section('content')

<div ng-app="UserManagement" ng-controller="UserController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>
    <div>
        <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
    </div>


    <div id="user-form" ng-if="isAddOrEdit != null">


        <form class="form-horizontal" role="form" action="/admin/user/create" method="post">
            <formset>
                <legend>
                    <h3 ng-if="isAddOrEdit === 'Add'">Add User</h3>
                    <h3 ng-if="isAddOrEdit === 'Edit'">Edit User</h3>
                </legend>

                <?php echo Form::token(); ?>
                <div class="form-group">
                    <label ng-readonly="isAddOrEdit === 'Edit'" for="user-email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input ng-model="user.email" type="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user-password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input ng-model="user.password" type="password" class="form-control"  placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="user-verifypassword" class="col-sm-2 control-label">Verify Password</label>
                    <div class="col-sm-10">
                        <input ng-model="user.verifypassword" type="password" class="form-control"  placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="user-title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input ng-model="user.title" type="text" class="form-control" placeholder="Title">
                    </div>
                </div>

                <div class="form-group">
                    <label for="user-firstname" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                        <input ng-model="user.firstname" type="text" class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user-lastname" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                        <input ng-model="user.lastname" type="text" class="form-control" placeholder="Last Name">
                    </div>
                </div>


            </formset>

            <formset>

            <legend>Advance Information</legend>

            <div class="form-group">
                <label for="user-profile-image" class="col-sm-2 control-label">Profile Image</label>
                <div class="col-sm-10">
                    <input type="button" style="margin-bottom: 20px;" class="btn btn-primary" ng-click="selectImage()" value="Select Image..."/>
                    <input id="file" style="display: none;" type="file" ng-model="user.profile_image" name="file" base-sixty-four-input>
                    <br/>
                    <img ng-show="user.profile_image.url" style="width:200px;height: 200px;" src="{{user.profile_image.url}}" alt="">
                    <img ng-show="user.profile_image.base64" style="width:200px;height: 200px;" ng-src="data:{{user.profile_image.filetype}};base64,{{user.profile_image.base64}}" alt="">
                    <img ng-hide="user.profile_image.filename" data-src="holder.js/200x200" holder-fix/>
                </div>
            </div>

        </formset>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" ng-click="submitForm()" class="btn btn-primary">Submit</button>
                    <button ng-click="closeForm()" type="button" class="btn btn-default">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div id="user-table" ng-if="isAddOrEdit == null">

        <h3>User Table</h3>

        <button ng-click="showAddForm()" type="button" class="btn btn-primary">Add User</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="user in users">
                    <td>
                        {{user.title}} {{user.firstname}} {{user.lastname}}
                    </td>
                    <td>
                        {{user.email}}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" ng-click="view(user)"class="btn btn-primary">View</button>
                            <button type="button" ng-click="showEditForm(user)" class="btn btn-default">Edit</button>
                            <button type="button" ng-click="delete(user)" class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>


</div>
@stop


@section('js')

<script type="text/javascript" src="/js/services/UserServices.js"></script>

<script type="text/javascript">

    var app = angular.module('UserManagement', ['ngLoadingSpinner','ui.bootstrap','UserServices','naif.base64']);

    app.controller('UserController', function ($scope, $timeout, User) {
        console.log("UserController Start...");

        $scope.isAddOrEdit = null;

        $scope.users = {};
        $scope.user = {};


        $scope.init = function () {
            User.get().success(function (response) {
                $scope.users = response.data;
            })
        };

        $scope.showAddForm = function () {
            $scope.isAddOrEdit = 'Add';
            $scope.user = {};
        }

        $scope.showEditForm = function (user) {
            $scope.isAddOrEdit = 'Edit';
            $scope.user = user;
        }

        $scope.submitForm = function () {
            User.save($scope.user).success(function (response) {
                if (response.success) {
                    $scope.closeForm();
                    $scope.init();
                }else {

                    console.log(response);
                    $scope.addAlert(response.message,'danger');
                }
            });
        }

        $scope.delete = function (user) {
            deleteStr = "Do you want to delete this user [" + user.title + " " + user.firstname + " " + user.lastname + "]?";
            if (confirm(deleteStr)) {
                User.delete(user).success(function (response) {
                    if (response.success) {
                        $scope.init();
                    }
                });
            }
        }

        $scope.view = function (user) {
            alert("This function hasn't implement yet.");
        }

        $scope.closeForm = function () {
            $scope.isAddOrEdit = null;
        }

        $scope.init()

        $scope.selectImage = function () {
            $("#file").click();
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