@extends('layout')

@section('content')

<div ng-app="NewsManagement" ng-controller="NewsController">

     <span us-spinner="{radius:30, width:8, length: 16}"></span>

    <div>
        <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
    </div>


    <div id="news-form" ng-show="isAddOrEdit !== null">

        <form class="form-horizontal" role="form" method="post">
            <formset>
                <legend>
                    <h3 ng-if="isAddOrEdit === 'ADD'">Add News</h3>
                    <h3 ng-if="isAddOrEdit === 'EDIT'">Edit News</h3>
                </legend>

                <?php echo Form::token(); ?>

                <div class="form-group">

                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input ng-model="news.is_pinned" ng-change="test(news.is_pinned)" ng-true-value="'true'" ng-false-value="'false'" type="checkbox">
                            Pinned News
                          </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="news-header" class="col-sm-2 control-label">News Header</label>
                    <div class="col-sm-10">
                        <input ng-model="news.header" type="text" class="form-control" placeholder="News Header">
                    </div>
                </div>
                <div class="form-group">
                    <label for="news-content" class="col-sm-2 control-label">News Content</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" placeholder="News Content" ng-model="news.content"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" ng-click="submitForm()" class="btn btn-primary">Save</button>
                        <button ng-click="closeForm()" type="button" class="btn btn-default">Close</button>
                    </div>
                </div>

            </formset>


            <formset ng-show="news.id">

                <legend>Photo Uploader</legend>

                <div class="form-group">
                    <label class="col-sm-2">Upload Image</label>
                    <div class=" col-sm-10">
                    <div class="input-group" style="margin-bottom: 10px;">
                          <span class="input-group-btn">
                            <button ng-hide="upload_image" style="width: 100px;" class="btn btn-primary" type="button" ng-click="selectImage()">Select Files</button>
                            <button ng-show="upload_image" style="width: 100px;" class="btn btn-info" type="button" ng-click="postPhoto()">Upload</button>
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

            <formset ng-show="news.id">

                <legend>Photo Lists</legend>

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb" ng-repeat="photo in news_photos">
                    <a class="thumbnail" href="#">
                        <img style="width: 200px;height: 200px;" class="img-responsive" ng-src="{{photo.url}}" alt="">
                    </a>
                </div>
                </div>

            </formset>
        </form>
    </div>

    <div id="news-table" ng-show="isAddOrEdit === null">

        <h3>News Table</h3>

        <button ng-click="showAddForm()" type="button" class="btn btn-primary">Add News</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Header</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr ng-repeat="news in news_arr">
                    <td>
                        {{news.header}}
                    </td>
                    <td>
                        {{news.content}}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" ng-click="view(news)"class="btn btn-primary">View</button>
                            <button type="button" ng-click="showEditForm(news)" class="btn btn-default">Edit</button>
                            <button type="button" ng-click="delete(news)" class="btn btn-danger">Delete</button>
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

    var app = angular.module('NewsManagement', ['ui.bootstrap','ngLoadingSpinner','naif.base64']);

    app.factory('News', function ($http) {
        return {
            all : function(){
                return $http.get('/api/news/');
            },
            get : function(newsId){
                return $http.get('/api/news/edit/'+newsId);
            },
            getPhotos : function(newsId){
                return $http.get('/api/news/photos/'+newsId);
            },
            postPhoto : function(newsId,photo){
                return $http({
                    url : '/api/news/upload-image/'+newsId,
                    method : 'POST',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(photo)
                })
            },
            save: function (news) {
                return $http({
                    url: '/api/news/save',
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(news)
                });
            },
            delete: function (news) {
                return $http({
                    method: 'POST',
                    url: '/api/news/delete',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(news)
                });
            }
        }
    });

    app.controller('NewsController', function ($scope,$timeout, News) {

        console.log("NewsController Start...");

        $scope.isAddOrEdit = null;

        $scope.news = {};
        $scope.news_arr = [];
        $scope.news_photos = [];
        $scope.upload_image = null;


        $scope.showAddForm = function () {
            $scope.isAddOrEdit = 'ADD';
            $scope.news = {};
        }

        $scope.closeForm = function () {
            $scope.isAddOrEdit = null;
            $scope.init();
        }

        $scope.submitForm = function () {
            console.log($scope.news);
            News.save($scope.news).success(function(response){
                $scope.news = response.data;
                $scope.addAlert("News has been save successfully.","success");

            });

        }

        $scope.init = function () {
            News.all().success(function (response) {
                $scope.news_arr = response.data;
            })
        }

        $scope.showEditForm = function (news) {
            $scope.isAddOrEdit = 'EDIT';
            $scope.news = news;
            $scope.news_photos = [];
            $scope.getPhotos();
            $scope.upload_image = null;

        }
        $scope.delete = function (news) {
            deleteStr = "Do you want to delete this News [" + news.header + "]?";
            if (confirm(deleteStr)) {
               News.delete(news).success(function (response) {
                   if (response.success) {
                       $scope.init();
                   }
               });
            }
        }


        $scope.selectImage = function(){
                $("#file").click();
            }

        $scope.removeImage = function(){
            $scope.upload_image = null;
        };


        $scope.getPhotos = function(){
            $news = $scope.news;
            News.getPhotos($news.id).success(function(response){
                response.data.forEach(function(photo){
                    $scope.news_photos.push(photo);
                })
            });
        };


        $scope.postPhoto = function(){
            News.postPhoto($scope.news.id,$scope.upload_image).success(function(response){
                console.log(response);
                $scope.removeImage();
                $scope.news_photos.push(response.data);
            })
        }

        $scope.$watch("upload_image", function(newValue, oldValue) {

                if(newValue !== null){

                    if(newValue.filetype.split('/')[0] !== 'image'){
                        $scope.addAlert('Please select only image file','danger');

                        $scope.upload_image = null;
                    }
                }
            });

        $scope.init();

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
