@extends('layout')

@section('content')

<div ng-app="ResearchProjectManagement" ng-controller="ResearchProjectController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>

    <div id="research-project-form" ng-show="isAddOrEdit !== null">

        <div class="form-header" style="padding-bottom: 40px;">
            <h3 ng-if="isAddOrEdit === 'ADD'">Add ResearchProject</h3>
            <h3 ng-if="isAddOrEdit === 'EDIT'">Edit ResearchProject</h3>
        </div>


                <form class="form-horizontal" role="form" action="/admin/research-project/create" method="post">
                    <formset>
                        <legend>
                            <h4>Research Project Basic Information</h4>
                        </legend>

                        <?php echo Form::token(); ?>
                        <div class="form-group">
                            <label for="research-project-name-en" class="col-sm-2 control-label">Name English</label>
                            <div class="col-sm-10">
                                <input ng-model="researchProject.name_en" type="text" class="form-control" placeholder="Name English">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="research-project-name-th" class="col-sm-2 control-label">Name Thai</label>
                            <div class="col-sm-10">
                                <input ng-model="researchProject.name_th" type="text" class="form-control" placeholder="ชื่อภาษาไทย">
                            </div>
                        </div>


                    </formset>

                    <formset>
                        <legend><h4>Research Project's Researcher</h4></legend>

                        <div class="form-group">
                            <label for="researchers" class="col-sm-2 control-label">Researchers</label>
                            <div class="col-sm-10">
                                <input ng-model="researcherAdd" typeahead-loading="loadingResearcher"
                                       typeahead-on-select="researcherAddEvent(researcherAdd); researcherAdd='';  "
                                       typeahead="researcher as researcher.title +''+ researcher.firstname +' '+ researcher.lastname for researcher in searchResearcher($viewValue) | filter : {firstname:$viewValue}"
                                       type="text" class="form-control" placeholder="ผู้วิจัย">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>

                            <div class="col-sm-10">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Researcher's Name</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <tr ng-repeat="researcher in researchProject.researchers">
                                            <td>
                                                {{researcher.title}}{{researcher.firstname}} {{researcher.lastname}}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" ng-click="removeResearcher(researcher)" class="btn btn-primary">Delete</button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr ng-hide="researchProject.researchers.length > 0">
                                            <td colspan="2">No data</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>บทสรุปผู้บริหาร (Executive Summary)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <textarea ng-model="researchProject.executive_summary" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>พื้นที่ที่ดำเนินการ (Area of Operations)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input ng-model="researchProject.area_operation" type="text" class="form-control"/>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>บริบทของพื้นที่ (Area's Context)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <textarea ng-model="researchProject.area_context" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>วัตถุประสงค์ (Objectives)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <textarea ng-model="researchProject.objectives" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>วิธีดำเนินการหรือกิจกรรม (Procedures)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <textarea ng-model="researchProject.procedures" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </formset>
                    <formset>
                        <legend>ผลการดำเนินงานโครงการ (Results of Operations)</legend>
                        <div class="form-group">
                            <label for="research-project-area-result" class="col-sm-2 control-label">ผลกระทบที่เกิดขึ้นกับชุมชนและพื้นที่</label>
                            <div class="col-sm-10">
                                <textarea ng-model="researchProject.result_area" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="research-project-researcher-result" class="col-sm-2 control-label">ผลกระทบที่เกิดขึ้นกับนักวิจัย</label>
                            <div class="col-sm-10">
                                <textarea ng-model="researchProject.result_researcher" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="research-project-student-result" class="col-sm-2 control-label">ผลกระทบที่เกิดขึ้นกับนิสิต</label>
                            <div class="col-sm-10">
                                <textarea ng-model="researchProject.result_student" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </formset>

                    <formset>
                        <legend>กิตติกรรมประกาศ (Acknowledgement)</legend>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <textarea ng-model="researchProject.acknowledgement" class="form-control" rows="5"></textarea>
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
    <div id="research-project-table" ng-show="isAddOrEdit === null">

        <h3>Research Project Table</h3>

        <button ng-click="showAddForm()" type="button" class="btn btn-primary">Add Research Project</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name English</th>
                    <th>Name Thai</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="researchProject in researchProjects">
                    <td>
                        {{researchProject.name_en}}
                    </td>
                    <td>
                        {{researchProject.name_th}}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="/admin/research-project/view/{{researchProject.id}}" class="btn btn-info">Media Management</a>
                            <!--button type="button" ng-click="view(researchProject)"class="btn btn-primary">View</button-->
                            <button type="button" ng-click="showEditForm(researchProject)" class="btn btn-default">Edit</button>
                            <button type="button" ng-click="delete(researchProject)" class="btn btn-danger">Delete</button>
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
<script src="/js/services/ResearchProjectServices.js" type="text/javascript"></script>

<script type="text/javascript">

var app = angular.module('ResearchProjectManagement', ['ngLoadingSpinner','naif.base64','ResearchProjectServices', 'ResearcherServices', 'ui.bootstrap']);


app.controller('ResearchProjectController', function ($scope, ResearchProject, Researcher) {

    console.log("ResearchProjectController Start...");

    $scope.isAddOrEdit = null;

    $scope.researchProject = {};
    $scope.researchProjects = [];

    $scope.showAddForm = function () {
        $scope.isAddOrEdit = 'ADD';
        $scope.researchProject = {};
        $scope.researchProject.researchers = [];
    }

    $scope.closeForm = function () {
        $scope.isAddOrEdit = null;


    }

    $scope.submitForm = function () {
        console.log($scope.researchProject);

        ResearchProject.save($scope.researchProject).success(function (response) {
            console.log(response);
            $scope.closeForm();
            $scope.init();
        });
    }

    $scope.showEditForm = function (researchProject) {
        $scope.isAddOrEdit = "EDIT";
        $scope.researchProject = researchProject

        if (!$scope.researchProject.researchers) {
            $scope.researchProject.researchers = [];
        }
    }

    $scope.init = function () {
        ResearchProject.get().success(function (response) {
            $scope.researchProjects = response.data;
        })
    }

    $scope.delete = function (researchProject) {
        deleteStr = "Do you want to delete this research project [" + researchProject.name_en + " : " + researchProject.name_th + "]?";
        if (confirm(deleteStr)) {
            ResearchProject.delete(researchProject).success(function (response) {
                if (response.success) {
                    $scope.init();
                }
            });
        }
    }

    $scope.searchResearcher = function (val) {
        return Researcher.search(val).then(function (response) {
            return response.data;
        });
    };

    $scope.researcherAddEvent = function ($item) {
        if ($scope.researchProject.researchers === undefined) {
            $scope.researchProject.researchers = [];
        }
        $scope.researchProject.researchers.push($item);
        $item = '';

        console.log($scope.researchProject.researchers);
    };

    $scope.removeResearcher = function (index) {
        $scope.researchProject.researchers.splice(index, 1);
    };

    $scope.init();


});


</script>
@stop