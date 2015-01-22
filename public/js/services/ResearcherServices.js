/**
 * Created by chaow on 11/28/2014 AD.
 */

angular.module('ResearcherServices',[])
    .factory('Researcher',function($http){
        return {
            get : function(){
                return $http.get('/api/researchers');
            },
            save : function(researcher){
                return $http({
                    method: 'POST',
                    url: '/api/researchers/save',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(researcher)
                });
            },
            delete : function(researcher){
                return $http({
                    method: 'POST',
                    url: '/api/researchers/delete',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(researcher)
                });
            },
            search: function(typed){
                return $http.get('/api/researchers/search/' + typed);
            }

        }
    });