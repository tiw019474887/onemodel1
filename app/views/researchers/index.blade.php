@extends('layout')

@section('content')
<div ng-app="ResearcherManagement" ng-controller="ResearcherController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>


    <div id="researcher-form" ng-if="isAddOrEdit != null">

        <div class="form-header" style="padding-bottom: 40px;">
            <h3 ng-if="isAddOrEdit === 'Add'">Add Researcher</h3>
            <h3 ng-if="isAddOrEdit === 'Edit'">Edit Researcher</h3>
        </div>

        <form class="form-horizontal" role="form" action="/admin/user/create" method="post">
            <formset>
                <legend>
                    <h4>Researcher Basic Information</h4>
                </legend>

                <?php echo Form::token(); ?>

                <div class="form-group">
                    <label for="researcher-title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input ng-model="researcher.title" type="text" class="form-control" placeholder="Title">
                    </div>
                </div>

                <div class="form-group">
                    <label for="researcher-firstname" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                        <input ng-model="researcher.firstname" type="text" class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="researcher-lastname" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                        <input ng-model="researcher.lastname" type="text" class="form-control" placeholder="Last Name">
                    </div>
                </div>

            </formset>

            <formset>

                <legend>Advance Information</legend>

                <div class="form-group">
                    <label for="researcher-profile-image" class="col-sm-2 control-label">Profile Image</label>
                    <div class="col-sm-10">
                        <input type="button" style="margin-bottom: 20px;" class="btn btn-primary" ng-click="selectImage()" value="Select Image..."/>
                        <input id="file" style="display: none;" type="file" ng-model="researcher.profile_image" name="file" base-sixty-four-input>
                        <br/>
                        <img ng-show="researcher.profile_image.url" style="width:200px;height: 200px;" src="{{researcher.profile_image.url}}" alt="">
                        <img ng-show="researcher.profile_image.base64" style="width:200px;height: 200px;" ng-src="data:{{researcher.profile_image.filetype}};base64,{{researcher.profile_image.base64}}" alt="">
                        <img ng-hide="researcher.profile_image.filename" data-src="holder.js/200x200" holder-fix/>
                    </div>
                </div>

            </formset>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" ng-click="submitForm()" class="btn btn-primary">Submit</button>
                    <button ng-model="image" ng-click="closeForm()" type="button" class="btn btn-default">Cancel</button>
                </div>
            </div>

        </form>
    </div>

    <div id="researcher-table" ng-if="isAddOrEdit == null">

        <h3>Researcher Table</h3>

        <button ng-click="showAddForm()" type="button" class="btn btn-primary">Add Researcher</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>

                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="researcher in researchers">
                    <td>
                        {{researcher.title}} {{researcher.firstname}} {{researcher.lastname}}
                    </td>

                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" ng-click="view(researcher)"class="btn btn-primary">View</button>
                            <button type="button" ng-click="showEditForm(researcher)" class="btn btn-default">Edit</button>
                            <button type="button" ng-click="delete(researcher)" class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>


</div>

@stop


@section('js')
<script src="/js/services/ResearcherServices.js" type="text/javascript"></script>
<script type="text/javascript">

var app = angular.module('ResearcherManagement', ['ResearcherServices', 'naif.base64','ngLoadingSpinner']);

app.controller('ResearcherController', function ($scope, Researcher) {
    console.log("ResearcherController Start...");

    $scope.isAddOrEdit = null;

    $scope.researchers = {};
    $scope.researcher = {};


    $scope.init = function () {
        Researcher.get().success(function (response) {
            $scope.researchers = response.data;
        })
    };

    $scope.showAddForm = function () {
        $scope.isAddOrEdit = 'Add';
        $scope.researcher = {};
        $scope.researcher.profileImage = {}
    }

    $scope.showEditForm = function (researcher) {
        $scope.isAddOrEdit = 'Edit';
        $scope.researcher = researcher;

        if (!$scope.researcher.profile_image) {
            $scope.researcher.profile_image = {}
        }
    }

    $scope.submitForm = function () {
        console.log($scope.researcher);

        Researcher.save($scope.researcher).success(function (response) {
            if (response.success) {
                $scope.closeForm();
                $scope.init();
            }
        });
    }

    $scope.delete = function (researcher) {
        deleteStr = "Do you want to delete this user [" + researcher.title + " " + researcher.firstname + " " + researcher.lastname + "]?";
        if (confirm(deleteStr)) {
            Researcher.delete(researcher).success(function (response) {
                if (response.success) {
                    $scope.init();
                }
            });
        }
    }

    $scope.view = function (researcher) {
        alert("This function hasn't implement yet.");
    }

    $scope.closeForm = function () {
        $scope.isAddOrEdit = null;
    }

    $scope.init();

    $scope.selectImage = function () {
        $("#file").click();
    }

});

app.directive('holderFix', function () {
    return {
        link: function (scope, element, attrs) {
            Holder.run({images: element[0], nocss: true});
        }
    };
});
</script>
@stop