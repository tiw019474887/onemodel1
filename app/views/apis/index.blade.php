@extends('layout')

@section('content')

<div ng-app="ApiManagement" ng-controller="ApiController">

    <span us-spinner="{radius:30, width:8, length: 16}"></span>
    <div id="api-form" ng-if="isAddOrEdit !== null">


        <form class="form-horizontal" role="form" action="/admin/api/create" method="post">
            <formset>
                <legend>
                    <h3 ng-if="isAddOrEdit === 'ADD'">Add Api</h3>
                    <h3 ng-if="isAddOrEdit === 'EDIT'">Edit Api</h3>
                </legend>

                <?php echo Form::token(); ?>
                <div class="form-group">
                    <label for="api-key" class="col-sm-2 control-label">Key</label>
                    <div class="col-sm-10">
                        <input ng-model="api.key" type="text" class="form-control" placeholder="Key">
                    </div>
                </div>
                <div class="form-group">
                    <label for="api-status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input ng-model="api.status" type="text" class="form-control" placeholder="Status">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" ng-click="submitForm()" class="btn btn-primary">Submit</button>
                        <button ng-click="closeForm()" type="button" class="btn btn-default">Cancel</button>
                    </div>
                </div>
            </formset>
        </form>
    </div>

    <div id="api-table" ng-if="isAddOrEdit === null">

        <h3>Api Table</h3>

        <button ng-click="generateApi()" type="button" class="btn btn-primary">Generate New Api</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Status</th>

                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="api in apis">
                    <td>
                        {{api.key}}
                    </td>
                    <td>
                        {{api.status}}

                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" ng-click="delete(api)" class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>


</div>

@stop


@section('js')

<script type="text/javascript">

    var app = angular.module('ApiManagement', ['ngLoadingSpinner']);

    app.factory('ApiService', function ($http) {
        return {
            get: function () {
                return $http.get('/api/apis');
            },
            save: function (api) {
                return $http({
                    url: '/api/apis/save',
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(api)
                });
            },
            delete: function (api) {
                return $http({
                    method: 'POST',
                    url: '/api/apis/delete',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(api)
                });
            },
            generate: function () {
                return $http.post('/api/apis/generate');
            }
        }
    });

    app.controller('ApiController', function ($scope, ApiService) {

        console.log("ApiController Start...");

        $scope.isAddOrEdit = null;

        $scope.api = {};
        $scope.apis = [];

        $scope.showAddForm = function () {
            $scope.isAddOrEdit = 'ADD';
        }

        $scope.showEditForm = function (api) {
            $scope.isAddOrEdit = 'EDIT';
            $scope.api = api;
        }

        $scope.generateApi = function () {
            ApiService.generate().success(function (response) {
                $scope.init();
            })
        }

        $scope.closeForm = function () {
            $scope.isAddOrEdit = null;
        }

        $scope.submitForm = function () {
            console.log($scope.api);

            ApiService.save($scope.api).success(function (response) {
                console.log(response);
                $scope.closeForm();
                $scope.init();
            });
        }
        $scope.delete = function (api) {
            deleteStr = "Do you want to delete this api [" + api.key + " " + api.status + "]?";
            if (confirm(deleteStr)) {
                ApiService.delete(api).success(function (response) {
                    if (response.success) {
                        $scope.init();
                    }
                });
            }
        }
        $scope.init = function () {
            ApiService.get().success(function (response) {
                $scope.apis = response.data;
            })
        }

        $scope.init();

    });


</script>
@stop