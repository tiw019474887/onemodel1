@extends('layout')

@section('content')
<input type="hidden" id="rpid" ng-model="rpid" value="<?php echo $id;?>"/>
<div ng-app="ResearchProjectView" ng-controller="ResearchProjectViewController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>


    <h3>Project Name :{{researchProject.name_en}}</h3>
    <h3>ชื่อโครงงาน :{{researchProject.name_th}}</h3>
    <form>

        <formset>

            <legend>Photo Uploader</legend>

            <div class="form-group">
                <label class="col-sm-2">Upload Image</label>
                <div class=" col-sm-10">
                <div class="input-group" style="margin-bottom: 10px;">
                      <span class="input-group-btn">
                        <button ng-hide="upload_image" style="width: 100px;" class="btn btn-primary" type="button" ng-click="selectImage()">Select Files</button>
                        <button ng-show="upload_image" style="width: 100px;" class="btn btn-info" type="button" ng-click="uploadImage()">Upload</button>
                      </span>
                      <input type="text" ng-model="upload_image.filename" class="form-control">
                      <span class="input-group-btn">
                      <button ng-show="upload_image" ng-click="removeImage()" class="btn btn-danger">Remove</button>
                      </span>
                    </div><!-- /input-group -->

                    <input id="file" style="display: none;" type="file" ng-model="upload_image" name="file" base-sixty-four-input>

                    <img ng-show="upload_image.base64" style="width:200px;height: 200px;" ng-src="data:{{upload_image.filetype}};base64,{{upload_image.base64}}" alt="">
                    <img ng-hide="upload_image.filename" data-src="holder.js/200x200" holder-fix/>
                </div>

            </div>

        </formset>

        <formset>

            <legend>Photo Lists</legend>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-xs-6 thumb" ng-repeat="photo in researchProject.photos">
                <a class="thumbnail" href="#">
                    <img style="width: 200px;height: 200px;" class="img-responsive" ng-src="{{photo.url}}" alt="">
                </a>
            </div>
            </div>

        </formset>

    </form>

    </div>

@stop


@section('js')
<script src="/js/services/ResearcherServices.js" type="text/javascript"></script>
<script src="/js/services/ResearchProjectServices.js" type="text/javascript"></script>

<script type="text/javascript">

var app = angular.module('ResearchProjectView', ['ngLoadingSpinner','naif.base64','ResearchProjectServices', 'ResearcherServices', 'ui.bootstrap']);


app.controller('ResearchProjectViewController', function ($scope, ResearchProject, Researcher) {

    console.log("ResearchProjectViewController Start...");
    $scope.rpid = $("#rpid").val();
    $scope.researchProject = {}
    $scope.upload_image = null;
    $scope.init = function(){

        ResearchProject.view($scope.rpid).success(function(response){
            $scope.researchProject = response.data;
            console.log($scope.researchProject);
            $scope.loadPhotos();
        })
    }


    $scope.skip = 0;
    $scope.loadPhotos  = function(){
        ResearchProject.viewPhoto($scope.rpid,$scope.skip).success(function(response){
            if (response.data.length > 0){
                $scope.skip = $scope.skip+1;
                if($scope.researchProject.photos === undefined){
                $scope.researchProject.photos = [];
                }
                response.data.forEach(function(d){
                    $scope.researchProject.photos.push(d);
                });
            }
        })
    }

    $scope.init();

    $scope.selectImage = function(){
        $("#file").click();
    }

    $scope.removeImage = function(){
        $scope.upload_image = null;
    }

    $scope.uploadImage = function(){
        ResearchProject.uploadImage($scope.researchProject.id,$scope.upload_image).success(function(response){
            console.log(response);
            $scope.removeImage();
            if($scope.researchProject.photos === undefined){
                $scope.researchProject.photos = [];
            }

            $scope.researchProject.photos.push(response.data);
        })
    }

    $scope.$watch("upload_image", function(newValue, oldValue) {
        if(newValue !== null){

            if(newValue.filetype.split('/')[0] !== 'image'){
                alert('Please select only image file');
                $scope.upload_image = null;
            }
        }
    });


});


</script>
@stop