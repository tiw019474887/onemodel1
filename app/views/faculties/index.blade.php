l@extends('layout')

@section('content')

<div ng-app="FacultyManagement" ng-controller="FacultyController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>


    <div id="faculty-form" ng-if="isAddOrEdit !== null">


        <form class="form-horizontal" role="form" action="/admin/faculty/create" method="post">
            <formset>
                <legend>
                    <h3 ng-if="isAddOrEdit === 'ADD'">Add Faculty</h3>
                    <h3 ng-if="isAddOrEdit === 'EDIT'">Edit Faculty</h3>
                </legend>

                <?php echo Form::token(); ?>
                <div class="form-group">
                    <label for="faculty-name-en" class="col-sm-2 control-label">Name English</label>
                    <div class="col-sm-10">
                        <input ng-model="faculty.name_en" type="text" class="form-control" placeholder="Name English">
                    </div>
                </div>
                <div class="form-group">
                    <label for="faculty-name-th" class="col-sm-2 control-label">Name Thai</label>
                    <div class="col-sm-10">
                        <input ng-model="faculty.name_th" type="text" class="form-control" placeholder="ชื่อภาษาไทย">
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

    <div id="faculty-table" ng-if="isAddOrEdit === null">

        <h3>Faculty Table</h3>

        <button ng-click="showAddForm()" type="button" class="btn btn-primary">Add Faculty</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name English</th>
                    <th>Name Thai</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="faculty in faculties">
                    <td>
                        {{faculty.name_en}}
                    </td>
                    <td>
                        {{faculty.name_th}}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" ng-click="view(faculty)"class="btn btn-primary">View</button>
                            <button type="button" ng-click="showEditForm(faculty)" class="btn btn-default">Edit</button>
                            <button type="button" ng-click="delete(faculty)" class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>


</div>

@stop


@section('js')
<script src="/js/services/FacultyServices.js" type="text/javascript"></script>

<script type="text/javascript">

    var app = angular.module('FacultyManagement', ['FacultyServices','ngLoadingSpinner']);

    app.controller('FacultyController', function ($scope, Faculty) {

        console.log("FacultyController Start...");

        $scope.isAddOrEdit = null;

        $scope.faculty = {};
        $scope.faculties = [];

        $scope.showAddForm = function () {
            $scope.isAddOrEdit = 'ADD';
            $scope.faculty = {};
        }

        $scope.closeForm = function () {
            $scope.isAddOrEdit = null;
        }

        $scope.submitForm = function () {
            console.log($scope.faculty);

            Faculty.save($scope.faculty).success(function (response) {
                console.log(response);
                $scope.closeForm();
                $scope.init();
            });
        }

        $scope.init = function () {
            Faculty.get().success(function (response) {
                $scope.faculties = response.data;
            })
        }
        $scope.showEditForm = function (faculty) {
            $scope.isAddOrEdit = 'EDIT';
            $scope.faculty = faculty;
        }
        $scope.delete = function (faculty) {
            deleteStr = "Do you want to delete this user [" + faculty.name_en + " " + faculty.name_th + "]?";
            if (confirm(deleteStr)) {
                Faculty.delete(faculty).success(function (response) {
                    if (response.success) {
                        $scope.init();
                    }
                });
            }
        }

        $scope.init();

    });


</script>
@stop
