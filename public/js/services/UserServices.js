/**
 * Created by chaow on 11/28/2014 AD.
 */

angular.module('UserServices',[])
    .factory('User',function($http){
        return {
            get : function(){
                return $http.get('/api/users');
            },
            save : function(user){
                return $http({
                    method: 'POST',
                    url: '/api/users/save',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(user)
                });
            },
            delete : function(user){
                return $http({
                    method: 'POST',
                    url: '/api/users/delete',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(user)
                });
            }
        }
    });