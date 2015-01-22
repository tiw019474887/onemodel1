@extends('layout')

@section('content')

<div id="DashboardModule" ng-controller="DashboardController">

    <span us-spinner="{radius:30, width:8, length: 16}"></span>

    <h3>Dashboard</h3>

</div>

@stop


@section('js')
<script type="text/javascript" src="/js/services/UserServices.js"></script>
<script type="text/javascript">

    var app = angular.module('DashboardModule', ['ngLoadingSpinner','UserServices'])

    .factory('DashboardService', function ($http) {
        return {
        }
    })

    .controller('DashboardController', function ($scope, User) {
        console.log("DashboardController Start...");

    });

    angular.bootstrap($("#DashboardModule"),['DashboardModule']);

</script>
@stop